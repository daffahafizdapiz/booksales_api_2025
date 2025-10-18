<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // GET all authors
    public function index()
    {
        return response()->json(Author::all(), 200);
    }

    // POST create author
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'asal' => 'required|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'message' => 'Author created successfully',
            'data' => $author
        ], 201);
    }
}
