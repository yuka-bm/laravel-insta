@extends('layouts.app')

@section('title', 'Update Password')

@section('content')

    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update_pass') }}" method="post" class="bg-white shadow-none rounded-3 p-5">
                @csrf
                @method('PATCH')

                <h2 class="h3 mb-3 fw-light text-muted">Update Password</h2>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                    @error('password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label fw-bold">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="{{ old('password') }}">
                    @error('confirm_password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                    @if(session('err'))
                        <p class="text-danger small">{{ session(('err')) }}</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-warning px-5 mt-3">Save</button>
            </form>
        </div>
    </div>

@endsection