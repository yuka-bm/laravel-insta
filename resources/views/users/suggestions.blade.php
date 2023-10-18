@extends('layouts.app')

@section('title', 'Suggestions')

@section('content')

    <div class="contaiiner">
        <table class="table mx-auto">
            @forelse ($suggested_users as $user)
                <tr>
                    <td class="border-0">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user d-block text-center text-secondary icon-md">
                        @endif
                    </td>
                    <td class="border-0 align-middle">
                        <a href="{{ route('profile.show', $user->id) }}" class="fw-bold text-decoration-none text-dark">{{ $user->name }}</a>
                        <div class="text-muted">
                            {{ $user->posts->count() }} {{ $user->posts->count() == 1 ? 'post' : 'posts' }} &nbsp;
                            {{ $user->followers->count() }} {{ $user->followers->count() == 1 ? 'follower' : 'followers' }} &nbsp;
                            {{ $user->following->count() }} following
                        </div>
                    </td>
                    <td class="border-0 align-middle">
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                        </form>
                    </td>
                </tr>
            @empty
                <div class="text-muted text-center fs-4">You followed all</div>
            @endforelse
        </div>
    </div>
    
@endsection