<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Services\UserProfileService;

class DashboardController extends Controller
{
    public function __construct(private readonly UserProfileService $userProfileService)
    {
    }
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function profile()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        /** @var User $user */
        $totalPoints = $user->rewardPoints()->sum('points');

        return view('dashboard.profile', compact('totalPoints'));
    }

    public function editprofile()
    {
        $user = Auth::user();
        
        if ($user->role !== User::SUPER_ADMIN) {
            return redirect()->route('profile')->with('error', 'Unauthorized access');
        }
        
        return view('dashboard.editprofile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== User::SUPER_ADMIN) {
            return redirect()->route('profile')->with('error', 'Unauthorized access');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ];

        // Add password validation if password is being updated
        if ($request->filled('new_password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['new_password'] = ['required', 'confirmed', Password::defaults()];
            $rules['new_password_confirmation'] = ['required'];
        }

        $request->validate($rules);

        $this->userProfileService->updateSuperAdminProfile(
            $user,
            $request->only(['name', 'email']),
            $request->file('profile_photo'),
            $request->filled('new_password') ? $request->new_password : null,
        );

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}