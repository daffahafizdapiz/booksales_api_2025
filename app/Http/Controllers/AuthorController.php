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

    // GET author by id
    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        return response()->json($author, 200);
    }

    // POST create author
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'negara' => 'required|string',
        ]);

        $author = Author::create($validated);
        return response()->json([
            'message' => 'Author created successfully',
            'data' => $author
        ], 201);
    }

    // PUT update author
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|string',
            'negara' => 'sometimes|string',
        ]);

        $author->update($validated);
        return response()->json([
            'message' => 'Author updated successfully',
            'data' => $author
        ], 200);
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
