<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MucTieuController extends Controller
{
    public function index()
    {
        return MucTieu::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'goal_type' => 'required|string|max:50',
            'target_value' => 'required|numeric|min:0',
            'progress' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        return MucTieu::create($data);
    }

    public function show($id)
    {
        return MucTieu::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $muctieu = MucTieu::findOrFail($id);

        $data = $request->validate([
            'goal_type' => 'sometimes|string|max:50',
            'target_value' => 'sometimes|numeric|min:0',
            'progress' => 'sometimes|numeric|min:0',
            'deadline' => 'sometimes|date',
        ]);

        $muctieu->update($data);
        return $muctieu;
    }

    public function destroy($id)
    {
        $muctieu = MucTieu::findOrFail($id);
        $muctieu->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}