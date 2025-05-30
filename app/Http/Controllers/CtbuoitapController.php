<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baitap;
use App\Models\BuoiTap;
use App\Models\Ctbuoitap;
use App\Models\DailyChiso;

class CtbuoitapController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'date' => 'required|date',
        'exercises' => 'required|array|min:1',
        'exercises.*.baitap_id' => 'required|integer|exists:baitap,id',
        'exercises.*.duration' => 'required|integer|min:1',
    ]);

    // 1. Tạo buổi tập mới
    $buoiTap = BuoiTap::create([
        'user_id' => $request->user_id,
        'date' => $request->date,
        // thêm các trường khác nếu có, ví dụ: mục tiêu, mô tả...
    ]);

    // 2. Thêm danh sách ctbuoitap
    foreach ($request->exercises as $exercise) {
        Ctbuoitap::create([
            'buoitapid' => $buoiTap->id,
            'baitap_id' => $exercise['baitap_id'],
            'duration' => $exercise['duration'],
        ]);
    }

    // 3. Tính lại calories
    $buoiTap->recalculateCalories();

    return response()->json([
        'message' => 'Tạo buổi tập + thêm bài tập thành công',
        'buoitap_id' => $buoiTap->id
    ], 201);
}

    
    public function destroy(Request $request, $buoitapid, $baitap_id)
    {
        $request->validate([
            'weight' => 'required|numeric|min:1',
        ]);

        $buoiTap = BuoiTap::with('baiTaps')->findOrFail($buoitapid);
        $buoiTap->baiTaps()->detach($baitap_id);

        // Tính lại calories
        $buoiTap->recalculateCalories($request->weight);

        return response()->json(['message' => 'Exercise removed & calories recalculated']);
    }

    public function updateDuration(Request $request)
    {
        $request->validate([
            'buoitapid' => 'required|exists:buoitap,id',
            'baitap_id' => 'required|exists:baitap,id',
            'duration' => 'required|integer|min:1',
        ]);

        $buoiTap = BuoiTap::with('baiTaps')->findOrFail($request->buoitapid);
        $buoiTap->baiTaps()->updateExistingPivot($request->baitap_id, ['duration' => $request->duration]);

        // Tính lại calories
        $buoiTap->recalculateCalories();

        return response()->json(['message' => 'Duration updated & calories recalculated']);
    }
}
