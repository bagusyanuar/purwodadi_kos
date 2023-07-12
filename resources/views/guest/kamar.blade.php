@extends('guest.layout')

@section('css')
    <style>
        .title-kos {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
            color: #777777;
        }

        .fasilitas-kos {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
            color: #777777;
        }

        .harga-kos {
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div style="min-height: 400px" class="p-3">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background-color: transparent !important; padding-left: 0 !important;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kos', ['kos' => $data->kos_id]) }}">{{ $data->kos->nama }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->nama }}</li>
            </ol>
        </nav>
        <div class="p-5">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                @if(count($data->gambar) > 0)
                    <ol class="carousel-indicators">
                        @foreach($data->gambar as $key => $g)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                                class="{{ $key === 0 ? 'active' :'' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($data->gambar as $key => $g)
                            <div class="carousel-item active" style="height: 450px">
                                <img class="d-block w-100" src="{{ asset('/assets/kamar').'/'.$g->gambar }}"
                                     height="450"
                                     alt="First slide"
                                     style="object-fit: contain">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @else
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 450px">
                            <img class="d-block w-100" src="{{ asset('/assets/hero.png') }}" height="450"
                                 alt="First slide"
                                 style="object-fit: contain">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
            <div class="row w-100 mt-3">
                <div class="col-8">
                    <p class="font-weight-bold mb-0"
                       style="font-size: 24px; color: #777777;">{{ $data->kos->nama.' - '.$data->nama }}</p>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center mr-2">
                            <i class="fa fa-map-marker mr-2" style="font-size: 16px"></i>
                            <span style="font-size: 16px">{{ $data->kos->wilayah->nama }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-building mr-2" style="font-size: 16px"></i>
                            <span style="font-size: 16px">{{ $data->ukuran }} meter</span>
                        </div>
                    </div>
                    <hr>
                    <p class="font-weight-bold">Fasilitas Kamar</p>
                    <div class="row w-100">
                        @foreach($data->fasilitas_kamar as $fk)
                            <div class="col-6">- {{ $fk->nama }}</div>
                        @endforeach
                    </div>
                    <p class="font-weight-bold mt-3">Fasilitas Umum</p>
                    <div class="row w-100">
                        @foreach($data->kos->fasilitas_umum as $fu)
                            <div class="col-6">- {{ $fu->nama }}</div>
                        @endforeach
                    </div>
                    <p class="font-weight-bold mt-3">Peraturan</p>
                    <div class="row w-100">
                        @foreach($data->kos->peraturan as $p)
                            <div class="col-6">- {{ $p->nama }}</div>
                        @endforeach
                    </div>
                    <hr>
                    <p class="font-weight-bold mt-3">Lokasi</p>
                    <div class="w-100 mt-3">
                        {{ $data->kos->embedded_map }}
                    </div>
                </div>
                <div class="col-4">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <p class="mb-0 font-weight-bold" style="font-size: 24px;">
                                Rp. {{ number_format($data->harga, 0, ',', '.') }}<span
                                    style="font-size: 16px; font-weight: normal">/bulan</span>
                            </p>
                            <hr>
                            <a href="https://wa.me/62{{ $data->kos->pemilik_kos->no_hp }}?text=Halo, saya ingin menanyakan info tentang kos {{ $data->kos->nama }} kamar {{ $data->nama }}" target="_blank" class="btn btn-lg btn-success w-100 d-flex align-items-center justify-content-center"
                               style="color: whitesmoke"><i class="fa fa-comment mr-2"></i>Tanya Pemilik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '{{ request()->path() }}';

        $(document).ready(function () {

        });
    </script>
@endsection
