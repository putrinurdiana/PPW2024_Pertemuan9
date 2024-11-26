@extends('buku.layoutdua')

@section('content')

<div class="container">
    <h4>Edit Buku</h4>
    <form method="post" enctype="multipart/form-data" action="{{ route('buku.update', $buku->id) }}">
        @csrf
        @method('PUT') <!-- Tambahkan metode PUT untuk update -->

        <div>Judul <input type="text" name="judul" value="{{ $buku->judul }}" required></div>
        <div>Penulis <input type="text" name="penulis" value="{{ $buku->penulis }}" required></div>
        <div>Harga <input type="number" name="harga" value="{{ $buku->harga }}" required></div>
        <div>Tanggal Terbit <input type="date" name="tgl_terbit" value="{{ $buku->tgl_terbit }}" required></div>
        <div>Photo <input type="file" name="photo" required></div>
        
        <button type="submit">Update</button>
        <a href="{{ url('/buku') }}">Kembali</a>
    </form>
</div>

@endsection
