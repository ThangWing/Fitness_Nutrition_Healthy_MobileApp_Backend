<?php
namespace App\Http\Controllers;

use App\Models\Doan;
use Illuminate\Http\Request;

class DoanController extends Controller
{
    public function index()
    {
        return Doan::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_food' => 'required|string|max:255',
            'calories_per_100g' => 'required|numeric|min:0',
            'image_url' => 'nullable|url'
        ]);

        return Doan::create($data);
    }

    public function show($id)
    {
        return Doan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $doan = Doan::findOrFail($id);
        $data = $request->validate([
            'name_food' => 'sometimes|string|max:255',
            'calories_per_100g' => 'sometimes|numeric|min:0',
            'image_url' => 'nullable|url'
        ]);

        $doan->update($data);
        return $doan;
    }

    public function destroy($id)
    {
        $doan = Doan::findOrFail($id);
        $doan->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
