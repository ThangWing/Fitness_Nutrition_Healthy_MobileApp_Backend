<?php
namespace App\Http\Controllers;

use App\Models\Dinhduongdoan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DinhDuongDoanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'dinhduong_id' => 'required|exists:dinhduong,id',
            'doan_id' => 'required|exists:doan,id',
            'quantity' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $record = DinhDuongDoan::create($data);
        return response()->json($record->load('dinhduong', 'doan'));
    }

    public function update(Request $request, $id)
    {
        $record = DinhDuongDoan::findOrFail($id);
        $data = $request->validate([
            'quantity' => 'sometimes|numeric|min:0',
            'date' => 'sometimes|date',
        ]);

        $record->update($data);
        return response()->json($record->load('dinhduong', 'doan'));
    }

    public function destroy($id)
    {
        $record = DinhDuongDoan::findOrFail($id);
        $record->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}

