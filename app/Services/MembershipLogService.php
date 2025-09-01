<?php

namespace App\Services;

use App\Models\MembershipLog;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MembershipLogService
{
    /**
     * Create a log for initial member approval
     */
    public function logInitialApproval(User $member, int $adminId): MembershipLog
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
            'status' => MembershipLog::STATUS_INITIAL,
            'changed_by' => $adminId,
            'metadata' => [
                'initial_approval' => true,
                'approved_at' => now()->toDateTimeString(),
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
                'updated_at' => now()->toDateTimeString(),
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
}
