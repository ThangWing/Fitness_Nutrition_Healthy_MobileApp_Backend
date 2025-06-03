<?php
namespace App\Http\Controllers;

use App\Models\Dinhduongdoan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buaan;

class DinhDuongDoanController extends Controller
{

    public function store(Request $request)
{
    $request->validate([
        'buaan_id' => 'required|integer|exists:buaan,id',
        'foods' => 'required|array|min:1',
        'foods.*.doan_id' => 'required|integer|exists:doan,id',
        'foods.*.quantity' => 'required|numeric|min:1',
    ]);

    foreach ($request->foods as $food) {
        Ctbuaan::create([
            'buaan_id' => $request->buaan_id,
            'doan_id' => $food['doan_id'],
            'quantity' => $food['quantity'],
            'date' => now()->toDateString(), // hoặc lấy từ request nếu cần
        ]);
    }

    // Gọi lại recalculation từ model Buaan
    $buaan = Buaan::find($request->buaan_id);
    if ($buaan) {
        $buaan->recalculateCalories();
    }

    return response()->json([
        'message' => 'Thêm món ăn vào bữa ăn thành công',
        'buaan_id' => $request->buaan_id
    ], 201);
}

    public function update(Request $request, $id)
    {
        $record = Ctbuaan::findOrFail($id);
        $data = $request->validate([
            'quantity' => 'sometimes|numeric|min:0',
        ]);

        $ct->update($data);
        $ct->buaan->recalculateCalories();
        
        return response()->json($ct);
    }

    public function destroy($id)
    {
        $ct = Ctbuaan::findOrFail($id);
        $buaan = $ct->buaan;

        $ct->delete();

        $buaan->recalculateCalories();

        return response()->json(['message' => 'Deleted']);
    }
}

