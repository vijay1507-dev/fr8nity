<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MembershipTier;

class BusinessCollaborationRewardsSeeder extends Seeder
{
    public function run(): void
    {
        // Get membership tiers
        $tiers = MembershipTier::all()->keyBy('name');
        
        // Business collaboration points matrix based on transaction value ranges
        $businessCollaborationMatrix = [
            // $50 - $1,000
            ['range' => '$50 - $1,000', 'activity_type' => 'business_collaboration_50_1k', 'base_points' => 500, 'Explorer' => 1, 'Elevate' => 1.5, 'Summit' => 2, 'Pinnacle' => 2],
            // $1,000 - $5,000  
            ['range' => '$1,000 - $5,000', 'activity_type' => 'business_collaboration_1k_5k', 'base_points' => 700, 'Explorer' => 1, 'Elevate' => 1.5, 'Summit' => 2, 'Pinnacle' => 2],
            // $5,000 - $25,000
            ['range' => '$5,000 - $25,000', 'activity_type' => 'business_collaboration_5k_25k', 'base_points' => 1000, 'Explorer' => 1, 'Elevate' => 1.5, 'Summit' => 2, 'Pinnacle' => 2],
            // $25,000 - $100,000
            ['range' => '$25,000 - $100,000', 'activity_type' => 'business_collaboration_25k_100k', 'base_points' => 1500, 'Explorer' => 1.5, 'Elevate' => 2, 'Summit' => 2.5, 'Pinnacle' => 2.5],
            // Above $100,000
            ['range' => 'Above $100,000', 'activity_type' => 'business_collaboration_above_100k', 'base_points' => 2000, 'Explorer' => 2, 'Elevate' => 2.5, 'Summit' => 3, 'Pinnacle' => 3],
        ];

        // Insert business collaboration rewards for each tier and range
        foreach ($businessCollaborationMatrix as $range) {
            foreach (['Explorer', 'Elevate', 'Summit', 'Pinnacle'] as $tierName) {
                if (isset($tiers[$tierName])) {
                    DB::table('membership_tier_rewards')->insert([
                        'membership_tier_id' => $tiers[$tierName]->id,
                        'activity_type' => $range['activity_type'],
                        'points' => $range['base_points'], // Store base points, not calculated
                        'multiplier' => $range[$tierName],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
