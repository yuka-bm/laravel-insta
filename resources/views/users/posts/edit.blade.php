@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<div class="container">
    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <h4 class="fw-bold">Category <span class="fw-normal">(up to 3)</span></h4>
        @forelse($all_categories as $category)
            <div class="form-check form-check-inline">
                @if(in_array($category->id, $selected_categories))
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input" checked>
                @else
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                @endif
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>
        @empty
        @endforelse
        @error('category')
            <p class="text-danger small">{{ $message }}</p>
        @enderror

        <h4 class="fw-bold mt-3">Description</h4>
        <textarea name="description" id="description" rows="4" class="form-control" placeholder="What's on your mind">{{ old('description', $post->description) }}</textarea>
        @error('description')
            <p class="text-danger small">{{ $message }}</p>
        @enderror

        <div class="row mb-4 mt-3">
            <div class="col-6">
                <label for="image" class="form-label fw-bold h4">Image</label>
                <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="img-thumbnail w-100">
                <input type="file" name="image" id="image" class="form-control" aria-discribedby="image-info">
                <div id="image-info" class="form-text">
                    The acceptable formats are jpeg, jpg, png, gif only.<br>
                    Max file size is 1048KB.
                </div>
                @error('image')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>
</div>

@endsection
