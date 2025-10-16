<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penulis</title>
</head>
<body>
    <h1>Daftar Penulis</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Asal</th>
        </tr>
        @foreach ($authors as $author)
        <tr>
            <td>{{ $author->id }}</td>
            <td>{{ $author->nama }}</td>
            <td>{{ $author->asal }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
