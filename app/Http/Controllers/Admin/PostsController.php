<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $all_posts = $this->post->withTrashed()->latest()->paginate(5);
        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    public function hide($id)
    {
        $this->post->destroy($id);
        return redirect()->back();
    }

    public function unhide($id)
    {
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function sort($post_status)
    {
        $post_status = $this->toggleStatus($post_status);
        if (1 == $post_status) {
            $all_posts = $this->post->withTrashed()->orderBy('deleted_at', 'desc')->latest()->paginate(5);
        }
        else if (2 == $post_status) {
            $all_posts = $this->post->withTrashed()->orderBy('deleted_at', 'asc')->latest()->paginate(5);
        }
        else {
            $all_posts = $this->post->withTrashed()->latest()->paginate(5);
        }

        return view('admin.posts.index')->with('all_posts', $all_posts)
                                        ->with('post_status', $post_status);
    }

    private function toggleStatus($status)
    {
        if (0 == $status) {
            $status = 1;
        }
        else if (1 == $status) {
            $status = 2;
        }
        else if (2 == $status) {
            $status = 1;
        }

        return $status;
    }
}
