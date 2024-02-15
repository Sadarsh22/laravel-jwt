<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\State;
use App\Models\Country;
use App\Models\City;

class zipcodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            'zipcode' => 'required|unique:zipcode,zipcode'
        ]);

        $zip = Zipcode::create([
            'city_id' => $id,
            'zipcode' => $request->zipcode
        ]);

        return response()->json([
            'status' => 'success',
            'zip' => $zip,
        ]);
    }

    public function view(Request $request)
    {
        $val = Country::join('states', 'states.country_id', '=', 'countries.id')
            ->join('cities', 'cities.state_id', '=', 'states.id')
            ->join('zipcode', 'zipcode.city_id', '=', 'cities.id')
            ->where('zipcode', 'like', '%' . $request->zipcode . '%')
            ->select('countries.name as country_name', 'states.name as state_name', 'cities.name as city_name', 'zipcode.zipcode')
            ->get();
        return response()->json($val);
    }
}
