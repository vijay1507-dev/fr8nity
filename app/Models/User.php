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
            'two_factor_enabled' => 'boolean',
            'certificate_uploaded_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope: only approved and active members
     */
    public function scopeApprovedActiveMembers(Builder $query): Builder
    {
        return $query->where('role', self::MEMBER)
            ->where('status', 'approved')
            ->where('is_active', true);
    }

    /**
     * Scope: apply directory filters (company/city/country/specialization)
     */
    public function scopeFilterForDirectory(Builder $query, array $filters): Builder
    {
        $query->when(!empty($filters['company_name']), function (Builder $q) use ($filters) {
            $term = $filters['company_name'];
            $q->where(function (Builder $inner) use ($term) {
                $inner->where('company_name', 'like', "%{$term}%")
                    ->orWhere('name', 'like', "%{$term}%");
            });
        });

        $query->when(!empty($filters['country']), function (Builder $q) use ($filters) {
            $q->whereHas('country', function (Builder $rel) use ($filters) {
                $rel->where('name', 'like', "%{$filters['country']}%");
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
        $this->two_factor_expires_at = now()->addMinutes(10);
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
               $this->two_factor_expires_at > now();
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
}
