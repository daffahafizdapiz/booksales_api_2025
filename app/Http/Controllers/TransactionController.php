<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    //  ADMIN: Lihat semua transaksi
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Akses ditolak. Hanya admin yang bisa melihat semua transaksi.'], 403);
        }

        $transactions = Transaction::with(['customer', 'book'])->get();
        return response()->json($transactions, 200);
    }

    //  CUSTOMER: Lihat 1 transaksi
    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $transaction = Transaction::with(['customer', 'book'])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }

        if ($user->role === 'user' && $transaction->customer_id !== $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        return response()->json($transaction, 200);
    }

    //  CUSTOMER: Buat transaksi
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->role !== 'user') {
            return response()->json(['message' => 'Hanya customer yang bisa membuat transaksi.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = Transaction::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount' => $request->total_amount,
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil dibuat.',
            'data' => $transaction
        ], 201);
    }

    //  CUSTOMER: Update transaksi miliknya
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }

        if ($user->role === 'user' && $transaction->customer_id !== $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction->update($request->only('total_amount'));

        return response()->json([
            'message' => 'Transaksi berhasil diperbarui.',
            'data' => $transaction
        ], 200);
    }

    //  ADMIN: Hapus transaksi
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang bisa menghapus transaksi.'], 403);
        }

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus.'], 200);
    }
}
