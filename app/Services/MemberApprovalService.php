<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;
use App\Notifications\ProfileApprovalNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\MembershipNumberService;

class MemberApprovalService
{
    public function __construct(
        private readonly RewardPointService $rewardPointService,
        private readonly MembershipLogService $membershipLogService,
        private readonly MembershipNumberService $membershipNumberService,
    ) {}

    public function updateStatus(User $member, string $status): void
    {
        if ($status === 'approved' && $member->status !== 'approved') {
            // Check if this is a reactivation from suspended status
            if ($member->status === User::STATUS_SUSPENDED) {
                $this->reactivateSuspendedMember($member);
            } else {
                $this->approveMember($member);
            }
            return;
        }

        if ($status === 'pending' && $member->status === 'approved') {
            $this->setPendingMember($member);
            return;
        }

        if ($status === 'suspended') {
            $this->setSuspendedMember($member);
            return;
        }

        $member->update(['status' => $status]);
    }

    public function approveMember(User $member): void
    {
        $notification = new ProfileApprovalNotification();

        // Generate membership number only if it doesn't exist
        $membershipNumber = $member->membership_number;
        if (!$membershipNumber) {
            $membershipNumber = $this->membershipNumberService->generateForTierId((int) $member->membership_tier);
        }

        // Determine membership expiry date based on tier
        $tier = $member->membershipTier;
        $expiryDate = utcNow()->addYear(); 
        if ($tier && $tier->name === 'Pinnacle') {
            $expiryDate = utcNow()->addYears(3);
        }

        $member->update([
            'status' => 'approved',
            'is_active' => true,
            'password' => Hash::make($notification->getPassword()),
            'membership_number' => $membershipNumber,
            'membership_start_at' => utcNow(),
            'membership_expires_at' => $expiryDate,
        ]);

        // Log the initial approval
        $this->membershipLogService->logInitialApproval($member, Auth::id() ?? 1);

        $this->awardReferralPointsIfApplicable($member);

        $member->notify($notification);
    }

    public function setPendingMember(User $member): void
    {
        $member->update([
            'status' => User::STATUS_PENDING,
            'is_active' => false, 
        ]);

        // Log the status change to pending
        \App\Models\MembershipLog::create([
            'user_id' => $member->id,
            'action' => \App\Models\MembershipLog::ACTION_PENDING,
            'membership_tier_id' => $member->membership_tier,
            'previous_tier_name' => $member->membershipTier->name ?? 'N/A',
            'previous_membership_number' => $member->membership_number,
            'previous_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'previous_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'previous_expiry_date' => $member->membership_expires_at,
            'new_tier_name' => $member->membershipTier->name ?? 'N/A',
            'new_membership_number' => $member->membership_number,
            'new_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'new_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'new_expiry_date' => $member->membership_expires_at,
            'status' => \App\Models\MembershipLog::STATUS_PENDING, 
            'reason' => 'Status changed back to pending - requires re-approval',
            'changed_by' => Auth::id() ?? 1,
            'metadata' => [
                'status_changed_to_pending' => true,
                'previous_status' => 'approved',
                'changed_at' => utcNow()->toISOString(),
                'previous_is_active' => true,
                'action_type' => 'status_change_to_pending',
            ],
        ]);
    }

    public function setSuspendedMember(User $member): void
    {
        // Store previous status for logging
        $previousStatus = $member->status;
        $previousIsActive = $member->is_active;

        // Update member status to suspended and deactivate access
        $member->update([
            'status' => User::STATUS_SUSPENDED,
            'is_active' => false, // Deactivate access to website
        ]);

        // Log the status change to suspended
        \App\Models\MembershipLog::create([
            'user_id' => $member->id,
            'action' => \App\Models\MembershipLog::ACTION_UPDATE,
            'membership_tier_id' => $member->membership_tier,
            'previous_tier_name' => $member->membershipTier->name ?? 'N/A',
            'previous_membership_number' => $member->membership_number,
            'previous_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'previous_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'previous_expiry_date' => $member->membership_expires_at,
            'new_tier_name' => $member->membershipTier->name ?? 'N/A',
            'new_membership_number' => $member->membership_number,
            'new_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'new_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'new_expiry_date' => $member->membership_expires_at,
            'status' => \App\Models\MembershipLog::STATUS_INITIAL,
            'reason' => 'Account suspended - login access revoked',
            'changed_by' => Auth::id() ?? 1,
            'metadata' => [
                'status_changed_to_suspended' => true,
                'previous_status' => $previousStatus,
                'changed_at' => utcNow()->toISOString(),
                'previous_is_active' => $previousIsActive,
                'action_type' => 'status_change_to_suspended',
            ],
        ]);
    }

    public function reactivateSuspendedMember(User $member): void
    {
        // Store previous status for logging
        $previousStatus = $member->status;
        $previousIsActive = $member->is_active;

        // Update member status to approved and reactivate access (keep existing password)
        $member->update([
            'status' => User::STATUS_APPROVED,
            'is_active' => true, // Reactivate access to website
        ]);

        // Log the reactivation from suspended status
        \App\Models\MembershipLog::create([
            'user_id' => $member->id,
            'action' => \App\Models\MembershipLog::ACTION_UPDATE,
            'membership_tier_id' => $member->membership_tier,
            'previous_tier_name' => $member->membershipTier->name ?? 'N/A',
            'previous_membership_number' => $member->membership_number,
            'previous_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'previous_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'previous_expiry_date' => $member->membership_expires_at,
            'new_tier_name' => $member->membershipTier->name ?? 'N/A',
            'new_membership_number' => $member->membership_number,
            'new_annual_fee' => $member->membershipTier->annual_fee ?? 'N/A',
            'new_annual_fee_currency' => $member->membershipTier->annual_fee_currency ?? 'USD',
            'new_expiry_date' => $member->membership_expires_at,
            'status' => \App\Models\MembershipLog::STATUS_RENEWED,
            'reason' => 'Account reactivated from suspended status',
            'changed_by' => Auth::id() ?? 1,
            'metadata' => [
                'reactivated_from_suspended' => true,
                'previous_status' => $previousStatus,
                'changed_at' => utcNow()->toISOString(),
                'previous_is_active' => $previousIsActive,
                'action_type' => 'reactivation_from_suspended',
                'password_preserved' => true,
            ],
        ]);
    }

    private function awardReferralPointsIfApplicable(User $approvedMember): void
    {
        $referral = Referral::where('referred_id', $approvedMember->id)->first();
        if (!$referral) {
            return;
        }

        $referrer = User::find($referral->referrer_id);
        if (!$referrer) {
            return;
        }

        $this->rewardPointService->awardPoints(
            $approvedMember,
            $referrer,
            'referral_join',
            'Referred new member: ' . $approvedMember->name,
        );
    }
}
