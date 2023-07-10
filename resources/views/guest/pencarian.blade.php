@extends('guest.layout')

@section('css')
@endsection

@section('content')
    <div style="min-height: 400px" class="p-3">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background-color: transparent !important; padding-left: 0 !important;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pencarian</li>
            </ol>
        </nav>
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
                <div class="w-100 mr-2">
                    <label for="wilayah">Wilayah</label>
                    <select class="form-control" id="wilayah" name="wilayah">
                        <option value="">Semua</option>
                        @foreach($wilayah as $v)
                            <option value="{{ $v->id }}">{{ $v->nama }}</option>
                        @endforeach
                    </select>
                </div>
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
            <div class="row" id="panel-pencarian">
                <div class="col-12 d-flex align-items-center justify-content-center" style="height: 300px;">Hasil Tidak
                    DiTemukan....
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '{{ request()->path() }}';

        async function search() {
            let param = $('#cari').val();
            let wilayah = $('#wilayah').val();
            let sort = $('#harga').val();
            let url = path + '?p=' + param + '&wilayah=' + wilayah + '&sort=' + sort;
            try {
                let response = await $.get(url);
                console.log(response);
            } catch (e) {
                console.log(e)
            }
        }

        $(document).ready(function () {
            $('#btn-search').on('click', function () {
                search();
            });

            $('#wilayah').on('change', function () {
                search();
            });

            $('#harga').on('change', function () {
                search();
            });
        });
    </script>
@endsection
