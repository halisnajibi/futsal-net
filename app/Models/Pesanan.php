<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
        
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'kode_pemesanan', 'kode_pemesanan');
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function jam()
    {
        return $this->belongsTo(Jam::class);
    }
}
