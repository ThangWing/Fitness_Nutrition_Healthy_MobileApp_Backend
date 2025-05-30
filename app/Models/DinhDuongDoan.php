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

        if (!$dinhDuong) {
            throw new \Exception('Không tìm thấy bản ghi dinhduong liên kết với bua an.');
        }

        $totalCalories = 0;

        foreach ($this->doAns as $doAn) {
            $quantity = $doAn->pivot->quantity;
            $caloriesPer100g = $doAn->calories_per_100g;
            $calories = ($quantity * $caloriesPer100g) / 100;
            $totalCalories += $calories;
        }

        // 1. Cập nhật tổng calories vào dinhduong
        $dinhDuong->calories = round($totalCalories, 2);
        $dinhDuong->save();

        // 2. Cộng dồn vào dailychiso.calories_consumed
        $dailyChiso = DailyChiso::firstOrCreate(
            ['user_id' => $this->user_id, 'date' => $this->date],
            ['calories_burned' => 0, 'calories_consumed' => 0]
        );

        $dailyChiso->calories_consumed = round($dailyChiso->calories_consumed + $totalCalories, 2);
        $dailyChiso->save();
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
