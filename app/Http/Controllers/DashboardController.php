<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Services\UserProfileService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(private readonly UserProfileService $userProfileService)
    {
    }
    public function index()
    {
        if (Auth::user()->role === User::MEMBER) {
            return view('dashboard.member-dashboard');
        }
        return view('dashboard.admin-dashboard');
    }

    public function getFilteredData(Request $request)
    {
        $request->validate([
            'period' => 'required|in:3,6,12'
        ]);
        $user   = Auth::user();
        $period = (int) $request->period;

        // Calculate the start date
        $startDate = Carbon::now()->subMonths($period);

        // --- GIVEN QUOTATIONS ---
        $givenSuccessful = $user->givenQuotations()
            ->where('created_at', '>=', $startDate)
            ->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL);
            
        $givenUnsuccessful = $user->givenQuotations()
            ->where('created_at', '>=', $startDate)
            ->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL);

        // --- RECEIVED QUOTATIONS ---
        $receivedSuccessful = $user->receivedQuotations()
            ->where('created_at', '>=', $startDate)
            ->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_SUCCESSFUL);

        $receivedUnsuccessful = $user->receivedQuotations()
            ->where('created_at', '>=', $startDate)
            ->where('status', \App\Models\MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL);

        // --- REFERRALS ---
        $referrals = $user->referrals()
            ->where('created_at', '>=', $startDate);

        // --- Build data ---
        $data = [
            'given_quotations' => [
                'transaction_value'   => $givenSuccessful->sum('transaction_value'),
                'successful_count'    => $givenSuccessful->count(),
                'unsuccessful_count'  => $givenUnsuccessful->count(),
            ],
            'received_quotations' => [
                'transaction_value'   => $receivedSuccessful->sum('transaction_value'),
                'successful_count'    => $receivedSuccessful->count(),
                'unsuccessful_count'  => $receivedUnsuccessful->count(),
            ],
            'referrals' => [
                'count' => $referrals->count(),
            ],
        ];

        return response()->json($data);
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