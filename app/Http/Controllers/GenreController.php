<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // GET all genres
    public function index()
    {
        return response()->json(Genre::all(), 200);
    }

    // POST create new genre
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $genre = Genre::create($validated);

        return response()->json([
            'message' => 'Genre created successfully',
            'data' => $genre
        ], 201);
    }
}
