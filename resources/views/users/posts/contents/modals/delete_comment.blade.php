<div class="modal fade" id="delete-comment-{{$comment->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-circle-exclamation"></i> Delete Comment
                </h3>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete this comment?</p>
                <div class="mt-2">{{ $comment->body }}</div>
            </div>

            <div class="modal-footer border-0">
                <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>