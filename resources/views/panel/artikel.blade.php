@extends('layouts.admin.index')

@section('title', 'Artikel')

@section('style-css')
<!-- Text Editor Style -->
<link href="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Akhir Text Editor Style -->

<!-- bootstrap-tagsinput -->
<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div id="main">
    @include('layouts.admin.header')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Artikel</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.panel') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="bootstrap-select">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" id="btnTmbArtikel">Tambah Artikel</button>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Artikel</h4>
                        </div>
                        <div class="card-body">
                            @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                            @endforeach
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-lg" id="tbl_artikel">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Artikel</th>
                                            <th>Judul Artikel</th>
                                            <th>Isi Artikel</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('layouts.admin.footer')
</div>
@endsection

<!-- Lihat, Update dan Delete Artikel -->
<script>
// Fungsi Merubah Format Tanggal Menjadi mm/dd/yyyy
function formattedDate(inputDate) {
    let date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        let day = date.getDate().toString();
        let month = (date.getMonth() + 1).toString();

        return date.getFullYear() + '-' + (month[1] ? month : '0' + month[0]) + '-' + (day[1] ? day : '0' + day[0]);
    }
}

function lihatArtikel(id) {
    $.ajax({
        url: `{{ url('/') }}/panel/artikel/${id}`,
        dataType: "json"
    }).done(function(response) {
        const date = formattedDate(new Date(response.tgl_artikel));
        const tags = response.tag.split(',');

        if (tags) {
            tags.forEach(tag => $('#viewTag').append(`<span class='tag label label-info'>#${tag}</span> `));
        }

        $('#viewJudul').html(response.judul_artikel);
        $('#viewTanggal').html(date);
        $('#viewIsi').html(response.isi_artikel);
        $('#viewAdmin').html(response.user['name']);

        $("#viewThumbnail").html('');
        let thumbnail = response.thumbnail_artikel;
        if (thumbnail) {
            thumbnail = response.thumbnail_artikel
        }

        $("#viewThumbnail").append(`<img src='../assets/images/thumbnail/artikel/${thumbnail}' id='thumbnailArtikel' class='card-img-top img-fluid' alt='Thumbnail ${response
            .judul_artikel}'>`);

        $('#lhtArtikel').modal('toggle');
    });
}

function hapusArtikel(id) {
    $.ajax({
        url: `{{ url('/') }}/panel/artikel/${id}`,
        dataType: "json"
    }).done((response) => {
        $('#idDelete').val(response.id);
        $('#judulArtikelDelete').html(`${response.judul_artikel}`);

        $('#hapusArtikel').modal('toggle');
    });
}

