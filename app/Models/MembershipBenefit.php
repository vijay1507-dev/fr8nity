<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MembershipBenefit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function tiers(): BelongsToMany
    {
        return $this->belongsToMany(MembershipTier::class, 'membership_tier_benefits')
                    ->withTimestamps();
    }
} 