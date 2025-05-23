<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Đăng ký tài khoản
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:login',
            'password' => 'required|min:6',
            'name' => 'required',
            'age' => 'required|integer|min:0',
            'gender' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email
        ]);

        // Tạo login
        $login = Login::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'login' => $login,
            'user' => $user
        ], 201);
    }

    // Đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $login = Login::where('username', $request->username)->first();

        if (!$login || !Hash::check($request->password, $login->password)) {
            return response()->json(['error' => 'Sai tài khoản hoặc mật khẩu'], 401);
        }

        // Có thể generate token ở đây nếu dùng Laravel Sanctum hoặc Passport
        return response()->json([
            'message' => 'Đăng nhập thành công',
            'user' => $login->user
        ]);
    }
}