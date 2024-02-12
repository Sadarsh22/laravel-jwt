<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class countryController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|min:3|unique:countries'
        ]);

        $id = Auth::user()->id;

        $cnt = Country::create([
            'name'=>$request->name,
            'code'=>$request->code,
            'created_by'=>$id,
            'updated_by'=>$id,
        ]);

        return response()->json([
            'message'=>'country created successfully',
            'country'=>$cnt
        ]);
    }

    public function update(Request $request,$cid)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|min:3|unique:countries'
        ]);
        
        $uid = Auth::user()->id;

        $country = Country::find($cid);
        
        $country->name=$request->name;
        $country->code=$request->code;
        $country->updated_by =  $uid;

        $country->save();

        return response()->json([
            'status'=>'Country edited successfully',
            'country'=>$country,
        ]);
    }

    public function view()
    {
        return response()->json([
            'status'=>'success',
            'Countries'=>Country::all('name'),
        ]);
    }

    public function delete($cid)
    {
        $country = Country::find($cid);
        $uid = Auth::user()->id;

        $country->updated_by =  $uid;
        $country->save();

        $country->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Country deleted successfully',
        ]);
    }
}
