<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * ADMIN: Get all transactions
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'book'])->latest()->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No transactions found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'All transactions retrieved successfully.',
            'data' => $transactions
        ], 200);
    }

    /**
     * Show a single transaction by ID
     */
    public function show($id)
    {
        $user = auth('api')->user();

        $transaction = Transaction::with(['user', 'book'])
        ->where('customer_id', $user->id)
        ->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaction details retrieved successfully.',
            'data' => $transaction
        ], 200);
    }

    /**
     * USER: Create a new transaction
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        $uniqueCode = "ORD-" . strtoupper(uniqid());
        
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.'
            ], 400);
        }

        // Reduce stock and create transaction
        $book->decrement('stock', $request->quantity);

        $transaction = Transaction::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => $request->quantity,
            'total_amount' => $book->price * $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully.',
            'data' => $transaction->load(['user', 'book'])
        ], 201);
    }

    /**
     * USER: Update transaction
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        // Revert stock of the old book
        $oldBook = Book::find($transaction->book_id);
        if ($oldBook && is_numeric($transaction->quantity)) {
            $oldBook->increment('stock', (int)$transaction->quantity);
        }

        // Check stock for new book
        $newBook = Book::find($request->book_id);
        if ($newBook->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock for the selected book.'
            ], 400);
        }

        // Update stock and transaction
        $newBook->decrement('stock', $request->quantity);
        $totalAmount = $newBook->price * $request->quantity;

        $transaction->update([
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction updated successfully.',
            'data' => $transaction
        ], 200);
    }

    /**
     * ADMIN: Delete a transaction
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found.'
            ], 404);
        }

        $book = Book::find($transaction->book_id);
        if ($book) {
            $book->increment('stock', $transaction->quantity);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => "Transaction ID: $id deleted successfully."
        ], 200);
    }
}
