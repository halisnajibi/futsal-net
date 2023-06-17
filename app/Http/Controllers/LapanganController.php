<?php

namespace App\Http\Controllers;

use App\Models\FotoLapangan;
use App\Models\Lapangan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('lapangan.index', [
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
        return \view('lapangan.tambah', [
            'kategories' => Kategori::all()
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
        $validateData = $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'keterangan' => 'required',
            'foto_sampul' => 'image|file|max:1024',
        ]);
        if ($request->file('foto_sampul')) {
            //rubah FILESYSTEM_DISK di fil env jadi public
            $validateData['foto_sampul'] =  $request->file('foto_sampul')->store('foto lapangan/sampul');
        }
        $lapangan = Lapangan::create($validateData);
        // upload foto detail
        $images = $request->file('foto');
        if ($images) {
            $validatedData2 = Validator::make(
                ['foto' => $images],
                [
                    'foto.*' => 'image|max:1024', // validasi untuk setiap foto
                    'foto' => 'max:3', // batasi jumlah foto yang diunggah menjadi 3
                ]
            );
            if ($validatedData2->fails()) {
                return redirect()->back()->withErrors($validatedData2);
            }
            $validatedImages = $validatedData2->validated()['foto'];
            foreach ($validatedImages as $validatedImage) {
                $path = $validatedImage->store('foto lapangan/detail');
                if (!$path) {
                    return redirect()->back()->withErrors(['foto' => 'Gagal menyimpan foto']);
                }
                FotoLapangan::create([
                    'lapangan_id' => $lapangan->id,
                    'foto' => $path,
                ]);
            }
        }
        return redirect('/admin/lapangans')->with('crud', 'Data sudah Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lapangan $lapangan)
    {
     return \view('lapangan.detail',[
        'lapangan' => $lapangan
     ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \view('lapangan.edit', [
            'lapangan' => Lapangan::find($id),
            'kategories' => Kategori::all(),
            'detailFoto' => FotoLapangan::where('lapangan_id', $id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lapangan $lapangan)
    {
        $rules = [
            'nama' => 'required|max:255',
            'kategori_id' => 'required',
            'keterangan' => 'required',
            'foto_sampul' => 'image|file|max:1024',
        ];
        $validateData = $request->validate($rules);
        if ($request->file('foto_sampul')) {
            if ($lapangan->foto_sampul != 'foto lapangan/sampul/sampul.jpg') {
                Storage::delete($lapangan->foto_sampul);
            }
            $validateData['foto_sampul'] = $request->file('foto_sampul')->store('foto lapangan/sampul');
        }
        Lapangan::where('id', $lapangan->id)->update($validateData);
        $images = $request->file('foto');
        if ($images) {
            $validatedData2 = Validator::make(
                ['foto' => $images],
                [
                    'foto.*' => 'image|max:1024', // validasi untuk setiap foto
                    'foto' => 'max:3', // batasi jumlah foto yang diunggah menjadi 3
                ]
            );
            if ($validatedData2->fails()) {
                return redirect()->back()->withErrors($validatedData2);
            }
            $fotoDetailLama = $lapangan->fotoLapangan;

            if ($fotoDetailLama->count() > 0) {
                $fotos = [];
                foreach ($fotoDetailLama as $foto) {
                    $fotos[] = $foto->foto;
                }
                Storage::delete($fotos);
            }
            FotoLapangan::where('lapangan_id', $lapangan->id)->delete();
            foreach ($images as $validatedImage) {
                $path = $validatedImage->store('foto lapangan/detail');
                if (!$path) {
                    return redirect()->back()->withErrors(['foto' => 'Gagal menyimpan foto']);
                }
                FotoLapangan::create([
                    'lapangan_id' => $lapangan->id,
                    'foto' => $path,
                ]);
            }
        }
        return redirect('/admin/lapangans')->with('crud', 'Data sudah Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->foto_sampul != 'sampul.jpg') {
            Storage::delete($lapangan->foto_sampul);
        }
        Lapangan::destroy($lapangan->id);
        $fotoDetail = FotoLapangan::where('lapangan_id', $lapangan->id)->get();
        if ($fotoDetail->count() > 0) {
            $fotos = [];
            foreach ($fotoDetail as $foto) {
                $fotos[] = $foto->foto;
            }
            Storage::delete($fotos);
            FotoLapangan::where('lapangan_id', $lapangan->id)->delete();
        }
        return \redirect('/admin/lapangans')->with('crud', 'Data sudah Dihapus');
    }
}
