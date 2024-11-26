<!-- harus ditambahkan extends -->
@extends('buku.layout')

@section('content')
    <div class="container">
        <h4>Tambah Buku</h4>
        <form method="post" enctype="multipart/form-data" action="{{route('buku.store')}}">
            @csrf
            <div>Judul <input type="text" name="judul"></div>
            <div>Penulis <input type="text" name="penulis"></div>
            <div>Harga <input type="text" name="harga"></div>
            <div>Tanggal Terbit <input type="date" name="tgl_terbit"></div>
            <div>Photo <input type="file" name="photo"></div>
            <button type="submit">Simpan</button>
            <a href="{{'/buku'}}">Kembali</a>
        </form>
    </div>
@endsection