<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $referrals = $user->referrals()
            ->with(['referred'])
            ->latest()
            ->paginate(10);

        return view('dashboard.referrals.index', compact('referrals'));
    }

    public function adminIndex()
    {
        $user = auth()->user();
        
        // Check if user is admin or super admin
        if (!in_array($user->role, [User::SUPER_ADMIN, User::ADMIN])) {
            abort(403, 'Unauthorized access.');
        }

        $referrals = Referral::with(['referrer', 'referred'])
            ->latest()
            ->paginate(15);

        return view('dashboard.referrals.admin-index', compact('referrals'));
    }

    public function generateLink()
    {
        $user = auth()->user();
        $referralLink = $user->getReferralLink();

        return response()->json([
            'referral_link' => $referralLink
        ]);
    }
}