<?php

namespace App\Policies;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReferralPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [User::SUPER_ADMIN, User::ADMIN]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Referral $referral): bool
    {
        return $user->id === $referral->referrer_id || 
               in_array($user->role, [User::SUPER_ADMIN, User::ADMIN]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Anyone can create a referral
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Referral $referral): bool
    {
        return in_array($user->role, [User::SUPER_ADMIN, User::ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Referral $referral): bool
    {
        return in_array($user->role, [User::SUPER_ADMIN, User::ADMIN]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Referral $referral): bool
    {
        return in_array($user->role, [User::SUPER_ADMIN, User::ADMIN]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Referral $referral): bool
    {
        return in_array($user->role, [User::SUPER_ADMIN, User::ADMIN]);
    }
}
