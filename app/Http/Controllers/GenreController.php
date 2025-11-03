<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    // Get all genres
    public function index()
    {
        $genres = Genre::all();

        return response()->json([
            'success' => true,
            'data'    => $genres
        ], 200);
    }

    // Create a new genre
    public function store(Request $request)
    {
        // Validate user input
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Save new genre
        $genre = Genre::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Genre created successfully.',
            'data'    => $genre
        ], 201);
    }

    // Get specific genre by ID
    public function show($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $genre
        ], 200);
    }

    // Update genre
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found.'
            ], 404);
        }

        // Validate request data
        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|string|max:100',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Update genre data
        $genre->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Genre updated successfully.',
            'data'    => $genre
        ], 200);
    }

    // Delete genre
    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found.'
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully.'
        ], 200);
    }
}
