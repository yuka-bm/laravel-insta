<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id, $comment_id)
    {
        $request->validate([
            'comment_body' . $post_id => 'required | max:150'
        ],
        [
            'comment_body' . $post_id, 'required' => 'You cannot submit an empty comment.',
            'comment_body' . $post_id, 'max' => 'The comment must not have more than 150 characters.'
        ]);

        $this->comment->body = $request->input('comment_body' . $post_id);
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->parent_msg_id = $comment_id;
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($comment_id)
    {
        $this->comment->where('parent_msg_id', $comment_id)->delete();
        $this->comment->destroy($comment_id);

        return redirect()->back();
    }

    public function update(Request $request, $post_id, $comment_id)
    {
        $request->validate([
            'edit_comment' . $post_id => 'required | max:150'
        ],
        [
            'edit_comment' . $post_id, 'required' => 'You cannot submit an empty comment.',
            'edit_comment' . $post_id, 'max' => 'The comment must not have more than 150 characters.'
        ]);

        $comment = $this->comment->findOrFail($comment_id);
        $comment->body = $request->input('edit_comment' . $post_id);
        $comment->save();

        return redirect()->back()->with('success', 'The comment was successfully updated.');
    }
}
