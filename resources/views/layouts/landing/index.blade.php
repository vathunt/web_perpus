<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  @include('layouts.landing.head')

<body>
    <div class="body-inner">

      @include('layouts.landing.top_bar')
      @include('layouts.landing.header')
      @include('layouts.landing.carousel')

      <section class="call-to-action-box no-padding">
        <div class="container">
          <div class="action-style-box">
              <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-left">
                    <div class="call-to-action-text">
                      <h3 class="action-title">We understand your needs on construction</h3>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-right mt-3 mt-md-0">
                    <div class="call-to-action-btn">
                      <a class="btn btn-dark" href="#">Request Quote</a>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </section>

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
    <!-- Google Map Plugin-->
    <script src="{{ asset('plugins/google-map/map.js') }}" defer></script>

    <!-- Template custom -->
    <script src="{{ asset('js/script.js') }}"></script>

    </div><!-- Body inner end -->
  </body>

</html>