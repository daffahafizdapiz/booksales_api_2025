<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // READ all genres
    public function index()
    {
        return response()->json(Genre::all(), 200);
    }

    // CREATE genre
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $genre = Genre::create($validated);
        return response()->json($genre, 201);
    }

    // SHOW genre by ID
    public function show($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre, 200);
    }

    // UPDATE genre
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $genre->update($validated);
        return response()->json($genre, 200);
    }

    // DELETE genre
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->delete();
        return response()->json(['message' => 'Genre deleted successfully'], 200);
    }
}
