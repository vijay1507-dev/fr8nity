<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class MembershipRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_tier_id',
        'renewal_type',
        'status',
        'renewal_date',
        'starts_at',
        'expires_at',
        'activated_at',
        'previous_expires_at',
        'previous_tier_name',
        'reason',
        'metadata',
        'created_by',
        'activated_by',
    ];

    protected $casts = [
        'renewal_date' => 'datetime',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'activated_at' => 'datetime',
        'previous_expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    // Renewal type constants
    const TYPE_RENEWAL = 'renewal';
    const TYPE_EARLY_RENEWAL = 'early_renewal';

    /**
     * Get the user that owns the renewal
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the membership tier for this renewal
     */
    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class);
    }

    /**
     * Get the user who created this renewal
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who activated this renewal
     */
    public function activator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'activated_by');
    }

    /**
     * Check if renewal is ready to be activated
     */
    public function isReadyForActivation(): bool
    {
        return $this->status === self::STATUS_PENDING && 
               Carbon::parse($this->starts_at)->setTimezone('UTC')->isPast();
    }

    /**
     * Check if this renewal should activate immediately (for expired or expiring memberships)
     */
    public function shouldActivateImmediately(): bool
    {
        $now = now('UTC');
        $startsAt = Carbon::parse($this->starts_at)->setTimezone('UTC');
        
        // If starts_at is in the past, it should activate
        if ($startsAt->isPast()) {
            return true;
        }
        
        // If previous membership has expired and we're at or past the start time
        if ($this->previous_expires_at) {
            $previousExpires = Carbon::parse($this->previous_expires_at)->setTimezone('UTC');
            if ($previousExpires->isPast() && $startsAt->lte($now)) {
                return true;
            }
        }
        
        // If user's current membership is expired or about to expire (within 1 day)
        if ($this->user) {
            $userExpiry = $this->user->membership_expires_at 
                ? Carbon::parse($this->user->membership_expires_at)->setTimezone('UTC')
                : null;
                
            if ($userExpiry && ($userExpiry->isPast() || $userExpiry->diffInHours($now) <= 24)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if renewal is an early renewal
     */
    public function isEarlyRenewal(): bool
    {
        return $this->renewal_type === self::TYPE_EARLY_RENEWAL;
    }

    /**
     * Activate this renewal
     */
    public function activate(?int $activatedBy = null): bool
    {
        if (!$this->isReadyForActivation()) {
            return false;
        }

        // Only update user's membership dates when renewal actually becomes active
        // This ensures the user table is not modified until the current membership expires
        $this->user->update([
            'membership_start_at' => $this->starts_at,
            'membership_expires_at' => $this->expires_at,
            'status' => User::STATUS_APPROVED,
            'is_active' => true,
        ]);

        // Mark renewal as active
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'activated_at' => utcNow(),
            'activated_by' => $activatedBy ?? auth()->id(),
        ]);

        return true;
    }

    /**
     * Cancel this renewal
     */
    public function cancel(?string $reason = null): bool
    {
        if ($this->status !== self::STATUS_PENDING) {
            return false;
        }

        $metadata = $this->metadata ?? [];
        $metadata['cancellation_reason'] = $reason;
        $metadata['cancelled_at'] = utcNow()->toISOString();

        $this->update([
            'status' => self::STATUS_CANCELLED,
            'metadata' => $metadata,
        ]);

        return true;
    }

    /**
     * Scope: Get pending renewals ready for activation
     */
    public function scopeReadyForActivation($query)
    {
        $now = now('UTC');
        
        return $query->where('status', self::STATUS_PENDING)
                    ->where(function($q) use ($now) {
                        // Either starts_at is in the past
                        $q->where('starts_at', '<=', $now)
                          // Or the renewal should activate immediately based on other criteria
                          ->orWhereHas('user', function($userQ) use ($now) {
                              $userQ->where(function($q) use ($now) {
                                  // User's membership is expired or expiring soon (within 1 day)
                                  $q->where('membership_expires_at', '<=', $now->copy()->addDay())
                                    ->orWhereNull('membership_expires_at');
                              });
                          });
                    });
    }

    /**
     * Scope: Get active renewals
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope: Get pending renewals
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: Get early renewals
     */
    public function scopeEarlyRenewals($query)
    {
        return $query->where('renewal_type', self::TYPE_EARLY_RENEWAL);
    }

    /**
     * Get formatted status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pending Activation',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_EXPIRED => 'Expired',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-warning',
            self::STATUS_ACTIVE => 'bg-success',
            self::STATUS_CANCELLED => 'bg-danger',
            self::STATUS_EXPIRED => 'bg-secondary',
            default => 'bg-info',
        };
    }

    /**
     * Get renewal type label
     */
    public function getRenewalTypeLabelAttribute(): string
    {
        return match($this->renewal_type) {
            self::TYPE_RENEWAL => 'Regular Renewal',
            self::TYPE_EARLY_RENEWAL => 'Early Renewal',
            default => ucfirst(str_replace('_', ' ', $this->renewal_type)),
        };
    }
}
