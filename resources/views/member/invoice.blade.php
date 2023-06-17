@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Transaksi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Invoice</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        <div class="card-header"> Invoice <strong>{{ $invoice[0]->kode_pemesanan }}</strong> <span
                                class="float-end">
                                <strong>Status:</strong> {{ $invoice[0]->transaksi->transaction_status }}</span> </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <h6>Pemesan:</h6>
                                    <div> <strong>{{ Auth::user()->nama }}</strong> </div>
                                    <div>{{ Auth::user()->email }}</div>
                                </div>
                                <div
                                    class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex justify-content-lg-end justify-content-md-end justify-content-xs-start">
                                    <div class="row align-items-center">
                                        <div class="col-sm-9">
                                            <div class="brand-logo mb-3">
                                                <img class="logo-abbr me-2" width="50"
                                                    src="{{ asset('assets/images/logo.png') }}" alt="">
                                                <img class="logo-compact" width="110"
                                                    src="{{ asset('assets/images/logo-text.png') }}" alt="">
                                            </div>
                                            <span>Payment Type: <strong
                                                    class="d-block">{{ $invoice[0]->transaksi->payment_type }}</strong></span>
                                            <span>Tanggal Pemesanan: <strong
                                                    class="d-block">{{ $invoice[0]->transaksi->tanggal_mesan_lapangan }}</strong></span>
                                        </div>
                                        <div class="col-sm-3 mt-3"> <img src="images/qr.png" alt=""
                                                class="img-fluid width110"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Tanggal Main</th>
                                            <th>Lapangan</th>
                                            <th>Jam</th>
                                            <th class="right">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0; // Inisialisasi variabel total
                                        @endphp
                                        @foreach ($invoice as $item)
                                            <tr>
                                                <td class="center">{{ $loop->iteration }}</td>
                                                <td class="left strong">{{ $item->tanggal_main }}</td>
                                                <td class="left">{{ $item->lapangan->nama }}</td>
                                                <td class="right">{{ $item->jam->jam }}</td>
                                                <td class="right">{{ $item->harga }}</td>
                                            </tr>
                                            @php
                                                $total += $item->harga;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-5"> </div>
                                <div class="col-lg-4 col-sm-5 ms-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="left"><strong>Total</strong></td>
                                                <td class="right"><strong>Rp {{ $total }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
