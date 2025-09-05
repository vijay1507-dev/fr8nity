<?php

namespace App\Services;

use App\Models\MembershipLog;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MembershipLogService
{
    /**
     * Create a log for initial member approval
     */
    public function logInitialApproval(User $member, int $adminId, string $status=null): MembershipLog
    {
        $tier = MembershipTier::find($member->membership_tier);
        
        return MembershipLog::create([
            'user_id' => $member->id,
            'membership_tier_id' => $member->membership_tier,
            'action' => MembershipLog::ACTION_APPROVE,
            'previous_tier_name' => null,
            'previous_membership_number' => null,
            'previous_annual_fee' => null,
            'previous_annual_fee_currency' => null,
            'previous_expiry_date' => null,
            'new_tier_name' => $tier?->name,
            'new_membership_number' => $member->membership_number,
            'new_annual_fee' => $tier?->annual_fee,
            'new_annual_fee_currency' => $tier?->annual_fee_currency,
            'new_expiry_date' => $member->membership_expires_at,
            'status' => $status,
            'changed_by' => $adminId,
            'metadata' => [
                'initial_approval' => true,
                'approved_at' => utcNow()->toDateTimeString(),
            ],
        ]);
    }

    /**
     * Create a log for membership updates
     */
    public function logMembershipUpdate(
        User $member,
        array $previousData,
        array $newData,
        ?string $reason = null,
        ?array $metadata = null
    ): MembershipLog {
        // Determine the action type
        $action = $this->determineAction($previousData, $newData);
        
        // Determine the status
        $status = MembershipLog::determineStatus(
            $previousData['membership_tier'] ?? null,
            $newData['membership_tier'] ?? null
        );

        // Get tier information
        $previousTier = isset($previousData['membership_tier']) 
            ? MembershipTier::find($previousData['membership_tier']) 
            : null;
        $newTier = isset($newData['membership_tier']) 
            ? MembershipTier::find($newData['membership_tier']) 
            : null;

        return MembershipLog::create([
            'user_id' => $member->id,
            'membership_tier_id' => $newData['membership_tier'] ?? $member->membership_tier,
            'action' => $action,
            'previous_tier_name' => $previousTier?->name,
            'previous_membership_number' => $previousData['membership_number'] ?? null,
            'previous_annual_fee' => $previousTier?->annual_fee,
            'previous_annual_fee_currency' => $previousTier?->annual_fee_currency,
            'previous_expiry_date' => $previousData['membership_expires_at'] ?? null,
            'new_tier_name' => $newTier?->name,
            'new_membership_number' => $newData['membership_number'] ?? $member->membership_number,
            'new_annual_fee' => $newTier?->annual_fee,
            'new_annual_fee_currency' => $newTier?->annual_fee_currency,
            'new_expiry_date' => $newData['membership_expires_at'] ?? $member->membership_expires_at,
            'status' => $status,
            'reason' => $reason,
            'metadata' => array_merge($metadata ?? [], [
                'updated_at' => utcNow()->toDateTimeString(),
                'changes' => $this->getChangedFields($previousData, $newData),
            ]),
            'changed_by' => Auth::id() ?? 1, // Default to system user if not authenticated
        ]);
    }

    /**
     * Log membership changes from old and new User models
     */
    public function logFromUserChange(
        User $oldUser,
        User $newUser,
        ?string $reason = null,
        ?array $metadata = null
    ): ?MembershipLog {
        // Check if any membership-related fields changed
        $membershipFields = [
            'membership_tier',
            'membership_number',
            'membership_expires_at',
            'membership_start_at',
        ];

        $hasChanges = false;
        foreach ($membershipFields as $field) {
            if ($oldUser->$field != $newUser->$field) {
                $hasChanges = true;
                break;
            }
        }

        if (!$hasChanges) {
            return null;
        }

        $previousData = [
            'membership_tier' => $oldUser->membership_tier,
            'membership_number' => $oldUser->membership_number,
            'membership_expires_at' => $oldUser->membership_expires_at,
            'membership_start_at' => $oldUser->membership_start_at,
        ];

        $newData = [
            'membership_tier' => $newUser->membership_tier,
            'membership_number' => $newUser->membership_number,
            'membership_expires_at' => $newUser->membership_expires_at,
            'membership_start_at' => $newUser->membership_start_at,
        ];

        return $this->logMembershipUpdate($newUser, $previousData, $newData, $reason, $metadata);
    }

    /**
     * Determine the action type based on changes
     */
    private function determineAction(array $previousData, array $newData): string
    {
        $previousTier = $previousData['membership_tier'] ?? null;
        $newTier = $newData['membership_tier'] ?? null;

        // If tier changed, it's a tier change
        if ($previousTier != $newTier) {
            return MembershipLog::ACTION_CHANGE_TIER;
        }

        // Check if only dates changed (and tier remained the same)
        $previousExpiry = $previousData['membership_expires_at'] ?? null;
        $newExpiry = $newData['membership_expires_at'] ?? null;
        $previousStart = $previousData['membership_start_at'] ?? null;
        $newStart = $newData['membership_start_at'] ?? null;

        // Convert to strings for comparison if they are Carbon instances
        $previousExpiryStr = $previousExpiry instanceof \Carbon\Carbon ? $previousExpiry->toDateTimeString() : $previousExpiry;
        $newExpiryStr = $newExpiry instanceof \Carbon\Carbon ? $newExpiry->toDateTimeString() : $newExpiry;
        $previousStartStr = $previousStart instanceof \Carbon\Carbon ? $previousStart->toDateTimeString() : $previousStart;
        $newStartStr = $newStart instanceof \Carbon\Carbon ? $newStart->toDateTimeString() : $newStart;

        // Only consider it a renewal if both start and expiry dates are extended
        // and the membership tier hasn't changed
        if ($previousExpiryStr && $newExpiryStr && $previousStartStr && $newStartStr) {
            if ($newExpiryStr > $previousExpiryStr && $newStartStr >= $previousStartStr) {
                return MembershipLog::ACTION_RENEWAL;
            }
        }

        // If we reach here, it's just a regular update (no meaningful membership changes)
        return MembershipLog::ACTION_UPDATE;
    }

    /**
     * Get list of changed fields
     */
    private function getChangedFields(array $previousData, array $newData): array
    {
        $changes = [];
        
        foreach ($newData as $key => $value) {
            if (!isset($previousData[$key]) || $previousData[$key] != $value) {
                $changes[$key] = [
                    'old' => $previousData[$key] ?? null,
                    'new' => $value,
                ];
            }
        }

        return $changes;
    }

    /**
     * Log membership renewal with detailed tracking
     */
    public function logMembershipRenewal(
        User $member,
        array $previousData,
        array $newData,
        ?string $reason = null,
        ?array $renewalDetails = null
    ): MembershipLog {
        // Determine renewal type
        $renewalType = $this->determineRenewalType($member, $previousData);
        

        // Get tier information
        $previousTier = isset($previousData['tier_name']) 
            ? $previousData['tier_name']
            : ($member->membershipTier?->name ?? 'N/A');
        $newTier = $member->membershipTier?->name ?? 'N/A';

        $logData = [
            'user_id' => $member->id,
            'membership_tier_id' => $member->membership_tier,
            'action' => $renewalType === 'early_renewal' ? MembershipLog::ACTION_EARLY_RENEWAL : MembershipLog::ACTION_RENEWAL,
            'previous_tier_name' => $previousTier,
            'previous_membership_number' => $previousData['membership_number'] ?? $member->membership_number,
            'previous_annual_fee' => $previousData['annual_fee'] ?? $member->membershipTier?->annual_fee,
            'previous_annual_fee_currency' => $previousData['annual_fee_currency'] ?? $member->membershipTier?->annual_fee_currency,
            'previous_expiry_date' => $previousData['expiry_date'] ?? null,
            'new_tier_name' => $newTier,
            'new_membership_number' => $member->membership_number,
            'new_annual_fee' => $member->membershipTier?->annual_fee,
            'new_annual_fee_currency' => $member->membershipTier?->annual_fee_currency,
            'new_expiry_date' => $newData['expiry_date'] ?? $member->membership_expires_at,
            'status' => $renewalType === 'early_renewal' ? MembershipLog::STATUS_EARLY_RENEWAL : MembershipLog::STATUS_RENEWAL,
            'renewal_type' => $renewalType,
            'original_expiry_date' => $previousData['expiry_date'] ?? null,
            'renewal_processed_at' => utcNow(),
            'reason' => $reason ?? ($renewalType === 'early_renewal' ? 'Early renewal processed' : 'Regular renewal processed'),
            'changed_by' => Auth::id() ?? 1,
        ];

        // Enhanced metadata
        $metadata = [
            'renewal_processed_at' => utcNow()->toISOString(),
            'previous_is_active' => $previousData['is_active'] ?? true,
            'previous_status' => $previousData['status'] ?? 'approved',
            'previous_start_date' => $previousData['start_date'] ?? null,
            'new_start_date' => $newData['start_date'] ?? $member->membership_start_at,
            'renewal_type' => $renewalType,
            'admin_initiated' => Auth::check() && Auth::user()->role !== User::MEMBER,
        ];

        if ($renewalType === 'early_renewal') {
            $metadata['early_renewal_details'] = [
                'original_expiry_date' => $previousData['expiry_date'],
                'early_renewal_benefit' => 'Extended from original expiry date',
            ];
        }

        $logData['metadata'] = $metadata;

        return MembershipLog::create($logData);
    }

    /**
     * Get renewal statistics for a member
     */
    public function getMemberRenewalStats(User $member): array
    {
        $renewalLogs = MembershipLog::where('user_id', $member->id)
            ->whereIn('action', [MembershipLog::ACTION_RENEWAL, MembershipLog::ACTION_EARLY_RENEWAL])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_renewals' => $renewalLogs->count(),
            'early_renewals' => $renewalLogs->where('renewal_type', 'early_renewal')->count(),
            'regular_renewals' => $renewalLogs->where('renewal_type', 'renewal')->count(),
            'last_renewal_date' => $renewalLogs->first()?->created_at,
        ];

        return $stats;
    }

    /**
     * Determine renewal type based on membership status and expiry
     */
    private function determineRenewalType(User $member, array $previousData): string
    {
        $previousExpiryDate = $previousData['expiry_date'] ?? $member->membership_expires_at;
        
        // If membership is still active and has more than 30 days left, it's early renewal
        if ($previousExpiryDate && Carbon::parse($previousExpiryDate)->diffInDays(utcNow()) > 30) {
            return 'early_renewal';
        }
        
        // Default to regular renewal
        return 'renewal';
    }

    /**
     * Get system-wide renewal analytics
     */
    public function getRenewalAnalytics(?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = MembershipLog::whereIn('action', [MembershipLog::ACTION_RENEWAL, MembershipLog::ACTION_EARLY_RENEWAL]);
        
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
        
        $renewals = $query->get();
        
        return [
            'total_renewals' => $renewals->count(),
            'early_renewals' => $renewals->where('renewal_type', 'early_renewal')->count(),
            'regular_renewals' => $renewals->where('renewal_type', 'renewal')->count(),
            'renewal_by_tier' => $renewals->groupBy('new_tier_name')->map->count(),
            'monthly_trend' => $renewals->groupBy(function($item) {
                return $item->created_at->format('Y-m');
            })->map->count(),
        ];
    }
}
