<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function harga()
    {
        return $this->hasMany(HargaLapangan::class,'jam_id');
    }
}
