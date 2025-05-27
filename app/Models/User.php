<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = ['name', 'age', 'gender', 'email','login_id'];

    public function buoiTaps() {
        return $this->hasMany(Buoitap::class);
    }

    public function dinhduong() {
        return $this->hasMany(Dinhduong::class);
    }

    public function muctieu() {
        return $this->hasMany(Muctieu::class);
    }

    public function dailyChisos() {
        return $this->hasMany(Daily_chiso::class);
    }

    public function login() {
        return $this->hasOne(Login::class);
    }
}
