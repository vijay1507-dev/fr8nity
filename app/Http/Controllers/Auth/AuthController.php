<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Region;

class AuthController extends Controller
{
    public function getCountries()
    {
        $countries = Country::orderBy('name')->get();
        return response()->json($countries);
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)
                      ->orderBy('name')
                      ->get();
        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)
                     ->orderBy('name')
                     ->get();
        return response()->json($cities);
    }

    public function getRegions()
    {
        $regions = Region::orderBy('name')->get();
        return response()->json($regions);
    }
} 