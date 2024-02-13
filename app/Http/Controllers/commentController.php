<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class commentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request,$pid)
    {
        $comment = Comment::create([
            'message' => $request->message,
            'post_id' => $pid,
        ]);

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'comment' => $comment,
            'user' => Auth::user(),
        ]);
    }

    public function edit(Request $request,$id)
    {
        $comment = Comment::find($id);

        $comment->message = $request->message;
        $comment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment edited successfully',
            'comment' => $comment,
            'user' => Auth::user(),
        ]);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'status' =>'success',
            'message'=>'comment deleted successfully'
        ]);
    }
}
