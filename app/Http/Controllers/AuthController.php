<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            }else if ($request->has('is_admin') && ( $user->role != User::SUPER_ADMIN && $user->role != User::ADMIN )) {
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
}