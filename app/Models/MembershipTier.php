<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MembershipTier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'credit_protection',
        'annual_fee',
        'order',
        'is_active',
        'is_visible'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_visible' => 'boolean',
        'order' => 'integer'
    ];
    const MEMBERSHIP_NUMBER_PREFIXES = [
        'explorer' => 'F8EXP08050',
        'elevate'  => 'F8ELV08050',
        'summit'   => 'F8SMT08050',
        'pinnacle' => 'F8PIN08050',
    ];
    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(MembershipBenefit::class, 'membership_tier_benefits')
                    ->withTimestamps()
                    ->orderBy('sort_order');
    }
} 