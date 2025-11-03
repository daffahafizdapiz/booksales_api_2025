<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;

// ✅ Health check
Route::get('/ping', fn() => response()->json(['message' => 'Booksales API running fine 🚀']));

// ✅ Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('jwt.verify')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('jwt.verify')->get('/me', fn() => response()->json(auth()->user()));

// ✅ Public Routes
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);

// ✅ Protected Routes (JWT Required)
Route::middleware(['jwt.verify'])->group(function () {

    // ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('authors', AuthorController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('books', BookController::class)->only(['store', 'update', 'destroy']);

        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
    });

    // USER
    Route::middleware('role:user')->group(function () {
        Route::post('/transactions', [TransactionController::class, 'store']);
        Route::put('/transactions/{id}', [TransactionController::class, 'update']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    });
});
