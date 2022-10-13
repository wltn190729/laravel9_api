<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return response()->json($posts);
    }

    public function create(Request $request)
    {
        $subject = $request->input('subject');
        $content = $request->input('content');

        $post = new Post();
        $post->subject = $subject;
        $post->content = $content;
        $post->save();

        return response()->json($post);
    }

    public function read($id)
    {
//        $post = Post::where('id', $id)->first();
        $post = Post::find($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $subject = $request->input('subject');
        $content = $request->input('content');

        $post->subject = $subject;
        $post->content = $content;
        $post->save();

        return response()->json($post);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json(['message' => '삭제되었습니다.']);
    }
}
