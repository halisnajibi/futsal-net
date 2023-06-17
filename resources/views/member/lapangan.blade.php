@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Member</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Lapangan</a></li>
            </ol>
        </div>
        <div class="row mb-3">
            <div class="col-10">
                <form action="" method="get">
                    <div class="col">
                        <select class="form-control wide" name="kategori_id" id="kategori">
                            <option value="">Semua</option>
                            @foreach ($kategories as $kategori)
                                @if (request('kategori_id') == $kategori->id)
                                    <option value="{{ $kategori->id }}" selected>{{ $kategori->nama }}</option>
                                @else
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-2">
                <div class="col">
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach ($lapangans as $lapangan)
                <div class="col-lg-12 col-xl-6" id="lapangan">
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-md-5 col-xxl-12">
                                    <div class="new-arrival-product mb-4 mb-xxl-4 mb-md-0">
                                        <div class="new-arrivals-img-contnent">
                                            @foreach ($lapangan->fotoLapangan as $fotoDetail)
                                                <div id="carouselExampleIndicators{{ $fotoDetail->id }}"
                                                    class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <img class="d-block w-100"
                                                                src="{{ asset('storage/' . $lapangan->foto_sampul) }}"
                                                                alt="First slide">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100"
                                                                src="{{ asset('storage/' . $fotoDetail->foto) }}"
                                                                alt="Second slide">
                                                        </div>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#carouselExampleIndicators{{ $fotoDetail->id }}"
                                                        data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button"
                                                        data-bs-target="#carouselExampleIndicators{{ $fotoDetail->id }}"
                                                        data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-xxl-12">
                                <div class="new-arrival-content position-relative">
                                    <h4>{{ $lapangan->nama }}</h4>
                                    <p>Kategori Lapangan : <span class="item"> {{ $lapangan->kategori->nama }}</p>
                                    <div class="text-content">{!! $lapangan->keterangan !!}</div>
                                </div>
                            </div>
                        </div>
                        <a href="/member/lapangan/{{ $lapangan->id }}" class="btn btn-primary">Pilih</a>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
    </div>
@endsection
@push('myscript')
    {{-- <script>

$(document).ready(function() {
  $("#kategori").on("change", function() {
    const value = $(this).val();
        $.ajax({
            url: '/member/cariLapangan/',
            type:'get',
            dataType:'json',
            data:{idKategori:value},
            success:function(response){
               rubahLapangan(response);
            }
        })
  });
});

function rubahLapangan(response) {
    $.each(response, function(index, lapangan) {
                // var carouselInnerHtml = '';
                $.each(lapangan.fotoLapangan, function(index, fotoDetail) {
                    var activeClass = index == 0 ? 'active' : '';
                    carouselInnerHtml += '<div class="carousel-item ' + activeClass + '">' +
                        '<img class="d-block w-100" src="' + fotoDetail.foto + '">' +
                        '</div>';
                });

                // var lapanganHtml = '<div class="col-lg-12 col-xl-6">' +
                //     '<div class="card">' +
                //     '<div class="card-body">' +
                //     '<div class="row m-b-30">' +
                //     '<div class="col-md-5 col-xxl-12">' +
                //     '<div class="new-arrival-product mb-4 mb-xxl-4 mb-md-0">' +
                //     '<div class="new-arrivals-img-contnent">' +
                //     '<div id="carouselExampleIndicators' + lapangan.id + '" class="carousel slide" data-bs-ride="carousel">' +
                //     '<div class="carousel-inner">' +
                //     carouselInnerHtml +
                //     '</div>' +
                //     '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators' + lapangan.id + '" data-bs-slide="prev">' +
                //     '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
                //     '<span class="visually-hidden">Previous</span>' +
                //     '</button>' +
                //     '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators' + lapangan.id + '" data-bs-slide="next">' +
                //     '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
                //     '<span class="visually-hidden">Next</span>' +
                //     '</button>' +
                //     '</div>' +
                //     '</div>' +
                //     '</div>' +
                //     '<div class="col-md-7 col-xxl-12">' +
                //     '<div class="new-arrival-content position-relative">' +
                //     '<h4><a href="#">' + lapangan.nama + '</a></h4>' +
                //     '<p>Kategori Lapangan : <span class="item">' + lapangan.kategori.nama + '</p>' +
                //     '<div class="text-content">' + lapangan.keterangan + '</div>' +
                //     '</div>' +
                //     '</div>' +
                //     '</div>' +
                //     '</div>' +
                //     '<a href="#" class="btn btn-primary">Pesan</a>' +
                //     '</div>' +
                //     '</div>';

                $('#lapangan').innerHTML(lapanganHtml);
                
            });
        }
</script> --}}
@endpush
