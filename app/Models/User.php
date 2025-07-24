<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        'designation',
        'whatsapp_phone',
        'company_name',
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
        'status',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_enabled',
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
            'two_factor_enabled' => 'boolean',
        ];
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
}
