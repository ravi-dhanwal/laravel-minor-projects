<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('registration-page');
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/user-register', [AuthController::class, 'register'])->name('register-user');
Route::post('/user-login', [AuthController::class, 'login'])->name('login-user');

Route::get('/2fa/login-verify', [AuthController::class, 'showLoginOtp'])->name('2fa.login.page');
Route::post('/2fa/login-verify', [AuthController::class, 'verifyLoginOtp'])->name('2fa.login.verify');

Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/2fa/send-otp', [AuthController::class, 'sendOtp'])->name('2fa.send');
    Route::post('/2fa/verify-otp', [AuthController::class, 'verifyOtp'])->name('2fa.verify');
    Route::post('/2fa/disable', [AuthController::class, 'disableTfa'])->name('2fa.disable');
});

