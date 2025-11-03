<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Get all authors.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Author::all()
        ], 200);
    }

    /**
     * Add a new author (with optional photo upload).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:100',
            'bio'   => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Upload photo if provided
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo->store('authors', 'public');
            $photoName = $photo->hashName();
        }

        // Create author
        $author = Author::create([
            'name'  => $request->name,
            'bio'   => $request->bio,
            'photo' => $photoName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'New author has been added successfully.',
            'data'    => $author,
        ], 201);
    }

    /**
     * Show a specific author by ID.
     */
    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $author,
        ], 200);
    }

    /**
     * Update author data (including photo).
     */
    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found.',
            ], 404);
        }

        // Validate input data
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:50',
            'bio'   => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Prepare updated data
        $updatedData = [
            'name' => $request->input('name'),
            'bio'  => $request->input('bio'),
        ];

        // If there’s a new photo, replace the old one
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = $photo->hashName();

            $photo->storeAs('authors', $photoName, 'public');

            // Delete old photo if it exists
            if ($author->photo && Storage::disk('public')->exists('authors/' . $author->photo)) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }

            $updatedData['photo'] = $photoName;
        }

        // Save changes
        $author->update($updatedData);

        return response()->json([
            'success' => true,
            'message' => 'Author information updated successfully.',
            'data'    => $author,
        ], 200);
    }

    /**
     * Delete an author by ID.
     */
    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found.',
            ], 404);
        }

        // Delete photo if it exists
        if ($author->photo && Storage::disk('public')->exists('authors/' . $author->photo)) {
            Storage::disk('public')->delete('authors/' . $author->photo);
        }

        // Delete author record
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author has been deleted successfully.',
        ], 200);
    }
}
