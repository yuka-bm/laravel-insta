{{-- Edit --}}
<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-tags"></i> Edit Category
                </h3>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <input type="text" name="edit_category" id="edit_category" class="form-control" value="{{ $category->name }}">

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
