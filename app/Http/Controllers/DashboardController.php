<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return \view('dashboard.index',[
            'user' => User::count(),
            'transaksi' => Transaksi::count(),
            'lapangan' => Lapangan::count()
        ]);
    }
}
