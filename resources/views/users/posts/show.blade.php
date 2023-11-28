@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<style>
    .col-4 {
        overflow-y: scroll;
    }
    
    .card-body {
        position: absolute;
        top: 65px;
    }
</style>
    {{-- message for edit comment --}}
    @if (session('success'))
        <div class="bg-success-light p-3 mb-3 rounded">{{ session('success') }}</div>
        {{ session()->forget('success') }}
    @endif
    @error('edit_comment' . "*")
        <div class="bg-danger-light p-3 mb-3 rounded">{{ $message }}</div>
    @enderror

    <div class="row border shadow">
        <div class="col p-0 border-end">
            <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
        </div>
        <div class="col-4 px-0 bf-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
                        </div>
                        <div class="col-auto">
                            {{-- if the owner of the post, you can edit or delete this post --}}
                            @if (Auth::user()->id === $post->user->id)
                                <div class="dropdown">
                                    <button class="btn btn-small shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </div>
                                    @include('users.posts.contents.modals.delete')
                                </div>
                            @else
                                {{-- if you are not owner of the post, show an unfollow button --}}
                                @if ($post->user->isFollowed())
                                    <form action="{{ route('follow.destroy', $post->user->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary">Following</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $post->user->id) }}" method="post" class="d-inline">
                                        @csrf

                                        <button type="submit" class="border-0 bg-transparent p-0 text-primary">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body w-100">
                    <div class="row align-items-center">
                        {{-- icons --}}
                        <div class="col-auto pe-1">
                            @if ($post->isLiked())
                                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm p-0">
                                        <i class="fa-solid fa-heart text-danger"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('like.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="col-auto px-0">
                            <span>{{ $post->likes->count() }}</span>
                        </div>

                        <div class="col-auto pe-1">
                            <button type="button" class="btn btn-sm shadow-none p-0">
                                <i class="fa-regular fa-comment"></i>
                            </button>
                        </div>
                        <div class="col-auto px-0">
                            <span>{{ $post->comments->count() }}</span>
                        </div>

                        <div class="col-auto">
                            @if ($post->isBookmarked())
                                <form action="{{ route('bookmark.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm p-0">
                                        <i class="fa-solid fa-bookmark text-success"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('bookmark.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- user info --}}
                        <div class="col text-end mt-2">
                            @forelse ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    <a href="{{ route('category', $category_post->category->id) }}" class="text-decoration-none text-white">{{ $category_post->category->name }}</a>
                                </div>
                            @empty
                                <div class="badge bg-dark text-wrap">Uncategorized</div>
                            @endforelse
                        </div>
                    </div>

                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{ $post->description }}</p>
                    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
                
                    <div class="mt-2">
                        <form action="{{ route('comment.store', ['post_id' => $post->id, 'comment_id' => 0]) }}" method="post">
                            @csrf

                            <div class="input-group">
                                <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                            </div>
                            @error('comment_body' . $post->id)
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </form>

                        {{-- comments --}}
                        @if ($post->comments->isNotEmpty())
                            <ul class="list-group mt-3">
                                {{-- parent comments --}}
                                @foreach ($post->comments->where('parent_msg_id', 0) as $comment)
                                    @include('users.posts.contents.comment_list') 
                                    
                                    {{-- child comments --}}
                                    @foreach ($post->comments->where('parent_msg_id', $comment->id) as $comment)
                                        @include('users.posts.contents.comment_list')
                                    @endforeach
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 text-end">
        @error('edit_comment' . $post->id)
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

@endsection
