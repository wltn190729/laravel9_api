<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->with('comments', 'categories')->get();
        return response()->json($posts);
    }

    public function create(Request $request)
    {
//        $subject = $request->input('subject');
//        $context = $request->input('context');

//        $post = new Post();
//        $post->subject = $subject;
//        $post->context = $context;
//        $post->save();

        $params = $request->only(['subject' , 'context']);
        $post = Post::create($params);
        $ids = $request->input('category_ids');
        //attach, detach, sync
        $post->categories()->sync($ids);
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
        $ids = $request->input('category_ids');

        if ($subject) $post->subject = $subject;
        if ($content) $post->content = $content;

        $post->save();
        $post->categories()->sync($ids);

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

    public function pagination(Request $request)
    {
        $size = $request->input('size') ?? 10;
        $offset = ($request->input('page') ?? 0) * $size;

        $posts = Post::orderBy('created_at', 'desc')->offset($offset)->limit($size)->get();

        $totalCnt = Post::all()->count();

        return response()->json(['data' => $posts, 'total' => $totalCnt]);

    }
}
