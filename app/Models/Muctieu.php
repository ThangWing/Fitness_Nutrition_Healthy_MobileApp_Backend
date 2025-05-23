<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muctieu extends Model
{
    protected $table = 'muctieu';

    protected $fillable = [
        'user_id',
        'goal_type',
        'target_value',
        'progress',
        'deadline'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
