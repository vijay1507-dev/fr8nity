<?php

namespace Database\Seeders\Custom;

use Illuminate\Database\Seeder;
use App\Models\MembershipTier;
use App\Models\MembershipBenefit;

class MembershipSeeder extends Seeder
{
    public function run()
    {
        // Create Membership Tiers
        $tiers = [
            [
                'name' => 'Explorer\'s Benefit',
                'slug' => 'explorer',
                'order' => 1,
                'description' => 'Basic membership tier with essential benefits'
            ],
            [
                'name' => 'Elevate Benefit',
                'slug' => 'elevate',
                'order' => 2,
                'description' => 'Mid-tier membership with enhanced benefits'
            ],
            [
                'name' => 'Summit Benefit',
                'slug' => 'summit',
                'order' => 3,
                'description' => 'Premium tier with exclusive benefits'
            ]
        ];

        foreach ($tiers as $tier) {
            MembershipTier::create($tier);
        }

        // Create Benefits
        $benefits = [
            // Explorer Benefits
            ['title' => 'Access to online member directory'],
            ['title' => 'Member dashboard'],
            ['title' => 'Basic listing in logistics partner network'],
            ['title' => 'Earn points through participation & business referrals (lower earning rate)'],
            
            // Elevate Benefits
            ['title' => 'Priority access to in-person events and online events'],
            ['title' => 'Featured company spotlight in newsletters and Webpage'],
            ['title' => 'Priority business connection and recommendation'],
            ['title' => 'Mid-tier points earning (higher multiplier)'],
            
            // Summit Benefits
            ['title' => 'All Elevate benefits'],
            ['title' => 'VIP invitation to annual global summit'],
            ['title' => 'Speaking opportunities at network events'],
            ['title' => 'Executive networking concierge service'],
            ['title' => 'Highest points earning rate'],
            ['title' => 'Opportunity to upgrade to Founder Circle']
        ];

        foreach ($benefits as $index => $benefit) {
            $benefit['sort_order'] = $index + 1;
            MembershipBenefit::create($benefit);
        }

        // Assign Benefits to Tiers
        $explorer = MembershipTier::where('slug', 'explorer')->first();
        $elevate = MembershipTier::where('slug', 'elevate')->first();
        $summit = MembershipTier::where('slug', 'summit')->first();

        // Explorer Benefits
        $explorer->benefits()->attach(MembershipBenefit::whereBetween('sort_order', [1, 4])->pluck('id'));

        // Elevate Benefits
        $elevate->benefits()->attach(MembershipBenefit::whereBetween('sort_order', [5, 8])->pluck('id'));

        // Summit Benefits
        $summit->benefits()->attach(MembershipBenefit::whereBetween('sort_order', [9, 14])->pluck('id'));
    }
} 