<!DOCTYPE html>
<html>
<head>
<<<<<<< HEAD
    <title>List of Genres</title>
</head>
<body>
    <h1>Genres</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
=======
    <title>Daftar Genre Buku</title>
</head>
<body>
    <h1>Daftar Genre Buku</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama Genre</th>
            <th>Deskripsi</th>
>>>>>>> c3132b7798469c138e99b1f5f4fd24e61da92583
        </tr>
        @foreach ($genres as $genre)
        <tr>
            <td>{{ $genre['id'] }}</td>
<<<<<<< HEAD
            <td>{{ $genre['name'] }}</td>
            <td>{{ $genre['description'] }}</td>
=======
            <td>{{ $genre['nama'] }}</td>
            <td>{{ $genre['deskripsi'] }}</td>
>>>>>>> c3132b7798469c138e99b1f5f4fd24e61da92583
        </tr>
        @endforeach
    </table>
</body>
</html>
