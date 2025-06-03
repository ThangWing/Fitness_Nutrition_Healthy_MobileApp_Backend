<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buaan extends Model
{
    protected $table = 'buaan';
    protected $fillable = ['user_id', 'calories', 'date'];

    public function doans()
    {
        return $this->belongsToMany(Doan::class, 'ctbuaan','buaan_id', 'doan_id')
                    ->withPivot('quantity');
    }

    public function recalculateCalories()
{
    // Lấy danh sách món ăn trong bữa
    $totalCalories = 0;

    foreach ($this->doans as $doan) {
        $quantity = $doan->pivot->quantity;
        $caloriesPer100g = $doan->calories_per_100g;

        $calories = ($quantity * $caloriesPer100g) / 100;
        $totalCalories += $calories;
    }

    // Cập nhật calories cho bản thân bữa ăn
    $this->calories = round($totalCalories, 2);
    $this->save();

    // Cập nhật vào DailyChiso (chỉ số trong ngày)
    $dailyChiso = DailyChiso::firstOrCreate(
        ['user_id' => $this->user_id, 'date' => $this->date],
        ['calories_burned' => 0, 'calories_consumed' => 0]
    );

    // Cập nhật calories_consumed cho ngày đó

    $dailyChiso->calories_consumed = round($dailyChiso->calories_consumed + $totalCalories, 2);

    $dailyChiso->save();
}
}