function editArtikel(id) {
    $('.datepicker').datepicker('destroy');
    $.ajax({
        url: `{{ url('/') }}/panel/artikel/${id}`,
        dataType: "json"
    }).done(response => {
        $('#idEdit').val(response.id);
        $('#judulEdit').val(response.judul_artikel);
        $('#tglEdit').val(formattedDate(response.tgl_artikel));
        $('#tagEdit').tagsinput('add', response.tag);

        // Preview Thumbnail
        $("#previewThumbnail").html('');
        let gambar = response.thumbnail_artikel;
        if (gambar) {
            gambar = response.thumbnail_artikel;
        }

        $("#previewThumbnail").append(
            `<img src='../assets/images/thumbnail/artikel/${gambar}' id='thumbnailTampil' style='max-width: 100%;'>`
        );
        // End of Preview Thumbnail

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            clearBtn: true,
            language: 'id',
            orientation: 'bottom right',
            showOnFocus: true,
            todayBtn: "linked",
            todayHighlight: true,
            onSelect: (d, i) => {
                if (d !== i.lastVal) $(this).change()
            },
            endDate: new Date(new Date().setDate(new Date().getDate() + 0))
        });

        const editor = new FroalaEditor('#isiEdit', {
            "charCounterCount": true,
            "zIndex": 2501,
            "toolbarButtons": [
                'undo', 'redo', 'clearFormatting', '|',
                'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass',
                'paragraphStyle',
                'lineHeight', '|',
                'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|',
                'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote',
                '-', 'insertLink',
                'insertImage', 'insertTable', '|',
                'specialCharacters', 'insertHR', 'selectAll', '|',
                'spellChecker', 'help', 'html', '|',
            ],
            "tabSpaces": 4,
            "fontFamilyDefaultSelection": "Arial",
            "fontFamilySelection": true,
            "fontSizeSelection": true,
            "fontSizeDefaultSelection": "12",
            "fontSizeUnit": "px",
            "autofocus": true,
            "attribution": false,
            "linkAlwaysBlank": true,
            "paragraphDefaultSelection": "Normal",
            "paragraphFormatSelection": true,
            "quickInsertButtons": ['table', 'ol', 'ul', 'hr'],
            "language": "id",
            "imageEditButtons": ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink',
                'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt',
                'imageSize'
            ],

            // Set the image upload parameter.
            "imageUploadParam": 'image_param',

            // Set the image upload URL.
            "imageUploadURL": "{{ route('upload.gambar.editor') }}",

            // Additional upload params.
            "imageUploadParams": {
                "froala": 'true',
                "_token": "{{ csrf_token() }}"
            },

            // Set request type.
            "imageUploadMethod": 'POST',

            // Set max image size to 5MB.
            "imageMaxSize": 5 * 1024 * 1024,

            // Allow to upload PNG and JPG.
            "imageAllowedTypes": ['jpeg', 'jpg', 'png', 'gif'],

            "events": {
                'image.removed': ($img) => {
                    $.ajax({
                        "url": "{{ route('remove.gambar.editor') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            src: $img.attr('src'),
                            "_token": "{{ csrf_token() }}"
                        }
                    });
                }
            }
        }, () => {
            // Call the method inside the initialized event.
            editor.events.focus(true);
            editor.html.set(response.isi_artikel);
        });

        $('#editArtikel').modal('toggle');
    });
}
</script>

@section('modal')
<!-- Modal Tambah Artikel -->
<div class="modal fade text-left" id="tmbArtikel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-full" role="document">
        <form method="POST" class="form form-vertical" id="formTmbArtikel" action="{{ route('artikel.post') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">
                        Tambah Artikel
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="judulArtikel">Judul Artikel</label>
                                    <div class="position-relative">
                                        <input type="text" name="judulArtikel" id="judulArtikel" class="form-control"
                                            autocomplete="off">
                                        <div class="form-control-icon">
                                            <i class="bi bi-chat-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="tglArtikel">Tanggal Artikel</label>
                                    <div class="position-relative">
                                        <input type="text" name="tglArtikel" id="tglArtikel"
                                            class="datepicker form-control" readonly>
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="thumbArtikel" class="font-bold">Thumbnail Artikel</label>
                                    <input type="file" name="thumbArtikel" class="form-control" id="thumbArtikel"
                                        accept="image/*">
                                    <img class="fotoThumbnail mt-2" style="max-width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tagArtikel">Tags</label>
                                    <div class="position-relative">
                                        <input type="text" name="tagArtikel" id="tagArtikel" data-role="tagsinput">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="isiArtikel">Isi Artikel</label>
                                    <textarea name="isiArtikel" id="isiArtikel" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="btnSubmit" disabled>
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                    <button class="btn btn-primary" type="button" id="btnSubmitLoading" disabled=""
                        style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Akhir Modal Tambah Artikel -->

<!-- Modal Lihat Artikel -->
<div class="modal fade text-left" id="lhtArtikel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title white" id="myModalLabel160">
                    Lihat Artikel
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-content">
                        <div id="viewThumbnail"></div>
                        <div class="card-body">
                            <h5 class="card-title text-center" id="viewJudul"></h5>
                            <div class="card-text text-center font-bold" id="viewTag"></div>
                            <div class="card-text" id="viewIsi"></div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tanggal Artikel : <span class="font-bold" id="viewTanggal"></span>
                        </li>
                        <li class="list-group-item">Diposting Oleh : <span class="font-bold" id="viewAdmin"></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Lihat Artikel -->

