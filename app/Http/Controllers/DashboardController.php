<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Services\UserProfileService;
use App\Services\DashboardService;
use App\Helpers\Helper;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        private readonly UserProfileService $userProfileService,
        private readonly DashboardService $dashboardService
    ) {
    }

    public function index()
    {
        if (Auth::user()->role === User::MEMBER) {
            $user = Auth::user();
            
            // Get current year using helper
            $currentYear = Helper::getCurrentYear(request('year'));
            
            // Get user's total points using service
            $totalPoints = $this->dashboardService->getUserTotalPoints($user->id);
            
            // Get leadership board data using service
            $leadershipBoard = $this->dashboardService->getLeadershipBoard($currentYear);
            
            return view('dashboard.member-dashboard', compact('totalPoints', 'leadershipBoard', 'currentYear'));
        }
        
        return view('dashboard.admin-dashboard');
    }

    /**
     * Get leadership board data via AJAX for a specific year
     */
    public function getLeadershipBoardAjax(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1)
        ]);
        
        $year = $request->year;
        $leadershipBoard = $this->dashboardService->getLeadershipBoard($year);
        
        return response()->json([
            'success' => true,
            'data' => $leadershipBoard,
            'year' => $year
        ]);
    }

    public function getFilteredData(Request $request)
    {
        $request->validate([
            'period' => 'required|in:3,6,12'
        ]);
        
        $userId = Auth::id();
        $period = (int) $request->period;
        
        // Get filtered data using service
        $data = $this->dashboardService->getFilteredDashboardData($userId, $period);
        
        return response()->json($data);
    }

    /**
     * Get chart data for Trade Surplus/Deficit chart
     */
    public function getChartData(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2020|max:' . (date('Y') + 1)
        ]);
        
        $userId = Auth::id();
        $year = $request->input('year');
        
        // Get chart data using service (January to current month or December for past years)
        $chartData = $this->dashboardService->getMonthlyChartData($userId, $year);
        
        return response()->json($chartData);
    }

    public function profile()
    {
        $user = Auth::user();
        $totalPoints = $this->dashboardService->getUserTotalPoints($user->id);

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