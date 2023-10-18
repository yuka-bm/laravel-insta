@extends('layouts.app')

@section('title', 'Followers')

@section('content')
@include('users.profile.header')

    <div class="mt-5 w-50 mx-auto">
        <h4 class="text-muted text-center mb-3">Followers</h4>
        @if ($user->followers->count() != 0)
            <table class="table">
                @foreach ($user->followers as $follower)
                    <tr>
                        @if ($follower->follower->avatar)
                            <td class="border-0">
                                <a href="{{ route('profile.show', $follower->follower->id) }}">
                                    <img src="{{ $follower->follower->avatar }}" alt="{{ $follower->follower->name }}" class="rounded-circle avatar-sm">
                                </a>
                            </td>
                        @else
                            <td class="border-0">
                                <a href="{{ route('profile.show', $follower->follower->id) }}">
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                </a>
                            </td>
                        @endif
                        <td class="border-0">{{ $follower->follower->name }}</td>
                        <td class="border-0">
                            @if ($follower->follower->id != Auth::user()->id)
                                @if ($follower->follower->isFollowed())
                                    <form action="{{ route('follow.destroy', $follower->follower->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-secondary border-0 bg-transparent p-0">Unfollow</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $follower->follower->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="text-primary border-0 bg-transparent p-0">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="text-center text-muted">No Followers yet</div>
        @endif
        
    </div>

@endsection
