@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Member</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Transaksi</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Riwayat Transaksi</h4>
                    </div>
                    <div class="card-body">
                        {{-- @if (session()->has('crud'))
                            <div class="alert alert-success solid alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <strong>Berhasil!</strong> {{ session('crud') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                </button>
                            </div>
                        @endif --}}
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pemesanan</th>
                                        <th>Order ID</th>
                                        <th>Total Bayar</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status</th>
                                        <th>Cara Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksis as $transaksi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaksi->kode_pemesanan }}</td>
                                            <td>{{ $transaksi->order_id }}</td>
                                            <td>{{ $transaksi->gross_amount}}</td>
                                            <td>{{ $transaksi->payment_type}}</td>
                                            <td>
                                                @if ($transaksi->transaction_status == 'pending')
                                                <button class="badge badge-rounded badge-danger">Pending</button>
                                                @else
                                                <button class="badge badge-rounded badge-success">Paid</button>
                                                @endif
                                            </td>
                                            <td><a target="_blank" class="badge badge-rounded badge-primary" href="{{ $transaksi->pdf }}">Download</a></td>
                                            <td><a  class="badge badge-rounded badge-warning" href="/member/invoice/{{ $transaksi->kode_pemesanan }}">Detail</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- hapus --}}
        {{-- @foreach ($users as $user)
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
                        <form action="/user/{{ $user->id }}" method="POST">
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
         @endforeach --}}
    </div>
    @endsection