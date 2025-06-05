<?php

namespace App\Http\Controllers;

use App\Models\Buaan;
use Illuminate\Http\Request;

class BuaanController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        if (!$userId) {
            return response()->json(['error' => 'Missing user_id'], 400);
        }
        // Đúng là Buaan, không phải BuoiTap
        $list = Buaan::with(['doans'])->where('user_id', $userId)->get();
        return response()->json($list, 200);
    }

    public function show($id)
    {
        $buaan = Buaan::with('doans')->find($id);
        if (!$buaan) return response()->json(['message' => 'Not found'], 404);
        return response()->json($buaan);
    }

    public function update(Request $request, $id)
    {
        $buaan = Buaan::findOrFail($id);
        $buaan->update($request->only(['meal_type', 'date']));
        return response()->json($buaan);
    }

    public function destroy($id)
    {
        $buaan = Buaan::findOrFail($id);
        $buaan->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function getByUser($user_id)
{
    $list = Buaan::with(['doans'])->where('user_id', $user_id)->get();
    return response()->json($list, 200);
}


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'meal_type' => 'required|string',
            'foods' => 'required|array',
            'foods.*.doan_id' => 'required|exists:doan,id',
            'foods.*.quantity' => 'required|numeric|min:1',
        ]);

        $buaan = Buaan::create([
            'user_id' => $request->user_id,
            'meal_type' => $request->meal_type,
            'calories' => 0,
            'date' => $request->date,
        ]);

        foreach ($request->foods as $food) {
            $buaan->doans()->attach($food['doan_id'], [
                'quantity' => $food['quantity'],
                'date' => $request->date,
            ]);
        }

        // Cần method này trong model Buaan để tính lại calories
        $buaan->recalculateCalories();

        return response()->json([
            'message' => 'Meal created with calculated calories',
            'calories' => $buaan->calories,
            'buaan' => $buaan->load('doans')
        ], 201);
    }
}
