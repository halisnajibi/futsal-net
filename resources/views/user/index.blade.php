@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Master</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data User</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Tambah
                            Data</button>
                    </div>
                    <div class="card-body">
                        @if (session()->has('user'))
                        <div class="alert alert-success solid alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                            <strong>Berhasil!</strong> {{ session('user') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close">
                            </button>
                        </div>
                    @endif
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->is_admin === 1)
                                            <form action="/admin/users/{{ $user->id }}" method="post">
                                                @csrf
                                            @method('put')
                                            <input type="hidden" name="is_admin" value="{{ $user->is_admin }}">
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button class="badge badge-rounded badge-warning" type="submit">Admin</button>
                                            </form>
                                            @else
                                            <form action="/admin/users/{{ $user->id }}" method="post">
                                                @csrf
                                            @method('put')
                                            <input type="hidden" name="is_admin" value="{{ $user->is_admin }}">
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button class="badge badge-rounded badge-info" type="submit">Member</button>
                                            </form>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="badge badge-rounded badge-danger" data-bs-toggle="modal" data-bs-target="#hapus{{ $user->id }}">Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah -->
        <div class="modal fade" id="basicModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label" for="validationCustom01">Nama
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror()" id="validationCustom01" placeholder="nama"
                                        required name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                        <div class="invalid-feedback">
                                           {{$message}}
                                        </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label" for="validationCustom01">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror()" id="validationCustom01"
                                        placeholder="contoh@gmail.com" required name="email"  value="{{ old('email') }}"">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-4 col-form-label" for="validationCustom01">Role
                                </label>
                                <div class="col-lg-6">
                                    <div class="basic-form">
                                        <select class="default-select form-control wide" id="inlineFormCustomSelect" name="is_admin">
                                            <option value="1">Admin</option>
                                            <option value="0">Member</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- hapus --}}
        @foreach ($users as $user)
        <div class="modal fade" id="hapus{{ $user->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Apakah anda yakin untuk menghapus?</h5>
                        <form action="/admin/users/{{ $user->id }}" method="POST">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>     
         @endforeach
    @endsection
