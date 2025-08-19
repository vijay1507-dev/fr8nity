<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class UniqueCompanyInCountry implements ValidationRule
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
        $countryId = request()->input('country_id');
        if (!$countryId) {
            return;
        }
        $existingCompany = User::where('company_name', $value)
            ->where('country_id', $countryId)
            ->first();
        if ($existingCompany) {
            $fail('A company with this name already exists in the selected country.');
        }
    }
}
