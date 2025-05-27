<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\User;
use App\Mail\ResetOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class LoginController extends Controller
{
    // Đăng ký tài khoản
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:login',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $login = Login::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_id' => null // chưa có user
        ]);

        return response()->json([
            'message' => 'Tạo tài khoản thành công',
            'login' => $login
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

    public function sendOtp(Request $request)
    {
        $request->validate(['username' => 'required']);

        $login = Login::where('username', $request->username)->first();
        if (!$login || !$login->user || !$login->user->email) {
            return response()->json(['error' => 'Không tìm thấy tài khoản hoặc email'], 404);
        }

        $otp = rand(100000, 999999);

        // Xóa mã OTP cũ nếu có
        DB::table('password_resets')->where('username', $request->username)->delete();

        // Lưu mã mới
        DB::table('password_resets')->insert([
            'username' => $request->username,
            'otp' => $otp,
            'created_at' => now()
        ]);

        // Gửi email
        Mail::to($login->user->email)->send(new ResetOtpMail($otp, $request->username));

        return response()->json(['message' => 'Đã gửi mã OTP qua email']);
    }

    public function verifyOtpAndReset(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'otp' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $otpRecord = DB::table('password_resets')
            ->where('username', $request->username)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return response()->json(['error' => 'Mã OTP không đúng'], 400);
        }

        if (Carbon::parse($otpRecord->created_at)->addMinutes(10)->isPast()) {
            return response()->json(['error' => 'Mã OTP đã hết hạn'], 410);
        }

        $login = Login::where('username', $request->username)->first();
        $login->password = Hash::make($request->new_password);
        $login->save();

        // Xóa OTP sau khi dùng
        DB::table('password_resets')->where('username', $request->username)->delete();

        return response()->json(['message' => 'Đặt lại mật khẩu thành công']);
    }

    public function changePasswordByUserId(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password',
        ]);

        $user = User::findOrFail($request->user_id);
        $login = $user->login;

        if (!$login) {
            return response()->json(['error' => 'Không tìm thấy tài khoản cho user_id đã cho'], 404);
        }

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $login->password)) {
            return response()->json(['error' => 'Mật khẩu cũ không đúng'], 401);
        }

        // Cập nhật mật khẩu mới
        $login->password = Hash::make($request->new_password);
        $login->save();

        return response()->json(['message' => 'Đổi mật khẩu thành công']);
    }
}