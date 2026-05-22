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
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login-page');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('/user-register', [AuthController::class, 'register'])->name('register-user');
Route::post('/user-login', [AuthController::class, 'login'])->name('login-user');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


