<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailyChisoController extends Controller
{
    public function index()
    {
        return DailyChiso::with('user')->get();
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

        return DailyChiso::create($data);
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

        $weight = $data['weight'] ?? $daily->weight;
        $height = $data['height'] ?? $daily->height;
        $data['bmi'] = $this->calculateBMI($weight, $height);

        $daily->update($data);
        return $daily;
    }

    private function calculateBMI($weight, $height)
    {
        if ($height == 0) {
            return 0;
        }
        return round($weight / pow($height / 100, 2), 2);
    }


    public function show($id)
    {
        return DailyChiso::with('user')->findOrFail($id);
    }

    public function destroy($id)
    {
        $daily = DailyChiso::findOrFail($id);
        $daily->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}