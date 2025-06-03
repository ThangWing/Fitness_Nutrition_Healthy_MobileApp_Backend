<?php
namespace App\Http\Controllers;

use App\Models\Dinhduongdoan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DinhDuongDoanController extends Controller
{

    public function index($buaan_id)
    {
        $details = Ctbuaan::with('doan')->where('buaan_id', $buaan_id)->get();
        return response()->json($details);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dinhduong_id' => 'required|exists:dinhduong,id',
            'doan_id' => 'required|exists:doan,id',
            'quantity' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $record = Ctbuaan::create($data);
        $ct->buaan->recalculateCalories();
        return response()->json($record->load('dinhduong', 'doan'));
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

