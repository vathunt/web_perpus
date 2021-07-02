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
        @yield('modal')
    </div>
    <!-- jQuery Plugins -->
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Data Tables JS -->
    <script src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('javascript')
</body>

</html>