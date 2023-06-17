<?php

namespace App\Http\Controllers;

use App\Imports\HargaLapanganImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\HargaLapangan;
use App\Models\Jam;
use Illuminate\Http\Request;
use App\Models\Lapangan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class HargaLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('tarif.index', [
            'lapangans' => Lapangan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return \view('tarif.tambah',[
        'lapangans' => Lapangan::all(),
        'jams' => Jam::where('status',1)->get()
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $results = DB::table('harga_lapangans')
        ->where('kode', '=', $request->kode)
        ->where('lapangan_id', '=', $request->lapangan_id)
        ->where('hari', '=', $request->hari)
        ->where('jam_id', '=', $request->jam_id)
        ->count();
        if($results > 0){
            return \redirect('/admin/tarifs/create')->with('gagal','Data sudah ada');
        }else{
            $validateData = $request->validate([
                'kode' => 'required',
                'lapangan_id' => 'required',
                'hari' => 'required',
                'jam_id' => 'required',
                'harga' => 'required|numeric',
               ]);
            HargaLapangan::create($validateData);
            return \redirect('/admin/tarifs')->with('alert','Data sudah ditambahkan');
        }

      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HargaLapangan  $hargaLapangan
     * @return \Illuminate\Http\Response
     */
    public function show(HargaLapangan $hargaLapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HargaLapangan  $hargaLapangan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \view('tarif.edit',[
            'tarif' => HargaLapangan::where('id',$id)->first(),
            'lapangans' => Lapangan::all(),
            'jams' => Jam::where('status',1)->get()
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HargaLapangan  $hargaLapangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HargaLapangan $hargaLapangan)
    {
       $validateData = $request->validate([
        'kode' => 'required',
        'lapangan_id' => 'required',
        'hari' => 'required',
        'jam_id' => 'required',
        'harga' => 'required|numeric'
       ]);
       HargaLapangan::where('id',$request->id)->update($validateData);
       return \redirect('/admin/tarifs')->with('alert','Data sudah diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HargaLapangan  $hargaLapangan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    HargaLapangan::destroy($id);
    return \redirect('/admin/tarifs')->with('alert','Data sudah dihapus');
    }

    public function cariLapangan(Request $request)
    {
     $idLapangan = $request->input('lapangan');
     $data = DB::table('harga_lapangans')
     ->select('harga_lapangans.id','harga_lapangans.kode', 'lapangans.nama', 'hari', 'jams.jam', 'harga_lapangans.harga')
     ->join('lapangans', 'harga_lapangans.lapangan_id', '=', 'lapangans.id')
     ->join('jams', 'harga_lapangans.jam_id', '=', 'jams.id')
     ->where('harga_lapangans.lapangan_id', '=', $idLapangan)
     ->get();
     return DataTables::of($data)
     ->addIndexColumn()
     ->addColumn('aksi', function($data){
        return \view('tarif.aksi',['data' => $data]);
     })
     ->make(true);
    }

    public function import(Request $request)
    {
        $file = $request->file('file')->store('import');
        $import = new HargaLapanganImport;
        $import->import($file);
        
        if($import->failures()){
            return \back()->with('gagal','Data duplikat atau kosong');
        }else{
            return \redirect('/admin/tarifs')->with('alert','Data Sudah Diimport');
        }
    }

}
