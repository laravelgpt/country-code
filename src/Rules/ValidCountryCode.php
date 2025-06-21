<?php

namespace Laravel\CountryCode\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Laravel\CountryCode\Models\Country;

class ValidCountryCode implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $code = strtoupper($value);
        
        // Check if it's a valid ISO alpha-2 code
        if (strlen($code) === 2) {
            if (!Country::where('iso_alpha2', $code)->exists()) {
                $fail("The {$attribute} must be a valid ISO 3166-1 alpha-2 country code.");
            }
            return;
        }
        
        // Check if it's a valid ISO alpha-3 code
        if (strlen($code) === 3) {
            if (!Country::where('iso_alpha3', $code)->exists()) {
                $fail("The {$attribute} must be a valid ISO 3166-1 alpha-3 country code.");
            }
            return;
        }
        
        $fail("The {$attribute} must be a valid 2 or 3 character country code.");
    }
} 