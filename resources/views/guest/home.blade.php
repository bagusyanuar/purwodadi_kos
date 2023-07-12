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
    <div class="hero-dark d-flex align-items-center">
        <div class="w-50 p-5 left-hero pr-5">
            <p style="font-size: 46px;">Mau Cari Kos?</p>
            <p style="font-size: 20px; color: #f7f7f7" class="mb-4">Dapatkan info nya dan hubungi penyedia kos di
                Purwodadi Kos</p>
            <a href="{{ route('pencarian') }}" class="btn-register">Cari Sekarang</a>
        </div>
        <div class="w-50 p-3 right-hero">
            <div class="w-100 text-center">
                <img src="{{ asset('/assets/hero.png') }}" height="400" alt="hero image">
            </div>
        </div>
    </div>
    <div class="text-center p-3">
        <p style="font-size: 20px; color: #777777; font-weight: bold; letter-spacing: 2px;">Rekomendasi Kos</p>
    </div>
    <section id="paket" class="pb-5 pl-3 pr-3">
        <div class="row justify-content-center w-100">
            @forelse($kamar as $k)
                <div class="col-3">
                    <div class="card-paket shadow-lg d-flex flex-column align-items-start" data-id="{{ $k->id }}"
                         data-kos="{{ $k->kos_id }}">
                        <div class="flex-grow-1 w-100">
                            @if(count($k->gambar) > 0)
                                <img src="{{ asset('/assets/kamar').'/'.$k->gambar[0]->gambar }}" height="200"
                                     class="w-100" alt="gmb"
                                     style="object-fit: cover; border-radius: 5px;"/>
                            @else
                                <img src="{{ asset('/assets/hero.png') }}" height="200" class="w-100" alt="gmb"
                                     style="object-fit: cover; border-radius: 5px;"/>
                            @endif
                            <p class="mt-2 title-kos w-100 mb-0">{{ $k->kos->nama . ' ' .$k->nama }}</p>
                            <p class="wilayah-kos w-100 font-weight-bold mb-0">{{ $k->kos->wilayah->nama }}</p>
                            <p class="fasilitas-kos w-100">
                                @foreach($k->fasilitas_kamar as $f)
                                    {{ $f->nama.' . ' }}
                                @endforeach
                            </p>
                        </div>
                        <div class="harga-kos">
                            <span>Rp. {{ number_format($k->harga, 0, ',', '.') }}<span
                                    style="font-size: 16px; font-weight: normal; color: #777777;">/bulan</span></span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="height: 200px;" class="d-flex justify-content-center align-items-center">
                    <p style="font-size: 16px; color: #777777; font-weight: bold;">Belum Ada Paket Tersedia</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.card-paket').on('click', function () {
                let id = this.dataset.id;
                let kosId = this.dataset.kos;
                window.location.href = '/kos/' + kosId + '/kamar/' + id;
            });
        })
    </script>
@endsection
