@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
            font-size: 12px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 4px;
            padding: 0 5px;
            height: 30px;
            text-align: center;
            display: flex;
            align-items: center;
        }

        #document-dropzone {
            height: 300px;
        }

        .dropzone .dz-message {
            text-align: center;
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            overflow: scroll;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Kamar Kos</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Kamar Kos
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-right mb-2">
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAdd"><i
                            class="fa fa-plus mr-1"></i><span
                            class="font-weight-bold">Tambah</span></a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Nama Kos</th>
                        <th>Nama Kamar</th>
                        <th width="12%">Harga (Rp.)</th>
                        <th width="12%">Ukuran (Meter)</th>
                        <th width="15%">Fasilitas Kamar</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Tambah Fasilitas Kamar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group w-100 mt-1">
                        <label for="kos">Kos</label>
                        <select class="select2" name="kos" id="kos" style="width: 100%;">
                            <option value="">--Pilih Kos--</option>
                            @foreach($kos as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-100 mb-1">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama"
                               name="nama">
                    </div>
                    <div class="w-100 mb-1">
                        <label for="harga" class="form-label">Harga (Rp.)</label>
                        <input type="number" class="form-control" id="harga" placeholder="Harga"
                               name="harga">
                    </div>
                    <div class="w-100 mb-1">
                        <label for="ukuran" class="form-label">Ukuran</label>
                        <input type="text" class="form-control" id="ukuran" placeholder="Ukuran"
                               name="ukuran">
                    </div>
                    <div class="form-group w-100">
                        <label for="fasilitas_kamar">Fasilitas Kamar</label>
                        <select class="select2" name="fasilitas_kamar[]" id="fasilitas_kamar" multiple="multiple"
                                style="width: 100%;">
                            @foreach($fasilitas_kamar as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="btn-save" type="button" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Kos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="id" name="id" value="">
                <div class="modal-body">
                    <div class="form-group w-100 mt-1">
                        <label for="kos-edit">Kos</label>
                        <select class="select2" name="kos-edit" id="kos-edit" style="width: 100%;">
                            <option value="">--Pilih Kos--</option>
                            @foreach($kos as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-100 mb-1">
                        <label for="nama-edit" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama-edit" placeholder="Nama"
                               name="nama-edit">
                    </div>
                    <div class="w-100 mb-1">
                        <label for="harga-edit" class="form-label">Harga (Rp.)</label>
                        <input type="number" class="form-control" id="harga-edit" placeholder="Harga"
                               name="harga-edit">
                    </div>
                    <div class="w-100 mb-1">
                        <label for="ukuran-edit" class="form-label">Ukuran</label>
                        <input type="text" class="form-control" id="ukuran-edit" placeholder="Ukuran"
                               name="ukuran-edit">
                    </div>
                    <div class="form-group w-100">
                        <label for="fasilitas_kamar-edit">Fasilitas Kamar</label>
                        <select class="select2" name="fasilitas_kamar-edit[]" id="fasilitas_kamar-edit"
                                multiple="multiple"
                                style="width: 100%;">
                            @foreach($fasilitas_kamar as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="btn-patch" type="button" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalImages" tabindex="-1" role="dialog" aria-labelledby="modalImagesLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImagesLabel">Gambar Kamar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-input" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id-image" name="id" value="">
                    <div class="modal-body">
                        <div id="panel-images" class="row mb-3">

                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file[]" multiple>
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button id="btn-upload" type="button" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;

        function clear() {
            $('#nama').val('');
            $('#ukuran').val('');
            $('#kos').select2().val('').trigger('change');
            $('#fasilitas_kamar').select2().val('').trigger('change');
            $('#harga').val('');
            $('#nama-edit').val('');
            $('#ukuran-edit').val('');
            $('#kos-edit').select2().val('').trigger('change');
            $('#fasilitas_kamar-edit').select2().val('').trigger('change');
            $('#harga-edit').val('');
            $('#id').val('');
        }

        function store() {
            let url = '{{ route('admin.kamar') }}';
            let data = {
                nama: $('#nama').val(),
                ukuran: $('#ukuran').val(),
                kos: $('#kos').val(),
                harga: $('#harga').val(),
                fasilitas_kamar: $('#fasilitas_kamar').val(),
            };
            AjaxPost(url, data, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menyimpan data...');
                reload();
            });
        }

        function patch() {
            let id = $('#id').val();
            let url = '{{ route('admin.kamar') }}' + '/' + id;
            let data = {
                nama: $('#nama-edit').val(),
                ukuran: $('#ukuran-edit').val(),
                kos: $('#kos-edit').val(),
                harga: $('#harga-edit').val(),
                fasilitas_kamar: $('#fasilitas_kamar-edit').val(),
            };
            AjaxPost(url, data, function () {
                clear();
                $('#modalEdit').modal('hide');
                SuccessAlert('Berhasil!', 'Berhasil merubah data...');
                reload();
            });
        }

        function destroy(id) {
            let url = '{{ route('admin.kamar') }}' + '/' + id + '/delete';
            AjaxPost(url, {}, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menghapus data...');
                reload();
            });
        }

        function reload() {
            table.ajax.reload();
        }

        function editEvent() {
            $('.btn-edit').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                let nama = this.dataset.nama;
                let ukuran = this.dataset.ukuran;
                let harga = this.dataset.harga;
                let kos = this.dataset.kos;
                let fasilitas = JSON.parse(this.dataset.fasilitas);
                $('#nama-edit').val(nama);
                $('#ukuran-edit').val(ukuran);
                $('#harga-edit').val(harga);
                $('#kos-edit').select2().val(kos).trigger('change');
                $('#fasilitas_kamar-edit').select2().val(fasilitas).trigger('change');
                $('#id').val(id);
                $('#modalEdit').modal('show');
            })
        }


        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        destroy(id);
                    }
                });

            })
        }

        function imageEvent() {
            $('.btn-images').on('click', async function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                $('#id-image').val(id);
                $('#file').val('');
                let url = '{{ route('admin.kamar') }}' + '/' + id + '/images';
                let response = await $.get(url);
                let el = $('#panel-images');
                el.empty();
                let newChild = createElImages(response['payload']['data']);
                el.append(newChild);
                dropImageEvent();
                $('#modalImages').modal('show');
            })
        }

        function createElImages(data) {
            let el = '';
            if (data.length > 0) {
                $.each(data, function (k, v) {
                    el += '<div class="col-3">' +
                        '<div class="flex flex-column align-items-center">' +
                        '<img src="/assets/kamar/' + v['gambar'] + '" alt="gbr-kmar" class="w-100">' +
                        '<a href="#" class="btn-delete-image" data-id="' + v['id'] + '">Hapus</a>' +
                        '</div>' +
                        '</div>';
                });
                return el;
            }
            return '<div class="col-12">' +
                '<div style="min-height: 200px;" class="d-flex justify-content-center align-items-center">\n' +
                '<p class="font-weight-bold">Gambar Tidak Tersedia</p>\n' +
                '</div>' +
                '</div>'
        }

        function dropImages(id) {
            let url = '{{ route('admin.kamar') }}' + '/' + id + '/drop-images';
            AjaxPost(url, {}, function () {
                $('#modalImages').modal('hide');
                SuccessAlert('Berhasil!', 'Berhasil menghapus gambar...');
            });
        }

        function dropImageEvent() {
            $('.btn-delete-image').on('click', async function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                dropImages(id);
            })
        }
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            $(".custom-file-input").on("change", function () {
                var files = Array.from(this.files)
                var fileName = files.map(f => {
                    return f.name
                }).join(", ")
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            let url = '{{ route('admin.kamar') }}';
            table = DataTableGenerator('#table-data', url, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'kos.nama'},
                {data: 'nama'},
                {
                    data: 'harga', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {data: 'ukuran'},
                {
                    data: 'fasilitas_kamar', render: function (data) {
                        let value = '';
                        if (data.length > 0) {
                            $.each(data, function (k, v) {
                                value += '<div>- ' + v['nama'] + '</div>';
                            });
                            return value;
                        }
                        return '<span>-</span>';
                    }
                },
                {
                    data: null, render: function (data) {
                        let fasilitas_kamar = [];
                        $.each(data['fasilitas_kamar'], function (k, v) {
                            fasilitas_kamar.push(v['id']);
                        });

                        let stringFasilitasKamar = JSON.stringify(fasilitas_kamar);
                        return '<a href="#" class="btn btn-sm btn-warning btn-edit mr-1" ' +
                            'data-id="' + data['id'] + '" ' +
                            'data-nama="' + data['nama'] + '" ' +
                            'data-ukuran="' + data['ukuran'] + '" ' +
                            'data-harga="' + data['harga'] + '" ' +
                            'data-fasilitas="' + stringFasilitasKamar + '"' +
                            'data-kos="' + data['kos']['id'] + '"' +
                            '><i class="fa fa-edit f12"></i></a>' +
                            '<a href="#" class="btn btn-sm btn-danger btn-delete mr-1" data-id="' + data['id'] + '"><i class="fa fa-trash f12"></i></a>' +
                            '<a href="#" class="btn btn-sm btn-primary btn-images mr-1" data-id="' + data['id'] + '"><i class="fa fa-file-image-o f12"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [3],
                    className: 'text-right'
                },
            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                    editEvent();
                    deleteEvent();
                    imageEvent();
                }
            });

            $('#btn-save').on('click', function () {
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menyimpan data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        store();
                    }
                });
            });
            $('#btn-patch').on('click', function () {
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin merubah data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        patch();
                    }
                });
            });
            deleteEvent();
            $('#modalAdd').on('hidden.bs.modal', function (e) {
                clear();
            });
            $('#modalEdit').on('hidden.bs.modal', function (e) {
                clear();
            })

            $('#btn-upload').on('click', function () {
                let id = $('#id-image').val();
                let frm = $('#form-input')[0];
                let f_data = new FormData(frm);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: '{{ route('admin.kamar') }}/' + id + '/images',
                    data: f_data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (data) {
                        $('.custom-file-label').html('');
                        $('#modalImages').modal('hide');
                        SuccessAlert('Berhasil', 'Berhasil Menambahkan Gambar...');
                    },
                    error: function (e) {
                        ErrorAlert('Error', 'Terjadi Kesalahan Server....')
                    }
                })
            });
        });
    </script>
@endsection
