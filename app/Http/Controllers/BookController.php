<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET all books
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    // GET book by id
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book, 200);
    }

    // POST create new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
            'author_id' => 'required|exists:authors,id'
        ]);

        $book = Book::create($validated);
        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    // PUT update book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'judul' => 'sometimes|string',
            'penerbit' => 'sometimes|string',
            'tahun_terbit' => 'sometimes|integer',
            'stok' => 'sometimes|integer',
            'author_id' => 'sometimes|exists:authors,id'
        ]);

        $book->update($validated);
        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book
        ], 200);
    }

    // DELETE book
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
