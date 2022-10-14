<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request, $postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return abort(404);
        }
    }

    public function delete($postId, $id)
    {

    }
}
