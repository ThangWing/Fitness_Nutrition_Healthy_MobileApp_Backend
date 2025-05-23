<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyChiso extends Model
{
    protected $table = 'dailychiso';

    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'height',
        'bmi',
        'calories_consumed',
        'calories_burned',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}