<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ctbuaan extends Model
{
    protected $table = 'ctbuaan';
    protected $fillable = ['buaan_id', 'doan_id', 'quantity', 'date'];

    protected static function booted()
    {
        static::saved(function ($model) {
            $model->recalculateCalories();
        });

        static::deleted(function ($model) {
            $model->recalculateCalories();
        });
    }

    public function buaan()
    {
        return $this->belongsTo(DinhDuong::class, 'buaan_id');
    }

    public function doan()
    {
        return $this->belongsTo(Doan::class, 'doan_id');
    }
}
