<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'login';
    protected $fillable = ['username', 'password'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
