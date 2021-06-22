<!DOCTYPE html>
<html lang="en">

@include('layouts.admin.head')

<body>
    <div id="app">
        @include('layouts.admin.sidebar')
        @yield('content')
    </div>
    <script src="{{ asset('admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
</body>

</html>