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
        'renewal_type',
        'original_expiry_date',
        'renewal_processed_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'previous_expiry_date' => 'datetime',
        'new_expiry_date' => 'datetime',
        'original_expiry_date' => 'datetime',
        'renewal_processed_at' => 'datetime',
    ];

    // Action constants
    const ACTION_APPROVE = 'approve';
    const ACTION_REJECT = 'reject';
    const ACTION_UPGRADE = 'upgrade';
    const ACTION_DOWNGRADE = 'downgrade';
    const ACTION_CANCEL = 'cancel';
    const ACTION_RENEWAL = 'renewal';
    const ACTION_CANCELLED = 'cancelled';
    const ACTION_EARLY_RENEWAL = 'early_renewal';
    const ACTION_UPDATE = 'update';
    const ACTION_PENDING = 'pending';
    const ACTION_CHANGE_TIER = 'change_tier';

    // Status constants
    const STATUS_UPGRADE = 'upgrade';
    const STATUS_DOWNGRADE = 'downgrade';
    const STATUS_RENEWAL = 'renewal';
    const STATUS_INITIAL = 'initial';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EARLY_RENEWAL = 'early_renewal';
    const STATUS_RENEWED = 'renewed';
    
    // Renewal type constants
    const RENEWAL_TYPE_RENEWAL = 'renewal';
    const RENEWAL_TYPE_EARLY_RENEWAL = 'early_renewal';

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
            self::ACTION_APPROVE => 'Approved',
            self::ACTION_REJECT => 'Rejected',
            self::ACTION_UPGRADE => 'Upgraded',
            self::ACTION_DOWNGRADE => 'Downgraded',
            self::ACTION_CANCEL => 'Cancelled',
            self::ACTION_RENEWAL => 'Renewed',
            self::ACTION_CANCELLED => 'Cancelled',
            self::ACTION_EARLY_RENEWAL => 'Early Renewal',
            default => ucfirst($this->action),
        };
    }

    /**
     * Get formatted status label
     */
    public function getStatusLabelAttribute(): string
    {
        // Check if this is a status change to pending based on metadata
        if (isset($this->metadata['status_changed_to_pending']) && $this->metadata['status_changed_to_pending'] === true) {
            return 'Status Change';
        }
        
        // Check if this is a status change to suspended based on metadata
        if (isset($this->metadata['status_changed_to_suspended']) && $this->metadata['status_changed_to_suspended'] === true) {
            return 'Account Suspended';
        }
        
        // Check if this is a reactivation from suspended based on metadata
        if (isset($this->metadata['reactivated_from_suspended']) && $this->metadata['reactivated_from_suspended'] === true) {
            return 'Account Reactivated';
        }
        
        return match($this->status) {
            self::STATUS_UPGRADE => 'Upgraded',
            self::STATUS_DOWNGRADE => 'Downgraded',
            self::STATUS_RENEWAL => 'Renewed',
            self::STATUS_INITIAL => 'Initial',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_EARLY_RENEWAL => 'Early Renewal',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClassAttribute(): string
    {
        // Check if this is a status change to pending based on metadata
        if (isset($this->metadata['status_changed_to_pending']) && $this->metadata['status_changed_to_pending'] === true) {
            return 'warning';
        }
        
        // Check if this is a status change to suspended based on metadata
        if (isset($this->metadata['status_changed_to_suspended']) && $this->metadata['status_changed_to_suspended'] === true) {
            return 'dark';
        }
        
        // Check if this is a reactivation from suspended based on metadata
        if (isset($this->metadata['reactivated_from_suspended']) && $this->metadata['reactivated_from_suspended'] === true) {
            return 'success';
        }
        
        return match($this->status) {
            self::STATUS_UPGRADE => 'bg-success',
            self::STATUS_DOWNGRADE => 'bg-warning',
            self::STATUS_RENEWAL => 'bg-primary',
            self::STATUS_INITIAL => 'bg-info',
            self::STATUS_CANCELLED => 'bg-danger',
            self::STATUS_EARLY_RENEWAL => 'bg-warning',
            default => 'bg-secondary',
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
        return $query->whereIn('action', [self::ACTION_RENEWAL, self::ACTION_EARLY_RENEWAL]);
    }

    /**
     * Scope: get early renewal logs
     */
    public function scopeEarlyRenewals($query)
    {
        return $query->where('action', self::ACTION_EARLY_RENEWAL);
    }

    /**
     * Get formatted action label for cancellation/renewal
     */
    public function getCancellationActionLabelAttribute(): string
    {
        return match($this->action) {
            self::ACTION_CANCELLED => 'Cancelled',
            self::ACTION_RENEWAL => 'Renewed',
            default => ucfirst($this->action)
        };
    }

    /**
     * Parse annual fee from currency string to decimal
     * Converts currency strings like "$1,900" to decimal values
     * Returns null for non-numeric strings like "N/A"
     */
    public function parseAnnualFee($fee): ?float
    {
        if (is_null($fee) || $fee === 'N/A' || $fee === '') {
            return null;
        }
        
        // Remove currency symbols and formatting
        $cleaned = preg_replace('/[^0-9.,]/', '', $fee);
        $cleaned = str_replace(',', '', $cleaned);
        
        if (is_numeric($cleaned)) {
            return (float) $cleaned;
        }
        
        return null;
    }

    /**
     * Get formatted previous annual fee
     */
    public function getFormattedPreviousAnnualFeeAttribute(): ?string
    {
        $fee = $this->parseAnnualFee($this->previous_annual_fee);
        if ($fee === null) {
            return null;
        }
        
        $currency = $this->previous_annual_fee_currency ?? 'USD';
        return $currency . ' ' . number_format($fee, 2);
    }

    /**
     * Get formatted new annual fee
     */
    public function getFormattedNewAnnualFeeAttribute(): ?string
    {
        $fee = $this->parseAnnualFee($this->new_annual_fee);
        if ($fee === null) {
            return null;
        }
        
        $currency = $this->new_annual_fee_currency ?? 'USD';
        return $currency . ' ' . number_format($fee, 2);
    }

    /**
     * Accessor for previous_annual_fee to handle non-numeric values
     */
    public function getPreviousAnnualFeeAttribute($value)
    {
        if (is_null($value) || $value === 'N/A' || $value === '') {
            return $value;
        }
        
        // If it's already numeric, return as is
        if (is_numeric($value)) {
            return $value;
        }
        
        // If it's a currency string, keep it as string to avoid casting errors
        return $value;
    }

    /**
     * Accessor for new_annual_fee to handle non-numeric values
     */
    public function getNewAnnualFeeAttribute($value)
    {
        if (is_null($value) || $value === 'N/A' || $value === '') {
            return $value;
        }
        
        // If it's already numeric, return as is
        if (is_numeric($value)) {
            return $value;
        }
        
        // If it's a currency string, keep it as string to avoid casting errors
        return $value;
    }

    /**
     * Get formatted renewal type label
     */
    public function getRenewalTypeLabelAttribute(): ?string
    {
        if (!$this->renewal_type) {
            return null;
        }
        
        return match($this->renewal_type) {
            'renewal' => 'Regular Renewal',
            'early_renewal' => 'Early Renewal',
            default => ucfirst(str_replace('_', ' ', $this->renewal_type)),
        };
    }

    /**
     * Get renewal type badge class
     */
    public function getRenewalTypeBadgeAttribute(): ?string
    {
        if (!$this->renewal_type) {
            return null;
        }

        return match($this->renewal_type) {
            'renewal' => 'bg-primary',
            'early_renewal' => 'bg-warning',
            default => 'bg-info',
        };
    }

    /**
     * Check if this is an early renewal
     */
    public function isEarlyRenewal(): bool
    {
        return $this->renewal_type === 'early_renewal' || $this->status === self::STATUS_EARLY_RENEWAL;
    }

}
