  <!-- Header start -->
  <header id="header" class="header-one">
      <div class="bg-white">
          <div class="container">
              <div class="logo-area">
                  <div class="row align-items-center">
                      <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                          <a class="d-block" href="{{ route('home') }}">
                              <img loading="lazy" src="{{ asset('images/logo-iain.png') }}" alt="Perpustakaan IAIN Madura" style="width: 300px; height: 85px;">
                          </a>
                      </div><!-- logo end -->

                      <div class="col-lg-9 header-right">
                          <ul class="top-info-box">
                              <li>
                                  <div class="info-box">
                                      <div class="info-box-content">
                                          <p class="info-box-title">Telp./Fax</p>
                                          <p class="info-box-subtitle">(+62) 324-322551</p>
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <div class="info-box">
                                      <div class="info-box-content">
                                          <p class="info-box-title">Email</p>
                                          <p class="info-box-subtitle">perpustakaan@iainmadura.ac.id</p>
                                      </div>
                                  </div>
                              </li>
                              <li class="last">
                                  <div class="info-box last">
                                      <div class="info-box-content">
                                          <p class="info-box-title">Akreditasi</p>
                                          <p class="info-box-subtitle">A (Unggul)</p>
                                      </div>
                                  </div>
                              </li>
                              <!-- <li class="header-get-a-quote">
                      <a class="btn btn-primary" href="contact.html">Get A Quote</a>
                    </li> -->
                          </ul><!-- Ul end -->
                      </div><!-- header right end -->
                  </div><!-- logo area end -->

              </div><!-- Row end -->
          </div><!-- Container end -->
      </div>

      <div class="site-navigation">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12">
                      <nav class="navbar navbar-expand-lg navbar-dark p-0">
                          <button class="navbar-toggler" type="button" data-toggle="collapse"
                              data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                              aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                          </button>

                          <div id="navbar-collapse" class="collapse navbar-collapse">
                              <ul class="nav navbar-nav mr-auto">
                                  <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>

                                  <li class="nav-item dropdown">
                                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Tentang Kami
                                          <i class="fa fa-angle-down"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                          <li><a href="#">Profil</a></li>
                                          <li><a href="#">Visi & Misi</a></li>
                                          <li><a href="#">Tujuan & Sasaran</a></li>
                                          <li><a href="#">Struktur Organisasi</a></li>
                                          <li><a href="#">Video Profil Perpustakaan</a></li>
                                      </ul>
                                  </li>

                                  <li class="nav-item dropdown">
                                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Layanan <i
                                              class="fa fa-angle-down"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                          <li><a href="#">Jam Layanan</a></li>
                                          <li><a href="#">Jenis Layanan</a></li>
                                          <li><a href="#">e-Library</a></li>
                                          <li><a href="#">e-Journal</a></li>
                                          <li><a href="#">Repository</a></li>
                                          <li><a href="#">e-Theses</a></li>
                                          <li><a href="#">OPAC</a></li>
                                      </ul>
                                  </li>

                                  <li class="nav-item dropdown">
                                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Tautan Penting
                                          <i class="fa fa-angle-down"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                          <li><a href="#">E-Resources</a></li>
                                          <li><a href="#">iPusnas</a></li>
                                          <li><a href="#">Indonesia One Search</a></li>
                                          <li><a href="#">Turnitin</a></li>
                                      </ul>
                                  </li>

                                  <li class="nav-item"><a href="#" class="nav-link">Galeri</a></li>
                                  <li class="nav-item"><a href="#" class="nav-link">Download</a></li>

                                  <li class="nav-item dropdown">
                                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Survei <i
                                              class="fa fa-angle-down"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                          <li><a href="#">Survei Layanan Perpustakaan</a></li>
                                          <li><a href="#">Formulir Usulan Buku</a></li>
                                          <li><a href="#">Hasil Survei</a></li>
                                      </ul>
                                  </li>

                                  <!-- <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Features <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="typography.html">Typography</a></li>
                              <li><a href="404.html">404</a></li>
                              <li class="dropdown-submenu">
                                  <a href="#!" class="dropdown-toggle" data-toggle="dropdown">Parent Menu</a>
                                  <ul class="dropdown-menu">
                                    <li><a href="#!">Child Menu 1</a></li>
                                    <li><a href="#!">Child Menu 2</a></li>
                                    <li><a href="#!">Child Menu 3</a></li>
                                  </ul>
                              </li>
                            </ul>
                        </li>
                
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li> -->
                              </ul>
                          </div>
                      </nav>
                  </div>
                  <!--/ Col end -->
              </div>
              <!--/ Row end -->

              <div class="nav-search">
                  <span id="search"><i class="fa fa-search"></i></span>
              </div><!-- Search end -->

              <div class="search-block" style="display: none;">
                  <label for="search-field" class="w-100 mb-0">
                      <input type="text" class="form-control" id="search-field"
                          placeholder="Type what you want and enter">
                  </label>
                  <span class="search-close">&times;</span>
              </div><!-- Site search end -->
          </div>
          <!--/ Container end -->

      </div>
      <!--/ Navigation end -->
  </header>
  <!--/ Header end -->