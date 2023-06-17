@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Jadwal</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Jam</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Tarif Sewa Lapangan</h4>
                        <a href="/admin/tarifs/create"  class="btn btn-primary">Tambah
                            Data</a>
                            <button data-bs-toggle="modal" data-bs-target="#import"  class="btn btn-success" >Import
                                Data</button>
                    </div>
                    <div class="card-body">
                        @if (session()->has('alert'))
                            <div class="alert alert-success solid alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <strong>Berhasil!</strong> {{ session('alert') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                </button>
                            </div>
                        @endif
                        @if (session()->has('gagal'))
                        <div class="alert alert-danger solid alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            <strong>Gagal!</strong>{{ session('gagal') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                        </div>
                        @endif
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Cari Lapangan</label>
                            <div class="col-sm-9">
                                <select class="form-control wide" id="lapangan" name="lapangan_id">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($lapangans as $lapangan)
                                        <option value="{{ $lapangan->id }}">{{ $lapangan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tes" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Lapangan</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Hari</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin/haris" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Hari</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('hari') is-invalid @enderror()"
                                        placeholder="hari" name="hari" value="{{ old('hari') }}">
                                    @error('hari')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
    <div class="modal fade" id="import">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Harga Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form action="/importHarga" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="basic-form">
                            <div class="col">
                                <p>Silahkan download template exel dibawah ini untuk melakukan import data     <a href="/download"><i class="fa-solid fa-download"></i>Download</a></p>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Exel</label>
                                    <div class="col-sm-9">
                                        <input type="file"
                                                class="form-control @error('file') is-invalid @enderror()"
                                                placeholder="file" name="file">
                                            @error('file')
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

    @push('myscript')
        <script>
            $(document).ready(function() {
                $('#lapangan').on('change', function() {
    const lapangan = $(this).val();
    
    if ($.fn.DataTable.isDataTable('#tes')) {
        $('#tes').DataTable().destroy();
    }
    
    $('#tes').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/tarifs/cari",
            "type": "GET",
            "data": {
                "lapangan": lapangan
            }
        },
        "columns": [
            {
                "data": "DT_RowIndex",
                "name": "DT_RowIndex",
                "orderable": false,
                "searchable": false,
                "width": "5%"
            },
            {
                "data": "kode",
                "name": "kode"
            },
            {
                "data": "nama",
                "name": "nama"
            },
            {
                "data": "hari",
                "name": "hari"
            },
            {
                "data": "jam",
                "name": "jam"
            },
            {
                "data": "harga",
                "name": "harga"
            },
            {
                "data":"aksi",
            "name":"aksi"
        }
        ]
    });
});

            });
        </script>
    @endpush
@endsection
