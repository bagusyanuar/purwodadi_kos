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
                <li class="breadcrumb-item active" aria-current="page">{{ $data->nama }}</li>
            </ol>
        </nav>
        <div class="p-5">
            <div class="row w-100">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 mr-2">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1 mr-2">
                                    <div class="w-100">
                                        <label for="cari" class="form-label">Pencarian</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fa fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="cari"
                                                   name="cari" aria-describedby="inputGroupPrepend"
                                                   placeholder="Cari Berdasarkan Nama Kos...">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" id="btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="w-100">
                                <label for="harga">Urutkan Harga</label>
                                <select class="form-control" id="harga" name="harga">
                                    <option value="ASC">Murah Ke Mahal</option>
                                    <option value="DESC">Mahal Ke Murah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-2">
                        <p class="font-weight-bold">Hasil Pencarian</p>
                        <div class="row justify-content-center" id="panel-pencarian">
                            <div class="col-12 d-flex align-items-center justify-content-center" style="height: 300px;">Hasil Tidak
                                DiTemukan....
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <p class="font-weight-bold mb-0">Pemilik Kos</p>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="font-weight-bold" style="color: #888888">{{ $data->pemilik_kos->nama }}</span>
                                <a href="https://wa.me/62{{ $data->pemilik_kos->no_hp }}?text=Halo, saya ingin menanyakan info tentang kos {{ $data->nama }}" target="_blank" class="btn btn-sm btn-success" style="color: whitesmoke; font-size: 16px;"><i class="fa fa-whatsapp"></i></a>
                            </div>
                            <hr>
                            <p class="font-weight-bold mb-0">Lokasi Kos</p>
                            <hr>
                            <div class="w-100">
                                <iframe class="w-100" height="450" src="{{ $data->embedded_map }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
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
        var path = '/{{ request()->path() }}';

        async function search() {
            let el = $('#panel-pencarian');
            let param = $('#cari').val();
            let sort = $('#harga').val();
            let url = path + '?p=' + param + '&sort=' + sort;
            try {
                el.empty();
                el.append(createLoader('Sedang mengunduh data..', 300));
                let response = await $.get(url);
                el.empty();
                let data = response['payload'];
                if (data.length > 0) {
                    $.each(data, function (k, v) {
                        el.append(createElProduct(v));
                    });
                } else {
                    el.append(createElEmpty());
                }

                $('.card-paket').on('click', function () {
                    let id = this.dataset.id;
                    let kosId = this.dataset.kos;
                    window.location.href = '/kos/' + kosId + '/kamar/' + id;
                });
                console.log(response);
            } catch (e) {
                console.log(e);
                alert('terjadi kesalahan server...')
            }
        }

        function createElProduct(v) {
            let fasilitas = '';

            let urlGambar = '/assets/hero.png';
            if (v['gambar'].length > 0) {
                urlGambar = v['gambar'][0]['gambar'];
            }
            $.each(v['fasilitas_kamar'], function (k, vF) {
                fasilitas += vF['nama'] + ' . ';
            });
            return '<div class="col-6">' +
                '<div class="card-paket shadow-lg d-flex flex-column align-items-start" data-id="'+v['id']+'" data-kos="'+v['kos_id']+'">' +
                '<div class="flex-grow-1 w-100">' +
                '<img src="' + urlGambar + '" height="200" class="w-100" alt="gmb" style="object-fit: cover; border-radius: 5px;"/>' +
                '<p class="mt-2 title-kos w-100 mb-0">' + v['nama'] + '</p>' +
                '<p class="wilayah-kos w-100 font-weight-bold mb-0">' + v['kos']['wilayah']['nama'] + '</p>' +
                '<p class="fasilitas-kos w-100">' + fasilitas + '</p>' +
                '</div>' +
                '<div class="harga-kos">' +
                '<span>Rp. ' + v['harga'].toLocaleString('id-ID') + '<span style="font-size: 16px; font-weight: normal; color: #777777;">/bulan</span></span>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        function createElEmpty() {
            return '<div class="col-12 d-flex align-items-center justify-content-center" style="height: 300px;">Hasil Tidak\n' +
                'DiTemukan....\n' +
                '</div>';
        }

        $(document).ready(function () {
            search();
            $('#btn-search').on('click', function () {
                search();
            });

            $('#harga').on('change', function () {
                search();
            });
        });
    </script>
@endsection
