<!DOCTYPE html>
<html>
<head>
    <title>List of Genres</title>
</head>
<body>
    <h1>Genres</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
        @foreach ($genres as $genre)
        <tr>
            <td>{{ $genre['id'] }}</td>
            <td>{{ $genre['name'] }}</td>
            <td>{{ $genre['description'] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
