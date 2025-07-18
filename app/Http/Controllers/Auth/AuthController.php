<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use App\Models\Region;

class AuthController extends Controller
{
    public function getCountries()
    {
        $countries = Country::orderBy('name')->get();
        return response()->json($countries);
    }

    public function getCities(Request $request)
    {
        $cities = City::join('states', 'cities.state_id', '=', 'states.id')
                     ->where('states.country_id', $request->country_id)
                     ->select('cities.*')
                     ->orderBy('cities.name')
                     ->get();
        return response()->json($cities);
    }

    public function getRegions()
    {
        $regions = Region::orderBy('name')->get();
        return response()->json($regions);
    }
} 