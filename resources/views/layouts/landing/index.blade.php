<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.landing.head')

<body>
    <div class="body-inner">

        @include('layouts.landing.top_bar')
        @include('layouts.landing.header')
        @include('layouts.landing.carousel')

        @yield('content')

        @include('layouts.landing.footer')


        <!-- Javascript Files
    ================================================== -->

        <!-- initialize jQuery Library -->
        <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
        <!-- Bootstrap jQuery -->
        <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}" defer></script>
        <!-- Slick Carousel -->
        <script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('plugins/slick/slick-animation.min.js') }}"></script>
        <!-- Color box -->
        <script src="{{ asset('plugins/colorbox/jquery.colorbox.js') }}"></script>
        <!-- shuffle -->
        <script src="{{ asset('plugins/shuffle/shuffle.min.js') }}" defer></script>

        <!-- Google Map API Key-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer>
        </script>
        <!-- Google Map Plugin-->
        <script src="{{ asset('plugins/google-map/map.js') }}" defer></script>

        <!-- Template custom -->
        <script src="{{ asset('js/script.js') }}"></script>

    </div><!-- Body inner end -->
</body>

</html>