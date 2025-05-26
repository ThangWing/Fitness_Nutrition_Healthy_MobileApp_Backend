<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BaiTapController;
use App\Http\Controllers\BuoitapController;
use App\Http\Controllers\CTBuoiTapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DoanController;
use App\Http\Controllers\DinhDuongController;
use App\Http\Controllers\DinhDuongDoanController;
use App\Http\Controllers\DailyChisoController;
use App\Http\Controllers\MucTieuController;

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
Route::apiResource('dinhduong', DinhDuongController::class);
Route::apiResource('dinhduong-doan', DinhDuongDoanController::class);
Route::apiResource('dailychiso', DailyChisoController::class);

Route::apiResource('muctieu', MucTieuController::class);