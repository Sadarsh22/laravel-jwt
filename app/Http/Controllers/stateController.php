<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
USE Illuminate\Support\Facades\Auth;

class stateController extends Controller
{
    public function create(Request $request,$cid)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|min:2|unique:countries'
        ]);

        $id = Auth::user()->id;

        $st = State::create([
            'name'=>$request->name,
            'code'=>$request->code,
            'created_by'=>$id,
            'updated_by'=>$id,
            'country_id'=>$cid
        ]);

        return response()->json([
            'message'=>'state created successfully',
            'state'=>$st
        ]);
    }

    public function update(Request $request,$sid)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|min:2|unique:states,code,'.$sid
        ]);
        
        $uid = Auth::user()->id;

        $state = State::find($sid);
        
        $state->code=$request->code;
        $state->created_by =  $uid;
        $state->name=$request->name;

        $state->save();

        return response()->json([
            'status'=>'State edited successfully',
            'state'=>$state,
        ]);
    }

    public function view()
    {
        return response()->json([
            'status'=>'success',
            'States'=>State::all('name'),
        ]);
    }

    public function read(Request $request)
    {
        $sid = State::where('code',$request->code)->first()->id;
        $cities = City::where('state_id',$sid)->get('name');
        return response()->json([
            'status'=>'success',
            'cities'=>$cities
        ]);
    }

    public function delete($sid)
    {
        $state = State::find($sid);
        $uid = Auth::user()->id;
        $state->updated_by =  $uid;
        $state->save();

        $state->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'state deleted successfully',
        ]);
    }
}
