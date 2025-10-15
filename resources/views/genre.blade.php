<!DOCTYPE html>
<html>
<head>
    <title>Daftar Genre Buku</title>
</head>
<body>
    <h1>Daftar Genre Buku</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama Genre</th>
            <th>Deskripsi</th>
        </tr>
        @foreach ($genres as $genre)
        <tr>
            <td>{{ $genre['id'] }}</td>
            <td>{{ $genre['nama'] }}</td>
            <td>{{ $genre['deskripsi'] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
