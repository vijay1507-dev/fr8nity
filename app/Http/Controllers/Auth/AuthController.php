<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\City;
use App\Models\Region;
use App\Models\User;
use App\Models\MembershipTier;
use App\Models\Referral;
use App\Notifications\NewRegistrationNotification;
use App\Notifications\RegistrationConfirmationNotification;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Str;
use App\Models\State;
use App\Rules\ValidReferralCode;
use App\Services\RegistrationService;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrationService,
    ) {
    }
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function showTwoFactorForm()
    {
        return view('auth.two-factor-challenge');
    }

    public function showSecuritySettings()
    {
        return view('dashboard.security');
    }

    public function showRegistrationForm(Request $request)
    {
        if (Auth::check() && Auth::user()->role == User::MEMBER) {
            return redirect()->route('dashboard');
        }
        $membershipTiers = MembershipTier::with('benefits')
            ->where('is_active', true)
            ->where('is_visible', true)
            ->orderBy('order')
            ->get();
        
        $selectedTier = $request->get('tier', 'explorer');
        $memberType = $request->get('type', 'freight');
        $referralCode = $request->get('ref');

        // Get Singapore's data from database
        $defaultCountry = Country::where('code', 'SG')->firstOrFail();
        $defaultState = State::where('country_id', $defaultCountry->id)->firstOrFail();
        $defaultCity = City::where('state_id', $defaultState->id)
            ->where('name', 'Singapore')
            ->firstOrFail();

        $defaults = [
            'default_country_id' => $defaultCountry->id,
            'default_city_id' => $defaultCity->id,
            'default_country_code' => $defaultCountry->code
        ];

        $referrer = null;
        if ($referralCode) {
            $referrer = User::where('referral_code', $referralCode)->first();
        }
        
        return view('auth.register', compact('membershipTiers', 'selectedTier', 'memberType', 'defaults', 'referralCode', 'referrer'));
    }
    
    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'designation' => ['required', 'string', 'max:255'],
            'whatsapp_phone' => ['required'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_telephone' => ['required'],
            'company_address' => ['required', 'string'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'region_id' => ['required', 'exists:regions,id'],
            'referral_code' => ['nullable', 'string', new ValidReferralCode],
            'specializations' => ['required', 'array'],
            'incorporation_date' => ['required', 'date'],
            'tax_id' => ['required', 'string', 'max:255'],
            'website_linkedin' => ['required', 'string', 'max:255'],
            'is_network_member' => ['required', 'in:yes,no'],
            'network_name' => ['required_if:is_network_member,yes', 'nullable', 'string', 'max:255'],
            'membership_tier' => ['required'],
            'consent' => ['required', 'accepted'],
        ]);

        // Check if there's a valid referral code
        $referrer = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
        }
        $user = $this->registrationService->registerMember($request->all(), $referrer);

        return redirect()->route('login')->with('success', 'Your registration request has been successfully submitted. We will notify you via email once your application is approved.');
    }

    // Handle login post
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check approval and active status
            if ($user->status !== 'approved' || !$user->is_active) {
                Auth::logout();
                $message = ($user->status !== 'approved')
                    ? 'Your application is pending approval.'
                    : 'Your account is blocked. Please contact support.';
                return back()->withErrors([
                    'email' => $message,
                ]);
            }

            if ($request->has('is_member') && $user->role != User::MEMBER) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Only members can log in.',
                ]);
            } elseif ($request->has('is_admin') && ($user->role != User::SUPER_ADMIN && $user->role != User::ADMIN)) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Only admins can log in.',
                ]);
            }

            // Only generate 2FA code if enabled
            /** @var User $user */
            if ($user->two_factor_enabled) {
                $user->generateTwoFactorCode();
                return redirect()->route('two-factor.show');
            }

            // If 2FA is not enabled, check for KYC completion
            $request->session()->regenerate();

            // For members, check if profile photo and company logo are uploaded
            if ($user->role === User::MEMBER && (!$user->profile_photo || !$user->company_logo)) {
                return redirect()->route('editmemberprofile', $user->id)->with('warning', [
                    'message' => 'Please complete your profile by uploading your profile photo, company logo, and about company description. You are not able to access other features until you complete this step.'
                ]);
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|string',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!$user->two_factor_enabled) {
            return redirect()->intended('dashboard');
        }

        if ($user->validTwoFactorCode($request->two_factor_code)) {
            $request->session()->regenerate();
            $user->resetTwoFactorCode();
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'two_factor_code' => 'The provided two factor code is invalid.',
        ]);
    }

    public function enableTwoFactor(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->enableTwoFactorAuth();

        return redirect()->route('security.settings')
            ->with('status', 'Two-factor authentication has been enabled.');
    }

    public function disableTwoFactor(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->disableTwoFactorAuth();
        return redirect()->route('security.settings')
            ->with('status', 'Two-factor authentication has been disabled.');
    }

    public function resendTwoFactorCode(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return redirect()->intended('dashboard');
        }

        $user->generateTwoFactorCode();

        return back()->with('message', 'A new authentication code has been sent to your email.');
    }

    // Logout user
    public function logout(Request $request)
    {
        $userRole = Auth::user()->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($userRole === User::SUPER_ADMIN || $userRole === User::ADMIN) {
            return redirect('/admin-login');
        }
        return redirect('/login');
    }

    public function getCountries()
    {
        $countries = Country::orderBy('name')->get();
        return response()->json($countries);
    }

    public function getCities(Request $request)
    {
        $cities = City::join('states', 'cities.state_id', '=', 'states.id')->where('states.country_id', $request->country_id)->select('cities.*')->orderBy('cities.name')->get();
        return response()->json($cities);
    }

    public function getRegions()
    {
        $regions = Region::orderBy('name')->get();
        return response()->json($regions);
    }
}
