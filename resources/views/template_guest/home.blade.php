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
                    <button class="btn btn-main py-2 px-4 rounded" onclick="window.location.href = '/course'">Mulai Belajar</button>
                    <button class="btn btn-main-outline py-2 px-4 rounded" onclick="window.location.href = '/register'">Daftar</button>
                </div>
            </div>
            <div class="col-0 col-lg-5 text-end">
                <img src="{{ asset('assets_new') }}/images/new/ANIMASI.png" style="max-width: 90%;height: auto;" />
            </div>
        </div>
        <!-- Carousel Start -->
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var splide = new Splide('.splide', {
                    type: 'loop',
                    focus: 0,
                    autoplay: true,
                    interval: 5000,
                });
                splide.mount();
            });
        </script>

        <style>
            .splide__pagination__page.is-active {
                background: #FC8B14;
            }

            .splide__arrow {
                background: transparent;
                opacity: .4;
                width: 2.7rem;
                height: 2.7rem;
            }

            .splide__arrow:hover {
                border: 2px;
                border-style: solid;
                border-color: #bbb;
                opacity: 1;
            }

            button:focus {
                outline: 0px;
            }

            .splide__arrow svg {
                fill: #bbb;
            }

            .splide__arrow--prev svg {
                transform: scale(-1.5)
            }

            .splide__arrow--next svg {
                transform: scale(1.5)
            }

            .splide__pagination {
                bottom: 1.5em;
                margin-bottom: -20px;
            }

            .mt-70-m {
                margin-top: 60px !important;
            }

            .countdown-text {
                font-size: 5rem;
                font-weight: 900
            }

            .header-event {
                display: block !important;
            }

            .header-event-mbl {
                display: none !important;
            }

            @media(max-width: 991.95px) {
                .header-event {
                    display: none !important;
                }

                .header-event-mbl {
                    margin-top: 50px !important;
                    margin-bottom: -10px !important;
                    display: block !important;
                }
            }

            @media (min-width: 992px) and (max-width: 1199.95px) {
                .img-header {
                    margin-top: 8rem !important;
                    margin-right: 2rem;
                    margin-left: 2rem
                }

                .empty {
                    max-width: 70% !important
                }
            }

            @media (min-width: 768px) and (max-width: 991.95px) {
                .img-header {
                    /* margin-top: 3rem !important; */
                    margin-right: 2rem;
                    margin-left: 2rem
                }

                .splide__arrow {
                    background: transparent;
                    opacity: .4;
                    width: 2.7rem;
                    height: 2.7rem;
                }

                .splide__arrow:hover {
                    border: 2px;
                    border-style: solid;
                    border-color: #bbb;
                    opacity: 1;
                }

                button:focus {
                    outline: 0px;
                }

                .splide__arrow svg {
                    fill: #bbb;
                }

                .splide__arrow--prev svg {
                    transform: scale(-1.5)
                }

                .splide__arrow--next svg {
                    transform: scale(1.5)
                }

                .empty {
                    max-width: 70% !important
                }
            }

            @media (max-width: 767px) {
                .img-header {
                    margin-right: 1.5rem;
                    margin-left: 1.5rem
                }

                .splide__arrow {
                    background: transparent;
                    opacity: .4;
                    width: 1.8rem;
                    height: 1.8rem;
                }

                .splide__arrow--prev svg {
                    transform: scale(-1)
                }

                .splide__arrow--next svg {
                    transform: scale(1)
                }

                .empty {
                    max-width: 59% !important
                }

                .container-exhibition {
                    grid-template-columns: repeat(5, minmax(200px, 1fr)) !important
                }


                .ebanner {
                    width: 170px
                }

                .mt-70-m {
                    margin-top: 60px !important;
                }
            }

            @media (min-width: 992px) and (max-width: 1199.95px) {
                .img-header {
                    margin-top: 8rem !important;
                    margin-right: 2rem;
                    margin-left: 2rem
                }

                .empty {
                    max-width: 70% !important
                }
            }

            @media (min-width: 768px) and (max-width: 991.95px) {
                .img-header {
                    /* margin-top: 3rem !important; */
                    margin-right: 2rem;
                    margin-left: 2rem
                }
            }


            @media (max-width: 479.95px) {
                .countdown-text {
                    font-size: 4rem;
                    font-weight: 900
                }
            }

            @media (min-width: 414px) and (max-width: 479.95px) {
                .img-header {
                    margin-right: 1.9rem;
                    margin-left: 1.2rem
                }
            }

            @media (max-width: 767px) {
                .img-header {
                    margin-right: 1.5rem;
                    margin-left: 1.5rem
                }

                .splide__arrow {
                    background: transparent;
                    opacity: .4;
                    width: 1.8rem;
                    height: 1.8rem;
                }

                .splide__arrow--prev svg {
                    transform: scale(-1)
                }

                .splide__arrow--next svg {
                    transform: scale(1)
                }

                .empty {
                    max-width: 59% !important
                }

                .container-exhibition {
                    grid-template-columns: repeat(5, minmax(200px, 1fr)) !important
                }

                .ebanner {
                    width: 170px
                }

                .mt-70-m {
                    margin-top: 20px !important;
                }

            }

            @media (min-width: 480px) and (max-width: 767.95px) {
                .img-header {
                    margin-right: 2rem;
                    margin-left: 1.3rem
                }

            }

            @media (min-width: 414px) and (max-width: 479.95px) {
                .img-header {
                    margin-right: 1.9rem;
                    margin-left: 1.2rem
                }

                .splide__arrow {
                    background: transparent;
                    opacity: .4;
                    width: 1.5rem;
                    height: 1.5rem;
                }

                .splide__arrow--prev svg {
                    transform: scale(-0.8)
                }

                .splide__arrow--next svg {
                    transform: scale(0.8)
                }

                .empty {
                    max-width: 50% !important
                }

            }

            @media (min-width: 321px) and (max-width: 413.95px) {
                .img-header {
                    margin-right: 1.8rem;
                    margin-left: 1.1rem
                }

                .empty {
                    max-width: 50% !important
                }

                .items::-webkit-scrollbar {
                    display: none;
                }

                .nav::-webkit-scrollbar {
                    display: none;
                }
            }

            @media (max-width: 320.95px) {
                .img-header {
                    margin-right: 1.7rem;
                    margin-left: 1rem
                }
            }

            .nav {
                flex-wrap: nowrap;
            }
        </style>

        <div style="margin:auto;max-width: 1208px;max-height: 400px;">
            <div class="splide img-header" style="margin-top:120px; overflow:hidden;border-radius:1rem;max-width: 1208px;max-height: 400px;">
                <div class="splide__track" style="aspect-ratio:151/50;">
                    <ul class="splide__list">
                        @foreach ($carousel as $item)
                        <li class="splide__slide">
                            <section class="bg-fixed division" onclick="window.open('<?=$item->link?>', '_blank')" style="background-size:cover;aspect-ratio:151/50;
                                background-image: url(<?=$item->gambar?>);
                                width: 100%; height: 100%;">
                            </section>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Carousel End -->
    </div>
    <div class="pt-6">
        <div class="bg-danger" style="background-color: rgb(255 255 255 / 25%) !important;backdrop-filter: blur(10px);">
            <div class="container py-5 ">
                <h3 class="text-center" style="font-weight:600">Mulai dan Pilih Pelatihan Anda</h3>
                <div class="row">
                    <div class="col-12 col-lg-6 text-center">
                        <a href="{{ url('course') }}">
                            <img src="{{ asset('assets_new') }}/images/new/event.png" style="max-width: 85%;height: auto;" />
                        </a>
                        <h3 class="fw-semibold" style="margin-top:-40px">Belajar Mandiri</h3>
                    </div>
                    <div class="col-12 col-lg-6 text-center">
                        <a href="{{ url('event') }}">
                            <img src="{{ asset('assets_new') }}/images/new/webinar.png" style="max-width: 85%;height: auto; margin-top: -11px;" />
                        </a>
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
            <!-- Carousel Start -->
            <div class="splide testimonial-carousel" style="margin-top:20px;">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($testimoni as $item)
                        <li class="splide__slide">
                            <div class="col-12 p-4">
                                <div class="rounded shadow py-4 px-4" style="background-color: #D9D9D9;">
                                    <i><?= $item->testimoni?></i>
                                    <div class="mt-3 fw-bold"><?= $item->nama?></div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Carousel End -->
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var testimonialSplide = new Splide('.testimonial-carousel', {
            type: 'loop',
            perPage: 3,
            perMove: 1,
            autoplay: true,
            interval: 5000,
            breakpoints: {
                991: {
                    perPage: 2,
                },
                767: {
                    perPage: 1,
                }
            }
        }).mount();
    });
</script>