@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row gx-5">
    {{-- message for edit comment --}}
    @if (session('success'))
        <div class="bg-success-light p-3 mb-3 rounded">{{ session('success') }}</div>
        {{ session()->forget('success') }}
    @endif
    @error('edit_comment' . "*")
        <div class="bg-danger-light p-3 mb-3 rounded">{{ $message }}</div>
    @enderror

    <div class="col-8">
        @if (request()->is('*/category'))
            <div class="badge bg-secondary bg-opacity-50 fs-5 mb-3">{{ $category_name }}
                <a href="{{ route('index') }}" class="text-decoration-none text-white">&nbsp;<i class="fa-solid fa-xmark"></i></a>
            </div>
        @endif
        @forelse ($home_posts as $post)
            <div class="card mb-4">
                {{-- title --}}
                @include('users.posts.contents.title')
                {{-- body --}}
                @include('users.posts.contents.body')
            </div>
        @empty
            <div class="text-center">
                <h2>Share Photos</h2>
                <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
            </div>
        @endforelse
    </div>

    <div class="col-4">
        {{-- PROFILE OVERVIEW --}}
        <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', Auth::user()->id) }}">
                    @if (Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-md">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>

            <div class="col ps-0">
                <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- SUGGESTIONS --}}
        @if ($suggested_users)
            <div class="row">
                <div class="col-auto">
                    <p class="fw-bold text-secondary">Suggestions For You</p>
                </div>
                <div class="col text-end">
                    <a href="{{ route('suggestions') }}" class="fw-bold text-dark text-decoration-none">See All</a>
                </div>
            </div>

            @foreach ($suggested_users as $user)
                <div class="row align-item-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>

                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
