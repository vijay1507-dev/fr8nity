<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function profile()
    {
        $totalPoints = auth()->user()->rewardPoints()->sum('points');

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

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $updateData['profile_photo'] = $path;
        }

        // Only update password if provided and current password is correct
        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->new_password);
        }

        $user->update($updateData);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}