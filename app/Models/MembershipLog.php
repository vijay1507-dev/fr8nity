<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipLog extends Model
{
    protected $fillable = [
        'user_id',
        'membership_tier_id',
        'action',
        'previous_tier_name',
        'previous_membership_number',
        'previous_annual_fee',
        'previous_annual_fee_currency',
        'previous_expiry_date',
        'new_tier_name',
        'new_membership_number',
        'new_annual_fee',
        'new_annual_fee_currency',
        'new_expiry_date',
        'status',
        'reason',
        'metadata',
        'changed_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'previous_expiry_date' => 'datetime',
        'new_expiry_date' => 'datetime',
        'previous_annual_fee' => 'decimal:2',
        'new_annual_fee' => 'decimal:2',
    ];

    // Actions constants
    const ACTION_APPROVE = 'approve';
    const ACTION_UPDATE = 'update';
    const ACTION_CHANGE_TIER = 'change_tier';
    const ACTION_RENEWAL = 'renewal';
    const ACTION_CANCELLED = 'cancelled';
    const ACTION_RENEWED = 'renewed';

    // Status constants
    const STATUS_UPGRADE = 'upgrade';
    const STATUS_DOWNGRADE = 'downgrade';
    const STATUS_RENEWAL = 'renewal';
    const STATUS_INITIAL = 'initial';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_RENEWED = 'renewed';

    /**
     * Get the user associated with this log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the membership tier associated with this log.
     */
    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class);
    }

    /**
     * Get the admin who made the change.
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Determine the status based on tier comparison
     */
    public static function determineStatus(?int $previousTierId, ?int $newTierId): ?string
    {
        if (!$previousTierId) {
            return self::STATUS_INITIAL;
        }

        if ($previousTierId === $newTierId) {
            return self::STATUS_RENEWAL;
        }

        // Get tier orders for comparison
        $previousTier = MembershipTier::find($previousTierId);
        $newTier = MembershipTier::find($newTierId);

        if (!$previousTier || !$newTier) {
            return null;
        }

        // Compare based on order (higher order = higher tier)
        if ($newTier->order > $previousTier->order) {
            return self::STATUS_UPGRADE;
        } elseif ($newTier->order < $previousTier->order) {
            return self::STATUS_DOWNGRADE;
        }

        return self::STATUS_RENEWAL;
    }

    /**
     * Get formatted action label
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            self::ACTION_APPROVE => 'Initial Approval',
            self::ACTION_UPDATE => 'Profile Update',
            self::ACTION_CHANGE_TIER => 'Tier Change',
            self::ACTION_RENEWAL => 'Membership Renewal',
            self::ACTION_CANCELLED => 'Membership Cancelled',
            self::ACTION_RENEWED => 'Membership Renewed',
            default => ucfirst($this->action),
        };
    }

    /**
     * Get formatted status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_UPGRADE => 'Upgrade',
            self::STATUS_DOWNGRADE => 'Downgrade',
            self::STATUS_RENEWAL => 'Renewal',
            self::STATUS_INITIAL => 'Initial Membership',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_RENEWED => 'Renewed',
            default => ucfirst($this->status ?? 'N/A'),
        };
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_UPGRADE => 'success',
            self::STATUS_DOWNGRADE => 'warning',
            self::STATUS_RENEWAL => 'info',
            self::STATUS_INITIAL => 'primary',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_RENEWED => 'success',
            default => 'secondary',
        };
    }

    /**
     * Scope: get cancellation logs
     */
    public function scopeCancellations($query)
    {
        return $query->where('action', self::ACTION_CANCELLED);
    }

    /**
     * Scope: get renewal logs
     */
    public function scopeRenewals($query)
    {
        return $query->where('action', self::ACTION_RENEWED);
    }

    /**
     * Get formatted action label for cancellation/renewal
     */
    public function getCancellationActionLabelAttribute(): string
    {
        return match($this->action) {
            self::ACTION_CANCELLED => 'Cancelled',
            self::ACTION_RENEWED => 'Renewed',
            default => ucfirst($this->action)
        };
    }
}
