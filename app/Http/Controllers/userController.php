<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;

class userController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password', 'user_type');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $loggedInUserType = User::where('id', Auth::user()->id)->first()->user_type;
        switch ($loggedInUserType) {
            case ('SA'):
                $request->validate(['user_type' => 'required|' . Rule::in(['ADMIN', 'MONITOR', 'CENTER', 'AGENT'])]);
                break;
            case ('ADMIN'):
                $request->validate(['user_type' => 'required|' . Rule::in(['MONITOR', 'CENTER', 'AGENT'])]);
                break;
            case ('MONITOR'):
                $request->validate(['user_type' => 'required|' . Rule::in(['CENTER', 'AGENT'])]);
                break;
            case ('CENTER'):
                $request->validate(['user_type' => 'required|' . Rule::in(['AGENT'])]);
                break;
            case ('AGENT'):
                $request->validate(['user_type' => 'required|' . Rule::in(['AGENT'])]);
                break;
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'created_by' => Auth::user()->id
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function me()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function view($id)
    {
        $array = array();

        $array[] = Auth::user()->id;
        $uid = Auth::user()->id;
        $value = User::where('created_by', $uid)->get('id')->toArray();
        foreach ($value as $val)
            $array[] = ($val['id']);

        foreach ($array as $arr) {
            $value = User::where('created_by', $arr)->get('id')->toArray();
            if ($value) {
                foreach ($value as $val)
                    $array[] = ($val['id']);
            }
        }
        if (in_array($id, $array)) {
            $display = User::where('created_by', $id)->get();
            return response()->json($display);
        } else {
            return response()->json('Be within Your limits');
        }

        return $array;
    }

    public function edit($id)
    {
        $val = User::find();
    }
}
