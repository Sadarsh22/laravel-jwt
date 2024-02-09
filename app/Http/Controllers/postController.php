<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class postController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|',
            'category' => 'required|string|min:6',
        ]);

        $uid = Auth::user()->id;

        $post = Post::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'category' => $request->category,
            'user_id' => $uid,
        ]);

        // $token=Auth::login();
        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'post' => $post,
            'user' => Auth::user(),
            'authorisation' => [
                // 'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function listing()
    {
        return response()->json([
            'status' => 'success',
            'listing' => Post::all(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|',
            'category' => 'required|string|min:6',
        ]);

        // $uid = Auth::user()->id;
        $post = Post::find($id);
        print_r($id);
        die();

        $post->name = $request->name;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->category = $request->category;
        $post->user_id = $id;

        print_r($post);
        die();

        // $post->save();
        // $post::save([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'image' => $request->image,
        //     'category' => $request->category,
        //     'user_id' =>$id,
        // ]);
    }
}