<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipTierReward extends Model
{
    protected $fillable = [
        'membership_tier_id',
        'activity_type',
        'points',
        'multiplier',
    ];

    public function membershipTier()
    {
        return $this->belongsTo(MembershipTier::class);
    }
}
