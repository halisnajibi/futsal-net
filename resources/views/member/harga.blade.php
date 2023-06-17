@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">List Harga</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Lapangan</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Tarif Sewa Lapangan</h4>
                    </div>
                    <div class="card-body">
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
                                        <th>Nama Lapangan</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Harga</th>
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
                                <p>Silahkan download template exel dibawah ini untuk melakukan import data     <a href="/download/template.xlsx"><i class="fa-solid fa-download"></i>Download</a></p>
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
            "url": "/member/cariHarga",
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
            }
        ]
    });
});

            });
        </script>
    @endpush
@endsection
