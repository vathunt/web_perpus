@extends('layouts.admin.index')

@section('title', 'Banner Slide')

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
                    <h3>Manajemen Banner Slide</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.panel') }}"><i
                                        class="bi bi-house-door-fill"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Banner Slide</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="bootstrap-select">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Banner Slide</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" class="form form-vertical" id="formSlide"
                                    action="{{ route('slide.post') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-md-12 mb-1">
                                                    <div class="input-group mb-3">
                                                        <label for="gambar_slide">Gambar Slide</label>
                                                        <small class="text-muted">&nbsp;<i
                                                                class="text-primary font-bold">*)
                                                                Ukuran
                                                                Gambar 1600x800
                                                                pixel</i></small>
                                                        <div class="input-group mb-3">
                                                            <label class="input-group-text" for="icon-label"><i
                                                                    class="bi bi-upload"></i></label>
                                                            <input type="file" name="gambar_slide" class="form-control"
                                                                id="gambar_slide" accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-icon-left">
                                                    <label for="ket_gambar">Keterangan Gambar</label>
                                                    <div class="position-relative">
                                                        <textarea name="ket_gambar" id="ket_gambar" class="form-control"
                                                            rows="5"></textarea>
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-chat-text"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1"
                                                    id="btnSubmit">Submit</button>
                                                <button type="reset"
                                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
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

@section('modal')
<div class="modal fade text-left" id="editBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-borderless modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="myModalLabel160">
                    Primary Modal
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                Tart lemon drops macaroon oat cake chocolate toffee
                chocolate
                bar icing. Pudding jelly beans
                carrot cake pastry gummies cheesecake lollipop. I
                love cookie
                lollipop cake I love sweet
                gummi
                bears cupcake dessert.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-info ml-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<!-- Update dan Delete Banner Slide -->
<script>
let id;

function editBanner(id) {
    $.ajax({
        url: "{{ url('/') }}/panel/slide/" + id,
        dataType: "json"
    }).done(function(response) {
        $('#idEdit').val(response.id);
        $('#keterangan_slide_edit').val(response.keterangan_slide);

        $("#previewBannerSlide").html('');
        let gambar = response.gambar_slide;
        if (gambar) {
            gambar = response.foto_alumni
        }

        $("#previewAlumni").append("<img src='../images/slider-main/" + gambar +
            "' id='fotoBannerTampil'>");

        $('#editBanner').modal('toggle');
    });
}
</script>

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
            extension: "Ekstensi File *.jpg, *.jpeg atau *.png"
        },
        ket_gambar: {
            required: "Keterangan Gambar Harus Diisi"
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
<!-- Akhir Validasi Form Tambah Banner Slide -->

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
            "data": "gambar_slide"
        },
        {
            "data": "keterangan_slide"
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
@endsection