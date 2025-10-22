<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;   
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Register User / Admin
    public function register(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    // Login
    public function login(Request $request) {
        // 1. Setup validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // 2. Cek validator
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 3. Get Kredensial dari request
        $credentials = $request->only('email', 'password');

        // 4. Cek idFailed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda Salah!'
            ], 401);
        }

        // 5. Cek isSuccess
        return response()->json([
            'success' => true,
            'message' => "Login successfully",
            'user' => auth()->guard('api')->user(),
            'token' => $token,
        ], 200);
    }

    // Logout
    public function logout(Request $request) {
        // try
        // 1. Invalidate token
        // 2. Cek isSuccess

        // catch
        // 1. cek isFailed

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully'
            ], 200);

        } catch (JWTExpection $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout Failed!'
            ], 500);
        }
    }
}
