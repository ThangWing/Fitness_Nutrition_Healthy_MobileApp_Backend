<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinhDuong extends Model
{
    protected $table = 'buaan';
    protected $fillable = ['user_id', 'meal_type', 'calories', 'date'];

    public function doans()
    {
        return $this->belongsToMany(Doan::class, 'ctbuaan')
                    ->withPivot('quantity', 'date')
                    ->withTimestamps();
    }
}
