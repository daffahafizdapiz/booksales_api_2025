<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

//  Tes API aktif
Route::get('/ping', function () {
    return response()->json(['message' => 'Server aktif di booksales-api!']);
});

//  Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

//  Public Routes (semua orang bisa)
Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('/books', BookController::class)->only(['index', 'show']);

//  Protected Routes (khusus admin)
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);
});
