@extends('layouts.app')

@section('title', 'Bookmarks')

@section('content')

    @forelse ($bookmark_posts as $post)
        <div class="card mb-4">
            {{-- title --}}
            @include('users.posts.contents.title')
            {{-- body --}}
            @include('users.posts.contents.body')
        </div>
    @empty
        <div class="text-center">
            <h2>No Bookmarks yet.</h2>
        </div>
    @endforelse

@endsection