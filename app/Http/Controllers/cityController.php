<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class cityController extends Controller
{
    public function create(Request $request, $sid)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $id = Auth::user()->id;

        $ct = City::create([
            'name' => $request->name,
            'code' => $request->code,
            'created_by' => $id,
            'updated_by' => $id,
            'state_id' => $sid
        ]);

        return response()->json([
            'message' => 'city created successfully',
            'state' => $ct
        ]);
    }

    public function update(Request $request, $cid)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $uid = Auth::user()->id;

        $city = City::find($cid);

        $city->updated_by =  $uid;
        $city->name = $request->name;

        $city->save();

        return response()->json([
            'status' => 'city edited successfully',
            'city' => $city,
        ]);
    }

    public function view()
    {
        return response()->json([
            'status' => 'success',
            'Cities' => City::all('name'),
        ]);
    }

    public function delete($cid)
    {
        $city = City::find($cid);

        $uid = Auth::user()->id;

        $city->updated_by =  $uid;
        $city->save();
        $city->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'City deleted successfully',
        ]);
    }
}
