<?php

namespace App\Services;

use App\Models\MembershipTierReward;
use App\Models\RewardPoint;

class RewardPointService
{
    public function awardPoints($user, $referrer, $activityType, $description = null)
    {
        $rewardRule = MembershipTierReward::where('membership_tier_id', $user->membership_tier)
            ->where('activity_type', $activityType)
            ->first();
        if ($rewardRule) {
            $points = $rewardRule->points * $rewardRule->multiplier;

            RewardPoint::create([
                'user_id' => $referrer->id,
                'activity_type' => $activityType,
                'points' => $points,
                'description' => $description ?? ucfirst(str_replace('_', ' ', $activityType))
            ]);

            return true;
        }

        return false;
    }
}