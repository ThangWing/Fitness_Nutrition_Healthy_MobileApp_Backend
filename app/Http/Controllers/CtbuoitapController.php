<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CtbuoitapController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buoitapid' => 'required|exists:buoitap,id',
            'baitap_id' => 'required|exists:baitap,id',
            'duration' => 'required|integer|min:1',
        ]);

        $buoiTap = BuoiTap::with('baiTaps')->findOrFail($request->buoitapid);
        $buoiTap->baiTaps()->attach($request->baitap_id, ['duration' => $request->duration]);

        // Tính lại calories
        $buoiTap->recalculateCalories();

        return response()->json(['message' => 'Exercise added & calories recalculated']);
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
