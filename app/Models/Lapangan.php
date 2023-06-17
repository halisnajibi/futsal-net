<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    public function Kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function fotoLapangan()
    {
        return $this->hasMany(FotoLapangan::class);
    }

    public function scopeFilter($query,array $filters)
    {
        $query->when($filters['kategori_id'] ?? false, function ($query, $kategori_id) {
            return  $query->where('kategori_id',  $kategori_id);
        });
    }

    public function harga()
    {
        return $this->hasMany(HargaLapangan::class,'lapangan_id');
    }
}
