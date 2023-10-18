@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<div class="container">
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h4 class="fw-bold">Category <span class="fw-normal">(up to 3)</span></h4>
        @forelse($all_categories as $category)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>
        @empty
        @endforelse
        @error('category')
            <p class="text-danger small">{{ $message }}</p>
        @enderror

        <h4 class="fw-bold mt-3">Description</h4>
        <textarea name="description" id="description" rows="4" class="form-control" placeholder="What's on your mind">{{ old('description') }}</textarea>
        @error('description')
            <p class="text-danger small">{{ $message }}</p>
        @enderror

        <h4 class="fw-bold mt-3">Image</h4>
        <input type="file" name="image" id="image" class="form-control">
        <p class="small">Acceptable formats: jpeg, jpg, png, gif only <br>Max file size is 1048KB</p>
        @error('image')
            <p class="text-danger small">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>
</div>

@endsection
