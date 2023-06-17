<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaLapangan extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }

    public function jam()
    {
        return $this->belongsTo(Jam::class, 'jam_id');
    }
}