<!-- Modal Edit Artikel -->
<div class="modal fade text-left" id="editArtikel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-full" role="document">
        <form method="POST" class="form form-vertical" id="formEditArtikel" action="{{ route('artikel.update') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="idEdit" id="idEdit">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">
                        Edit Artikel
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="judulEdit">Judul Artikel</label>
                                    <div class="position-relative">
                                        <input type="text" name="judulEdit" id="judulEdit" class="form-control"
                                            autocomplete="off">
                                        <div class="form-control-icon">
                                            <i class="bi bi-chat-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="tglEdit">Tanggal Artikel</label>
                                    <div class="position-relative">
                                        <input type="text" name="tglEdit" id="tglEdit" class="datepicker form-control"
                                            readonly>
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="thumbEdit" class="font-bold">Thumbnail Artikel</label>
                                    <small class="text-muted"><i class="text-primary font-bold">*) Kosongkan jika tidak
                                            ada perubahan</i></small>
                                    <input type="file" name="thumbEdit" class="form-control" id="thumbEdit"
                                        accept="image/*">
                                    <div id="previewThumbnail" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tagEdit">Tags</label>
                                    <div class="position-relative">
                                        <input type="text" name="tagEdit" id="tagEdit" data-role="tagsinput">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="isiEdit">Detail Pengumuman</label>
                                    <textarea name="isiEdit" id="isiEdit" class="form-control"
                                        autofocus="true"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="btnEdit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Akhir Modal Edit Artikel -->

<!-- Modal Hapus Artikel -->
<div class="modal fade text-left" id="hapusArtikel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel160">
                    Hapus Artikel
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Hapus Artikel Ini?</h4>
                <h5 class="text-center fst-italic" id="judulArtikelDelete">
                    </h3>
            </div>
            <div class="modal-footer">
                <form action="{{ route('artikel.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="idDelete" id="idDelete">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-danger ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Hapus Artikel -->
@endsection

@section('javascript')
<script>
$('#btnSubmit').on('click', () => {
    document.getElementById('btnSubmit').style.display = 'none';
    document.getElementById('btnSubmitLoading').style.display = 'block';
});
</script>

<!-- Uppercase Judul Artikel -->
<script>
$('#judulArtikel').keyup(function() {
    document.getElementById('judulArtikel').style.textTransform = "uppercase";
});

$('#judulEdit').keyup(() => {
    document.getElementById('judulEdit').style.textTransform = "uppercase";
});
</script>
<!-- End of Uppercase Judul Artikel -->

<!-- Toggle Modal Tambah Artikel -->
<script type="text/javascript">
$('#btnTmbArtikel').on('click', () => {
    $('#tmbArtikel').modal('toggle');
});
</script>
<!-- Akhir Toggle Modal Tambah Artikel -->

<!-- jQuery Validate Plugins -->
<script src="{{ asset('assets/vendors/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendors/validate/additional-methods.min.js') }}"></script>

<!-- Validasi Form Tambah Artikel -->
<script>
$("#formTmbArtikel").on('blur keyup', function() {
    if ($("#formTmbArtikel").valid()) {
        $('#btnSubmit').prop('disabled', false);
    } else {
        $('#btnSubmit').prop('disabled', 'disabled');
    }
});

$.validator.addMethod('maxfilesize', function(value, element, param) {
    let length = (element.files.length);
    let fileSize = 0;
    if (length > 0) {
        fileSize = element.files[0].size; // get file size
        fileSize = fileSize / 1000000; //file size in Mb
        return this.optional(element) || fileSize <= param;
    } else {
        return this.optional(element) || fileSize <= param;
    }
});

