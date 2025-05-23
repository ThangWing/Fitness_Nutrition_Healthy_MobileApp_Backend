<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuoitapController extends Controller
{
    //
    public function index()
    {
        return response()->json(BuoiTap::with('baiTaps')->get());
    }
    
    public function show($id)
    {
        $bt = BuoiTap::with('baiTaps')->find($id);
        if (!$bt) return response()->json(['message' => 'Not found'], 404);
        return response()->json($bt);
    }
    
    public function update(Request $request, $id)
    {
        $bt = BuoiTap::findOrFail($id);
        $bt->update($request->all());
        return response()->json($bt);
    }

    public function destroy($id)
    {
        $bt = BuoiTap::findOrFail($id);
        $bt->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function store(Request $request)
    {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',
        'exercises' => 'required|array',
        'exercises.*.baitap_id' => 'required|exists:baitap,id',
        'exercises.*.duration' => 'required|integer|min:1',
        'weight' => 'required|numeric|min:1', // đơn vị: kg
    ]);

    $totalCalories = 0;

    foreach ($request->exercises as $ex) {
        $baitap = \App\Models\BaiTap::find($ex['baitap_id']);
        $duration = $ex['duration'];
        $mets = $baitap->mets;
        $calories = ($mets * 3.5 * $request->weight / 200) * $duration;
        $totalCalories += $calories;
    }

    $buoiTap = \App\Models\BuoiTap::create([
        'user_id' => $request->user_id,
        'calories_burned' => round($totalCalories, 2),
        'date' => $request->date,
    ]);

    foreach ($request->exercises as $ex) {
        $buoiTap->baiTaps()->attach($ex['baitap_id'], ['duration' => $ex['duration']]);
    }

    return response()->json([
        'message' => 'Session created with calculated calories',
        'calories_burned' => $totalCalories,
        'session' => $buoiTap->load('baiTaps')
    ], 201);
}

}
