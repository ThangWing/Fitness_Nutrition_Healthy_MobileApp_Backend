<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinhDuongDoan extends Model
{
    protected $table = 'dinhduong_doan';
    protected $fillable = ['dinhduong_id', 'doan_id', 'quantity', 'date'];

    protected static function booted()
    {
        static::saved(function ($model) {
            $model->recalculateCalories();
        });

        static::deleted(function ($model) {
            $model->recalculateCalories();
        });
    }

    public function recalculateCalories()
    {
        $dinhDuong = $this->dinhduong;
        $totalCalories = $dinhDuong->doans->sum(function ($doan) {
            return ($doan->pivot->quantity * $doan->calories_per_100g) / 100;
        });
        $dinhDuong->calories = $totalCalories;
        $dinhDuong->save();
    }

    public function dinhduong()
    {
        return $this->belongsTo(DinhDuong::class, 'dinhduong_id');
    }

    public function doan()
    {
        return $this->belongsTo(Doan::class, 'doan_id');
    }
}
