<?php

namespace App\Services;

use App\Models\User;
use App\Models\MembershipRenewal;
use App\Models\MembershipLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipRenewalService
{
    public function __construct(
        private MembershipLogService $membershipLogService,
        private SettingsService $settingsService
    ) {}

    /**
     * Create a renewal plan instead of directly updating user membership
     */
    public function createRenewalPlan(
        User $member,
        ?string $reason = null,
        ?Carbon $customStartDate = null
    ): MembershipRenewal {
        return DB::transaction(function () use ($member, $reason, $customStartDate) {
            // Check if membership is expired
            $isExpired = $member->membership_expires_at && $member->membership_expires_at->isPast();
            
            // Determine renewal type
            $renewalType = $this->determineRenewalType($member);
            
            // Calculate renewal dates
            $renewalDates = $this->calculateRenewalDates($member, $renewalType, $customStartDate);
            
            // For expired memberships, start from current date instead of expiry date
            if ($isExpired) {
                $renewalDates['starts_at'] = $customStartDate ?? utcNow();
                
                // Recalculate expiry based on new start date
                if ($member->membershipTier && $member->membershipTier->name === 'Pinnacle') {
                    $renewalDates['expires_at'] = $renewalDates['starts_at']->copy()->addYears(3);
                } else {
                    $renewalDates['expires_at'] = $renewalDates['starts_at']->copy()->addYear();
                }
            }
            
            // Create renewal record
            $renewal = MembershipRenewal::create([
                'user_id' => $member->id,
                'membership_tier_id' => $member->membership_tier,
                'renewal_type' => $renewalType,
                'status' => $isExpired ? MembershipRenewal::STATUS_ACTIVE : MembershipRenewal::STATUS_PENDING,
                'renewal_date' => utcNow(),
                'starts_at' => $renewalDates['starts_at'],
                'expires_at' => $renewalDates['expires_at'],
                'previous_expires_at' => $member->membership_expires_at,
                'previous_tier_name' => $member->membershipTier?->name,
                'reason' => $reason ?? ($renewalType === 'early_renewal' ? 'Early renewal processed' : ($isExpired ? 'Expired membership renewal' : 'Regular renewal processed')),
                'metadata' => [
                    'renewal_processed_at' => utcNow()->toISOString(),
                    'previous_is_active' => $member->is_active,
                    'previous_status' => $member->status,
                    'admin_initiated' => Auth::check() && Auth::user()->role !== User::MEMBER,
                    'starts_from_expiry' => !$isExpired,
                    'calculated_start_date' => $renewalDates['starts_at']->toISOString(),
                    'calculated_expiry_date' => $renewalDates['expires_at']->toISOString(),
                    'was_expired' => $isExpired,
                ],
                'created_by' => Auth::id() ?? 1,
                'activated_at' => $isExpired ? utcNow() : null,
                'activated_by' => $isExpired ? (Auth::id() ?? 1) : null,
            ]);

            // If membership is expired, immediately update user record
            if ($isExpired) {
                $member->update([
                    'membership_start_at' => $renewalDates['starts_at'],
                    'membership_expires_at' => $renewalDates['expires_at'],
                    'status' => User::STATUS_APPROVED,
                    'is_active' => true,
                ]);
                
                // Award renewal points for expired membership renewal
                $this->awardRenewalPoints($member, $renewal);
            }

            // Log the renewal creation
            $this->logRenewalCreation($member, $renewal);

            return $renewal;
        });
    }

    /**
     * Activate pending renewals that are ready
     */
    public function activatePendingRenewals(): int
    {
        $renewals = MembershipRenewal::with('user')
            ->where('status', MembershipRenewal::STATUS_PENDING)
            ->where('starts_at', '<=', now('UTC'))
            ->get();
            
        $activated = 0;
        
        \Log::info('Checking for pending renewals to activate', [
            'count' => $renewals->count(),
            'current_time' => utcNow()->toDateTimeString(),
        ]);

        foreach ($renewals as $renewal) {
            try {
                \Log::info('Processing renewal', [
                    'renewal_id' => $renewal->id,
                    'user_id' => $renewal->user_id,
                    'starts_at' => $renewal->starts_at,
                    'expires_at' => $renewal->expires_at,
                    'is_ready' => $renewal->isReadyForActivation(),
                    'should_activate' => $renewal->shouldActivateImmediately(),
                ]);
                
                if (($renewal->isReadyForActivation() || $renewal->shouldActivateImmediately()) && $this->updateUserMembershipFromRenewal($renewal, 1)) {
                    $activated++;
                    \Log::info('Successfully activated renewal with points allocation', ['renewal_id' => $renewal->id]);
                } else {
                    \Log::warning('Failed to activate renewal', [
                        'renewal_id' => $renewal->id,
                        'status' => $renewal->status,
                        'is_ready' => $renewal->isReadyForActivation(),
                        'should_activate_immediately' => $renewal->shouldActivateImmediately(),
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Error activating renewal: ' . $e->getMessage(), [
                    'renewal_id' => $renewal->id ?? null,
                    'exception' => $e->getTraceAsString(),
                ]);
            }
        }

        return $activated;
    }

    /**
     * Manually update user table membership from a renewal record
     */
    public function updateUserMembershipFromRenewal(MembershipRenewal $renewal, ?int $activatedBy = null): bool
    {
        if ($renewal->status !== MembershipRenewal::STATUS_PENDING) {
            return false;
        }

        // Update user's membership dates directly
        $renewal->user->update([
            'membership_start_at' => $renewal->starts_at,
            'membership_expires_at' => $renewal->expires_at,
            'status' => User::STATUS_APPROVED,
            'is_active' => true,
        ]);

        // Mark renewal as active
        $renewal->update([
            'status' => MembershipRenewal::STATUS_ACTIVE,
            'activated_at' => utcNow(),
            'activated_by' => $activatedBy ?? auth()->id(),
        ]);

        // Award renewal points when activation happens
        $this->awardRenewalPoints($renewal->user, $renewal);

        // Log the activation
        $this->logRenewalActivation($renewal);

        return true;
    }

    /**
     * Force activate a specific renewal (bypass date checks)
     */
    public function forceActivateRenewal(MembershipRenewal $renewal, ?int $activatedBy = null): bool
    {
        return $this->updateUserMembershipFromRenewal($renewal, $activatedBy);
    }

    /**
     * Determine renewal type based on current membership status
     */
    private function determineRenewalType(User $member): string
    {
        if (!$member->membership_expires_at) {
            return MembershipRenewal::TYPE_RENEWAL;
        }

        $daysUntilExpiry = Carbon::parse($member->membership_expires_at)->diffInDays(utcNow(), false);
        
        // If membership has more than 30 days left, it's early renewal
        if ($daysUntilExpiry < -30) {
            return MembershipRenewal::TYPE_EARLY_RENEWAL;
        }

        return MembershipRenewal::TYPE_RENEWAL;
    }

    /**
     * Calculate renewal start and end dates
     */
    private function calculateRenewalDates(User $member, string $renewalType, ?Carbon $customStartDate = null): array
    {
        $currentExpiry = $member->membership_expires_at ? Carbon::parse($member->membership_expires_at) : utcNow();
        
        // All renewals start from the current membership expiry date
        // This ensures continuity and no loss of remaining time
        $startsAt = $currentExpiry;
        
        // If custom start date is provided and it's after current expiry, use it
        if ($customStartDate && $customStartDate->isAfter($currentExpiry)) {
            $startsAt = $customStartDate;
        }

        // Calculate expiry based on membership tier
        if ($member->membershipTier && $member->membershipTier->name === 'Pinnacle') {
            $expiresAt = $startsAt->copy()->addYears(3);
        } else {
            $expiresAt = $startsAt->copy()->addYear();
        }

        return [
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * Log renewal creation
     */
    private function logRenewalCreation(User $member, MembershipRenewal $renewal): void
    {
        $previousData = [
            'tier_name' => $renewal->previous_tier_name,
            'membership_number' => $member->membership_number,
            'annual_fee' => $member->membershipTier?->annual_fee,
            'annual_fee_currency' => $member->membershipTier?->annual_fee_currency,
            'expiry_date' => $renewal->previous_expires_at,
            'start_date' => $member->membership_start_at,
            'status' => $member->status,
            'is_active' => $member->is_active,
        ];

        $newData = [
            'expiry_date' => $renewal->expires_at,
            'start_date' => $renewal->starts_at,
        ];

        $this->membershipLogService->logMembershipRenewal(
            $member,
            $previousData,
            $newData,
            $renewal->reason
        );
    }

    /**
     * Log renewal activation
     */
    private function logRenewalActivation(MembershipRenewal $renewal): void
    {
        MembershipLog::create([
            'user_id' => $renewal->user_id,
            'membership_tier_id' => $renewal->membership_tier_id,
            'action' => 'renewal_activated',
            'status' => 'renewal',
            'reason' => 'Renewal plan activated automatically',
            'metadata' => [
                'renewal_id' => $renewal->id,
                'activated_at' => $renewal->activated_at->toISOString(),
                'renewal_type' => $renewal->renewal_type,
            ],
            'changed_by' => $renewal->activated_by ?? 1,
        ]);
    }

    /**
     * Get pending renewals for a member
     */
    public function getPendingRenewals(User $member)
    {
        return MembershipRenewal::where('user_id', $member->id)
            ->where('status', MembershipRenewal::STATUS_PENDING)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Cancel a pending renewal
     */
    public function cancelRenewal(MembershipRenewal $renewal, ?string $reason = null): bool
    {
        if ($renewal->cancel($reason)) {
            // Log the cancellation
            MembershipLog::create([
                'user_id' => $renewal->user_id,
                'membership_tier_id' => $renewal->membership_tier_id,
                'action' => 'renewal_cancelled',
                'status' => 'cancelled',
                'reason' => $reason ?? 'Renewal cancelled',
                'metadata' => [
                    'renewal_id' => $renewal->id,
                    'cancelled_at' => utcNow()->toISOString(),
                ],
                'changed_by' => Auth::id() ?? 1,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Award renewal points based on membership tier and renewal timing
     */
    private function awardRenewalPoints(User $member, MembershipRenewal $renewal): void
    {
        try {
            // Get the membership tier rewards for renewal
            $tierReward = \DB::table('membership_tier_rewards')
                ->where('membership_tier_id', $member->membership_tier)
                ->where('activity_type', 'renewal_paid')
                ->first();

            if (!$tierReward) {
                \Log::warning('No renewal reward configuration found for tier', [
                    'user_id' => $member->id,
                    'tier_id' => $member->membership_tier
                ]);
                return;
            }

            $basePoints = $tierReward->points;
            $multiplier = $tierReward->multiplier ?? 1;
            $finalPoints = $basePoints;
            $activityType = 'renewal_paid';
            $description = "Membership renewal - {$basePoints} points awarded";

            // Determine renewal scenario and points allocation
            if ($renewal->previous_expires_at) {
                $renewalDate = $renewal->renewal_date;
                $previousExpiryDate = $renewal->previous_expires_at;
                
                // Calculate days between renewal date and previous expiry
                $daysFromExpiry = $renewalDate->diffInDays($previousExpiryDate, false);
                
                if ($renewalDate->isAfter($previousExpiryDate)) {
                    // Renewal after expiry - half points
                    $finalPoints = $basePoints / 2;
                    $activityType = 'renewal_after_expiry';
                    $description = "Membership renewal after expiry - {$finalPoints} points awarded";
                } elseif ($daysFromExpiry <= $this->settingsService->getRenewalDaysPriorExpiring()) {
                    // Early renewal within last configured days - full points
                    $finalPoints = $basePoints;
                    $activityType = 'early_renewal';
                    $description = "Early membership renewal (within {$this->settingsService->getRenewalDaysPriorExpiring()} days) - {$finalPoints} points awarded";
                } else {
                    // Very early renewal (more than configured days before expiry) - apply multiplier
                    $finalPoints = $basePoints * $multiplier;
                    $activityType = 'early_renewal_bonus';
                    $roundedDays = round($daysFromExpiry);
                    $description = "Very early membership renewal ({$roundedDays} days before expiry) - {$basePoints} × {$multiplier} = {$finalPoints} points awarded";
                }
            }

            // Create reward point entry
            \DB::table('reward_points')->insert([
                'user_id' => $member->id,
                'points' => $finalPoints,
                'activity_type' => $activityType,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create membership log entry for renewal points allocation
            MembershipLog::create([
                'user_id' => $member->id,
                'membership_tier_id' => $member->membership_tier,
                'action' => 'renewal', 
                'previous_tier_name' => $renewal->previous_tier_name,
                'previous_membership_number' => $member->membership_number,
                'previous_annual_fee' => $member->membershipTier?->annual_fee,
                'previous_annual_fee_currency' => $member->membershipTier?->annual_fee_currency,
                'previous_expiry_date' => $renewal->previous_expires_at,
                'new_tier_name' => $member->membershipTier?->name,
                'new_membership_number' => $member->membership_number,
                'new_annual_fee' => $member->membershipTier?->annual_fee,
                'new_annual_fee_currency' => $member->membershipTier?->annual_fee_currency,
                'new_expiry_date' => $renewal->expires_at,
                'status' => 'renewal',
                'renewal_type' => $renewal->renewal_type,
                'original_expiry_date' => $renewal->previous_expires_at,
                'renewal_processed_at' => now(),
                'reason' => "Renewal points allocated: {$finalPoints} points for {$activityType}",
                'metadata' => [
                    'renewal_id' => $renewal->id,
                    'base_points' => $basePoints,
                    'multiplier' => $multiplier,
                    'final_points' => $finalPoints,
                    'activity_type' => $activityType,
                    'renewal_type' => $renewal->renewal_type,
                    'days_from_expiry' => $renewal->previous_expires_at ? 
                        round($renewal->renewal_date->diffInDays($renewal->previous_expires_at, false)) : null,
                    'points_calculation' => $description,
                    'allocated_at' => now()->toISOString(),
                    'log_type' => 'renewal_points_allocation',
                ],
                'changed_by' => 1,
            ]);

            \Log::info('Renewal points awarded successfully', [
                'user_id' => $member->id,
                'base_points' => $basePoints,
                'multiplier' => $multiplier,
                'final_points' => $finalPoints,
                'activity_type' => $activityType,
                'renewal_id' => $renewal->id,
                'renewal_type' => $renewal->renewal_type,
                'days_from_expiry' => $renewal->previous_expires_at ? 
                    $renewal->renewal_date->diffInDays($renewal->previous_expires_at, false) : null
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to award renewal points: ' . $e->getMessage(), [
                'user_id' => $member->id,
                'renewal_id' => $renewal->id,
                'exception' => $e->getTraceAsString()
            ]);
        }
    }
}
