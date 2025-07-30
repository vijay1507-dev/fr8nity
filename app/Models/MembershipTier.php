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
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(MembershipBenefit::class, 'membership_tier_benefits')
                    ->withTimestamps()
                    ->orderBy('sort_order');
    }
} 