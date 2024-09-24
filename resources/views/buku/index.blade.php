<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
</head>
<body>
<a href="{{ route('buku.create')}}" class="btn btn-primary float-end">Tambah Buku</a>
<table class="table table-stripped">
    <thead>
        <tr>
            <th>id</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_buku as $buku)
            <tr>
                <td>{{ $buku->id }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ "Rp. ".number_format($buku->harga, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('D/M/Y') }}</td>
                <td>
                <div class="action-buttons">
                        <form action="{{ route('buku.destroy', $buku->id)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin mau di hapus?')" type="submit"
                            class="btn btn-danger">Hapus</button>
                        </form>
                        
                        <form action="{{ route('buku.edit', $buku->id)}}" method="PUT" style="display:inline;">
                            @csrf
                            @method('UPDATE')
                            <button onclick="return confirm('Yakin mau di melanjutkan update?')" type="submit"
                            class="btn btn-warning">Update</button>
                        </form>
                    </div>
                </td>
                
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
