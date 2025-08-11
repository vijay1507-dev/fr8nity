<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;
use App\Notifications\ProfileApprovalNotification;
use Illuminate\Support\Facades\Hash;

class MemberApprovalService
{
    public function __construct(
        private readonly RewardPointService $rewardPointService,
    ) {
    }

    public function updateStatus(User $member, string $status): void
    {
        if ($status === 'approved' && $member->status !== 'approved') {
            $this->approveMember($member);
            return;
        }

        $member->update(['status' => $status]);
    }

    public function approveMember(User $member): void
    {
        $notification = new ProfileApprovalNotification();

        $member->update([
            'status' => 'approved',
            'password' => Hash::make($notification->getPassword()),
            'membership_start_at' => now(),
            'membership_expires_at' => now()->addYear(),
        ]);

        $this->awardReferralPointsIfApplicable($member);

        $member->notify($notification);
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


