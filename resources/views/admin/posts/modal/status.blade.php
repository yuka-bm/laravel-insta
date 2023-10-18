{{-- Hide --}}
<div class="modal fade" id="hide-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-newspaper"></i> Hide Post
                </h3>
            </div>

            <div class="modal-body">
                Are you sure you want to hide post id  <span class="fw-bold">{{ $post->id }}</span> ?
            </div>

            <div class="modal-footer border-0">
                <form action="{{ route('admin.posts.hide', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Unhide --}}
<div class="modal fade" id="unhide-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-solid fa-newspaper"></i> Unhide Post
                </h3>
            </div>

            <div class="modal-body">
                Are you sure you want to unhide post id <span class="fw-bold">{{ $post->id }}</span> ?
            </div>

            <div class="modal-footer border-0">
                <form action="{{ route('admin.posts.unhide', $post->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Unhide</button>
                </form>
            </div>
        </div>
    </div>
</div>