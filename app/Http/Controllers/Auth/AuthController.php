<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\City;
use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRegistrationNotification;
use App\Mail\RegistrationConfirmationMail;

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
    
    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'designation' => ['required', 'string', 'max:255'],
            'whatsapp_phone' => ['required', 'digits:10', 'numeric'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_telephone' => ['required', 'digits:10', 'numeric'],
            'company_address' => ['required', 'string'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'region_id' => ['required', 'exists:regions,id'],
            'referred_by' => ['nullable', 'string', 'max:255'],
            'specializations' => ['required', 'array'],
            'incorporation_date' => ['required', 'date'],
            'tax_id' => ['required', 'string', 'max:255'],
            'website_linkedin' => ['required', 'string', 'max:255'],
            'looking_for' => ['required', 'array'],
            'is_network_member' => ['required', 'in:yes,no'],
            'network_name' => ['required_if:is_network_member,yes', 'nullable', 'string', 'max:255'],
            'membership_tier' => ['required'],
            'consent' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'looking_for' => json_encode($request->looking_for),
            'is_network_member' => $request->is_network_member,
            'network_name' => $request->network_name,
            'membership_tier' => $request->membership_tier,
            'role' => User::MEMBER,
            'status' => 'pending',
        ]);

        $superAdmin = User::where('role', User::SUPER_ADMIN)->first();
        // Send notification to admin
        if ($superAdmin) {
            Mail::to($superAdmin->email)->queue(new NewRegistrationNotification($user));
        }
        
        // Send confirmation email to the user
        Mail::to($user->email)->queue(new RegistrationConfirmationMail($user));

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
            $request->session()->regenerate();
            $user = Auth::user();
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
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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
