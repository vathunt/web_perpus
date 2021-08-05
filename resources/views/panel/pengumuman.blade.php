@extends('layouts.admin.index')

@section('title', 'Pengumuman')

@section('style-css')
<!-- Text Editor Style -->
<link href="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Akhir Text Editor Style -->
@endsection

@section('content')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn btn-sm d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Pengumuman</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.panel') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="bootstrap-select">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" id="btnTmbPengumuman">Tambah Pengumuman</button>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pengumuman</h4>
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
                                <table class="table table-hover table-bordered table-lg" id="tbl_pengumuman">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Pengumuman</th>
                                            <th>Judul Pengumuman</th>
                                            <th>Detail Pengumuman</th>
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

<!-- Lihat, Update dan Delete Pengumuman -->
<script>
// Fungsi Merubah Format Tanggal Menjadi mm/dd/yyyy
function formattedDate(inputDate) {
    // let day = date.getDate();
    // let month = date.getMonth() + 1;
    // let year = date.getFullYear();

    // let fullDate = (month <= 10 ? '0' + month : month) + '/' + (day <= 9 ? '0' + day : day) + '/' + year;
    // // console.log(fullDate);
    // return fullDate;
    let date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        let day = date.getDate().toString();
        let month = (date.getMonth() + 1).toString();

        return date.getFullYear() + '-' + (month[1] ? month : '0' + month[0]) + '-' + (day[1] ? day : '0' + day[0]);
    }
}

function lihatPengumuman(id) {
    $.ajax({
        url: "{{ url('/') }}/panel/pengumuman/" + id,
        dataType: "json"
    }).done(function(response) {
        let date = formattedDate(new Date(response.tgl_pengumuman));

        $('#viewJudul').html(response.judul_pengumuman);
        $('#viewTanggal').html(date);
        $('#viewDetail').html(response.detail_pengumuman);
        $('#viewAdmin').html(response.user['name']);

        $("#viewThumbnail").html('');
        let thumbnail = response.thumbnail_pengumuman;
        if (thumbnail) {
            thumbnail = response.thumbnail_pengumuman
        }

        $("#viewThumbnail").append("<img src='../assets/images/thumbnail/pengumuman/" + thumbnail +
            "' id='thumbnailPengumuman' class='card-img-top img-fluid' alt='Thumbnail " + response
            .judul_pengumuman + "'>");

        $('#viewLampiran').html('');
        let lampiran = response.lampiran_pengumuman;
        let namaFileLamp = response.nama_file_lampiran;

        if (lampiran && namaFileLamp) {
            lampiran = response.lampiran_pengumuman;
            namaFileLamp = response.nama_file_lampiran;
        }

        // if (lampiran) {
        //     lampiran.forEach((item, index) => {
        //         $('#viewLampiran').append("<li><a class='badge bg-warning' target='_blank' href='../assets/files/pengumuman/" + item + "'>" + item + "</a></li>")
        //     });
        // }

        if (lampiran) {
            for (let i = 0; i < lampiran.length; i++) {
                $('#viewLampiran').append(
                    "<li><a class='badge bg-warning' target='_blank' href='../assets/files/pengumuman/" +
                    lampiran[i] + "'>" + namaFileLamp[i] + "</a></li>")
            }
        }

        $('#lhtPengumuman').modal('toggle');
    });
}

function hapusPengumuman(id) {
    $.ajax({
        url: "{{ url('/') }}/panel/pengumuman/" + id,
        dataType: "json"
    }).done((response) => {
        $('#idDelete').val(response.id);
        $('#judulPengumumanDelete').html(`"${response.judul_pengumuman}"`);

        $('#hapusPengumuman').modal('toggle');
    });
}

