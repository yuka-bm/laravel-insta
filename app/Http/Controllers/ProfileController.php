<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    private $user;
    private $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        $bookmarked_posts = $this->getBookmarkedPosts();

        return view('users.profile.show')->with('user', $user)
                                            ->with('bookmarked_posts', $bookmarked_posts);
    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required | min:1 | max:255',
            'email' => 'required | email | min:1 | max:255 | unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpeg,jpg,png,gif | max:1048',
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;

        $user->introduction = null;
        if ($request->introduction) {
            $user->introduction = $request->introduction;
        }

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->save();

        return redirect()->route('index');
    }

    public function followers($user_id)
    {
        $user = $this->user->findOrFail($user_id);
        $bookmarked_posts = $this->getBookmarkedPosts();
        return view('users.profile.followers')->with('user', $user)
                                                ->with('bookmarked_posts', $bookmarked_posts);
    }

    public function following($user_id)
    {
        $user = $this->user->findOrFail($user_id);
        $bookmarked_posts = $this->getBookmarkedPosts();
        return view('users.profile.following')->with('user', $user)
                                                ->with('bookmarked_posts', $bookmarked_posts);
    }

    public function editPassword()
    {
        return view('users.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required | min:8',
            'confirm_password' => 'required | min:8'
        ]);

        if ($request->password != $request->confirm_password) {
            return redirect()->route('profile.edit_pass')->with('err', "Password and Confirm Password did not match.");
        }

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
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
}
