<?php

use App\Models\Country;
use App\Models\State;
use App\Models\City;

if (!function_exists('get_default_locations')) {
    function get_default_locations(): array
    {
        $defaultCountry = Country::where('code', 'SG')->first();
        
        if (!$defaultCountry) {
            return [
                'country' => null,
                'city' => null
            ];
        }

        $defaultState = State::where('country_id', $defaultCountry->id)->first();
        
        if (!$defaultState) {
            return [
                'country' => $defaultCountry,
                'city' => null
            ];
        }

        $defaultCity = City::where('state_id', $defaultState->id)
            ->where('name', 'Singapore')
            ->first();

        return [
            'country' => $defaultCountry,
            'city' => $defaultCity
        ];
    }
}