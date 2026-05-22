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

This is a Laravel 10 application (PHP 8.1+) implementing a basic user authentication system with role-based access.

**Auth flow**: Registration auto-assigns `admin` role to the first user, `user` role to all subsequent registrations. Login uses Laravel's `Auth::attempt()` with session-based auth (no API tokens in use despite Sanctum being installed).

**Role logic lives in**: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php) — the `register()` method checks `User::where('role', 'admin')->exists()` to determine role assignment.

**User model** ([app/Models/User.php](app/Models/User.php)): `fillable` includes `name`, `email`, `password`, `role`, `status`. Uses `HasApiTokens`, `HasFactory`, `Notifiable`.

**Routes** ([routes/web.php](routes/web.php)): All routes are web (session-based). No API routes defined yet. The root `/` redirects to the register view.

**Views** are Blade templates organized under `resources/views/`:
- `auth/` — register and login forms
- `dashboard/` — post-login dashboard

**Testing**: PHPUnit with Feature and Unit test suites. Test env uses array cache/session/queue drivers. DB connection is not overridden in phpunit.xml (commented out), so tests run against the configured database.
