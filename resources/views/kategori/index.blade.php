@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Master</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kategori</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Kategori</h4>
                        <button data-bs-toggle="modal" data-bs-target="#tambahkategori"  class="btn btn-primary" >Tambah
                            Data</button>
                    </div>
                    <div class="card-body">
                        @if (session()->has('kategori'))
                        <div class="alert alert-success solid alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                            <strong>Berhasil!</strong> {{ session('kategori') }}
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
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategories as $kategori)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kategori->nama }}</td>
                                        <td>
                                            <form action="/admin/kategoris/{{ $kategori->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                            <button type="button" class="badge badge-rounded badge-danger"  data-bs-toggle="modal" data-bs-target="#hapus{{ $kategori->id }}" >Hapus
                                            </button>
                                        </form>
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
        {{-- tambah modal --}}
        <div class="modal fade" id="tambahkategori">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <form action="/admin/kategoris" method="POST">
                        @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="basic-form">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama Kategori</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('nama') is-invalid @enderror()"
                                                placeholder="nama kategori" name="nama" value="{{ old('nama') }}">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        {{-- hapus --}}
        @foreach ($kategories as $kategori)
        <div class="modal fade" id="hapus{{ $kategori->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Apakah anda yakin untuk menghapus?</h5>
                        <form action="/admin/kategoris/{{ $kategori->id }}" method="POST">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="id" value="{{ $kategori->id }}">
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
