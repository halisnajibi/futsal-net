<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLapangan extends Model
{
    protected $guarded =['id'];
    use HasFactory;
    public static $rules = [
        'foto' => 'required|image|max:1024', // aturan validasi untuk foto
    ];

    public static function validate($data)
    {
        return validator($data, static::$rules);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}
