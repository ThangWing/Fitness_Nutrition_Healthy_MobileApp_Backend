<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doan extends Model
{
    protected $table = 'doan';
    protected $fillable = ['name_food', 'calories_per_100g', 'image_url'];

    public function dinhDuongs()
    {
        return $this->belongsToMany(DinhDuong::class, 'dinhduong_doan')
                    ->withPivot('quantity', 'date')
                    ->withTimestamps();
    }
}