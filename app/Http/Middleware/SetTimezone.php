<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class SetTimezone
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Set timezone to Singapore for superadmin and admin only
            if ($user->role === User::SUPER_ADMIN || $user->role === User::ADMIN) {
                config(['app.timezone' => 'Asia/Singapore']);
                date_default_timezone_set('Asia/Singapore');
            }
        }

        return $next($request);
    }
}