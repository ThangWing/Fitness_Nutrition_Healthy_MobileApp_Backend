<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTBuoiTap extends Model
{
    protected $table = 'ctbuoitap';

    protected $fillable = ['buoitapid', 'baitap_id', 'duration'];

    public $timestamps = false;

    public function baiTap()
    {
        return $this->belongsTo(BaiTap::class, 'baitap_id');
    }

    public function buoiTap()
    {
        return $this->belongsTo(BuoiTap::class, 'buoitapid');
    }
}

