<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // 1 Validasi manual pakai Validator
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'asal' => 'nullable|string|max:100',
        ]);

        // 2 Kalau gagal, kirim error JSON
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3 Simpan data author
        $author = Author::create($validator->validated());

        // 4️⃣ Response sukses
        return response()->json([
            'success' => true,
            'message' => 'Author created successfully',
            'data' => $author
        ], 201);
    }

    // SHOW author by ID
    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $author
        ], 200);
    }

    // UPDATE author
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'asal' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data author
        $author->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully',
            'data' => $author
        ], 200);
    }

    // DELETE author
    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ], 200);
    }
}
