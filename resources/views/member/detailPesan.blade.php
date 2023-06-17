@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Detail</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pesan</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lapangan->nama }}</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" class="form-control" id="idlapangan" value="{{ $lapangan->id }}">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Cari Tanggal</label>
                            <div class="col-sm-9">
                            
                                <input type="date" class="form-control @error('tanggal_pesan') is-invalid @enderror()"
                                    placeholder="tarif/jam" name="tanggal_pesan" min="{{ date('Y-m-d') }}"
                                    max="{{ date('Y-m-d', strtotime('+2 week')) }}" id="tanggal">
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
        <h4 id="ceklis"></h4>
        <form action="/member/pesan" method="post">
            @csrf
            <input type="hidden" value="{{ date('Y-m-d') }}" id="tanggalSekarang" name="tanggalSekarang">
            <div class="row" id="result-jam">
            </div>
            <button type="submit" class="btn btn-success btn-block d-none" id="tombol-pesan">Pesan Sekarang</button>
        </form>


        @push('myscript')
            <script>
                $('#tanggal').on('change', function() {
                    const tanggal = $(this).val();
                    const idlapangan = $('#idlapangan').val()
                    $.ajax({
                        url: '/member/cariPesanan',
                        type: 'get',
                        data: {
                            id: idlapangan,
                            tanggal: tanggal,
                        },
                        success: function(response) {
                            setHTML(response['jam'], response['pesanan'], idlapangan, tanggal)
                        },
                        error: function(xhr, status, error) {
                            console.log("Terjadi kesalahan: " + error);
                        }
                    })
                })

                function setHTML(jam, pesanan, idlapangan, tanggal) {
                    let html = "";
                    $.each(jam, function(i, data) {
                        let isBooked = false;
                        $.each(pesanan, function(j, pesananData) {
                            if (pesananData.jam_id === data.id) {
                                isBooked = true;
                                return false;
                            }
                        });
                        if (isBooked) {
                            html += '<div class="col-3 card text-center">';
                            html += '<div class="form-check custom-checkbox mb-3 checkbox-success check-lg">';
                            html += '<input type="checkbox" class="form-check-input" id="customCheckBox8" checked disabled>'
                            html += '</div>'
                            html += '<h5 class="mb-1">' + data.jam + '</h5>';
                            html += '<button class="btn btn-secondary btn-xxs shadow" disabled>Terisi</button>';
                            html += '</div>';
                        } else {
                            // let href = 'member/checkout/'+data.id+'/'+idlapangan
                            html += '<div class="col-3 card text-center">';
                            html += '<div class="form-check custom-checkbox mb-3 checkbox-success check-lg">';
                            html += '<input type="hidden" class="form-check-input" name="idLapangan" value="' + idlapangan +
                                '">'
                            html += '<input type="hidden" class="form-check-input" name="tanggal" value="' + tanggal +
                                '">'
                            html +=
                                '<input type="checkbox" class="form-check-input" id="customCheckBox8" name="jam[]" value="' +
                                data.id + '">'
                            html += '</div>'
                            html += '<h5 class="mb-1">' + data.jam + '</h5>';
                            html += '<button class="btn btn-primary btn-xxs shadow" disabled>Kosong</button>';
                            html += '</div>';
                        }
                    });
                    $('#result-jam').html(html);
                    $('#ceklis').text('Silahkan Ceklis Jam Main')
                    $('#tombol-pesan').removeClass('d-none')
                }
            </script>
        @endpush
    @endsection
