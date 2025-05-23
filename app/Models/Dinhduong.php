<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinhDuong extends Model
{
    protected $table = 'dinhduong';
    protected $fillable = ['user_id', 'meal_type', 'calories', 'date'];

    public function doans()
    {
        return $this->belongsToMany(Doan::class, 'dinhduong_doan')
                    ->withPivot('quantity', 'date')
                    ->withTimestamps();
    }
}
