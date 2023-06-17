<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HariController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HargaLapanganController;
use App\Http\Controllers\ProfielController;
use App\Http\Controllers\TransaksiController;
use App\Models\HargaLapangan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[LoginController::class,'index'])->name('login')->middleware('guest');
Route::get('/logout',[LoginController::class,'logout']);
Route::post('/',[LoginController::class,'authenticate']);
Route::get('auth',[AuthController::class,'index'])->middleware('guest');
Route::post('auth',[AuthController::class,'store']);

Route::get('dashboard',[DashboardController::class,'index'])->middleware('auth');

Route::resource('/admin/users',UserController::class)->middleware('auth');
Route::resource('/admin/lapangans',LapanganController::class)->middleware('auth');
Route::resource('/admin/jadwals',JadwalController::class)->middleware('auth');
Route::resource('/admin/kategoris',KategoriController::class)->middleware('auth');

Route::resource('/admin/haris',HariController::class)->middleware('auth');
Route::resource('/admin/jams',JamController::class)->middleware('auth');

Route::get('/admin/tarifs/cari',[HargaLapanganController::class,'cariLapangan'])->middleware('auth');
Route::resource('/admin/tarifs',HargaLapanganController::class)->middleware('auth');

Route::get('/member/lapangans',[MemberController::class,'Showlapangan'])->middleware('auth');
Route::get('/member/lapangan/{lapangan:id}',[MemberController::class,'pilihHari'])->middleware('auth');
Route::get('/member/hargas',[MemberController::class,'ShowHarga'])->middleware('auth');
Route::get('/member/cariHarga',[MemberController::class,'cariHarga'])->middleware('auth');
Route::get('/member/cariPesanan',[MemberController::class,'cariPesanan'])->middleware('auth');
Route::post('/member/pesan',[MemberController::class,'pesanan'])->middleware('auth');
Route::post('/member/notification',[MemberController::class,'notification'])->middleware('auth');
Route::post('/importHarga',[HargaLapanganController::class,'import']);

Route::get('/member/transaksi',[TransaksiController::class,'index'])->middleware('auth');
Route::get('/member/invoice/{kode}',[TransaksiController::class,'invoice'])->middleware('auth');

Route::get('/download', function () {
    $pathToFile = storage_path('app/public/import/template.xlsx');
    return response()->download($pathToFile);
});

Route::resource('/profiel',ProfielController::class)->middleware('auth');

