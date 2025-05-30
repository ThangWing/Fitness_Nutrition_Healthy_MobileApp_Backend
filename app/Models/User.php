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
        return $this->hasMany(Dailychiso::class);
    }

    public function login()
    {
        return $this->belongsTo(Login::class, 'login_id');
    }

    public function favoriteExercises()
    {
        return $this->belongsToMany(BaiTap::class, 'BaiTapFav', 'user_id', 'baitap_id')->withTimestamps();
    }

    public function favoriteFoods()
    {
        return $this->belongsToMany(Doan::class, 'food_favs', 'user_id', 'doan_id')->withTimestamps();
    }

}
