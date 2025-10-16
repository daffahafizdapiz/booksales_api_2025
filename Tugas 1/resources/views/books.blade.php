<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
</head>
<body>
    <h1>Daftar Buku</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Stok</th>
            <th>Penulis</th>
        </tr>
        @foreach ($books as $book)
        <tr>
            <td>{{ $book->id }}</td>
            <td>{{ $book->judul }}</td>
            <td>{{ $book->penerbit }}</td>
            <td>{{ $book->tahun_terbit }}</td>
            <td>{{ $book->stok }}</td>
            <td>{{ $book->author->nama }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
