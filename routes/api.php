<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;

// Tes koneksi API
Route::get('/ping', function () {
    return response()->json(['message' => '✅ Server aktif di booksales-api!']);
});

// AUTH ROUTES
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Logout (wajib login JWT)
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

// PUBLIC ROUTES (tanpa login)
// Semua orang bisa lihat daftar & detail Author, Genre, dan Book
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);

// PROTECTED ROUTES (login wajib JWT)
Route::middleware(['auth:api'])->group(function () {

    // ADMIN HANYA (bisa create/update/delete)
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('authors', AuthorController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('books', BookController::class)->only(['store', 'update', 'destroy']);

        // Admin bisa lihat semua transaksi dan hapus transaksi
        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
    });

    // CUSTOMER (bisa buat & lihat transaksi sendiri)
    Route::middleware('role:user')->group(function () {
        Route::post('/transactions', [TransactionController::class, 'store']);
        Route::put('/transactions/{id}', [TransactionController::class, 'update']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    });
});