$('#formTmbArtikel').validate({
    errorClass: 'error is-invalid',
    validClass: 'is-valid',
    ignore: "[contenteditable='true'].fr-element.fr-view",
    rules: {
        judulArtikel: {
            required: true
        },
        tglArtikel: {
            required: true
        },
        isiArtikel: {
            required: true
        },
        thumbArtikel: {
            required: true,
            extension: "jpg|jpeg|png",
            maxfilesize: 2
        }
    },
    messages: {
        judulArtikel: {
            required: "Judul Artikel Harus Diisi"
        },
        tglArtikel: {
            required: "Tanggal Artikel Belum Dipilih"
        },
        isiArtikel: {
            required: "Detail Artikel Harus Diisi"
        },
        thumbArtikel: {
            required: "Thumbnail Artikel Belum Dipilih",
            extension: "Ekstensi File *.jpg, *.jpeg atau *.png",
            maxfilesize: 'Ukuran File Tidak Boleh Lebih dari 2 MB'
        }
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass(errorClass).addClass(validClass);
    }
});
</script>
<!-- Akhir Validasi Form Tambah Artikel -->

<!-- Validasi Form Edit Artikel -->
<script>
$("#formEditArtikel").on('blur keyup', function() {
    if ($("#formEditArtikel").valid()) {
        $('#btnEdit').prop('disabled', false);
    } else {
        $('#btnEdit').prop('disabled', 'disabled');
    }
});

$.validator.addMethod('maxfilesize', function(value, element, param) {
    let length = (element.files.length);
    let fileSize = 0;
    if (length > 0) {
        fileSize = element.files[0].size; // get file size
        fileSize = fileSize / 1000000; //file size in Mb
        return this.optional(element) || fileSize <= param;
    } else {
        return this.optional(element) || fileSize <= param;
    }
});

$('#formEditArtikel').validate({
    errorClass: 'error is-invalid',
    validClass: 'is-valid',
    ignore: "[contenteditable='true'].fr-element.fr-view",
    rules: {
        judulEdit: {
            required: true
        },
        tglEdit: {
            required: true
        },
        isiEdit: {
            required: true
        },
        thumbEdit: {
            extension: "jpg|jpeg|png",
            maxfilesize: 2
        }
    },
    messages: {
        judulEdit: {
            required: "Judul Artikel Harus Diisi"
        },
        tglEdit: {
            required: "Tanggal Artikel Belum Dipilih"
        },
        isiEdit: {
            required: "Detail Artikel Harus Diisi"
        },
        thumbEdit: {
            extension: "Ekstensi File *.jpg, *.jpeg atau *.png",
            maxfilesize: 'Ukuran File Tidak Boleh Lebih dari 2 MB'
        }
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass(errorClass).addClass(validClass);
    }
});
</script>
<!-- Akhir Validasi Form Edit Artikel -->

<!-- Menampilkan Data Artikel di DataTable -->
<script type="text/javascript">
var table_article = $('#tbl_artikel').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        "url": "{{ route('artikel.data') }}",
        "dataType": "json",
        "type": "POST",
        "data": {
            _token: "{{ csrf_token() }}"
        }
    },
    columns: [{
            "data": null,
            "orderable": false,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            "data": "tgl_artikel"
        },
        {
            "data": "judul_artikel",
            "orderable": true
        },
        {
            "data": "isi_artikel"
        },
        {
            "data": "action",
            "name": "action",
            "orderable": false
        },
    ],
    "columnDefs": [{
        "targets": "_all",
        "className": "text-center",
        "visible": true
    }],
    "responsive": true
});
</script>
<!-- Menampilkan Data Artikel di DataTable -->

<!-- Datepicker -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}">
<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}">
</script>
<script type="text/javascript"
    src="{{ asset('assets/vendors/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js') }}"></script>

<script>
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    clearBtn: true,
    language: 'id',
    orientation: 'bottom right',
    showOnFocus: true,
    todayBtn: "linked",
    todayHighlight: true,
    onSelect: (d, i) => {
        if (d !== i.lastVal) $(this).change()
    },
    endDate: new Date(new Date().setDate(new Date().getDate() + 0))
});
</script>
<!-- End of Datepicker -->

<!-- Text Editor -->
<script type="text/javascript" src="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.js') }}"></script>