function editPengumuman(id) {
    $('.datepicker').datepicker('remove');
    $.ajax({
        url: "{{ url('/') }}/panel/pengumuman/" + id,
        dataType: "json"
    }).done(function(response) {
        $('#idEdit').val(response.id);
        $('#judulEdit').val(response.judul_pengumuman);
        $('#tglEdit').val(formattedDate(response.tgl_pengumuman));

        // Preview Thumbnail
        $("#previewThumbnail").html('');
        let gambar = response.thumbnail_pengumuman;
        if (gambar) {
            gambar = response.thumbnail_pengumuman;
        }

        $("#previewThumbnail").append("<img src='../assets/images/thumbnail/pengumuman/" + gambar +
            "' style='max-width: 100%;'>");
        // End of Preview Thumbnail

        // Preview Lampiran
        $('#previewLampiran').html('');
        let lampiran = response.lampiran_pengumuman;
        let namaFileLamp = response.nama_file_lampiran;

        if (lampiran && namaFileLamp) {
            lampiran = response.lampiran_pengumuman;
            namaFileLamp = response.nama_file_lampiran;
        }

        if (lampiran) {
            for (let i = 0; i < lampiran.length; i++) {
                $('#previewLampiran').append(
                    "<li><a class='badge bg-warning' target='_blank' href='../assets/files/pengumuman/" +
                    lampiran[i] + "'>" + namaFileLamp[i] + "</a></li>")
            }
        }
        // End of Preview Lampiran

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

        $('#editPengumuman').modal('toggle');
    });
}
</script>

@section('modal')
<!-- Modal Tambah Pengumuman -->
<div class="modal fade text-left" id="tmbPengumuman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-full" role="document">
        <form method="POST" class="form form-vertical" id="formTmbPengumuman" action="{{ route('pengumuman.post') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">
                        Tambah Pengumuman
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="judulPengumuman">Judul Pengumuman</label>
                                    <div class="position-relative">
                                        <input type="text" name="judulPengumuman" id="judulPengumuman"
                                            class="form-control" autocomplete="off">
                                        <div class="form-control-icon">
                                            <i class="bi bi-chat-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="tglPengumuman">Tanggal Pengumuman</label>
                                    <div class="position-relative">
                                        <input type="text" name="tglPengumuman" id="tglPengumuman"
                                            class="datepicker form-control" readonly>
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="input-group mb-3">
                                <label for="thumbPengumuman" class="font-bold">Thumbnail Pengumuman</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="icon-label"><i class="bi bi-upload"></i></label>
                                    <input type ="file" name="thumbPengumuman" class="form-control"
                                    id="thumbPengumuman" accept="image/*">
                                </div>
                                <div id="errThumbPengumuman"></div>
                            </div> -->
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="lampPengumuman" class="font-bold">Lampiran Pengumuman</label>
                                    <!-- <input type="file" name="lampPengumuman[]" class="form-control" id="lampPengumuman" multiple> -->
                                    <div class="input-group">
                                        <input type="text" name="namaLampPengumuman[]" class="form-control"
                                            id="namaLampPengumuman" placeholder="Nama File Lampiran" autocomplete="off">
                                        <input type="file" name="lampPengumuman[]" class="form-control" data-id="0"
                                            id="lampPengumuman">
                                        <button class="btn btn-primary" type="button"
                                            id="btnTmbLampiran">&plus;</button>
                                    </div>
                                    <div id="errLampPengumuman-0"></div>
                                    <p></p>
                                    <div id="inputLampiran"></div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="thumbPengumuman" class="font-bold">Thumbnail Pengumuman</label>
                                    <input type="file" name="thumbPengumuman" class="form-control" id="thumbPengumuman"
                                        accept="image/*">
                                </div>
                            </div>
                            <!-- <div class="input-group mb-3">
                                <label for="lampPengumuman" class="font-bold">Lampiran Pengumuman</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="icon-label"><i class="bi bi-upload"></i></label>
                                    <input type="file" name="lampPengumuman[]" class="form-control" id="lampPengumuman" multiple>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="detailPengumuman">Detail Pengumuman</label>
                                    <textarea name="detailPengumuman" id="detailPengumuman"
                                        class="form-control"></textarea>
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
                    <button type="submit" class="btn btn-primary ml-1" id="btnSubmit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Akhir Modal Tambah Pengumuman -->

