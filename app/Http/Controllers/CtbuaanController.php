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
        'user_id' => 'required|integer|exists:users,id',
        'buaan_id' => 'required|integer|exists:buaan,id',
        'date' => 'required|date',
        'foods' => 'required|array|min:1',
        'foods.*.doan_id' => 'required|integer|exists:doan,id',
        'foods.*.quantity' => 'required|numeric|min:1',
    ]);

    $buaan = Buaan::create([
        'user_id' => $request->user_id,
        'date' => $request->date,
        // thêm các trường khác nếu có, ví dụ: mục tiêu, mô tả...
    ]);

    foreach ($request->foods as $food) {
        Ctbuaan::create([
            'buaan_id' => $request->id,
            'doan_id' => $food['doan_id'],
            'quantity' => $food['quantity'],
        ]);
    }

    // Gọi lại recalculation từ model Buaan
    $buaan->recalculateCalories();
    

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

