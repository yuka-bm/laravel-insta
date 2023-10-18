<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    public function create()
    {
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required | array | between:1,3',
            'description' => 'required | min:1 | max:1000',
            'image' => 'required | mimes:jpeg,jpg,png,gif | max:1048'
        ]);

        # save the post
        $this->post->user_id = Auth::user()->id;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        # save the categories to the category_post table
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];
        }
        $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index');
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        if (Auth::user()->id != $post->user->id) {
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();
        $selected_categories = [];

        foreach ($post->categoryPost as $category_post) {
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')->with('post', $post)
                                        ->with('all_categories', $all_categories)
                                        ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required | array | between:1,3',
            'description' => 'required | min:1 | max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif | max:1048'
        ]);

        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        if ($request->image) {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        $post->categoryPost()->delete();
        
        // add new category
        foreach ($request->category as $category_id) {
            $category_post_a[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post_a);

        return redirect()->route('post.show', $id);
    }

    public function destroy($id)
    {
        // soft delete
        // $this->post->destroy($id);
        $post = $this->post->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('index');
    }
}
