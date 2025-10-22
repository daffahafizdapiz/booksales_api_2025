<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // 1️⃣ Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        // 2️⃣ Kalau gagal, kirim pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3️⃣ Simpan genre baru
        $genre = Genre::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Genre created successfully',
            'data' => $genre
        ], 201);
    }

    // SHOW genre by ID
    public function show($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $genre
        ], 200);
    }

    // UPDATE genre
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data genre
        $genre->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Genre updated successfully',
            'data' => $genre
        ], 200);
    }

    // DELETE genre
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found'
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully'
        ], 200);
    }
}
