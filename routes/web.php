<?php

use Illuminate\Support\Facades\Route;

// Kosongin aja atau isi rute dummy biar gak error
Route::get('/', function () {
    return response()->json([
        'message' => 'Selamat datang di BookSales API 🚀',
        'status' => 'API aktif dan berjalan'
    ]);
});

