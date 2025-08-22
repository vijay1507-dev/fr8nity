<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'credit_protection',
        'annual_fee',
        'annual_fee_currency',
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

    public function rewards(): HasMany
    {
        return $this->hasMany(MembershipTierReward::class);
    }

    /**
     * Get membership logs for this tier
     */
    public function membershipLogs(): HasMany
    {
        return $this->hasMany(\App\Models\MembershipLog::class);
    }

    /**
     * Get the next available order number
     */
    public static function getNextOrder(): int
    {
        $maxOrder = self::max('order');
        return $maxOrder ? $maxOrder + 1 : 1;
    }

    /**
     * Scope for active tiers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for visible tiers
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Get formatted annual fee
     */
    public function getFormattedAnnualFeeAttribute(): string
    {
        return $this->annual_fee_currency ?: 'N/A';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->is_active ? 'success' : 'danger';
    }

    /**
     * Get visibility badge class
     */
    public function getVisibilityBadgeClassAttribute(): string
    {
        return $this->is_visible ? 'info' : 'warning';
    }
} 