<?php
namespace App\Http\Controllers;

use App\Post;
use App\Events\PostCreated;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
    return view('post.create');
    }

    public function createPost(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->save();

        return response()->json([
        'message' => 'New post created'
        ]);
    }
}
