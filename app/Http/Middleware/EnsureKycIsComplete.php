<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKycIsComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Skip middleware for non-member users
        if ($user->role !== \App\Models\User::MEMBER) {
            return $next($request);
        }

        // Check if KYC is incomplete (missing profile photo, company logo, or company description)
        if (!$user->profile_photo || !$user->company_logo || !$user->company_description) {
            // Allow access to edit profile route
            if ($request->route()->getName() === 'editmemberprofile') {
                return $next($request);
            }

            // Redirect to edit profile with warning for all other routes
            return redirect()->route('editmemberprofile', $user->id)->with('warning', [
                'title' => 'Complete Your KYC',
                'message' => 'Please complete your KYC by uploading your profile photo, company logo, and about company description. You won\'t be able to access other features until you complete this step.'
            ]);
        }

        return $next($request);
    }
}