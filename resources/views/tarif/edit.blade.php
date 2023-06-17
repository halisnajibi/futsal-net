
@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Tarif Lapangan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (session()->has('gagal'))
                        <div class="alert alert-danger solid alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <strong>Gagal!</strong> {{ session('gagal') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                        </div>
                    @endif
                    <div class="card-header">
                        <h4 class="card-title">Form Edit Data Tarif Lapangan</h4>

                    </div>
                    <div class="card-body">
                        <form action="/admin/tarifs/{{ $tarif->id }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="basic-form">
                                    <input type="hidden" name="id" value="{{ $tarif->id }}">
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Kode Harga</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('kode') is-invalid @enderror()"
                                                    placeholder="kode" name="kode"
                                                    value="{{ old('kode', $tarif->kode) }}" readonly>
                                                @error('kode')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Nama Lapangan</label>
                                            <div class="col-sm-9">
                                                <select class="form-control wide" id="inlineFormCustomSelect"
                                                    name="lapangan_id">
                                                    @foreach ($lapangans as $lapangan)
                                                        @if ($tarif->lapangan_id == $lapangan->id)
                                                            <option value="{{ $lapangan->id }}" selected>
                                                                {{ $lapangan->nama }}</option>
                                                        @else
                                                            <option value="{{ $lapangan->id }}">{{ $lapangan->nama }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Hari</label>
                                            <div class="col-sm-9">
                                                <select class="form-control wide" id="inlineFormCustomSelect"
                                                    name="hari_id">
                                                    @foreach ($haris as $hari)
                                                        @if ($tarif->hari_id == $hari->id)
                                                            <option value="{{ $hari->id }}" selected>
                                                                {{ $hari->hari }}</option>
                                                        @else
                                                            <option value="{{ $hari->id }}">{{ $hari->hari }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Jam</label>
                                            <div class="col-sm-9">
                                                <select class="form-control wide" id="inlineFormCustomSelect"
                                                    name="jam_id">
                                                    @foreach ($jams as $jam)
                                                        @if ($tarif->jam_id == $jam->id)
                                                            <option value="{{ $jam->id }}" selected>
                                                                {{ $jam->jam }}</option>
                                                        @else
                                                            <option value="{{ $jam->id }}">{{ $jam->jam }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Tarif/Jam</label>
                                            <div class="col-sm-9">
                                                <input type="number"
                                                    class="form-control @error('harga') is-invalid @enderror()"
                                                    placeholder="tarif/jam" name="harga"
                                                    value="{{ old('harga', $tarif->harga) }}">
                                                @error('harga')
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
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('myscript')
    @endpush
