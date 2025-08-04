<?php

namespace Database\Seeders\Custom;

use Illuminate\Database\Seeder;
use App\Models\MembershipTierReward;

class MembershipTierRewardsSeeder extends Seeder
{
    public function run()
    {
        // Explorer
        MembershipTierReward::create([
            'membership_tier_id' => 1,
            'activity_type' => 'referral_join',
            'points' => 1000,
            'multiplier' => 1
        ]);

        // Elevate
        MembershipTierReward::create([
            'membership_tier_id' => 2,
            'activity_type' => 'referral_join',
            'points' => 2000,
            'multiplier' => 1
        ]);

        // Summit
        MembershipTierReward::create([
            'membership_tier_id' => 3,
            'activity_type' => 'referral_join',
            'points' => 3000,
            'multiplier' => 1
        ]);
    }
}