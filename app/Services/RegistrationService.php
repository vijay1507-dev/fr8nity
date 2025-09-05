<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use App\Notifications\RegistrationConfirmationNotification;

class RegistrationService
{
    public function __construct(
        private readonly MembershipNumberService $membershipNumberService,
    ) {
    }

    /**
     * Handles member registration domain logic:
     * - Create user
     * - Generate membership number
     * - Create referral record (if any)
     * - Notify super admin and user
     */
    public function registerMember(array $attributes, ?User $referrer = null): User
    {
        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'designation' => $attributes['designation'],
            'whatsapp_phone' => $attributes['whatsapp_phone'],
            'company_name' => $attributes['company_name'],
            'company_telephone' => $attributes['company_telephone'],
            'company_address' => $attributes['company_address'],
            'country_id' => $attributes['country_id'],
            'city_id' => $attributes['city_id'],
            'region_id' => $attributes['region_id'],
            'referred_by' => $referrer?->id,
            'specializations' => json_encode($attributes['specializations']),
            'incorporation_date' => $attributes['incorporation_date'],
            'tax_id' => $attributes['tax_id'],
            'website_linkedin' => $attributes['website_linkedin'],
            'is_network_member' => $attributes['is_network_member'],
            'network_name' => $attributes['network_name'] ?? null,
            'membership_tier' => (int) $attributes['membership_tier'],
            'role' => User::MEMBER,
            'status' => 'pending',
        ]);

        $membershipNumber = $this->membershipNumberService->generateForTierId((int) $user->membership_tier);
        $user->update(['membership_number' => $membershipNumber]);

        if ($referrer) {
            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
                'referral_code' => $attributes['referral_code'] ?? null,
                'registered_at' => utcNow(),
            ]);
        }

        $superAdmin = User::where('role', User::SUPER_ADMIN)->first();
        if ($superAdmin) {
            $superAdmin->notify(new NewRegistrationNotification($user));
        }

        $user->notify(new RegistrationConfirmationNotification($user));

        return $user;
    }
}


