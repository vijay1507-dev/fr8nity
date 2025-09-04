<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'designation',
        'whatsapp_phone',
        'company_name',
        'company_logo',
        'company_description',
        'company_telephone',
        'company_address',
        'country_id',
        'city_id',
        'region_id',
        'referred_by',
        'specializations',
        'incorporation_date',
        'tax_id',
        'website_linkedin',
        'is_network_member',
        'network_name',
        'membership_tier',
        'membership_number',
        'membership_start_at',
        'membership_expires_at',
        'status',
        'cancelled_at',
        'cancellation_reason',
        'cancelled_by',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_enabled',
        'certificate_document',
        'certificate_uploaded_at',
        'is_active',
    ];

    const SUPER_ADMIN = 0;
    const ADMIN = 1;   
    const MEMBER = 2;
    
    // Profile approval status constants - controls login access and membership lifecycle
    const STATUS_PENDING = 'pending';    // Profile pending approval, cannot login
    const STATUS_APPROVED = 'approved';  // Profile approved, can login (if is_active = true)
    const STATUS_CANCELLED = 'cancelled'; // Membership cancelled, cannot access website
    const STATUS_SUSPENDED = 'suspended'; // Account suspended, cannot login
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'specializations' => 'array',
            'two_factor_expires_at' => 'datetime',
            'membership_start_at' => 'datetime',
            'membership_expires_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'certificate_uploaded_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope: only approved and active members (can login and access website)
     */
    public function scopeApprovedActiveMembers(Builder $query): Builder
    {
        return $query->where('role', self::MEMBER)
            ->where('status', self::STATUS_APPROVED)  // Profile approved
            ->where('is_active', true);                // Active access to website
    }

    /**
     * Scope: only cancelled members
     */
    public function scopeCancelledMembers(Builder $query): Builder
    {
        return $query->where('role', self::MEMBER)
            ->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope: only suspended members
     */
    public function scopeSuspendedMembers(Builder $query): Builder
    {
        return $query->where('role', self::MEMBER)
            ->where('status', self::STATUS_SUSPENDED);
    }

    /**
     * Scope: only approved members
     */
    public function scopeApprovedMembers(Builder $query): Builder
    {
        return $query->where('role', self::MEMBER)
            ->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope: for leadership board queries
     */
    public function scopeForLeadershipBoard(Builder $query, int $year): Builder
    {
        return $query->select([
                'users.id',
                'users.name', 
                'users.company_logo',
                'users.company_name'
            ])
            ->selectRaw('DATE_FORMAT(rp.created_at, "%Y-%m") as reward_month')
            ->selectRaw('SUM(rp.points) as monthly_points')
            ->leftJoin('reward_points as rp', 'users.id', '=', 'rp.user_id')
            ->where('role', self::MEMBER)
            ->where('is_active', true)
            ->whereNotNull('rp.created_at')
            ->whereYear('rp.created_at', $year)
            ->groupBy('users.id', 'users.name', 'users.company_logo', 'users.company_name', 'reward_month')
            ->having('monthly_points', '>', 0)
            ->orderBy('reward_month', 'desc')
            ->orderBy('monthly_points', 'desc');
    }

    /**
     * Scope: apply directory filters (company/city/country/specialization)
     * Only shows approved and active members (can login and access website)
     */
    public function scopeFilterForDirectory(Builder $query, array $filters): Builder
    {
        // Base filter: only approved and active members (exclude suspended)
        $query->where('role', self::MEMBER)
            ->where('status', self::STATUS_APPROVED)  // Profile approved and not cancelled or suspended
            ->where('is_active', true);                // Active access to website

        $query->when(!empty($filters['company_name']), function (Builder $q) use ($filters) {
            $term = $filters['company_name'];
            $q->where(function (Builder $inner) use ($term) {
                $inner->where('company_name', 'like', "%{$term}%")
                    ->orWhere('name', 'like', "%{$term}%");
            });
        });

        $query->when(!empty($filters['country']), function (Builder $q) use ($filters) {
            $q->whereHas('country', function (Builder $rel) use ($filters) {
                $rel->where(function (Builder $inner) use ($filters) {
                    $inner->where('name', 'like', "%{$filters['country']}%")
                          ->orWhere('code', 'like', "%{$filters['country']}%");
                });
            });
        });

        $query->when(!empty($filters['city']), function (Builder $q) use ($filters) {
            $q->whereHas('city', function (Builder $rel) use ($filters) {
                $rel->where('name', 'like', "%{$filters['city']}%");
            });
        });

        $query->when(!empty($filters['specialization']), function (Builder $q) use ($filters) {
            $termRaw = trim((string) $filters['specialization']);
            $termLower = strtolower($termRaw);

            $q->where(function (Builder $inner) use ($termRaw, $termLower) {
                $inner->whereJsonContains('specializations', $termRaw)
                    ->orWhereRaw('LOWER(specializations) LIKE ?', ['%"' . $termLower . '"%'])
                    ->orWhereRaw('LOWER(specializations) LIKE ?', ['%' . $termLower . '%']);
            });
        });

        return $query;
    }

    /**
     * Generate a new two factor code for the user
     */
    public function generateTwoFactorCode()
    {
        if (!$this->two_factor_enabled) {
            return;
        }

        $this->two_factor_code = Str::random(6);
        $this->two_factor_expires_at = utcNow()->addMinutes(10);
        $this->save();

        $this->notify(new TwoFactorCodeNotification());
    }

    /**
     * Reset the two factor code
     */
    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    /**
     * Check if the two factor code is valid
     */
    public function validTwoFactorCode($code)
    {
        return $this->two_factor_code === $code && 
               $this->two_factor_expires_at > utcNow();
    }

    /**
     * Enable two factor authentication
     */
    public function enableTwoFactorAuth()
    {
        $this->two_factor_enabled = true;
        $this->save();
    }

    /**
     * Disable two factor authentication
     */
    public function disableTwoFactorAuth()
    {
        $this->two_factor_enabled = false;
        $this->resetTwoFactorCode();
        $this->save();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class,'membership_tier');
    }

    /**
     * Get membership logs for this user
     */
    public function membershipLogs()
    {
        return $this->hasMany(\App\Models\MembershipLog::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get membership renewals for this user
     */
    public function membershipRenewals()
    {
        return $this->hasMany(\App\Models\MembershipRenewal::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get pending membership renewals
     */
    public function pendingRenewals()
    {
        return $this->hasMany(\App\Models\MembershipRenewal::class)
                    ->where('status', \App\Models\MembershipRenewal::STATUS_PENDING)
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get active membership renewal
     */
    public function activeRenewal()
    {
        return $this->hasOne(\App\Models\MembershipRenewal::class)
                    ->where('status', \App\Models\MembershipRenewal::STATUS_ACTIVE)
                    ->latest();
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function rewardPoints()
    {
        return $this->hasMany(RewardPoint::class);
    }

    public function generateReferralCode()
    {
        if (!$this->referral_code) {
            do {
                $code = strtoupper(Str::random(8));
            } while (static::where('referral_code', $code)->exists());
            
            $this->referral_code = $code;
            $this->save();
        }

        return $this->referral_code;
    }

    public function getReferralLink()
    {
        return url('/register?ref=' . $this->generateReferralCode());
    }

    /**
     * Get quotations given by the user
     */
    public function givenQuotations()
    {
        return $this->hasMany(MemberQuotation::class, 'given_by_id');
    }

    /**
     * Get quotations received by the user
     */
    public function receivedQuotations()
    {
        return $this->hasMany(MemberQuotation::class, 'receiver_id');
    }

    /**
     * Get the admin who cancelled the membership
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Get membership cancellation and renewal logs for this user
     */
    public function membershipCancellationAndRenewalLogs()
    {
        return $this->hasMany(MembershipLog::class)->whereIn('action', ['cancelled', 'renewed']);
    }

    /**
     * Check if membership is cancelled
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if membership is suspended
     */
    public function isSuspended()
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    /**
     * Check if membership is active
     */
    public function isActive()
    {
        return $this->status === self::STATUS_APPROVED && $this->is_active === true;
    }

    /**
     * Check if membership is renewed
     */
    public function isRenewed()
    {
        return $this->status === self::STATUS_APPROVED && $this->is_active === true;
    }
}
