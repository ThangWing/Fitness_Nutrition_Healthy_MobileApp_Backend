<?php

namespace App\Http\Controllers;

use App\Models\DinhDuong;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DinhDuongController extends Controller
{
    public function index()
    {
        return DinhDuong::with('doans')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'meal_type' => 'required|string|max:20',
            'date' => 'required|date',
        ]);

        // Calories được mặc định là 0, sẽ được cập nhật sau khi thêm thực phẩm
        $data['calories'] = 0;

        return DinhDuong::create($data);
    }

    public function show($id)
    {
        return DinhDuong::with('doans')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $dinhduong = DinhDuong::findOrFail($id);
        $data = $request->validate([
            'meal_type' => 'sometimes|string|max:20',
            'date' => 'sometimes|date',
        ]);

        $dinhduong->update($data);
        return $dinhduong;
    }

    public function destroy($id)
    {
        $dinhduong = DinhDuong::findOrFail($id);
        $dinhduong->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}