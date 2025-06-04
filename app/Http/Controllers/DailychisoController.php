<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dailychiso;


class DailyChisoController extends Controller
{
    public function index()
    {
        return Dailychiso::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'weight' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'calories_consumed' => 'required|numeric|min:0',
            'calories_burned' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:100',
        ]);

        $data['bmi'] = $this->calculateBMI($data['weight'], $data['height']);

        return Dailychiso::create($data);
    }

    public function update(Request $request, $id)
{
    $daily = DailyChiso::findOrFail($id);

    $data = $request->validate([
        'weight' => 'sometimes|numeric|min:0',
        'height' => 'sometimes|numeric|min:0',
        'calories_consumed' => 'sometimes|numeric|min:0',
        'calories_burned' => 'sometimes|numeric|min:0',
        'note' => 'nullable|string|max:100',
    ]);

    // SỬA chỗ này: lấy weight/height mới hoặc giữ cũ
    $weight = $data['weight'] ?? $daily->weight;
    $height = $data['height'] ?? $daily->height;
    $data['bmi'] = $this->calculateBMI($weight, $height);

    $daily->update($data);
    // ĐẢM BẢO trả về đầy đủ id/weight/height
    return response()->json(['data' => $daily]);
}

    public function latestByUser($user_id) {
    $daily = DailyChiso::where('user_id', $user_id)->orderBy('date', 'desc')->first();
    if ($daily) {
        return response()->json(['data' => $daily]);
    }
    return response()->json(['data' => null], 404);
}


    private function calculateBMI($weight, $height)
    {
        if ($height == 0) {
            return 0;
        }
        return round($weight / pow($height / 100, 2), 2);
    }

    public function checkDailyChiso(Request $request)
    {
        $userId = $request->input('user_id');
        $date = $request->input('date');

        if (!$userId || !$date) {
            return response()->json(['message' => 'Missing user_id or date'], 400);
        }

        $dailyChiso = DailyChiso::where('user_id', $userId)
            ->whereDate('date', $date)
            ->first();

        if ($dailyChiso) {
            return response()->json($dailyChiso);
        } else {
            return response()->json(['message' => 'No daily chiso found for this user and date'], 404);
        }
    }

    public function show($id)
    {
        return Dailychiso::with('user')->findOrFail($id);
    }

    public function destroy($id)
    {
        $daily = Dailychiso::findOrFail($id);
        $daily->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}