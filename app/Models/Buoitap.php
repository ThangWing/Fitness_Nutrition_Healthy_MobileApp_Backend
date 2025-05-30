<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuoiTap extends Model
{
    protected $table = 'buoitap';

    protected $fillable = ['user_id', 'calories_burned', 'date'];

    public function baiTaps()
    {
        return $this->belongsToMany(BaiTap::class, 'ctbuoitap', 'buoitapid', 'baitap_id')
                    ->withPivot('duration');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recalculateCalories()
    {
        $latestChiso = $this->user->dailyChisos()->orderByDesc('date')->first();

        if (!$latestChiso) {
            throw new \Exception('Không tìm thấy chỉ số cân nặng mới nhất của người dùng.');
        }

        $userWeight = $latestChiso->weight;
        $totalCalories = 0;

        foreach ($this->baiTaps as $bt) {
            $duration = $bt->pivot->duration;
            $mets = $bt->mets;
            $calories = ($mets * 3.5 * $userWeight / 200) * $duration;
            $totalCalories += $calories;
        }

        $this->calories_burned = round($totalCalories, 2);
        $this->save();

        $dailyChiso = DailyChiso::class::firstOrCreate(
            ['user_id' => $this->user_id, 'date' => $this->date],
            ['calories_consumed' => 0, 'calories_burned' => 0]
        );

        $dailyChiso->calories_burned = round($dailyChiso->calories_burned + $addedCalories, 2);
        $dailyChiso->save();
    }
}