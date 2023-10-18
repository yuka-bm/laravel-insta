<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers(5);

        return view('users.home')->with('home_posts', $home_posts)
                                    ->with('suggested_users', $suggested_users);
    }

    private function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];   // in case the home_posts is empty, it will not return null, but emppty insteasd

        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
            }
        }
 
        return $home_posts;
    }

    private function getSuggestedUsers($num)
    {
        $all_user = $this->user->all()->where('role_id', 2)
                                        ->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_user as $user) {
            if (!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        if (0 < $num) {
            // array_slice(x, y, z)
            // x: name of the array
            // y: starting index
            // z: number of records to be displayed
            return array_slice($suggested_users, 0, $num);
        }
        else {
            return  $suggested_users;
        }
    }

    public function search(Request $request)
    {
        $user = $this->user->where('name', 'like', '%' . $request->search . '%')
                            ->where('role_id', 2)
                            ->get();
        return view('users.search')->with('users', $user)
                                    ->with('search', $request->search);
    }

    public function suggestions()
    {
        $suggested_users = $this->getSuggestedUsers(0);
        return view('users.suggestions')->with('suggested_users', $suggested_users);
    }
}
