<?php

namespace App\Services;

use App\Models\User;
use App\Models\MemberQuotation;
use App\Models\Referral;
use Carbon\Carbon;
use App\Models\MembershipLog;
use App\Models\MembershipTier;

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

    /**
     * Get admin dashboard data for the specified period
     */
    public function getAdminDashboardData(int $period = 12): array
    {
        $startDate = Carbon::now()->subMonths($period);
        return [
            'new_signups' => $this->getNewSignupsCount($startDate),
            'member_churn' => $this->getMemberChurnData($startDate),
            'tier_growth' => $this->getTierGrowthData($startDate),
            'membership_fees' => $this->getMembershipFeesByTier($startDate),
            'average_revenue' => $this->getAverageRevenuePerMonth(),
            'country_members' => $this->getCountryWiseMemberCounts(),
            'referral_leaders' => $this->getReferralLeaders($startDate),
            'inactive_members' => $this->getInactiveMembersCount(),
        ];
    }

    /**
     * Get new sign-ups count for the period
     */
    private function getNewSignupsCount(Carbon $startDate): int
    {
        return User::where('role', User::MEMBER)
            ->where('created_at', '>=', $startDate)
            ->count();
    }

    /**
     * Get member churn data (cancellations and non-renewals)
     */
    private function getMemberChurnData(Carbon $startDate): array
    {
        // Get cancellations (users with status 'cancelled' in the period)
        $cancellations = User::where('role', User::MEMBER)
            ->where('status', 'cancelled')
            ->where('updated_at', '>=', $startDate)
            ->where('deleted_at', null)
            ->count();

        // Get non-renewals (expired memberships that weren't renewed in the period)
        // This counts members whose membership expired but they weren't cancelled or renewed
        $nonRenewals = User::where('role', User::MEMBER)
            ->where('status', 'approved') // Only approved members (not cancelled)
            ->where('membership_expires_at', '<', now()) // Expired
            ->where('membership_expires_at', '>=', $startDate) // Expired in the period
            ->where('deleted_at', null)
            ->count();

        return [
            'cancellations' => $cancellations,
            'non_renewals' => $nonRenewals,
        ];
    }

    /**
     * Get tier growth data (upgrades and downgrades)
     */
    private function getTierGrowthData(Carbon $startDate): array
    {
        $upgrades = MembershipLog::where('action', MembershipLog::ACTION_CHANGE_TIER)
            ->where('status', MembershipLog::STATUS_UPGRADE)
            ->whereHas('user', function($query) {
                $query->where('status', User::STATUS_APPROVED);
            })
            ->distinct('user_id')
            ->count('user_id');

        $downgrades = MembershipLog::where('action', MembershipLog::ACTION_CHANGE_TIER)
            ->where('status', MembershipLog::STATUS_DOWNGRADE)
            ->whereHas('user', function($query) {
                $query->where('status', User::STATUS_APPROVED);
            })
            ->distinct('user_id')
            ->count('user_id');

        return [
            'upgrades' => $upgrades,
            'downgrades' => $downgrades,
        ];
    }

    /**
     * Get country-wise active member counts for the map
     */
    public function getCountryWiseMemberCounts(): array
    {
        $countryCounts = User::where('role', User::MEMBER)
            ->where('status', 'approved') // Only approved members (not cancelled)
            ->where('deleted_at', null)
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->selectRaw('countries.code as country_code, COUNT(*) as member_count')
            ->groupBy('countries.code')
            ->pluck('member_count', 'country_code')
            ->toArray();

        return $countryCounts;
    }

    /**
     * Get membership fees by tier for the period
     */
    private function getMembershipFeesByTier(Carbon $startDate): array
    {
        $tiers = MembershipTier::active()->get();
        $fees = [];
        $totalTierRevenue = 0;

        // Initialize default tiers with zero values
        $defaultTiers = ['explorer', 'elevate', 'summit', 'pinnacle'];
        foreach ($defaultTiers as $tierSlug) {
            $fees[$tierSlug] = [
                'name' => ucfirst($tierSlug),
                'count' => 0,
                'annual_fee' => 0,
                'total_revenue' => 0,
            ];
        }

        foreach ($tiers as $tier) {
            // Get total count of active users for this tier (regardless of start date)
            $memberCount = User::where('role', User::MEMBER)
                ->where('membership_tier', $tier->id)
                ->where('status', 'approved') // Only approved members (not cancelled)
                ->where('deleted_at', null)
                ->count();

            if (isset($fees[$tier->slug])) {
                // Parse annual fee from string format (e.g., "$1,900" -> 1900)
                $annualFee = $this->parseAnnualFee($tier->annual_fee);
                $tierRevenue = $annualFee * $memberCount;
                
                $fees[$tier->slug] = [
                    'name' => $tier->name,
                    'count' => $memberCount,
                    'annual_fee' => $annualFee,
                    'total_revenue' => $tierRevenue,
                ];
                
                // Add to total tier revenue
                $totalTierRevenue += $tierRevenue;
            }
        }

        // Add total tier revenue to the fees array
        $fees['total'] = [
            'name' => 'Total',
            'count' => array_sum(array_column($fees, 'count')),
            'annual_fee' => 0,
            'total_revenue' => $totalTierRevenue,
        ];

        return $fees;
    }

    /**
     * Parse annual fee from string format to float
     */
    private function parseAnnualFee($annualFee): float
    {
        if (empty($annualFee)) {
            return 0;
        }

        // Remove currency symbols and commas, then convert to float
        $cleanedFee = preg_replace('/[^0-9.]/', '', $annualFee);
        
        return is_numeric($cleanedFee) ? (float) $cleanedFee : 0;
    }

    /**
     * Get average revenue per month for the period
     */
    private function getAverageRevenuePerMonth(): float
    {
        return 0;
    }

    /**
     * Get referral leaders data for the admin dashboard
     */
    private function getReferralLeaders(Carbon $startDate): array
    {
        $referralLeaders = User::select([
                'users.id',
                'users.name', 
                'users.company_name',
                'users.company_logo'
            ])
            ->selectRaw('COUNT(referrals.id) as referral_count')
            ->leftJoin('referrals', 'users.id', '=', 'referrals.referrer_id')
            ->where('users.role', User::MEMBER)
            ->where('users.status', 'approved')
            ->where('users.deleted_at', null)
            ->where(function($query) use ($startDate) {
                $query->where('referrals.created_at', '>=', $startDate)
                      ->orWhereNull('referrals.created_at');
            })
            ->groupBy('users.id', 'users.name', 'users.company_name', 'users.company_logo')
            ->having('referral_count', '>', 0)
            ->orderBy('referral_count', 'desc')
            ->limit(10)
            ->get();

        return $referralLeaders->map(function ($leader) {
            return [
                'id' => $leader->id,
                'name' => $leader->name,
                'company_name' => $leader->company_name,
                'company_logo' => $leader->company_logo ? asset('storage/' . $leader->company_logo) : asset('images/default-company-logo.png'),
                'referral_count' => $leader->referral_count,
            ];
        })->toArray();
    }

    /**
     * Get count of active members with 0 points
     */
    public function getInactiveMembersCount(): int
    {
        return User::where('role', User::MEMBER)
            ->where('status', User::STATUS_APPROVED)
            ->where('is_active', true)
            ->whereNotExists(function($query) {
                $query->selectRaw(1)
                    ->from('reward_points')
                    ->whereColumn('reward_points.user_id', 'users.id')
                    ->where('reward_points.points', '>', 0);
            })
            ->count();
    }
}
