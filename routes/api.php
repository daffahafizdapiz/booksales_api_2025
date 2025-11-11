<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;

// ✅ Health check
Route::get('/ping', fn() => response()->json(['message' => 'Booksales API running fine 🚀']));

// ✅ Auth Routes (bisa diabaikan dulu)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ Public routes biar React bisa CRUD tanpa token
Route::apiResource('authors', AuthorController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::apiResource('genres', GenreController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::apiResource('books', BookController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
