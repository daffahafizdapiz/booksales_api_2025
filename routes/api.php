<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;

// 🔐 Route auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// 🌐 Public access (no login)
Route::apiResource('/books', BookController::class)->only(['index', 'show']);
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{id}', [GenreController::class, 'show']);
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);

// 👤 User authenticated (customer)
Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::post('/transactions', [TransactionController::class, 'store']); // Buat transaksi
    Route::get('/transactions/{id}', [TransactionController::class, 'show']); // Lihat transaksi
});

// 🛡️ Admin only (dengan middleware admin)
Route::middleware(['auth:api', 'admin'])->group(function () {
    // ✅ Admin akses semua transaksi (lihat semua, edit, hapus)
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

    // ✅ Admin CRUD buku
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // ✅ Admin CRUD genre
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

    // ✅ Admin CRUD author
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{id}', [AuthorController::class, 'update']);
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);
});
