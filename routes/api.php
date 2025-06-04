<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BaiTapController;
use App\Http\Controllers\BuoitapController;
use App\Http\Controllers\CTBuoiTapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DoanController;
use App\Http\Controllers\BuaanController;
use App\Http\Controllers\CtbuaanController;
use App\Http\Controllers\DailyChisoController;
use App\Http\Controllers\MucTieuController;
use App\Http\Controllers\BaiTapFavController;
use App\Http\Controllers\FoodFavController;

Route::apiResource('baitap', BaiTapController::class);

// CRUD buổi tập
Route::apiResource('buoitap', BuoiTapController::class);

Route::prefix('ctbuoitap')->group(function () {
    // Thêm bài tập vào buổi tập
    Route::post('/store', [CTBuoiTapController::class, 'store']);

    // Cập nhật thời lượng
    Route::put('/update-duration', [CTBuoiTapController::class, 'updateDuration']);

    // Xoá bài tập ra khỏi buổi tập
    Route::delete('/destroy/{buoitapid}/{baitap_id}', [CTBuoiTapController::class, 'destroy']);

    // (tuỳ chọn) Lấy danh sách bài tập của 1 buổi tập
    Route::get('/list/{buoitapid}', [CTBuoiTapController::class, 'list']);
});





Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);       // Danh sách user
    Route::get('/{id}', [UserController::class, 'show']);    // Chi tiết 1 user
    Route::post('/', [UserController::class, 'store']);      // Tạo mới user
    Route::put('/{id}', [UserController::class, 'update']);  // Cập nhật user
    Route::delete('/{id}', [UserController::class, 'destroy']); // Xóa user
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
});

Route::apiResource('doan', DoanController::class);

Route::prefix('buaan')->group(function () {
    Route::get('/', [BuaanController::class, 'index']);
    Route::get('/{id}', [BuaanController::class, 'show']);
    Route::post('/', [BuaanController::class, 'store']);
    Route::put('/{id}', [BuaanController::class, 'update']);
    Route::delete('/{id}', [BuaanController::class, 'destroy']);
});

Route::prefix('ctbuaan')->group(function () {
    Route::get('/{buaan_id}', [CtbuaanController::class, 'index']);
    Route::post('/', [CtbuaanController::class, 'store']);
    Route::put('/{id}', [CtbuaanController::class, 'update']);
    Route::delete('/{id}', [CtbuaanController::class, 'destroy']);
});

Route::get('dailychiso/latest/{user_id}', [DailyChisoController::class, 'latestByUser']);
Route::get('dailychiso/check', [DailyChisoController::class, 'checkDailyChiso']);
Route::get('dailychiso/{user_id}/{date}', [DailyChisoController::class, 'showByUserAndDate']);
Route::apiResource('dailychiso', DailyChisoController::class);
// Lấy dailychiso theo user_id và date


Route::apiResource('muctieu', MucTieuController::class);

Route::post('/send-otp', [LoginController::class, 'sendOtp']);
Route::post('/verify-otp-reset', [LoginController::class, 'verifyOtpAndReset']);
Route::post('/change-password', [LoginController::class, 'changePasswordByUserId']);

Route::prefix('fav-exercise')->group(function () {
    Route::get('{userId}', [BaiTapFavController::class, 'index']);
    Route::post('/', [BaiTapFavController::class, 'store']);
    Route::delete('/', [BaiTapFavController::class, 'destroy']);
    Route::post('/check', [BaiTapFavController::class, 'isFavorite']);
});

Route::prefix('fav-food')->group(function () {
    Route::get('{userId}', [FoodFavController::class, 'index']);
    Route::post('/', [FoodFavController::class, 'store']);
    Route::delete('/', [FoodFavController::class, 'destroy']);
});