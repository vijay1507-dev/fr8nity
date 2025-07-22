<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\DashboardController;

// Main website route - accessible to all
Route::get('/', function () {
    return view('index');
});
Route::get('/membership', function () {
    return view('membership');
})->name('membership');
Route::get('/trader', function () {
    return view('trader');
})->name('trader');
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Guest-only routes (redirect to dashboard if logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/admin-login', [AuthController::class, 'showAdminLoginForm'])->name('admin-login');

    // Password Reset routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Public API routes
Route::get('/get-countries', [AuthController::class, 'getCountries'])->name('get.countries');
Route::get('/get-cities/{country_id}', [AuthController::class, 'getCities'])->name('get.cities');
Route::get('/get-regions', [AuthController::class, 'getRegions'])->name('get.regions');


