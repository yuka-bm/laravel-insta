<div class="modal fade" id="reply-comment-{{$comment->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <h3 class="h5 modal-title text-success">
                    <i class="fa-solid fa-circle-exclamation"></i> Reply Comment
                </h3>
            </div>

            <form action="{{ route('comment.store', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" method="post">
                @csrf

                <div class="modal-body">
                    {{ $comment->body }}
                    <textarea name="comment_body{{ $post->id }}" rows="3" class="form-control form-control-sm mt-3" placeholder="Add a comment..."></textarea>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>