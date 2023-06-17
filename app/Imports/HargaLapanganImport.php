<?php

namespace App\Imports;

use App\Models\HargaLapangan;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
class HargaLapanganImport implements ToModel, WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable,SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HargaLapangan([
            'kode' => $row['kode'],
            'lapangan_id' => $row['lapangan_id'],
            'hari' => $row['hari'],
            'jam_id' => $row['jam_id'],
            'harga' => $row['harga'],
        ]);
    }

    public function rules():array
    {
            return [
                'kode' => 'required|unique:harga_lapangans',
                'lapangan_id' => 'required|numeric',
                'hari' => 'required',
                'jam_id' => 'required|numeric',
                'harga' => 'required|numeric',
            ];
    }

}
