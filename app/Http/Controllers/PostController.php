<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->with('comments')->get();
        return response()->json($posts);
    }

    public function create(Request $request)
    {
        $subject = $request->input('subject');
        $context = $request->input('context');

        $post = new Post();
        $post->subject = $subject;
        $post->context = $context;
        $post->save();

        return response()->json($post);
    }

    public function read($id)
    {
        $post = Post::where('id', $id)->with('comments')->first();
//        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => '조회할 데이터가 없습니다.'], 404);
        }

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response()->json(['message' => '조회할 데이터가 없습니다.'], 404);
        }

        $subject = $request->input('subject', null);
        $content = $request->input('content', null);
        if ($subject) $post->subject = $subject;
        if ($content) $post->content = $content;
        $post->save();

        return response()->json($post);
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => '조회할 데이터가 없습니다.'], 404);
        }

        $post->delete();

        return response()->json(['message' => '삭제되었습니다.']);
    }
}
