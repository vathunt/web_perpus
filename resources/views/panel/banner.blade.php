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
                                    action="{{ route('slide.post') }}">
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
                                <table class="table table-hover table-lg">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ asset('assets/images/faces/5.jpg') }}">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Si Cantik</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">Congratulations on your graduation!</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-sm btn-primary"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-info"><i
                                                            class="fas fa-eye"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ asset('assets/images/faces/2.jpg') }}">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Si Ganteng</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">Wow amazing design! Can you make another
                                                    tutorial for
                                                    this design?</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-sm btn-primary"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-info"><i
                                                            class="fas fa-eye"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
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

@section('javascript')
<!-- jQuery Validate Plugins -->
<script src="{{ asset('assets/vendors/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendors/validate/additional-methods.min.js') }}"></script>
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
@endsection