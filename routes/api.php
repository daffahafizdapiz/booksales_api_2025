<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

// Route::get('/books', [BookController::class, 'index']);
// Route::get('/books/{id}', [BookController::class, 'show']);
// Route::post('/books', [BookController::class, 'store']);
// Route::put('/books/{id}', [BookController::class, 'update']);
// Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Route::get('/authors', [AuthorController::class, 'index']);
// Route::get('/authors/{id}', [AuthorController::class, 'show']);
// Route::post('/authors', [AuthorController::class, 'store']);
// Route::put('/authors/{id}', [AuthorController::class, 'update']);
// Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

Route::apiResource('books', BookController::class);
Route::apiResource('authors', AuthorController::class);