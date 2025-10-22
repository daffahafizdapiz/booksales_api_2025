<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // GET all books
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Book::all()
        ], 200);
    }

    // GET book by ID
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $book
        ], 200);
    }

    // POST create new book
    public function store(Request $request)
    {
        // 1 Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer|min:0',
            'author_id' => 'required|exists:authors,id'
        ]);

        // 2. Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3 Simpan buku baru
        $book = Book::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    //  PUT update book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|string|max:255',
            'penerbit' => 'sometimes|string|max:255',
            'tahun_terbit' => 'sometimes|integer',
            'stok' => 'sometimes|integer|min:0',
            'author_id' => 'sometimes|exists:authors,id'
        ]);

        // Kalau gagal validasi
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data
        $book->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
            'data' => $book
        ], 200);
    }

    //  DELETE book
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ], 200);
    }
}
