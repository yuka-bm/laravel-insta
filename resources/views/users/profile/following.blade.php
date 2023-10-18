@extends('layouts.app')

@section('title', 'Following')

@section('content')
@include('users.profile.header')

    <div class="mt-5 w-50 mx-auto">
        <h4 class="text-muted text-center mb-3">Following</h4>
        @if ($user->following->count() != 0)
            <table class="table">
                @foreach ($user->following as $following)
                    <tr>
                        @if ($following->following->avatar)
                            <td class="border-0">
                                <a href="{{ route('profile.show', $following->following->id) }}">
                                    <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}" class="rounded-circle avatar-sm">
                                </a>
                            </td>
                        @else
                            <td class="border-0">
                                <a href="{{ route('profile.show', $following->following->id) }}">
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                </a>
                            </td>
                        @endif
                        <td class="border-0">{{ $following->following->name }}</td>
                        <td class="border-0">
                            @if ($following->following->id != Auth::user()->id)
                                @if ($following->following->isFollowed())
                                    <form action="{{ route('follow.destroy', $following->following->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-secondary border-0 bg-transparent p-0">Unfollow</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $following->following->id) }}" method="post">
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
            <div class="text-center text-muted">No Following yet</div>
        @endif
        
    </div>

@endsection
