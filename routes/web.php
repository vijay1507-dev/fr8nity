<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberQuotationController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\TradeMemberController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SettingsController;

// Main website route - accessible to all
Route::get('/', function () {
    return view('website.index');
});

// Membership routes
Route::prefix('membership')->group(function () {
    Route::get('/', function () {
        return view('website.membership');
    })->name('membership');
     // Authenticated membership pages
     Route::middleware('auth')->group(function () {
         // Membership Routes
        Route::get('/explorer', function () {
            $membershipTier = \App\Models\MembershipTier::where('slug', 'explorer')->first();
            return view('website.membership.explorer', compact('membershipTier'));
        })->name('membership.explorer');

        Route::get('/elevate', function () {
            $membershipTier = \App\Models\MembershipTier::where('slug', 'elevate')->first();
            return view('website.membership.elevate', compact('membershipTier'));
        })->name('membership.elevate');

        Route::get('/summit', function () {
            $membershipTier = \App\Models\MembershipTier::where('slug', 'summit')->first();
            return view('website.membership.summit', compact('membershipTier'));
        })->name('membership.summit');
    });
    Route::get('/pinnacle', function () {
        return view('website.membership.pinnacle');
    })->name('membership.pinnacle');
    Route::get('/join-member', function () {
        return view('website.membership.join-member');
    })->name('membership.join-member');
    Route::get('/shipment-enquiry', function () {
        return view('website.membership.shipment-enquiry');
    })->name('membership.shipment-enquiry');
    Route::post('/shipment-enquiry', [ShipmentController::class, 'store'])->name('shipment-enquiry.store');
    Route::get('/thank-you', function () {
        return view('website.thank-you');
    })->name('thank-you');
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
})->name('about-us')->middleware('auth');
Route::get('/spotlight', function () {
    return view('website.spotlight');
})->name('spotlight');
Route::get('/contact-us', function () {
    return view('website.contact-us');
})->name('contact-us');
Route::get('/faq', function () {
    return view('website.faq');
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
Route::middleware(['auth', 'kyc.complete'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/edit-profile', [DashboardController::class, 'editprofile'])->name('editprofile');
    Route::post('/update-profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/security-settings', [AuthController::class, 'showSecuritySettings'])->name('security.settings');
    Route::post('/two-factor/enable', [AuthController::class, 'enableTwoFactor'])->name('two-factor.enable');
    Route::delete('/two-factor/disable', [AuthController::class, 'disableTwoFactor'])->name('two-factor.disable');
    Route::get('/members-directory', [MemberController::class, 'directory'])->name('members.directory');
    Route::get('/members-directory/{company_name}/{encrypted_id}', [MemberController::class, 'viewProfile'])->name('members.directory-view-profile');
    Route::post('/member-quotations', [MemberQuotationController::class, 'store'])->name('member.quotations.store');
    
    // Member Quotation routes
    Route::prefix('quotations')->group(function () {
        Route::get('/given', [MemberQuotationController::class, 'givenQuotations'])->name('member.quotations.given');
        Route::get('/received', [MemberQuotationController::class, 'receivedQuotations'])->name('member.quotations.received');
        Route::get('/{quotation}', [MemberQuotationController::class, 'show'])->name('member.quotations.show');
    });
    // Member management routes - requires admin access
    Route::middleware('admin')->prefix('members')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('members.index');
        Route::get('/add', [MemberController::class, 'create'])->name('members.add');
        Route::post('/store', [MemberController::class, 'store'])->name('members.store');
        Route::get('/{member}', [MemberController::class, 'show'])->name('members.show');
        Route::patch('/{member}/status', [MemberController::class, 'updateStatus'])->name('members.update-status');
        Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::patch('/{member}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    });

    // Settings routes
    Route::middleware('admin')->group(function () {
        Route::get('/settings/membership-reminders', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings/membership-reminders', [SettingsController::class, 'update'])->name('settings.update');

        // Site settings
        Route::get('/settings/site', [SettingsController::class, 'siteIndex'])->name('settings.site.index');
        Route::put('/settings/site', [SettingsController::class, 'siteUpdate'])->name('settings.site.update');
    });
    // Admin Quotations routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/quotations', [MemberQuotationController::class, 'adminIndex'])->name('admin.quotations.index');
        Route::get('/quotations/{quotation}', [MemberQuotationController::class, 'adminShow'])->name('admin.quotations.show');
    });
    Route::get('/{member}/edit-profile', [MemberController::class, 'edit'])->name('editmemberprofile');
    Route::patch('/{member}/update-profile', [MemberController::class, 'update'])->name('members.updateprofile')->withoutMiddleware('kyc.complete');
    
    // Shipment management routes - requires admin access
    Route::middleware('admin')->prefix('shipments')->group(function () {
        Route::get('/', [ShipmentController::class, 'index'])->name('shipments.index');
        Route::get('/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
        Route::get('/{shipment}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
        Route::patch('/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');
        Route::delete('/{shipment}', [ShipmentController::class, 'destroy'])->name('shipments.destroy');
    });
});

// Public API routes
Route::get('/get-countries', [AuthController::class, 'getCountries'])->name('get.countries');
Route::get('/get-cities/{country_id}', [AuthController::class, 'getCities'])->name('get.cities');
Route::get('/get-regions', [AuthController::class, 'getRegions'])->name('get.regions');

// Two Factor Authentication Routes
Route::get('/two-factor', [AuthController::class, 'showTwoFactorForm'])->name('two-factor.show');
Route::post('/two-factor', [AuthController::class, 'verifyTwoFactor'])->name('two-factor.verify');
Route::post('/two-factor/resend', [AuthController::class, 'resendTwoFactorCode'])->name('two-factor.resend');

// Trade Member Routes
Route::resource('trade-members', TradeMemberController::class)->only(['store']);
Route::resource('trade-members', TradeMemberController::class)->except(['store'])->middleware('admin');

// Referral Routes
Route::middleware(['auth', 'kyc.complete'])->group(function () {
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/generate-link', [ReferralController::class, 'generateLink'])->name('referrals.generate-link');
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/referrals', [ReferralController::class, 'adminIndex'])->name('admin.referrals.index');
    });
});



