@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit Gallery</div>
            <div class="card-body">
                <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Input Title -->
                    <div class="mb-3 row">
                        <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $gallery->title) }}">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Input Description -->
                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="description" rows="5" name="description">{{ old('description', $gallery->description) }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Picture -->
                    <div class="mb-3 row">
                        <label for="current-picture" class="col-md-4 col-form-label text-md-end text-start">Current Picture</label>
                        <div class="col-md-6">
                            <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" class="img-fluid mb-2" alt="Current Image">
                        </div>
                    </div>

                    <!-- Input New Picture -->
                    <div class="mb-3 row">
                        <label for="picture" class="col-md-4 col-form-label text-md-end text-start">New Picture</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="picture" name="picture">
                            @error('picture')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
