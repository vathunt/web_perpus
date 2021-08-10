@extends('layouts.admin.index')

@section('title', 'Banner Slide')

@section('style-css')
<!-- Text Editor Style -->
<!-- <link href="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" /> -->
<!-- Akhir Text Editor Style -->
@endsection

@section('content')
<div id="main">
    @include('layouts.admin.header')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Banner Slide</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.panel') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Banner Slide</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="bootstrap-select">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Banner Slide</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <h4 class="alert-heading">Gagal</h4>
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <form method="POST" class="form" id="formSlide"
                                action="{{ route('slide.post') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="gambar_slide" class="font-bold">Gambar Slide</label>
                                                <small class="text-muted">&nbsp;
                                                    <i class="text-primary font-bold">*) Ukuran gambar akan diubah ke 1600x800 pixel</i>
                                                </small>
                                                <img id="fotoSlide" style="max-width: 100%; margin: 15px 0;" />
                                                <input type="file" name="gambar_slide" class="form-control" id="gambar_slide" accept="image/*">
                                                <div id="errGambarSlide"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ket_gambar">Keterangan Gambar</label>
                                                <textarea name="ket_gambar" id="ket_gambar" class="form-control" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" id="btnSubmit">Simpan</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Banner Slide</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-lg" id="tbl_slide">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Keterangan</th>
                                            <th>Status Tampil</th>
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

<!-- Update dan Delete Banner Slide -->
<script>
    let id;

    function hapusBanner(id, image) {
        $('#idDelete').val(id);
        $("#previewHapusBanner").html('');
        let gambar = image;

        $("#previewHapusBanner").append("<img src='../images/slider-main/" + gambar +
            "' style='max-width: 100%;'>");

        $('#hapusBanner').modal('toggle');
    }

    function editBanner(id) {
        $.ajax({
            url: "{{ url('/') }}/panel/slide/" + id,
            dataType: "json"
        }).done(function(response) {
            $('#idEdit').val(response.id);
            $('#ket_gambar_edit').val(response.keterangan_slide);
                // $('[name="status_tampil_edit"][value="' + response.status_tampil + '"]').prop('checked', true);

                $("#previewBannerSlide").html('');
                let gambar = response.gambar_slide;
                if (gambar) {
                    gambar = response.gambar_slide
                }

                $("#previewBannerSlide").append("<img src='../images/slider-main/" + gambar +
                    "' id='fotoBannerTampil' style='max-width: 100%;'>");

                $('#editBanner').modal('toggle');
            });
    }

    function editStatus(id) {
        $.ajax({
            url: "{{ url('/') }}/panel/slide/status/" + id,
            type: "get",
            success: function() {
                swal.fire({
                    title: 'Berhasil',
                    text: "Status Tampil Berhasil Diubah",
                    icon: 'success',
                    confirmButtonText: '<i class="fas fa-check"></i> OK'
                }).then(function() {
                    window.location.reload();
                });
            }
        });
    }
</script>

@section('modal')
<!-- Modal Edit Banner Slide -->
<div class="modal fade text-left" id="editBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
aria-hidden="true">
<div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
    <form method="POST" class="form form-vertical" id="formSlideEdit" action="{{ route('slide.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Edit Banner Slide
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-12 mb-1">
                                <div class="input-group mb-3">
                                    <input type="hidden" id="idEdit" name="idEdit">
                                    <div id="previewBannerSlide" style="margin-bottom: 15px;"></div>
                                    <label for="gambar_slide_edit" class="font-bold">Gambar Slide</label>
                                    <small class="text-muted">&nbsp;<i
                                        class="text-primary font-bold">*) Ukuran
                                    Gambar 1600x800 pixel</i></small>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="icon-label"><i class="bi bi-upload"></i></label>
                                        <input type="file" name="gambar_slide_edit" class="form-control" id="gambar_slide_edit" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-icon-left">
                                <label for="ket_gambar_edit">Keterangan Gambar</label>
                                <div class="position-relative">
                                    <textarea name="ket_gambar_edit" id="ket_gambar_edit" class="form-control"
                                    rows="5"></textarea>
                                    <div class="form-control-icon">
                                        <i class="bi bi-chat-text"></i>
                                    </div>
                                </div>
                            </div>
                                    <!-- <div class="form-group has-icon-left">
                                        <label for="status_tampil_edit">Status Tampil</label>
                                        <div class="position-relative">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="status_tampil_edit" name="status_tampil_edit">
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="input-group mb-3">
                                        <label for="status_tampil_edit" class="font-bold">Status Tampil</label>
                                        <div class="input-group mb-3">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status_tampil_edit" id="status_tampil_edit1" value="1">
                                                <label for="status_tampil_edit1" class="form-check-label">Ditampilkan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status_tampil_edit" id="status_tampil_edit2" value="0">
                                                <label for="status_tampil_edit2" class="form-check-label">Tidak Ditampilkan</label>
                                            </div>
                                        </div>
                                    </div> -->
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
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Akhir Modal Edit Banner Slide -->

    <!-- Modal Hapus Banner Slide -->
    <div class="modal fade text-left" id="hapusBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel160">
                    Hapus Banner Slide
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Hapus Gambar Banner ini?</h4>
                <div id="previewHapusBanner"></div>
            </div>
            <div class="modal-footer">
                <form action="{{ route('slide.delete') }}" method="POST">
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
<!-- Akhir Modal Hapus Banner Slide -->
@endsection

