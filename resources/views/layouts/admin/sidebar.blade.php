<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="#"><img src="{{ asset('images/logo-iain.png') }}" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ set_active('admin.panel') }}">
                    <a href="{{ route('admin.panel') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item {{ set_active('slide.banner') }}">
                    <a href="{{ route('slide.banner') }}" class='sidebar-link'>
                        <i class="bi bi-collection"></i>
                        <span>Banner Slide</span>
                    </a>
                </li>

                <li class="sidebar-item {{ set_active('panel.artikel') }}">
                    <a href="{{ route('panel.artikel') }}" class='sidebar-link'>
                        <i class="bi bi-pen-fill"></i>
                        <span>Artikel</span>
                    </a>
                </li>

                <li class="sidebar-item {{ set_active('panel.berita') }}">
                    <a href="{{ route('panel.berita') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Berita</span>
                    </a>
                </li>

                <li class="sidebar-item {{ set_active('panel.pengumuman') }}">
                    <a href="{{ route('panel.pengumuman') }}" class='sidebar-link'>
                        <i class="bi bi-mic"></i>
                        <span>Pengumuman</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar-date"></i>
                        <span>Agenda</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-bar-chart-line-fill"></i>
                        <span>Polling</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-download"></i>
                        <span>Download</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-camera-fill"></i>
                        <span>Galeri</span>
                    </a>
                </li>

                <li class="sidebar-item   ">
                    <a href="#" class='sidebar-link' onclick="logout()">
                        <i class="bi bi-power"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- <button class="sidebar-toggler btn x"><i data-feather="x"></i></button> -->
    </div>
</div>

<script type="application/javascript">
function logout() {
    const swalWithBootstrapButtons = Swal.mixin({
        buttonsStyling: true
    });

    swalWithBootstrapButtons.fire({
        title: 'Konfirmasi',
        text: "Anda Akan Keluar dari Halaman Ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Keluar!',
        cancelButtonText: '<i class="fas fa-ban"></i> Tidak!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('signout') }}",
                    type: 'get',
                    success: function() {
                        swalWithBootstrapButtons.fire({
                            title: 'Berhasil',
                            text: "Anda Sudah Logout",
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> OK'
                        }).then(function() {
                            window.location.href = "{{ route('login') }}";
                        });
                    }
                });
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: 'Batal',
                text: "Anda Masih Belum Logout",
                icon: 'info',
                confirmButtonText: '<i class="fas fa-check"></i> OK'
            });
        }
    });
}
</script>