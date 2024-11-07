@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Gallery Photo</div>
            <a href="{{ route('gallery.create') }}" class="btn btn-sm btn-success">Create New Gallery</a>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                        @foreach ($galleries as $gallery)
                            <div class="col-sm-2">
                                <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                    <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="Image-1" />
                                </a>
                                <div class="mt-2 d-flex justify-content-between">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>
                    @endif
                    <div class="d-flex">
                        {{ $galleries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
