<div class="mt-3">
    {{-- comments --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            {{-- parent comments --}}
            @foreach ($post->comments->where('parent_msg_id', 0)->take(3) as $comment)
                @include('users.posts.contents.comment_list')
                
                {{-- child comments --}}
                @foreach ($post->comments->where('parent_msg_id', $comment->id)->take(2) as $comment)
                    @include('users.posts.contents.comment_list')
                @endforeach
            @endforeach

            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">View all {{ $post->comments->count() }} comments</a>
                </li>
            @endif
        </ul>
    @endif

    <form action="{{ route('comment.store', ['post_id' => $post->id, 'comment_id' => 0]) }}" method="post">
        @csrf

        <div class="input-group">
            <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
    </form>
    @error('comment_body' . $post->id)
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    @error('edit_comment' . $post->id)
        <div class="text-danger small">{{ $message }}</div>
        {{ session(['error' => $message]) }}
    @enderror
</div>