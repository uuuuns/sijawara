<style>
    .carousel-indicators {
        margin-right: 0;
        margin-left: 0;
        margin-bottom: -2.3rem;
        justify-content: start;
    }

    .carousel-indicators [data-bs-target] {
        width: 15px;
        height: 15px;
        background-color: #000;
        border-radius: 100% !important;
    }

    .carousel-control-next {
        height: 60px;
        margin-right: -82px;
    }

    .carousel-control-prev {
        height: 60px;
        margin-left: -82px;
    }

    .carousel-control-prev-icon {
        height: 100%;
        width: 75px;
        background-size: 50px;
        background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" id="back" x="0" y="0" version="1.1" viewBox="0 0 29 29" xml:space="preserve"%3E%3Cpath d="M14.5 27.065a12.465 12.465 0 0 1-8.839-3.655c-4.874-4.874-4.874-12.804 0-17.678 2.361-2.361 5.5-3.662 8.839-3.662s6.478 1.3 8.839 3.662c4.874 4.874 4.874 12.804 0 17.678a12.465 12.465 0 0 1-8.839 3.655zm-7.425-5.069c4.094 4.094 10.756 4.094 14.85 0C23.908 20.012 25 17.375 25 14.571s-1.092-5.441-3.075-7.425S17.305 4.07 14.5 4.07 9.059 5.163 7.075 7.146 4 11.766 4 14.571s1.092 5.441 3.075 7.425z"%3E%3C/path%3E%3Cpath d="M16.798 20.167a.997.997 0 0 1-.707-.293l-4.596-4.596a.999.999 0 0 1 0-1.414l4.596-4.596a.999.999 0 1 1 1.414 1.414l-3.889 3.889 3.889 3.889a.999.999 0 0 1-.707 1.707z"%3E%3C/path%3E%3C/svg%3E');
    }

    .carousel-control-next-icon {
        height: 100%;
        width: 75px;
        background-size: 44px;
        background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="next"%3E%3Cg data-name="19. Next"%3E%3Cpath d="M12 0a12 12 0 1 0 12 12A12.013 12.013 0 0 0 12 0Zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1-10 10Z"%3E%3C/path%3E%3Cpath d="M10.641 6.232a1 1 0 1 0-1.282 1.536L14.437 12l-5.078 4.232a1 1 0 0 0 1.282 1.536l6-5a1 1 0 0 0 0-1.536Z"%3E%3C/path%3E%3C/g%3E%3C/svg%3E');
    }
</style>
<div style="">
    <div class="container px-0 pt-5">
        <div class="row">
            <div class="col-12 col-lg-7 py-2 px-4">
                <h1 class="fw-bold">Selamat Datang di SIJAWARA+</h1>
                <p class="fw-600 text-dark pt-3">SIJAWARA adalah akronim dari Sistem Informasi Pembelajaran dan Peningkatan Wawasan Perkoperasian. Melalui sijawara, sobat bisa mempelajari secara mandiri ilmu perkoperasian. Tak hanya itu, sobat sijawara bisa juga mempelajari ilmu terkait pengembangan UMKM. </p>
                <svg width="375" height="34" viewBox="0 0 487 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 30C73.6307 10.3798 266.914 -17.0885 483 30" stroke="#45B104" stroke-width="8" stroke-linecap="round" />
                </svg>
                <p class="py-3" style="font-size:14px;color:#505050;font-weight:500">
                    Tersedia video pembelajaran, materi tertulis, dan dilengkapi soal-soal. Kamu juga akan mendapatkan sertifikat. Sijawara juga hadir untuk pembelajaran daring. Pilih materi yang disukai dan segera daftarkan dirimu !!!
                </p>
                <div class="d-flex gap-2">
                    <button class="btn btn-main py-2 px-4 rounded">Mulai Belajar</button>
                    <button class="btn btn-main-outline py-2 px-4 rounded">Daftar</button>
                </div>
            </div>
            <div class="col-0 col-lg-5 text-end">
                <img src="{{ asset('assets_new') }}/images/new/ANIMASI.png" style="max-width: 90%;height: auto;" />
            </div>
        </div>
        <div class="row px-4 pt-80 mb-5">
            <h4 class="pb-3" style="font-weight:500">Materi belajar untuk sobat Sijawara+</h4>
            <div id="carousel" class="carousel slide" data-bs-ride="true">

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets_new') }}/images/new/1.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets_new') }}/images/new/2.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets_new') }}/images/new/3.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets_new') }}/images/new/4.png" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
            </div>
        </div>

    </div>
    <div class="pt-6">
        <div class="bg-danger" style="background-color: rgb(255 255 255 / 25%) !important;backdrop-filter: blur(10px);">
            <div class="container py-5 ">
                <h3 class="text-center" style="font-weight:600">Mulai dan Pilih Pelatihan Anda</h3>
                <div class="row">
                    <div class="col-12 col-lg-6 text-center">
                        <img src="{{ asset('assets_new') }}/images/new/event.png" style="max-width: 85%;height: auto;" />
                        <h3 class="fw-semibold" style="margin-top:-40px">Belajar Mandiri</h3>
                    </div>
                    <div class="col-12 col-lg-6 text-center">
                        <img src="{{ asset('assets_new') }}/images/new/webinar.png" style="max-width: 85%;height: auto; margin-top: -11px;" />
                        <h3 class="fw-semibold" style="margin-top:-53px">Webinar</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="pb-7">
            <h3 class="text-center mb-2" style="font-weight:600">Apa Kata Mereka ?</h3>
            <h6 class="text-center" style="font-weight:300;color:#A2A2A2">Testimoni dari beberapa peserta Pelatihan,<br>
                apakah kamu selanjutnya?</h6>
            <div class="row">
                <div class="col-6 col-lg-4 p-4">
                    <div class="rounded shadow py-4 px-4" style="background-color: #D9D9D9;">
                        <i>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate quaerat soluta eligendi magni cumque iusto."</i>
                        <div class="mt-3 fw-bold">John Doe</div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 p-4">
                    <div class="rounded shadow py-4 px-4" style="background-color: #D9D9D9;">
                        <i>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate quaerat soluta eligendi magni cumque iusto."</i>
                        <div class="mt-3 fw-bold">John Doe</div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 p-4">
                    <div class="rounded shadow py-4 px-4" style="background-color: #D9D9D9;">
                        <i>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate quaerat soluta eligendi magni cumque iusto."</i>
                        <div class="mt-3 fw-bold">John Doe</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 8rem !important;margin-bottom: 8rem !important;">
            <h3 class="text-center" style="font-weight:600">Support By</h3>
            <div class="mx-5 pt-4 text-center">
                <img src="{{ asset('assets_new') }}/images/new/sponsor/jatim.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/kemenkop.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/diskop.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/uptp.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/perpustakaan.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/bankjatim.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/stiki.png" class="img-fluid px-2" style="width:140px" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/machung.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/its.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/uin.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/linkaja.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/sijawara.png" class="img-fluid px-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/eperpus.png" class="img-fluid px-2" />
            </div>
        </div>
    </div>
</div>