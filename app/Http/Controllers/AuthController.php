<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * ============================
     * 🧩 REGISTER USER / ADMIN
     * ============================
     */
    public function register(Request $request)
    {
        // ✅ Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // ✅ Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
        ]);

        // ✅ Response sukses
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => $user,
        ], 201);
    }

    /**
     * ============================
     * 🔐 LOGIN USER
     * ============================
     */
    public function login(Request $request)
    {
        // ✅ Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // ✅ Ambil kredensial
        $credentials = $request->only('email', 'password');

        try {
            // ✅ Coba autentikasi menggunakan JWT
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password',
                ], 401);
            }

            // ✅ Ambil data user
            $user = auth('api')->user();

            // ✅ Response sukses
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ============================
     * 🚪 LOGOUT
     * ============================
     */
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

            return response()->json([
                'success' => true,
                'message' => 'Logout successful',
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout, token invalid or expired',
            ], 500);
        }
    }

    /**
     * ============================
     * 👤 GET CURRENT USER INFO
     * ============================
     */
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalid or expired',
            ], 401);
        }
    }
}
