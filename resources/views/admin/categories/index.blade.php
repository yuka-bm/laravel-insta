@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')

    <div class="container">
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <div class="d-flex">
                <input type="text" name="category" id="category" class="form-control w-75" placeholder="Add category...">
                <button type="submit" class="btn btn-warning ms-2"><i class="fa-solid fa-plus"></i> Add</button>
            </div>
            @error('category')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            @error('edit_category')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </form>

        <table class="table table-hover align-middle bg-white border text-secondary mt-3">
            <thead class="small table-warning text-secondary">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>COUNT</th>
                    <th>LAST UPDATED</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->CategoryPost->count() }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <button type="button" class="btn btn-outline-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}" title="Delete"><i class="fa-regular fa-trash-can"></i></button>

                        {{-- include modal --}}
                        @include('admin.categories.modal.edit')
                        @include('admin.categories.modal.delete')
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="text-dark">
                        Uncategorized
                        <p class="xsmall mb-0 text-muted">Hidden posts are not included</p>
                    </td>
                    <td>{{ $uncategorized_count }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $all_categories->links() }}
        </div>
    </div>

@endsection
