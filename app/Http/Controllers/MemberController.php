<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use App\Models\Lapangan;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\HargaLapangan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class MemberController extends Controller
{
    public function Showlapangan()
    {
        return \view('member.lapangan', [
            'lapangans' => Lapangan::latest()->filter(\request(['kategori_id']))->get(),
            'kategories' => Kategori::all()
        ]);
    }

    public function ShowHarga()
    {
        return \view('member.harga', [
            'lapangans' => Lapangan::all()
        ]);
    }

    public function pilihHari(Lapangan $lapangan)
    {
        return \view('member.detailPesan', [
            'lapangan' => $lapangan
        ]);
    }

    public function cariHarga(Request $request)
    {
        $idLapangan = $request->input('lapangan');
        $data = DB::table('harga_lapangans')
            ->select('harga_lapangans.id', 'harga_lapangans.kode', 'lapangans.nama', 'haris.hari', 'jams.jam', 'harga_lapangans.harga')
            ->join('lapangans', 'harga_lapangans.lapangan_id', '=', 'lapangans.id')
            ->join('haris', 'harga_lapangans.hari_id', '=', 'haris.id')
            ->join('jams', 'harga_lapangans.jam_id', '=', 'jams.id')
            ->where('harga_lapangans.lapangan_id', '=', $idLapangan)
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function cariPesanan(Request $request)
    {
        $idLapangan = $request->input('id');
        $tanggal = $request->input('tanggal');
        $pesan =  Pesanan::where('lapangan_id', $idLapangan)
            ->where('tanggal_main', $tanggal)
            ->get();
        $jam = Jam::all();
        $result = [
            'pesanan' => $pesan,
            'jam' => $jam
        ];
        return $result;
    }

    public function pesanan(Request $request)
    {
        $idLapangan = $request->idLapangan;
        $idJam = $request->jam;
        $hari = $this->balikHari($request->tanggal);

        // cari harga lapangan sesuai yang dinput user
        $hargaLapangan = HargaLapangan::where('lapangan_id', $idLapangan)
            ->where(function ($query) use ($idJam) {
                $query->whereIn('jam_id', $idJam)
                    ->havingRaw('COUNT(DISTINCT jam_id) = ' . count($idJam));
            })
            ->where('hari', $hari)
            ->get();

        //simpan data pesanan ke tabel pesanans
        foreach($hargaLapangan as $h){
        $data = [
            'user_id' => Auth::user()->id,
            'kode_pemesanan' => \date('Ymd').Str::random(5),
            'tanggal_mesan' => $request->tanggalSekarang,
            'tanggal_main' => $request->tanggal,
            'lapangan_id' => $idLapangan,
            'harga' => $h->harga,
            'status' => 'belum bayar'
        ];
    }
        $this->simpanPesanan($data, $idJam);

        //munculkan snap mindtrans

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-HsfaFIIlwi_k3IeRBLbhCnuY';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $items = [];
        $no = 1;
        foreach ($hargaLapangan as $row) {
            $items[] = array(
                'id' => 'ID' . $no++,
                'price' => $row->harga,
                'quantity' => 1,
                'name' => $row->lapangan->nama . ' ( Jam ' . $row->jam->jam . ' ) '
            );
        }
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'];
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $total,
            ),
            'item_details' => $items,
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return \view('member.checkout', [
            'harga' => $hargaLapangan,
            'token' => $snapToken,
            'kode_pemesanan' => $data['kode_pemesanan']
        ]);
    }

    public function simpanPesanan($data, $idJam)
    {
        foreach ($idJam as $jam) {
            $data['jam_id'] = $jam;
            Pesanan::create($data);
        }
        Session::flash('alert', 'Data disimpan,Silahkan lakukan pembayaran !!');
    }

    public function notification(Request $request){
        $data = $request->input('data');
        $kodePemesanan = $request->input('kodePemesanan');
        // $kodeOrder = \date('Ymd').Str::random(5);
        if($data['transaction_status'] == 'pending'){
               $this->_pending($data,$kodePemesanan);
               return $result =[
                'alert' => 'berhasil memilih metode pemabayaran',
                'kode_pemesanan' => $kodePemesanan
            ] ;
        }elseif($data['transaction_status'] == 'settlement'){
            $this->_success($data,$kodePemesanan);
            return $result =[
             'alert' => 'berhasil memilih metode pemabayaran',
             'kode_pemesanan' => $kodePemesanan
         ] ;
        }
    }


    private function _pending($data,$kodePemesanan){
        switch (true) {
            case array_key_exists('biller_code', $data):
                //MANDIRI
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'mandiri -' . $data['bill_key'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            case array_key_exists('permata_va_number', $data):
                //PERMATA
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'permata -' . $data['permata_va_number'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            case array_key_exists('ewallet_type', $data):
                //E-WALLET
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'e-wallet -' . $data['ewallet_type'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            case array_key_exists('payment_type', $data) && $data['payment_type'] == 'cstore':
                //ALFAMRT /INDOMARET
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'Alfamrt / Indomaret - ' . $data['payment_code'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            default:
                //BRI BNI BCA
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => $data['va_numbers'][0]['bank'] . '-' . $data['va_numbers'][0]['va_number'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
        }
    }

    private function _success($data,$kodePemesanan){
        switch (true) {
            case array_key_exists('biller_code', $data):
                //MANDIRI
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'mandiri -' . $data['bill_key'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            case array_key_exists('permata_va_number', $data):
                //PERMATA
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'permata -' . $data['permata_va_number'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            case array_key_exists('ewallet_type', $data):
                //E-WALLET
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'e-wallet -' . $data['ewallet_type'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            case array_key_exists('payment_type', $data) && $data['payment_type'] == 'cstore':
                //ALFAMRT /INDOMARET
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => 'Alfamrt / Indomaret - ' . $data['payment_code'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
                break;
            default:
                //BRI BNI BCA
                Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'kode_pemesanan' => $kodePemesanan,
                    'tanggal_mesan_lapangan' =>  \date('Y-m-d'),
                    'order_id' => $data['order_id'],
                    'gross_amount' => $data['gross_amount'],
                    'payment_type' => $data['va_numbers'][0]['bank'] . '-' . $data['va_numbers'][0]['va_number'],
                    'transaction_status' => $data['transaction_status'],
                    'pdf' => $data['pdf_url']
                ]);
        }
    }

    public function balikHari($tanggalInput)
    {
        $hari = date('l', strtotime($tanggalInput)); // Output: Monday
        $tanggal = DateTime::createFromFormat('Y-m-d', $tanggalInput);
        $namaHariInggris = $tanggal->format('l');
        $namaHariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hari = $namaHariIndonesia[$namaHariInggris];
        return $hari;
    }
}
