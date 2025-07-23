<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\DashboardController;

// Main website route - accessible to all
Route::get('/', function () {
    return view('website.index');
});

// Membership routes
Route::prefix('membership')->group(function () {
    Route::get('/', function () {
        return view('website.membership');
    })->name('membership');
    Route::get('/benefits', function () {
        return view('website.membership.benefits');
    })->name('membership.benefits');
    Route::get('/points', function () {
        return view('website.membership.points');
    })->name('membership.points');  
    Route::get('/trade-member', function () {
        return view('website.membership.trade');
    })->name('membership.trade-member'); 
});

// Events routes
Route::prefix('events')->group(function () {
    Route::get('/', function () {
        return view('website.events');
    })->name('events');
    Route::get('/calendar', function () {
        return view('website.events.calendar');
    })->name('events.calendar');
    Route::get('/conference', function () {
        return view('website.events.conference');
    })->name('events.conference');
});


Route::get('/about-us', function () {
    return view('website.about-us');
})->name('about-us');
Route::get('/spotlight', function () {
    return view('website.spotlight');
})->name('spotlight');
Route::get('/contact-us', function () {
    return view('website.contact-us');
})->name('contact-us');
Route::get('/faq', function () {
    return view('website.membership.faq');
})->name('faq');
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
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/edit-profile', [DashboardController::class, 'editprofile'])->name('editprofile');
});

// Public API routes
Route::get('/get-countries', [AuthController::class, 'getCountries'])->name('get.countries');
Route::get('/get-cities/{country_id}', [AuthController::class, 'getCities'])->name('get.cities');
Route::get('/get-regions', [AuthController::class, 'getRegions'])->name('get.regions');


