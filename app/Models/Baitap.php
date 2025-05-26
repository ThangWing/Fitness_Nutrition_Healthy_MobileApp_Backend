<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiTap extends Model
{
    protected $table = 'baitap';

    protected $fillable = ['name_exercise', 'mets', 'image_url'];

    public $timestamps = false;

    public function buoiTaps()
    {
        return $this->belongsToMany(BuoiTap::class, 'ctbuoitap', 'baitap_id', 'buoitapid')
                    ->withPivot('duration');
    }

    public function getImageUrlAttribute($value)
    {
        return "http://10.0.2.2:8000" . $value;
    }
}
