<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return \view('user.index',[
        'users' => User::all()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $request->is_admin;
       $validateData = $request->validate([
        'nama' => 'required',
        'email' => 'required|email:dns|unique:users|'
       ]);
      if($role == 0){
        $validateData['password'] = Hash::make('admin');
      }else{
        $validateData['password'] = Hash::make('member');
      }
      $validateData['is_admin'] = $role;
      User::create($validateData);
      return \redirect('/user')->with('tambah', 'Data sudah Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['is_admin' => 'required'];
        $validateData = $request->validate($rules);
        if($request->is_admin == 1){
            $validateData['is_admin'] = 0;
        }else{
            $validateData['is_admin'] =1;
        }
       User::where('id',$id)->update($validateData);
       return \redirect('/admin/user')->with('user', 'Data Sudah Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      User::destroy($id);
      return \redirect('/admin/users')->with('user', 'Data Sudah Dihapus');
    }
}