<!-- Modal Lihat Pengumuman -->
<div class="modal fade text-left" id="lhtPengumuman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title white" id="myModalLabel160">
                    Lihat Pengumuman
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
                            <div class="card-text text-justify" id="viewDetail"></div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tanggal Pengumuman : <span class="font-bold"
                                id="viewTanggal"></span></li>
                        <li class="list-group-item">Diupload Oleh : <span class="font-bold" id="viewAdmin"></span></li>
                        <li class="list-group-item">
                            <span class="font-bold">Lampiran Pengumuman</span>
                            <ol id="viewLampiran"></ol>
                        </li>
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
<!-- Akhir Modal Lihat Pengumuman -->

<!-- Modal Edit Pengumuman -->
<div class="modal fade text-left" id="editPengumuman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-full" role="document">
        <form method="POST" class="form form-vertical" id="formEditPengumuman" action="{{ route('pengumuman.update') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">
                        Edit Pengumuman
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="judulEdit">Judul Pengumuman</label>
                                    <div class="position-relative">
                                        <input type="text" name="judulEdit" id="judulEdit" class="form-control"
                                            autocomplete="off">
                                        <div class="form-control-icon">
                                            <i class="bi bi-chat-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="tglEdit">Tanggal Pengumuman</label>
                                    <div class="position-relative">
                                        <input type="text" name="tglEdit" id="tglEdit" class="datepicker form-control"
                                            readonly>
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="lampPengumuman" class="font-bold">Lampiran Pengumuman</label>
                                    <div class="input-group">
                                        <input type="text" name="namaLampPengumuman[]" class="form-control"
                                            id="namaLampPengumuman" placeholder="Nama File Lampiran" autocomplete="off">
                                        <input type="file" name="lampPengumuman[]" class="form-control" data-id="0"
                                            id="lampPengumuman">
                                        <button class="btn btn-primary" type="button"
                                            id="btnTmbLampiran">&plus;</button>
                                    </div>
                                    <div>
                                        <ol id="previewLampiran"></ol>
                                    </div>
                                    <div id="errLampPengumuman-0"></div>
                                    <p></p>
                                    <div id="inputLampiran"></div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="thumbPengumuman" class="font-bold">Thumbnail Pengumuman</label>
                                    <input type="file" name="thumbPengumuman" class="form-control" id="thumbPengumuman"
                                        accept="image/*">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="detailPengumuman">Detail Pengumuman</label>
                                    <textarea name="detailPengumuman" id="detailPengumuman"
                                        class="form-control"></textarea>
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
                    <button type="submit" class="btn btn-primary ml-1" id="btnSubmit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Akhir Modal Edit Pengumuman -->

<!-- Modal Hapus Pengumuman -->
<div class="modal fade text-left" id="hapusPengumuman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel160">
                    Hapus Pengumuman
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Hapus Pengumuman Ini?</h4>
                <h5 class="text-center fst-italic" id="judulPengumumanDelete">
                    </h3>
            </div>
            <div class="modal-footer">
                <form action="{{ route('pengumuman.delete') }}" method="POST">
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
<!-- Akhir Modal Hapus Pengumuman -->
@endsection

@section('javascript')
<!-- Uppercase Judul Pengumuman -->
<script>
$('#judulPengumuman').keyup(function() {
    // $(this).val($('#judulPengumuman').val().toUpperCase());
    document.getElementById('judulPengumuman').style.textTransform = "uppercase";
});
</script>
<!-- End of Uppercase Judul Pengumuman -->

<!-- Tombol Tambah Lampiran -->
<script>
$(document).ready(function() {
    let i = 0;
    $("#btnTmbLampiran").on('click', function(event) {
        i++;
        event.preventDefault();
        $("<div id='remove_" + i +
                "'><div class='input-group'><input type='text' name='namaLampPengumuman[]' class='form-control' placeholder='Nama File Lampiran' autocomplete='off'><input type='file' name='lampPengumuman[]' class='form-control' data-id='" +
                i + "'><button type='button' class='btn btn-danger' onclick=\"hapus_lampiran('" + i +
                "')\">&times;</button></div><div id='errLampPengumuman-" + i + "'></div><p></p></div>")
            .appendTo($("#inputLampiran"));
    });

});

