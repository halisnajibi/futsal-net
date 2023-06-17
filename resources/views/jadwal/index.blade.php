@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Master</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Jadwal</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Jadwal</h4>
                    </div>
                    <div class="card-body">
                        @if (session()->has('jadwal'))
                        <div class="alert alert-success solid alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                            <strong>Berhasil!</strong> {{ session('jadwal') }}
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
                                        <th>Jadwal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwal->jadwal }}</td>
                                        <td>
                                            @if ($jadwal->status === 1)
                                            <form action="/admin/jadwals/{{ $jadwal->id }}" method="post">
                                                @csrf
                                            @method('put')
                                            <input type="hidden" name="status" value="{{ $jadwal->status }}">
                                            <input type="hidden" name="id" value="{{ $jadwal->id }}">
                                            <button class="badge badge-rounded badge-success" type="submit">Aktif</button>
                                            </form>
                                            @else
                                            <form action="/admin/jadwals/{{ $jadwal->id }}" method="post">
                                                @csrf
                                            @method('put')
                                            <input type="hidden" name="status" value="{{ $jadwal->status }}">
                                            <input type="hidden" name="id" value="{{ $jadwal->id }}">
                                            <button class="badge badge-rounded badge-danger" type="submit">Tidak Aktif</button>
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
    @endsection
