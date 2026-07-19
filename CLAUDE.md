# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install dependencies
composer install
npm install

# Run development server
php artisan serve

# Run Vite asset bundler (in a separate terminal)
npm run dev

# Build assets for production
npm run build

# Run all tests
php artisan test

# Run a single test file
php artisan test tests/Feature/ExampleTest.php

# Run migrations
php artisan migrate

# Rollback and re-run migrations, then seed roles/permissions
php artisan migrate:fresh --seed

# Seed roles/permissions only (safe to re-run; also backfills existing users)
php artisan db:seed --class=RolesAndPermissionsSeeder

# Code style fix (Laravel Pint)
./vendor/bin/pint
```

## Architecture

Laravel 10 application (PHP 8.1+) implementing session-based user authentication with a hybrid role/permission system, email-OTP two-factor auth, event-driven registration emails, account activation, profile self-service (photo + password), and an admin/manager user-management area.

### Auth & authorization — hybrid role/permission model

There are **two parallel representations of a user's role**, kept in sync manually rather than one replacing the other:

- A plain `role` string column on `users` (`admin` | `manager` | `user`) — this is still the source of truth for **registration-time role assignment**.
- `spatie/laravel-permission` (roles + permissions tables), added later. `User` uses `HasRoles` ([app/Models/User.php](app/Models/User.php)).

**Registration** ([app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php) `register()`): checks `User::where('role', 'admin')->exists()` — the first registrant becomes `admin`, every subsequent registrant becomes `user` (nobody self-registers as `manager`; that role is assigned later by an admin). The `role` column is set **and** `$user->assignRole($role)` mirrors it into Spatie's tables. Nothing enforces these two stay consistent outside of registration and the seeder backfill below.

**Authorization** everywhere else runs through Spatie permissions, not the `role` column: controllers use `Auth::user()->can('view users')` / `can('manage users')`, and Blade views use `@can(...)` (e.g. the dashboard sidebar's "Users" nav link). [database/seeders/RolesAndPermissionsSeeder.php](database/seeders/RolesAndPermissionsSeeder.php) defines the matrix — `admin` gets `view users`, `manage users`, `assign roles`; `manager` gets only `view users`; `user` gets none — and backfills Spatie roles for any existing user based on their legacy `role` column. It's wired into `DatabaseSeeder` and safe to re-run.

Route-level Spatie middleware aliases (`role`, `permission`, `role_or_permission`) are registered in [app/Http/Kernel.php](app/Http/Kernel.php) but **not used on any route** — don't assume routes are gated by middleware; all enforcement is the inline `can()` checks described above. There are no formal Policy classes (`AuthServiceProvider::$policies` is empty).

### Registration events

`AuthController::register()` fires `App\Events\UserRegistered` after creating the user and logging them in. `App\Providers\EventServiceProvider` (`shouldDiscoverEvents()` returns `false`, so listeners must be registered manually) maps this event to two listeners, both implementing `ShouldQueue`:
- `SendWelcomeEmail` — sends `App\Mail\WelcomeMail` to the new user
- `SendAdminEmail` — sends `App\Mail\AdminNewUserMail` to the admin address (`config('custom.admin_email')`, i.e. the `ADMIN_EMAIL` env var, falling back to `mail.from.address`). `ADMIN_EMAIL` is unset in `.env`/`.env.example`, so in practice the fallback address is always used today.

Since `QUEUE_CONNECTION=sync` in `.env`, `ShouldQueue` listeners still run synchronously in-request — switching the queue driver would change this behavior without any other code changes.

### Two-factor auth (email OTP)

Users have `two_fa_is_active`, `two_fa_otp`, and `two_fa_expires_at` columns. When 2FA is enabled and a user logs in, `AuthController::login()` logs them out immediately, generates a 6-digit OTP, stores it with a 10-minute expiry, emails it via `App\Mail\OtpMail`, and redirects to `2fa.login.page` for verification (`showLoginOtp`/`verifyLoginOtp`). This pre-auth verification route is necessarily **outside** the `auth` middleware group. Once logged in, users manage 2FA from the dashboard via `/2fa/send-otp`, `/2fa/verify-otp`, and `/2fa/disable` — these three (post-login toggle) **are** behind `auth`.

### Account activation

Users have an `is_active` boolean (separate from the vestigial `status` field in `$fillable` — `status` has no backing DB column and isn't referenced anywhere). `AuthController::login()` blocks and logs out deactivated users with an error. Admins (permission `manage users`) toggle it via `POST /dashboard/users/{user}/toggle-status`; a user can't deactivate themselves (`toggleUserStatus()` blocks `$user->id === Auth::id()`).

### Profile self-service

- **Photo upload** (`POST /profile/photo`, `AuthController::uploadProfilePhoto`): client-side cropping via Croppie.js (CDN-loaded in `dashboard/index.blade.php`, not a package.json dependency), which POSTs a base64 PNG data URI. Server validates only `required|string` plus a regex on the data-URI prefix — no file-size limit. Always saved as `profile_photos/user_{id}.png` on the `public` disk (requires `php artisan storage:link`), overwriting any previous photo.
- **Password change** (`POST /profile/password`, `AuthController::updatePassword`): requires current password match and that the new password differs from the current one.

### User management (list & detail)

`GET /dashboard/users` (`usersList`) and `GET /dashboard/users/{user}` (`showUser`) both require the `view users` permission — so both `admin` and `manager` can view them, not just `admin`. The list is **not paginated** (`User::orderBy('created_at', 'desc')->get()` loads every row). The toggle-status action separately requires `manage users`, so a `manager` can view users but gets a 403 attempting to activate/deactivate one.

### User model

[app/Models/User.php](app/Models/User.php): `fillable` is `name`, `email`, `password`, `role`, `status` (vestigial, see above), `is_active`, `profile_photo`, `two_fa_is_active`, `two_fa_otp`, `two_fa_expires_at`. Uses `HasApiTokens`, `HasFactory`, `Notifiable`, `HasRoles`.

### Routes

[routes/web.php](routes/web.php): all routes are web (session-based); no API routes despite Sanctum being installed. Root `/` returns the register view directly (not a redirect). In local environment only, `/preview/email/*` renders the OTP, welcome, and admin-new-user mailables in-browser (explicitly commented `⚠️ REMOVE IN PRODUCTION`). Everything post-login — dashboard, user management, 2FA toggles, profile self-service, logout — is grouped under `auth` + `throttle:60,1`.

### Views

Blade templates under `resources/views/`:
- `auth/` — register, login, and 2FA verification forms
- `dashboard/` — `index` (dashboard + profile/2FA/photo UI), `users-list`, `user-details`
- `emails/` — mailable templates (layout, OTP, welcome, admin notification)

### Config

- `config/custom.php` — single key `admin_email`, read from `ADMIN_EMAIL` env var.
- `config/permission.php` — published Spatie config (standard, no teams).

### Testing

PHPUnit with Feature and Unit test suites. Test env uses array cache/session/queue drivers, but **`phpunit.xml` does not override the DB connection** (it's commented out) — `php artisan test` runs against whatever database is configured in `.env`, not an isolated one. Only the stock Laravel `ExampleTest` stubs exist; there is no test coverage for roles/permissions, profile photo, user management, or 2FA.
