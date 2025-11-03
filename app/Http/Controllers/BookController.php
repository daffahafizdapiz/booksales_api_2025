<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Get all books (with author & genre info)
    public function index()
    {
        $books = Book::with(['author', 'genre'])->get();

        return response()->json([
            'success' => true,
            'data'    => $books
        ], 200);
    }

    // Get book by ID
    public function show($id)
    {
        $book = Book::with(['author', 'genre'])->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $book
        ], 200);
    }

    // Create a new book (admin only)
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'description'  => 'required|string|max:1000',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'cover_photo'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'genre_id'     => 'required|exists:genres,id',
            'author_id'    => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Upload book cover
        $image = $request->file('cover_photo');
        $image->store('books', 'public');

        // Create new book record
        $book = Book::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'cover_photo'  => $image->hashName(),
            'genre_id'     => $request->genre_id,
            'author_id'    => $request->author_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully.',
            'data'    => $book
        ], 201);
    }

    // Update existing book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found.'
            ], 404);
        }

        // Validate update data
        $validator = Validator::make($request->all(), [
            'title'        => 'sometimes|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'sometimes|numeric|min:0',
            'stock'        => 'sometimes|integer|min:0',
            'cover_photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'genre_id'     => 'sometimes|exists:genres,id',
            'author_id'    => 'sometimes|exists:authors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // If there's a new cover uploaded
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image->store('books', 'public');

            // Delete old cover if it exists
            if ($book->cover_photo && Storage::disk('public')->exists('books/' . $book->cover_photo)) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            $data['cover_photo'] = $image->hashName();
        }

        // Update book data
        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully.',
            'data'    => $book
        ], 200);
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found.'
            ], 404);
        }

        // Remove cover from storage if exists
        if ($book->cover_photo && Storage::disk('public')->exists('books/' . $book->cover_photo)) {
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully.'
        ], 200);
    }
}
