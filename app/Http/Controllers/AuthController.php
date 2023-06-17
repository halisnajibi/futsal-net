<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function index()
    {
        return \view('auth.index');
    }

    public function store(Request $request)
    {
       $validateData = $request->validate([
        'nama' => 'required|max:255',
        'email' => 'required|email:dns|unique:users',
        'password' => 'required|min:3',
        'jk' => 'nullable',
        'tempat_lahir' => 'nullable',
        'tanggal_lahir' => 'nullable',
        'alamat' => 'nullable'
       ]);
       $validateData['password'] = Hash::make($validateData['password']);
       User::create($validateData);
       return \redirect('/')->with('register', 'Silahkan Login');
    }
}
