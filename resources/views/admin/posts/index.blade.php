@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')

    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED_AT</th>
                <th>
                    <div class="d-flex">
                        STATUS
                        <a href="{{ route('admin.posts.sort', isset($post_status) ? $post_status : 1) }}" class="ms-auto text-decoration-none">
                            @if (isset($post_status))
                                @if ($post_status == 1)
                                    <i class="fa-solid fa-caret-down fs-5 text-primary"></i>
                                @else
                                    <i class="fa-solid fa-caret-up fs-5 text-primary"></i>
                                @endif
                            @else
                                <i class="fa-solid fa-caret-down fs-5 text-dark"></i>
                            @endif
                        </a>
                    </div>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>
                    <a href="{{ route('post.show', $post->id) }}">
                        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="d-block mx-auto image-md">
                    </a>
                </td>
                <td>
                    {{-- category --}}
                    @forelse ($post->categoryPost as $category_post)
                        <div class="badge bg-secondary bg-opacity-50">
                            <a href="{{ route('category', $category_post->category->id) }}" class="text-decoration-none text-white">{{ $category_post->category->name }}</a>
                        </div>
                    @empty
                        <div class="badge bg-dark text-wrap">Uncategorized</div>
                    @endforelse
                </td>
                <td>
                    @if ($post->user->trashed())
                        {{ $post->user->name }}
                    @else
                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none fw-bold text-dark">
                        {{ $post->user->name }}
                    </a>
                    @endif
                </td>
                <td>{{ $post->created_at }}</td>
                <td>
                    @if ($post->trashed())
                        <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Hidden
                    @else
                        <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                    @endif
                </td>
                <td>
                    @if (Auth::user()->id !== $post->user->id)
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="dropdown-menu">
                                @if ($post->trashed())
                                    <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#unhide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-newspaper"></i> Unhide post id {{ $post->id }}
                                    </button>
                                @else
                                    <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-newspaper"></i> Hide post id {{ $post->id }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        {{-- include modal --}}
                        @include('admin.posts.modal.status')
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $all_posts->links() }}
    </div>

@endsection
