<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MembershipTier;

class AnnualMembershipRenewalRewardsSeeder extends Seeder
{
    public function run(): void
    {
        // Get membership tiers
        $tiers = MembershipTier::all()->keyBy('name');
        
        // Annual Membership Renewal rewards matrix
        $renewalRewardsMatrix = [
            // Renewal and Paid
            [
                'activity_type' => 'renewal_paid',
                'points' => [
                    'Explorer' => 3000,
                    'Elevate' => 5000,
                    'Summit' => 8000,
                    'Pinnacle' => 8000
                ],
                'multiplier' => [
                    'Explorer' => 1.5,
                    'Elevate' => 2.0,
                    'Summit' => 2.5,
                    'Pinnacle' => 2.5
                ]
            ],
        ];

        // Insert annual membership renewal rewards for each tier
        foreach ($renewalRewardsMatrix as $reward) {
            foreach (['Explorer', 'Elevate', 'Summit', 'Pinnacle'] as $tierName) {
                if (isset($tiers[$tierName]) && isset($reward['points'][$tierName]) && isset($reward['multiplier'][$tierName])) {
                    DB::table('membership_tier_rewards')->insert([
                        'membership_tier_id' => $tiers[$tierName]->id,
                        'activity_type' => $reward['activity_type'],
                        'points' => $reward['points'][$tierName],
                        'multiplier' => $reward['multiplier'][$tierName],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
