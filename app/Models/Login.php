<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'login';
    protected $fillable = ['username', 'password', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