@section('javascript')
<!-- jQuery Validate Plugins -->
<script src="{{ asset('assets/vendors/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendors/validate/additional-methods.min.js') }}"></script>

<!-- Validasi Form Tambah Banner Slide -->
<script>
    $("#formSlide").on('blur keyup', function() {
        if ($("#formSlide").valid()) {
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

    $('#formSlide').validate({
        errorClass: 'error is-invalid',
        validClass: 'is-valid',
        ignore: "[contenteditable='true'].fr-element.fr-view",
        rules: {
            gambar_slide: {
                required: true,
                extension: "jpg|jpeg|png",
                maxfilesize: 1
            },
            ket_gambar: {
                required: true
            }
        },
        messages: {
            gambar_slide: {
                required: "Gambar Belum Dipilih",
                extension: "Ekstensi File *.jpg, *.jpeg atau *.png",
                maxfilesize: 'Ukuran File Tidak Boleh Lebih dari 1 MB'
            },
            ket_gambar: {
                required: "Keterangan Gambar Harus Diisi"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "gambar_slide") {
                error.appendTo($('#errGambarSlide'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        }
    });
</script>
<!-- Akhir Validasi Form Tambah Banner Slide -->

<!-- Validasi Form Edit Banner Slide -->
<script>
    $("#formSlideEdit").on('blur keyup', function() {
        if ($("#formSlideEdit").valid()) {
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

    $('#formSlideEdit').validate({
        errorClass: 'error is-invalid',
        validClass: 'is-valid',
        rules: {
            gambar_slide_edit: {
                extension: "jpg|jpeg|png",
                maxfilesize: 1
            },
            ket_gambar_edit: {
                required: true
            },
            // status_tampil_edit: {
            //     required: true
            // }
        },
        messages: {
            gambar_slide_edit: {
                required: "Gambar Belum Dipilih",
                extension: "Ekstensi File *.jpg, *.jpeg atau *.png"
            },
            ket_gambar_edit: {
                required: "Keterangan Gambar Harus Diisi"
            },
            // status_tampil_edit: {
            //     required: "Status Tampil Harus Dipilih"
            // }
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
<!-- Akhir Validasi Form Edit Banner Slide -->

<!-- Menampilkan Data Banner Slide di DataTable -->
<script type="text/javascript">
    var table_slide = $('#tbl_slide').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('slide.data') }}",
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
            "data": "gambar_slide",
            "orderable": false
        },
        {
            "data": "keterangan_slide"
        },
        {
            "data": "status_tampil",
            "orderable": false
        },
        {
            "data": "action",
            "name": "action",
            "orderable": false
        },
        ],
        "columnDefs": [{
            "width": "50%",
            "targets": 1
        },
        {
            "targets": "_all",
            "className": "text-center",
            "visible": true
        }
        ],
        "responsive": true
    });
</script>
<!-- Menampilkan Data Banner Slide di DataTable -->

<!-- Menampilkan Foto Ketika Diupload (Insert) -->
<script>
    $(document).ready(function() {
        $("#gambar_slide").change(function(event) {
            fadeInAdd();
            getURL(this);
        });

        $("#gambar_slide").on('click', function(event) {
            fadeInAdd();
        });

        function getURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var filename = $("#gambar_slide").val();
                filename = filename.substring(filename.lastIndexOf('\\') + 1);
                reader.onload = function(e) {
                // debugger;
                $('#fotoSlide').attr('src', e.target.result);
                $('#fotoSlide').hide();
                $('#fotoSlide').fadeIn(500);
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
<!-- Akhir Menampilkan Foto (Insert) -->

<!-- Text Editor -->
<!-- <script type="text/javascript" src="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.js') }}"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script> -->

<!-- <script>
new FroalaEditor('#ket_gambar', {
    "charCounterCount": true,
    "toolbarButtons": [
        'undo', 'redo', 'clearFormatting', '|',
        'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|'
    ],
    "autofocus": true,
    "attribution": false,
    "height": -1,
    "quickInsertButtons": false,
    "language": "id"
});
</script> -->
<!-- Akhir Text Editor -->
@endsection