<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan, periksa kembali!',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password tidak sesuai.',
            ], 401);
        }

        if ($user->role !== 'customer') {
            return response()->json([
                'status' => false,
                'message' => 'Anda bukan customer!',
            ], 403);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'Akun anda tidak aktif! Hubungi owner untuk informasi lebih lanjut.',
            ], 403);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login',
                'token' => $user->createToken('mobile-api')->plainTextToken,
                'user' => Auth::user(),
                'request' => $request->all(),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Terjadi Kesalahan, periksa kembali.',
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|unique:users,email',
            'phone' => 'required|string|max:20|regex:/^[0-9]+$/|unique:users,phone',
            'address' => 'required|string',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan validasi',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user,
        ], 201);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil logout',
        ], 200);
    }
}
