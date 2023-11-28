<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;
use App\Models\Post;

class BookmarkController extends Controller
{
    private $bookmark;
    private $post;

    public function __construct(Bookmark $bookmark, Post $post)
    {
        $this->bookmark = $bookmark;
        $this->post = $post;
    }

    public function index()
    {
        $bookmark_posts = $this->getBookmarkedPosts();
        return view('users.bookmark')->with('bookmark_posts', $bookmark_posts);
    }

    private function getBookmarkedPosts()
    {
        $all_posts = $this->post->latest()->get();
        $bookmarked_posts = [];

        foreach ($all_posts as $post) {
            if (($post->isBookmarked()) && (!$post->user->trashed())) {
                $bookmarked_posts[] = $post;
            }
        }

        return $bookmarked_posts;
    }

    public function store($post_id)
    {
        $this->bookmark->user_id = Auth::user()->id;
        $this->bookmark->post_id = $post_id;
        $this->bookmark->save();

        return redirect()->back();
    }

    public function destroy($post_id)
    {
        $this->bookmark->where('post_id', $post_id)
                        ->where('user_id', Auth::user()->id)
                        ->delete();

        return redirect()->back();
    }
}
