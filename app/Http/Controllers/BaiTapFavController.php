<?php

namespace App\Http\Controllers;

use App\Models\BaiTapFav;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaiTapFavController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $favorites = DB::table('BaiTapFav')
            ->join('baitap', 'baitap.id', '=', 'BaiTapFav.baitap_id')
            ->where('BaiTapFav.user_id', $userId)
            ->select('baitap.*')
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'baitap_id' => 'required|exists:baitap,id',
        ]);

        DB::table('BaiTapFav')->updateOrInsert([
            'user_id' => $request->user_id,
            'baitap_id' => $request->baitap_id,
        ]);

        return response()->json(['message' => 'Đã thêm bài tập vào mục yêu thích.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BaiTapFav $baiTapFav)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BaiTapFav $baiTapFav)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BaiTapFav $baiTapFav)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::table('BaiTapFav')
            ->where('user_id', $request->user_id)
            ->where('baitap_id', $request->baitap_id)
            ->delete();

        return response()->json(['message' => 'Đã xóa bài tập khỏi mục yêu thích.']);
    }
}