<script>
new FroalaEditor('#isiArtikel', {
    "charCounterCount": true,
    "placeholderText": 'Isi Artikel Ketik Disini!',
    "zIndex": 2501, // Untuk memunculkan popup bawaan froala jika ada dalam modal bootstrap
    "toolbarButtons": [
        'undo', 'redo', 'clearFormatting', '|',
        'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'paragraphStyle',
        'lineHeight', '|',
        'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|',
        'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-',
        'insertLink',
        'insertImage', 'insertTable', '|',
        'specialCharacters', 'insertHR', 'selectAll', '|',
        'spellChecker', 'help', 'html', '|',
    ],
    "tabSpaces": 4,
    "fontFamilyDefaultSelection": "Arial",
    "fontFamilySelection": true,
    "fontSizeSelection": true,
    "fontSizeDefaultSelection": "12",
    "fontSizeUnit": "px",
    "autofocus": true,
    "attribution": false,
    "linkAlwaysBlank": true,
    "paragraphDefaultSelection": "Normal",
    "paragraphFormatSelection": true,
    "quickInsertButtons": ['table', 'ol', 'ul', 'hr'],
    "language": "id",
    "imageEditButtons": ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit',
        'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'
    ],

    // Set the image upload parameter.
    "imageUploadParam": 'image_param',

    // Set the image upload URL.
    "imageUploadURL": "{{ route('upload.gambar.editor') }}",

    // Additional upload params.
    "imageUploadParams": {
        "froala": 'true',
        "_token": "{{ csrf_token() }}"
    },

    // Set request type.
    "imageUploadMethod": 'POST',

    // Set max image size to 5MB.
    "imageMaxSize": 5 * 1024 * 1024,

    // Allow to upload PNG and JPG.
    "imageAllowedTypes": ['jpeg', 'jpg', 'png', 'gif'],

    "events": {
        'image.removed': ($img) => {
            $.ajax({
                "url": "{{ route('remove.gambar.editor') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    src: $img.attr('src'),
                    "_token": "{{ csrf_token() }}"
                }
            });
        }
    }
});
</script>
<!-- End of Text Editor -->

<!-- Menampilkan Foto Thumbnail (Insert) -->
<script>
$(document).ready(function() {
    $("#thumbArtikel").change(function(event) {
        fadeInAdd();
        getURL(this);
    });

    $("#thumbArtikel").on('click', function(event) {
        fadeInAdd();
    });

    function getURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var filename = $("#thumbArtikel").val();
            filename = filename.substring(filename.lastIndexOf('\\') + 1);
            reader.onload = function(e) {
                // debugger;
                $('.fotoThumbnail').attr('src', e.target.result);
                $('.fotoThumbnail').hide();
                $('.fotoThumbnail').fadeIn(500);
            }
            reader.readAsDataURL(input.files[0]);
        }
        $(".alert").removeClass("loadAnimate").hide();
    }
});

function fadeInAdd() {
    fadeInAlert();
}

function fadeInAlert(text) {
    $(".alert").text(text).addClass("loadAnimate");
}
</script>
<!-- Akhir Menampilkan Foto Thumbnail (Insert) -->

<!-- Menampilkan Foto Thumbnail (Update) -->
<script>
$(document).ready(function() {
    $("#thumbEdit").change(function(event) {
        fadeInAdd();
        getURL(this);
    });

    $("#thumbEdit").on('click', function(event) {
        fadeInAdd();
    });

    function getURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var filename = $("#thumbEdit").val();
            filename = filename.substring(filename.lastIndexOf('\\') + 1);
            reader.onload = function(e) {
                // debugger;
                $('#thumbnailTampil').attr('src', e.target.result);
                $('#thumbnailTampil').hide();
                $('#thumbnailTampil').fadeIn(500);
            }
            reader.readAsDataURL(input.files[0]);
        }
        $(".alert").removeClass("loadAnimate").hide();
    }
});

function fadeInAdd() {
    fadeInAlert();
}

function fadeInAlert(text) {
    $(".alert").text(text).addClass("loadAnimate");
}
</script>
<!-- Akhir Menampilkan Foto Thumbnail (Update) -->

<!-- bootstrap-tagsinput -->
<script src="{{ asset('assets/vendors/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
@endsection