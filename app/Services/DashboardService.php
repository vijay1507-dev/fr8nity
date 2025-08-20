<?php

namespace App\Services;

use App\Models\User;
use App\Models\MemberQuotation;
use App\Models\Referral;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get user's total reward points
     */
    public function getUserTotalPoints(int $userId): int
    {
        return User::find($userId)
            ->rewardPoints()
            ->sum('points');
    }

    /**
     * Get leadership board data for a specific year
     */
    public function getLeadershipBoard(int $year): array
    {
        $leaders = User::forLeadershipBoard($year)->get();
        
        return $this->formatLeadershipBoardData($leaders);
    }

    /**
     * Get filtered dashboard data for a specific period
     */
    public function getFilteredDashboardData(int $userId, int $period): array
    {
        $startDate = Carbon::now()->subMonths($period);
        
        return [
            'given_quotations' => $this->getGivenQuotationsData($userId, $startDate),
            'received_quotations' => $this->getReceivedQuotationsData($userId, $startDate),
            'referrals' => $this->getReferralsData($userId, $startDate),
        ];
    }

    /**
     * Format leadership board data
     */
    private function formatLeadershipBoardData($leaders): array
    {
        $monthlyLeaders = $this->groupLeadersByMonth($leaders);
        $sortedLeaders = $this->getSortedMonthlyLeaders($monthlyLeaders);
        
        return $this->formatLeadersForDisplay($sortedLeaders);
    }

    /**
     * Group leaders by month and keep top performer per month
     */
    private function groupLeadersByMonth($leaders): array
    {
        $monthlyLeaders = [];
        
        foreach ($leaders as $leader) {
            $month = $leader->reward_month;
            if (!isset($monthlyLeaders[$month]) || $leader->monthly_points > $monthlyLeaders[$month]['points']) {
                $monthlyLeaders[$month] = [
                    'company_name' => $leader->company_name,
                    'points' => $leader->monthly_points,
                    'month' => $leader->reward_month,
                    'company_logo' => $leader->company_logo,
                ];
            }
        }
        
        return $monthlyLeaders;
    }

    /**
     * Get all monthly leaders sorted by points
     */
    private function getSortedMonthlyLeaders(array $monthlyLeaders): array
    {
        // Sort by points (descending) but return all monthly leaders
        uasort($monthlyLeaders, function($a, $b) {
            return $b['points'] <=> $a['points'];
        });
        return $monthlyLeaders;
    }

    /**
     * Format leaders data for display
     */
    private function formatLeadersForDisplay(array $leaders): array
    {
        $formattedLeaders = [];
        
        foreach ($leaders as $leader) {
            $formattedLeaders[] = [
                'company_name' => $leader['company_name'] ?: 'Unknown Company',
                'points' => $leader['points'],
                'month' => $this->formatMonth($leader['month']),
                'company_logo' => $this->getCompanyLogoUrl($leader['company_logo']),
            ];
        }
        
        return $formattedLeaders;
    }

    /**
     * Format month string
     */
    private function formatMonth(string $monthString): string
    {
        try {
            return Carbon::createFromFormat('Y-m', $monthString)->format('F Y');
        } catch (\Exception $e) {
            return 'Current Period';
        }
    }

    /**
     * Get profile photo URL with fallback
     */
    private function getProfilePhotoUrl(?string $profilePhoto): string
    {
        return $profilePhoto ? asset('storage/' . $profilePhoto) : asset('images/dummy_user.jpg');
    }

    /**
     * Get company logo URL with fallback
     */
    private function getCompanyLogoUrl(?string $companyLogo): string
    {
        return $companyLogo ? asset('storage/' . $companyLogo) : asset('images/default_company.png');
    }

    /**
     * Get given quotations data
     */
    private function getGivenQuotationsData(int $userId, Carbon $startDate): array
    {
        $successful = $this->getGivenQuotationsQuery($userId, $startDate, MemberQuotation::STATUS_CLOSED_SUCCESSFUL);
        $unsuccessful = $this->getGivenQuotationsQuery($userId, $startDate, MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL);
        
        return [
            'transaction_value' => $successful->sum('transaction_value'),
            'successful_count' => $successful->count(),
            'unsuccessful_count' => $unsuccessful->count(),
        ];
    }

    /**
     * Get received quotations data
     */
    private function getReceivedQuotationsData(int $userId, Carbon $startDate): array
    {
        $successful = $this->getReceivedQuotationsQuery($userId, $startDate, MemberQuotation::STATUS_CLOSED_SUCCESSFUL);
        $unsuccessful = $this->getReceivedQuotationsQuery($userId, $startDate, MemberQuotation::STATUS_CLOSED_UNSUCCESSFUL);
        
        return [
            'transaction_value' => $successful->sum('transaction_value'),
            'successful_count' => $successful->count(),
            'unsuccessful_count' => $unsuccessful->count(),
        ];
    }

    /**
     * Get referrals data
     */
    private function getReferralsData(int $userId, Carbon $startDate): array
    {
        return [
            'count' => User::find($userId)
                ->referrals()
                ->where('created_at', '>=', $startDate)
                ->count()
        ];
    }

    /**
     * Get monthly chart data for Trade Surplus/Deficit chart
     */
    public function getMonthlyChartData(int $userId, int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;
        $currentMonth = $year == Carbon::now()->year ? Carbon::now()->month : 12;
        $months = [];
        $givenData = [];
        $receivedData = [];
        
        // Generate month labels from January to current month (or December for past years)
        for ($month = 1; $month <= $currentMonth; $month++) {
            $date = Carbon::createFromDate($year, $month, 1);
            $months[] = $date->format('M');
            
            // Get data for this month
            $monthStart = $date->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            // Given quotations for this month
            $givenValue = User::find($userId)
                ->givenQuotations()
                ->where('status', MemberQuotation::STATUS_CLOSED_SUCCESSFUL)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('transaction_value');
            
            // Received quotations for this month
            $receivedValue = User::find($userId)
                ->receivedQuotations()
                ->where('status', MemberQuotation::STATUS_CLOSED_SUCCESSFUL)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('transaction_value');
            
            $givenData[] = round($givenValue, 2);
            $receivedData[] = round($receivedValue, 2);
        }
        
        return [
            'labels' => $months,
            'given_data' => $givenData,
            'received_data' => $receivedData
        ];
    }

    /**
     * Get given quotations query builder
     */
    private function getGivenQuotationsQuery(int $userId, Carbon $startDate, string $status)
    {
        return User::find($userId)
            ->givenQuotations()
            ->where('created_at', '>=', $startDate)
            ->where('status', $status);
    }

    /**
     * Get received quotations query builder
     */
    private function getReceivedQuotationsQuery(int $userId, Carbon $startDate, string $status)
    {
        return User::find($userId)
            ->receivedQuotations()
            ->where('created_at', '>=', $startDate)
            ->where('status', $status);
    }
}