function hapus_lampiran(i) {
    $('#remove_' + i).fadeOut('slow', function() {
        $('#remove_' + i).remove();
    });
}
</script>
<!-- End of Tombol Tambah Lampiran -->

<!-- Toggle Modal Tambah Pengumuman -->
<script type="text/javascript">
$('#btnTmbPengumuman').on('click', () => {
    $('#tmbPengumuman').modal('toggle');
});
</script>
<!-- Akhir Toggle Modal Tambah Pengumuman -->

<!-- jQuery Validate Plugins -->
<script src="{{ asset('assets/vendors/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendors/validate/additional-methods.min.js') }}"></script>

<!-- Validasi Form Tambah Pengumuman -->
<script>
$("#formTmbPengumuman").on('blur keyup', function() {
    if ($("#formTmbPengumuman").valid()) {
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

$('#formTmbPengumuman').validate({
    errorClass: 'error is-invalid',
    validClass: 'is-valid',
    ignore: "[contenteditable='true'].fr-element.fr-view",
    rules: {
        judulPengumuman: {
            required: true
        },
        tglPengumuman: {
            required: true
        },
        detailPengumuman: {
            required: true
        },
        thumbPengumuman: {
            required: true,
            extension: "jpg|jpeg|png",
            maxfilesize: 2
        },
        "lampPengumuman[]": {
            extension: "jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|txt|pdf",
            maxfilesize: 10
        }
    },
    messages: {
        judulPengumuman: {
            required: "Judul Pengumuman Harus Diisi"
        },
        tglPengumuman: {
            required: "Tanggal Pengumuman Belum Dipilih"
        },
        detailPengumuman: {
            required: "Detail Pengumuman Harus Diisi"
        },
        thumbPengumuman: {
            required: "Thumbnail Pengumuman Belum Dipilih",
            extension: "Ekstensi File *.jpg, *.jpeg atau *.png",
            maxfilesize: 'Ukuran File Tidak Boleh Lebih dari 2 MB'
        },
        "lampPengumuman[]": {
            extension: "Ekstensi File *.jpg, *.jpeg, *.png, *.doc, *.docx, *.xls, *.xlsx, *.ppt, *.pptx, *.txt, *.pdf",
            maxfilesize: 'Ukuran File Tidak Boleh Lebih dari 10 MB'
        }
    },
    errorPlacement: function(error, element) {
        if (element.attr("name") == "lampPengumuman[]") {
            error.appendTo($('#errLampPengumuman-' + element.attr("data-id")));
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
<!-- Akhir Validasi Form Tambah Pengumuman -->

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
        status_tampil_edit: {
            required: true
        }
    },
    messages: {
        gambar_slide_edit: {
            required: "Gambar Belum Dipilih",
            extension: "Ekstensi File *.jpg, *.jpeg atau *.png"
        },
        ket_gambar_edit: {
            required: "Keterangan Gambar Harus Diisi"
        },
        status_tampil_edit: {
            required: "Status Tampil Harus Dipilih"
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
<!-- Akhir Validasi Form Edit Banner Slide -->

<!-- Menampilkan Data Pengumuman di DataTable -->
<script type="text/javascript">
var table_slide = $('#tbl_pengumuman').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        "url": "{{ route('pengumuman.data') }}",
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
            "data": "tgl_pengumuman"
        },
        {
            "data": "judul_pengumuman"
        },
        {
            "data": "detail_pengumuman"
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
<!-- Menampilkan Data Pengumuman di DataTable -->

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
new FroalaEditor('#detailPengumuman', {
    "charCounterCount": true,
    "toolbarButtons": [
        'undo', 'redo', 'clearFormatting', '|',
        'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'paragraphStyle',
        'lineHeight', '|',
        'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|',
        'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink',
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
    "height": -1,
    "linkAlwaysBlank": true,
    "paragraphDefaultSelection": "Normal",
    "paragraphFormatSelection": true,
    "quickInsertButtons": ['table', 'ol', 'ul', 'hr'],
    "language": "id"
});
</script>
<!-- End of Text Editor -->
@endsection