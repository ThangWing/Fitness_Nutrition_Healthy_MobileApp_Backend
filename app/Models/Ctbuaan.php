<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ctbuaan extends Model
{
    protected $table = 'ctbuaan';
    protected $fillable = ['buaan_id', 'doan_id', 'quantity'];

    public function buaan()
    {
        return $this->belongsTo(Buaan::class, 'buaan_id');
    }

    public function doan()
    {
        return $this->belongsTo(Doan::class, 'doan_id');
    }
}
