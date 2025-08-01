<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidReferralCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $referrer = \App\Models\User::where('referral_code', $value)
            ->where('status', 'approved')
            ->first();

        if (!$referrer) {
            $fail('The referral code is invalid.');
        }
    }
}
