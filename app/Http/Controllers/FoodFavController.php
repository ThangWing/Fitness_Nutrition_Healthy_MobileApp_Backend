<?php

namespace App\Http\Controllers;

use App\Models\FoodFav;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodFavController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $favorites = DB::table('food_favs')
            ->join('doan', 'doan.id', '=', 'food_favs.doan_id')
            ->where('food_favs.user_id', $userId)
            ->select('doan.*')
            ->get();

        return response()->json($favorites);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodFav $foodFav)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodFav $foodFav)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodFav $foodFav)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodFav $foodFav)
    {
        DB::table('food_favs')
            ->where('user_id', $foodFav->user_id)
            ->where('doan_id', $foodFav->doan_id)
            ->delete();

        return response()->json(['message' => 'Đã xóa bài tập khỏi mục yêu thích.']);
    }
}
