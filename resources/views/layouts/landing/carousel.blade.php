<div class="banner-carousel banner-carousel-1 mb-0">
    @foreach($slides as $slide)
    <div class="banner-carousel-item" style="background-image:url(images/slider-main/{{ $slide->gambar_slide }})">
        <div class="slider-content">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12 text-center">
                        <div class="box-slider-text">
                            <p class="slider-description lead" data-animation-in="slideInRight">{{ $slide->keterangan_slide }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- <div class="banner-carousel-item" style="background-image:url(images/slider-main/bg2.jpg)">
        <div class="slider-content text-left">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12">
                        <div class="box-slider-text">
                            <h2 class="slide-title-box" data-animation-in="slideInDown">World Class Service</h2>
                            <h3 class="slide-title" data-animation-in="fadeIn">When Service Matters</h3>
                            <h3 class="slide-sub-title" data-animation-in="slideInLeft">Your Choice is Simple</h3>
                            <p data-animation-in="slideInRight">
                                <a href="services.html" class="slider btn btn-primary border">Our Services</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-carousel-item" style="background-image:url(images/slider-main/bg3.jpg)">
        <div class="slider-content text-right">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12">
                        <div class="box-slider-text">
                            <h2 class="slide-title" data-animation-in="slideInDown">Meet Our Engineers</h2>
                            <h3 class="slide-sub-title" data-animation-in="fadeIn">We believe sustainability</h3>
                            <p class="slider-description lead" data-animation-in="slideInRight">We will deal with your
                                failure that determines how you achieve success.</p>
                            <div data-animation-in="slideInLeft">
                                <a href="contact.html" class="slider btn btn-primary" aria-label="contact-with-us">Get
                                    Free
                                    Quote</a>
                                <a href="about.html" class="slider btn btn-primary border"
                                    aria-label="learn-more-about-us">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<!-- <section class="call-to-action-box no-padding">
    <div class="container">
        <div class="action-style-box">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-left">
                    <div class="call-to-action-text">
                        <h3 class="action-title">Form Pendaftaran Layanan Peminjaman Buku</h3>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-right mt-3 mt-md-0">
                    <div class="call-to-action-btn">
                        <a class="btn btn-dark" href="#">Klik Disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->