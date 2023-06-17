@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Lapangan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Checkout</a></li>
            </ol>
        </div>
        @if (session()->has('alert'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                class="me-2">
                <polyline points="9 11 12 14 22 4"></polyline>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <strong>Berhasil!!</strong> {{ session('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
         @endif
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 order-lg-2 mb-4">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Jumlah Pesanan</span>
                                    <span class="badge badge-primary badge-pill">{{ $harga->count() }}</span>
                                </h4>
                                <ul class="list-group mb-3">
                                    @foreach ($harga as $h)
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">{{ $h->lapangan->nama }}</h6>
                                            <small class="text-muted">{{ $h->jam->jam }}</small>
                                        </div>
                                        <span class="text-muted" id="hargaLapangan">Rp {{ $h->harga }}</span>
                                    </li>
                                     @endforeach
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total</span>
                                        <strong id="totalHarga"></strong>
                                    </li>  
                                </ul>
                            </div>
                            <div class="col-lg-8 order-lg-1">
                                <h4 class="mb-3">Pembayaran</h4>
                                <form class="needs-validation" method="POST" action="/member/checkout" id="formCheckout">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName" class="form-label">Kode Pemesanan</label>
                                            <input type="text" class="form-control" value="{{ $kode_pemesanan }}" readonly id="kode_pemesanan">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName" class="form-label">Nama Pemesan</label>
                                            <input type="text" class="form-control" id="firstName" placeholder="" value="{{ Auth::user()->nama }}" readonly name="nama">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email"  class="form-label">Email</label>
                                        <input type="email" readonly class="form-control" id="email" value="{{  Auth::user()->email }}">
                                    </div>
                                    <hr class="mb-4">
                                    <button class="btn btn-primary btn-lg btn-block" type="button" id="pay-button">Bayar</button>
                                    <input type="hidden" name="json" id="jsonCallback">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Chfe8EEu5TdRUDd5"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        // SnapToken acquired from previous step
        snap.pay('{{ $token }}', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
            alert('success')
            const kode = $("#kode_pemesanan").val();
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url': 'notification',
                        'type': 'post',
                        'data': {
                            data: result,
                            kodePemesanan: kode,
                        },
                        success: function(response) {
                            console.log(response)
                            window.location.href = '/member/invoice/' + response['kode_pemesanan']
                        }
                    });
            },
            // Optional
            onPending: function(result) {
                const kode = $("#kode_pemesanan").val();
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url': 'notification',
                        'type': 'post',
                        'data': {
                            data: result,
                            kodePemesanan: kode,
                        },
                        success: function(response) {
                            console.log(response)
                            window.location.href = '/member/invoice/' + response['kode_pemesanan']
                        }
                    });
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
               console.log(result)
               setResponse(result)
            }
        });
    };

    function setResponse(result){
    console.log(result)
     document.getElementById('jsonCallback').value = JSON.stringify(result);
     $('#formCheckout').submit()
    }
</script>
    <script>
      var total = 0;
    $('.text-muted#hargaLapangan').each(function(){
        var harga = parseInt($(this).text().replace('Rp ', ''));
        total += harga;
    });
    $('#totalHarga').text('Rp ' + total);
    </script>
@endpush
