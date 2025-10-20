<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // READ all authors
    public function index()
    {
        return response()->json(Author::all(), 200);
    }

    // CREATE author
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'asal' => 'nullable|string|max:100',
        ]);

        $author = Author::create($validated);
        return response()->json($author, 201);
    }

    // SHOW author by ID
    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        return response()->json($author, 200);
    }

    // UPDATE author
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'asal' => 'nullable|string|max:100',
        ]);

        $author->update($validated);
        return response()->json($author, 200);
    }

    // DELETE author
    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->delete();
        return response()->json(['message' => 'Author deleted successfully'], 200);
    }
}
