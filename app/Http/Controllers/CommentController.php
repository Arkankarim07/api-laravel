<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // $commentUser = $request->post_id;

        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment_content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment = Comment::create($request->all());

        return new CommentResource($comment->loadMissing('userComment:id,email,username'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'comment_content' => 'required',
        ]);

        $comment = Comment::findorfail($id);
        $comment->update($request->only('comment_content'));

        return new CommentResource($comment->loadMissing('userComment:id,email,username'));
    }

    public function delete($id)
    {
        $comment = Comment::findorfail($id);
        $comment->delete();
        return new CommentResource($comment);
    }
}
