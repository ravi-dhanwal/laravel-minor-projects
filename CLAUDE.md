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

# Rollback and re-run migrations
php artisan migrate:fresh --seed

# Code style fix (Laravel Pint)
./vendor/bin/pint
```

## Architecture

This is a Laravel 10 application (PHP 8.1+) implementing user authentication with role-based access, two-factor authentication (email OTP), and event-driven registration emails.

**Auth flow**: Registration auto-assigns `admin` role to the first user, `user` role to all subsequent registrations. Login uses Laravel's `Auth::attempt()` with session-based auth (no API tokens in use despite Sanctum being installed).

**Role logic lives in**: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php) — the `register()` method checks `User::where('role', 'admin')->exists()` to determine role assignment.

**Registration events**: `AuthController::register()` fires `App\Events\UserRegistered` after creating the user. `App\Providers\EventServiceProvider` (with `shouldDiscoverEvents()` returning `false`, so listeners must be registered manually) maps this event to two listeners:
- `SendWelcomeEmail` — sends `App\Mail\WelcomeMail` to the new user
- `SendAdminEmail` — sends `App\Mail\AdminNewUserMail` to the admin address (`ADMIN_EMAIL` env var, read via `config('custom.admin_email')`, falling back to `mail.from.address`)

**Two-factor auth (email OTP)**: Users have `two_fa_is_active`, `two_fa_otp`, and `two_fa_expires_at` columns (added via a dedicated migration). When 2FA is enabled and a user logs in, `AuthController` logs them out immediately, generates a 6-digit OTP, stores it with a 10-minute expiry, emails it via `App\Mail\OtpMail`, and redirects to the `2fa.login.page` route for verification. Users can enable/disable 2FA and manage OTP verification from the dashboard via `/2fa/send-otp`, `/2fa/verify-otp`, and `/2fa/disable` (all behind `auth` middleware).

**User model** ([app/Models/User.php](app/Models/User.php)): `fillable` includes `name`, `email`, `password`, `role`, `status`, `two_fa_is_active`, `two_fa_otp`, `two_fa_expires_at`. Uses `HasApiTokens`, `HasFactory`, `Notifiable`.

**Routes** ([routes/web.php](routes/web.php)): All routes are web (session-based). No API routes defined yet. The root `/` redirects to the register view. Authenticated routes (`dashboard`, `logout`, 2FA management) are grouped under `auth` + `throttle:60,1` middleware. In local environment only, `/preview/email/*` routes render the OTP, welcome, and admin-new-user mailables directly in-browser for design iteration — these are explicitly flagged for removal in production.

**Views** are Blade templates organized under `resources/views/`:
- `auth/` — register, login, and 2FA verification forms
- `dashboard/` — post-login dashboard
- `emails/` — mailable templates (layout, OTP, welcome, admin notification)

**Testing**: PHPUnit with Feature and Unit test suites. Test env uses array cache/session/queue drivers. DB connection is not overridden in phpunit.xml (commented out), so tests run against the configured database.
