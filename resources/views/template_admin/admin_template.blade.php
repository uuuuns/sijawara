<style>
    .sidebar-profile li a {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        line-height: 1.4;
        text-transform: capitalize;
        font-family: var(--theme-heading-font);
    }

    .sidebar-profile li a:hover {
        color: var(--theme-primary-color);
    }
</style>

<div class="px-4 px-md-0 py-4 pb-6 pt-3">
    <div class="container-fluid">
        <div class="row main-content flex-column-reverse flex-md-row">
            <div class="col-md-2 sidebar">
                <div class="sidebar__inner">
                    <div class="px-0" style="z-index: 0;">
                        <div class="bg-white shadow rounded-2 overflow-hidden" style="height:max-content">
                            <div class="d-flex flex-column align-items-center align-items-sm-start text-white">
                                <ul class="sidebar-profile nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                                    <li class="nav-item w-100 pt-2">
                                        <a href="{{ url('dashboard') }}" class=" {{ request()->is('dashboard') ? 'active' : '' }}    nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-tachometer"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>

                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>

                                    <li class="nav-item w-100">
                                        <a data-bs-toggle="collapse" data-bs-target="#submenu" aria-expanded="true" aria-controls="submenu" class="nav-link d-flex align-middle px-4 py-3 rounded-0 {{ (request()->is('webinar-admin*') || request()->is('kursus-admin*')) ? 'active' :  '' }}" style="cursor: pointer;">
                                            <i class="fs-6 d-flex align-items-center far fa-book-open"></i>
                                            <span class="ms-1 ps-2 fs-6 align-self-center ">Aktifitas</span>
                                            <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                </path>
                                            </svg>
                                        </a>
                                        <ul class="nav nav-list collapse" id="submenu">
                                            <li class="nav-item w-100">
                                                <a href="{{ url('kursus-admin') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center ">Kursus</span>
                                                </a>
                                            </li>
                                            <li class="w-100">
                                                <hr class="my-0 border border-1 mx-3">
                                            </li>
                                            <li class="nav-item w-100">
                                                <a href="{{ url('webinar-admin') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center ">Webinar</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php if ((session('user')[0]['ID_ROLE']) == 1 || (session('user')[0]['ID_ROLE']) == 4) { ?>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="{{ url('aspirasi') }}" class=" {{ request()->is('aspirasi') ? 'active' : '' }}    nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-lightbulb"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                    Aspirasi
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="{{ url('kategori') }}" class="nav-link  {{ request()->is('kategori') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-th-large"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                    Kategori
                                                </span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a data-bs-toggle="collapse" data-bs-target="#statistik_menu" aria-expanded="true" aria-controls="submenu" class="nav-link d-flex align-middle px-4 py-3 rounded-0 {{ (request()->is('statistik-kategori*') || request()->is('statistik-peserta*')) ? 'active' :  '' }}" style="cursor: pointer;">
                                                <i class="fs-6 d-flex align-items-center far fa-file-chart-pie"></i>
                                                <span class="ms-1 ps-2 fs-6 align-self-center ">Statistik</span>
                                                <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <ul class="nav nav-list collapse" id="statistik_menu">
                                                <li class="nav-item w-100">
                                                    <a href="{{ url('statistik-peserta') }}" class="nav-link  {{ request()->is('statistik-peserta') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                        <i class="fs-6 d-flex align-items-center far fa-file-chart-pie"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                            Statistik Peserta
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="w-100">
                                                    <hr class="my-0 border border-1 mx-3">
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a href="{{ url('statistik-kategori') }}" class="nav-link  {{ request()->is('statistik-kategori') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                        <i class="fs-6 d-flex align-items-center far fa-file-chart-pie"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                            Statistik Kategori Kursus
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a href="/ranking" class="nav-link  {{ request()->is('ranking') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                        <i class="fs-6 d-flex align-items-center bx bx-trophy"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                            Top 10 User Teraktif
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="{{ url('pengguna') }}" class="nav-link  {{ request()->is('user') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-user"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                    Peserta
                                                </span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="{{ url('instruktur') }}" class="nav-link  {{ request()->is('instruktur') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-user-md"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">
                                                    Instruktur
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item w-100">
                                            <a data-bs-toggle="collapse" data-bs-target="#submenu_master_data" aria-expanded="true" aria-controls="submenu" class="nav-link d-flex align-middle px-4 py-3 rounded-0 {{ (request()->is('widyaiswara*') || request()->is('ukm*') || request()->is('koperasi*')) ? 'active' :  '' }}" style="cursor: pointer;">
                                                <i class="fs-6 d-flex align-items-center far fa-tools"></i>
                                                <span class="ms-1 ps-2 fs-6 align-self-center ">Master Data</span>
                                                <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <ul class="nav nav-list collapse" id="submenu_master_data">
                                                <li class="nav-item w-100">
                                                    <a data-bs-toggle="collapse" data-bs-target="#submenu_master_data_1" aria-expanded="true" aria-controls="submenu" class="nav-link d-flex align-middle px-4 py-3 rounded-0 {{ (request()->is('testimoni*') || request()->is('pengaturan*')) ? 'active' :  '' }}" style="cursor: pointer;">
                                                        <span class="ms-3 ps-3 fs-6 align-self-center ">UKM</span>
                                                        <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <ul class="nav nav-list collapse" id="submenu_master_data_1">
                                                        <li class="nav-item w-100">
                                                            <a href="{{ url('ukm/badan_usaha') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Bentuk Badan Usaha</span>
                                                            </a>
                                                            <a href="{{ url('ukm/jabatan_ukm') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Jabatan UKM</span>
                                                            </a>
                                                            <a href="{{ url('ukm/kategori_ukm') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Kategori UKM</span>
                                                            </a>
                                                            <a href="{{ url('ukm/sumber_bahanbaku') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Sumber Bahan Baku</span>
                                                            </a>
                                                            <a href="{{ url('ukm/legalitas_usaha') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Legalitas Usaha</span>
                                                            </a>
                                                            <a href="{{ url('ukm/standar_produk') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Standarisasi Produk</span>
                                                            </a>
                                                            <a href="{{  url('ukm/wilayah_pemasaran') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Wilayah Pemasaran</span>
                                                            </a>
                                                            <a href="{{ url('ukm/fasilitas_kegiatan') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Fasilitas Kegiatan</span>
                                                            </a>
                                                            <a href="{{ url('ukm/masalah_ukm') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Masalah UKM</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="w-100">
                                                    <hr class="my-0 border border-1 mx-3">
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a data-bs-toggle="collapse" data-bs-target="#submenu_master_data_2" aria-expanded="true" aria-controls="submenu" class="nav-link d-flex align-middle px-4 py-3 rounded-0 {{ (request()->is('testimoni*') || request()->is('pengaturan*')) ? 'active' :  '' }}" style="cursor: pointer;">
                                                        <span class="ms-3 ps-3 fs-6 align-self-center ">Koperasi</span>
                                                        <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <ul class="nav nav-list collapse" id="submenu_master_data_2">
                                                        <li class="nav-item w-100">
                                                            <a href="{{ url('bentuk') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Bentuk Koperasi</span>
                                                            </a>
                                                            <a href="{{ url('jenis')}}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Jenis Koperasi</span>
                                                            </a>
                                                            <a href="{{ url('kelompok')}}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Kelompok Koperasi</span>
                                                            </a>
                                                            <a href="{{ url('masalah') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Masalah Koperasi</span>
                                                            </a>
                                                            <a href="{{ url('sektor') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                                <span class="ms-3 ps-3 fs-6 align-self-center ">Sektor Usaha</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="w-100">
                                                    <hr class="my-0 border border-1 mx-3">
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a href="{{ url('widyaiswara') }}" class="nav-link  {{ request()->is('instruktur') ? 'active' : '' }}  d-flex align-middle px-4 py-3 rounded-0">
                                                        <span class="ms-3 ps-3 fs-6 align-self-center ">Widyaiswara</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item w-100">
                                            <a data-bs-toggle="collapse" data-bs-target="#submenu_setting" aria-expanded="true" aria-controls="submenu" class="nav-link d-flex align-middle px-4 py-3 rounded-0 {{ (request()->is('testimoni*') || request()->is('pengaturan*')) ? 'active' :  '' }}" style="cursor: pointer;">
                                                <i class="fs-6 d-flex align-items-center far fa-tools"></i>
                                                <span class="ms-1 ps-2 fs-6 align-self-center ">Pengaturan</span>
                                                <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <ul class="nav nav-list collapse" id="submenu_setting">
                                                <li class="nav-item w-100">
                                                    <a href="{{ url('pengaturan') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                        <span class="ms-3 ps-3 fs-6 align-self-center ">Carousel</span>
                                                    </a>
                                                </li>
                                                <li class="w-100">
                                                    <hr class="my-0 border border-1 mx-3">
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a href="{{ url('testimoni') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                        <span class="ms-3 ps-3 fs-6 align-self-center ">Testimoni</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100 pb-3">
                                            <a href="{{ url('keluar') }}" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-arrow-alt-to-left"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">Keluar
                                                </span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-10 content py-4 py-md-0">
                <!-- Page -->
                @yield('content')
            </div>
        </div>
    </div>
</div>

<style>
    .rotate180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('#submenu').on('show.bs.collapse', function() {
            $('.fa-chevron-down').addClass('rotate180');
        });

        $('#submenu').on('hide.bs.collapse', function() {
            $('.fa-chevron-down').removeClass('rotate180');
        });
    });

    // var sidebar = new StickySidebar('.sidebar', {
    //     topSpacing: 20,
    //     bottomSpacing: 20,
    //     containerSelector: '.main-content',
    //     innerWrapperSelector: '.sidebar__inner'
    // });
</script>