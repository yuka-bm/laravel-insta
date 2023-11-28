<li class="list-group-item border-0 p-0 mb-2">
    <div class="{{ !$comment->parent_msg_id == 0 ? 'ms-3' : '' }}">
        <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
        &nbsp;
        <p class="d-inline fw-light">{{ $comment->body }}</p>
    
        <span class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>
    
        @if ($comment->parent_msg_id == 0)
            &middot;
            <button type="button" class="border-0 bg-transparent text-success p-0" data-bs-toggle="modal" data-bs-target="#reply-comment-{{$comment->id}}">Reply</button>
            @include('users.posts.contents.modals.reply_comment')
        @endif
        
        @if (Auth::user()->id === $comment->user->id)
            {{ !$comment->parent_msg_id == 0 ? ' · ' : '' }}
            <button type="button" class="border-0 bg-transparent text-primary p-0 ms-1" data-bs-toggle="modal" data-bs-target="#edit-comment-{{$comment->id}}">Edit</button>
            <button type="button" class="border-0 bg-transparent text-danger p-0 ms-1" data-bs-toggle="modal" data-bs-target="#delete-comment-{{$comment->id}}">Delete</button>
            @include('users.posts.contents.modals.edit_comment')
            @include('users.posts.contents.modals.delete_comment')
        @endif
    </div>
</li>
