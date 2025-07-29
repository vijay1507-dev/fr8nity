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
use App\Notifications\NewRegistrationNotification;
use App\Notifications\RegistrationConfirmationNotification;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Str;
class AuthController extends Controller
{
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
        $membershipTiers = MembershipTier::with('benefits')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
        
        $selectedTier = $request->get('tier', 'explorer');
        $memberType = $request->get('type', 'freight');
        
        return view('auth.register', compact('membershipTiers', 'selectedTier', 'memberType'));
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
            'referred_by' => ['nullable', 'string', 'max:255'],
            'specializations' => ['required', 'array'],
            'incorporation_date' => ['required', 'date'],
            'tax_id' => ['required', 'string', 'max:255'],
            'website_linkedin' => ['required', 'string', 'max:255'],
            'is_network_member' => ['required', 'in:yes,no'],
            'network_name' => ['required_if:is_network_member,yes', 'nullable', 'string', 'max:255'],
            'membership_tier' => ['required'],
            'consent' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'whatsapp_phone' => $request->whatsapp_phone,
            'company_name' => $request->company_name,
            'company_telephone' => $request->company_telephone,
            'company_address' => $request->company_address,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'referred_by' => $request->referred_by,
            'specializations' => json_encode($request->specializations),
            'incorporation_date' => $request->incorporation_date,
            'tax_id' => $request->tax_id,
            'website_linkedin' => $request->website_linkedin,
            'is_network_member' => $request->is_network_member,
            'network_name' => $request->network_name,
            'membership_tier' => $request->membership_tier,
            'role' => User::MEMBER,
            'status' => 'pending',
        ]);

        $superAdmin = User::where('role', User::SUPER_ADMIN)->first();
        // Send notification to admin
        if ($superAdmin) {
            $superAdmin->notify(new NewRegistrationNotification($user));
        }
        
        // Send confirmation email to the user
        $user->notify(new RegistrationConfirmationNotification($user));

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
            
            if ($user->status !== 'approved') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your application is pending approval.',
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
            if ($user->two_factor_enabled) {
                $user->two_factor_code = Str::random(6);
                $user->two_factor_expires_at = now()->addMinutes(10);
                $user->save();
                $user->notify(new TwoFactorCodeNotification());
                return redirect()->route('two-factor.show');
            }

            // If 2FA is not enabled, log in directly
            $request->session()->regenerate();
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

        $user = Auth::user();

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
        $user = Auth::user();
        $user->two_factor_enabled = '1';
        $user->save();

        return redirect()->route('security.settings')
            ->with('status', 'Two-factor authentication has been enabled.');
    }

    public function disableTwoFactor(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_enabled = '0';
        $user->save();
        return redirect()->route('security.settings')
            ->with('status', 'Two-factor authentication has been disabled.');
    }

    public function resendTwoFactorCode(Request $request)
    {
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
