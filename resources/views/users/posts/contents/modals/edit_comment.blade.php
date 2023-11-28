<div class="modal fade" id="edit-comment-{{$comment->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-solid fa-circle-exclamation"></i> Edit Comment
                </h3>
            </div>

            <form action="{{ route('comment.update', ['post_id' => $post->id, 'comment_id' => $comment->id]) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <textarea name="edit_comment{{ $post->id }}" rows="5" class="form-control form-control-sm">{{ $comment->body }}</textarea>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>