<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <!-- Link ke CSS -->
    <link rel="stylesheet" href="{{ asset('css/buku.css') }}">
</head>
<body>
    <div class="container">
        <h1>Daftar Buku</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($buku as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="summary">
            <p>Total Buku: {{ $buku->count() }}</p>
            <p>Total Harga: Rp {{ number_format($buku->sum('harga'), 0, ',', '.') }}</p>
        </div>
    </div>
</body>
</html>
