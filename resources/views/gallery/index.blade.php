@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Gallery Photo</span>
                <a href="{{ route('gallery.create') }}" class="btn btn-sm btn-success">Create New Gallery</a>
            </div>
            <div class="card-body">
                <div class="row gallery-container">
                    @if($galleries->count() > 0)
                        @foreach ($galleries as $gallery)
                            <div class="col-sm-4 mb-4">
                                <div class="card">
                                    <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" 
                                       data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        <img class="example-image img-fluid card-img-top" 
                                             src="{{ asset('storage/posts_image/' . $gallery->picture) }}" 
                                             alt="{{ $gallery->title }}" />
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text text-center">{{ $gallery->description }}</p>
                                        <div class="d-flex justify-content-between">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <h5 class="text-center">Tidak ada data.</h5>
                        </div>
                    @endif
                </div>
                @if($galleries->hasPages())
                    <div class="pagination-container d-flex justify-content-center mt-4">
                        {{ $galleries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const galleryContainer = document.querySelector('.gallery-container');
        const paginationContainer = document.querySelector('.pagination-container');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fungsi untuk memuat galeri
        const loadGalleries = async (url = '/api/gallery') => {
            try {
                const response = await fetch(url, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();
                if (result.status === 'success') {
                    // Bersihkan kontainer sebelumnya
                    galleryContainer.innerHTML = '';
                    paginationContainer.innerHTML = '';

                    // Tampilkan galeri
                    result.data.data.forEach(gallery => {
                        const galleryHTML = `
                            <div class="col-sm-4 mb-4">
                                <div class="card">
                                    <a class="example-image-link" href="/storage/posts_image/${gallery.picture}" data-lightbox="roadtrip" data-title="${gallery.description}">
                                        <img class="example-image img-fluid card-img-top" src="/storage/posts_image/${gallery.picture}" alt="${gallery.title}" />
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text text-center">${gallery.description}</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="/gallery/${gallery.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="/gallery/${gallery.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        galleryContainer.innerHTML += galleryHTML;
                    });

                    // Tampilkan pagination
                    if (result.data.links) {
                        result.data.links.forEach(link => {
                            if (link.url) {
                                const paginationHTML = `<a href="${link.url}" class="btn btn-sm ${link.active ? 'btn-primary' : 'btn-secondary'}">${decodeHtmlEntities(link.label)}</a>`;
                                paginationContainer.innerHTML += paginationHTML;
                            }
                        });
                    }
                } else {
                    galleryContainer.innerHTML = `<div class="col-12"><h5 class="text-center">Tidak ada data.</h5></div>`;
                }
            } catch (error) {
                console.error('Error fetching gallery data:', error);
                galleryContainer.innerHTML = `<div class="col-12"><h5 class="text-center text-danger">Gagal memuat data: ${error.message}</h5></div>`;
            }
        };

        // Decode label pagination jika berisi entitas HTML
        const decodeHtmlEntities = (label) => {
            const txt = document.createElement('textarea');
            txt.innerHTML = label;
            return txt.value;
        };

        // Muat galeri awal
        loadGalleries();

        // Event listener untuk pagination
        paginationContainer.addEventListener('click', (e) => {
            e.preventDefault();
            if (e.target.tagName === 'A' && e.target.href) {
                loadGalleries(e.target.href);
            }
        });
    });
</script>
@endsection