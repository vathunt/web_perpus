<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Login - Website Perpustakaan</title>
    <link rel="icon" href="{{ asset('assets/images/logo/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
    rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}" />
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    @if(Session::has('error'))
                    <script type="application/javascript">
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });

                        swalWithBootstrapButtons.fire({
                            title: 'Gagal',
                            text: "Periksa Kembali Username dan Password",
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> OK'
                        });
                    </script>
                    @endif
                    <div class="auth-logo">
                        <a href="#"><img src="{{ asset('images/logo-iain.png') }}" alt="Logo" /></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">
                        Masukkan Username dan Password Anda
                    </p>
                    @if(session('errors'))
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                    @endif
                    <form action="{{ route('post.login') }}" method="POST" id="formLogin">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Username"
                            name="username" id="username" value="{{ old('username') }}" autocomplete="off" />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password"
                            name="password" id="password" value="{{ old('password') }}" />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" id="lihatPassword" />
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Lihat Password
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" id="btnLogin">
                         Log in
                     </button>
                 </form>
                    <!-- <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="auth-register.html" class="font-bold">Sign up</a>.
                        </p>
                        <p>
                            <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.
                        </p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="{{ asset('assets/images/samples/IMG_6547.jpg') }}" alt="Background"
                    style="object-fit: cover; width: 100%; height: 100%;">
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery Plugins -->
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <!-- Lihat Password -->
    <script>
        $("#lihatPassword").on('click', function() {

        // $(this).toggleClass("fa-eye fa-eye-slash");
        var pass = $("#password");
        pass.attr("type") == "password" ? pass.attr("type", "text") : pass.attr("type", "password");
    });
</script>

<!-- jQuery Validate Plugins -->
<script src="{{ asset('assets/vendors/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendors/validate/additional-methods.min.js') }}"></script>
<script>
    $("#formLogin").on('blur keyup', function() {
        if ($("#formLogin").valid()) {
            $('#btnLogin').prop('disabled', false);
        } else {
            $('#btnLogin').prop('disabled', 'disabled');
        }
    });

    $('#formLogin').validate({
        errorClass: 'error is-invalid',
        validClass: 'is-valid',
        rules: {
            username: {
                required: true
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            username: {
                required: "Username Harus Diisi"
            },
            password: {
                required: "Password Harus Diisi",
                minlength: "Password Minimal 8 Karakter"
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        }
    });
</script>
</body>

</html>