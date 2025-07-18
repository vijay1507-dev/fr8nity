<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Redirect root to login page
Route::get('/', function () {
    return view('index');
});

Route::get('/admin-login', function () {
    return redirect()->route('admin-login');
});

Route::get('/login', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Login/Logout routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin-login', [AuthController::class, 'showAdminLoginForm'])->name('admin-login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset routes

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/get-countries', [App\Http\Controllers\Auth\AuthController::class, 'getCountries'])->name('get.countries');
Route::get('/get-cities/{country_id}', [App\Http\Controllers\Auth\AuthController::class, 'getCities'])->name('get.cities');
Route::get('/get-regions', [App\Http\Controllers\Auth\AuthController::class, 'getRegions'])->name('get.regions');
