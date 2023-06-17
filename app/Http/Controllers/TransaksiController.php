<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
  public function index(){
    return \view('member.transaksi',[
        'transaksis' => Transaksi::all()
    ]);
  }

  public function invoice($kodePemesanan){
    return \view('member.invoice',[
      'invoice' => Pesanan::where('kode_pemesanan',$kodePemesanan)->get()
    ]);
  }
}
