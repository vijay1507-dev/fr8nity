<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class UniqueCompanyInCountry implements ValidationRule
{
    protected $excludeUserId;

    public function __construct($excludeUserId = null)
    {
        $this->excludeUserId = $excludeUserId;
    }

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
        
        $query = User::where('company_name', $value)
            ->where('country_id', $countryId);
            
        // Exclude the current user if editing
        if ($this->excludeUserId) {
            $query->where('id', '!=', $this->excludeUserId);
        }
        
        $existingCompany = $query->first();
        
        if ($existingCompany) {
            $fail('A company with this name already exists in the selected country.');
        }
    }
}
