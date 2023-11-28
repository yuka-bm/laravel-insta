<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>

<div class="card-body">
    <div class="row align-items-center mb-2">
        <div class="col-auto">
            @if ($post->isLiked())
                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm p-0">
                        <i class="fa-solid fa-heart text-danger reaction"></i>
                    </button>
                </form>
            @else
                <form action="{{ route('like.store', $post->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-regular fa-heart reaction"></i>
                    </button>
                </form>
            @endif
        </div>
        <div class="col-auto px-0">
            <span>{{ $post->likes->count() }}</span>
        </div>

        <div class="col-auto ms-3">
            <button type="button" class="btn btn-sm shadow-none p-0">
                <i class="fa-regular fa-comment reaction"></i>
            </button>
        </div>
        <div class="col-auto px-0">
            <span>{{ $post->comments->count() }}</span>
        </div>

        <div class="col-auto ms-3">
            @if ($post->isBookmarked())
                <form action="{{ route('bookmark.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm p-0">
                        <i class="fa-solid fa-bookmark text-success reaction"></i>
                    </button>
                </form>
            @else
                <form action="{{ route('bookmark.store', $post->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-regular fa-bookmark reaction"></i>
                    </button>
                </form>
            @endif
        </div>

        <div class="col text-end">
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

    @include('users.posts.contents.comment')
</div>