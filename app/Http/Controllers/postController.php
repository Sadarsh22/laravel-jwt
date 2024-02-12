<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class postController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        $allowedCategory = ['a','b','c','d'];
        $request->validate([
            'name' => 'required|unique:posts',
            'category' => Rule::in($allowedCategory),
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

    public function view($id)
    {
        return response()->json([
            'status'=>'success',
            'post'=>Post::find($id),
            'comments'=>Comment::where('post_id',$id)->orderBy('created_at','desc')->get(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|',
            'category' => 'required|string|min:6',
        ]);

        $post = Post::find($id);

        $post->name = $request->name;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->category = $request->category;

        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post edited successfully',
            'post' => $post,
            'user' => Auth::user(),
        ]);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
        ]);
    }
}
