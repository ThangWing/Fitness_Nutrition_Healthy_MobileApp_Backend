<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baitap;

class BaitapController extends Controller
{
    //
    public function index() {
        return Baitap::all();
    }
}
