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
                        <h4 class="card-title">Data Jam</h4>
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
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Jam</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jams as $jam)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jam->id }}</td>
                                            <td>{{ $jam->jam }}</td>
                                            <td>
                                                {{-- <form action="/admin/jams/{{ $jam->id }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="badge badge-rounded badge-danger"
                                                        onclick="return confirm('yakin')">Hapus
                                                    </button>
                                                </form> --}}
                                                @if ($jam->status == 1)
                                                <form action="/admin/jams/{{ $jam->id }}" method="post">
                                                    @method('put')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $jam->id }}">
                                                    <input type="hidden" name="status" value="0">
                                                    <button type="submit" class="badge badge-success">Aktif</button>
                                                </form>
                                                @else
                                                <form action="/admin/jams/{{ $jam->id }}" method="post">
                                                    @method('put')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $jam->id }}">
                                                    <input type="hidden" name="status" value="1">
                                                    <button type="submit" class="badge badge-danger">Tidak Aktif</button>
                                                </form>
                                                @endif
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
    </div>
@endsection
