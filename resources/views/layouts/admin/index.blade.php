<!DOCTYPE html>
<html lang="en">

@include('layouts.admin.head')

<body>
    <div id="app">
        @if(Session::has('sukses'))
        <script type="application/javascript">
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Berhasil',
            text: "{{ Session::get('sukses') }}",
            icon: 'success',
            confirmButtonText: '<i class="fa fa-check"></i> OK',
            confirmButtonColor: '#3085d6'
        });
        </script>
        @elseif(Session::has('error'))
        <script type="application/javascript">
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Gagal',
            text: "{{ Session::get('error') }}",
            icon: 'error',
            confirmButtonText: '<i class="fa fa-check"></i> OK',
            confirmButtonColor: '#3085d6'
        });
        </script>
        @endif
        @include('layouts.admin.sidebar')
        @yield('content')
    </div>
    <!-- jQuery Plugins -->
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('javascript')
</body>

</html>