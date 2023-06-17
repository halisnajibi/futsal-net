<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded;
    use HasFactory;
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'kode_pemesanan', 'kode_pemesanan');
    }
    
}
