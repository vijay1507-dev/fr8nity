<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipTierReward extends Model
{
    protected $fillable = [
        'membership_tier_id',
        'activity_type',
        'label',
        'points',
        'multiplier',
    ];

    public function membershipTier()
    {
        return $this->belongsTo(MembershipTier::class);
    }

    /**
     * Get business collaboration transaction value ranges and their corresponding activity types
     */
    public static function getBusinessCollaborationRanges(): array
    {
        return [
            ['min' => 50, 'max' => 1000, 'activity_type' => 'business_collaboration_50_1k'],
            ['min' => 1000, 'max' => 5000, 'activity_type' => 'business_collaboration_1k_5k'],
            ['min' => 5000, 'max' => 25000, 'activity_type' => 'business_collaboration_5k_25k'],
            ['min' => 25000, 'max' => 100000, 'activity_type' => 'business_collaboration_25k_100k'],
            ['min' => 100000, 'max' => null, 'activity_type' => 'business_collaboration_above_100k'],
        ];
    }
}
