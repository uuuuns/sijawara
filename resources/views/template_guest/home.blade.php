<style>
    .carousel,
    .carousel-inner,
    .carousel-item {
        height: 100vh;
    }

    .carousel-item>.container,
    .carousel-item>.row,
    .carousel-item>div {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (min-width: 1024px) {
        .carousel-item>div {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -5rem;
        }
    }

    .carousel-fade .carousel-item {
        opacity: 0;
        transition-property: opacity;
        transition-duration: 1s;
        transition-timing-function: ease-in-out;
    }

    .carousel-fade .carousel-item.active,
    .carousel-fade .carousel-item-next.carousel-item-start,
    .carousel-fade .carousel-item-prev.carousel-item-end {
        opacity: 1;
        transform: none;
    }

    .carousel-fade .active.carousel-item-start,
    .carousel-fade .active.carousel-item-end {
        opacity: 0;
    }

    .bg-indonesia {
        background: linear-gradient(to bottom, red 50%, white 50%);
    }
</style>
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide Default -->
        <div class="carousel-item active">
            <div class="container pb-5">
                <div class="row align-items-center mt-n5">
                    <div class="col-12 col-lg-7 py-2 px-4">
                        <h1 class="fw-bold">Selamat Datang di SIJAWARA+</h1>
                        <p class="fw-semibold text-dark pt-3">
                            SIJAWARA adalah akronim dari Sistem Informasi Pembelajaran dan Peningkatan Wawasan
                            Perkoperasian.
                            Melalui sijawara, sobat bisa mempelajari secara mandiri ilmu perkoperasian. Tak hanya itu,
                            sobat sijawara bisa juga mempelajari ilmu terkait pengembangan UMKM.
                        </p>
                        <svg class="w-100" width="375" height="34" viewBox="0 0 487 34" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 30C73.6307 10.3798 266.914 -17.0885 483 30" stroke="#45B104" stroke-width="8"
                                stroke-linecap="round" />
                        </svg>
                        <p class="py-3" style="font-size:14px;color:#505050;font-weight:500">
                            Tersedia video pembelajaran, materi tertulis, dan dilengkapi soal-soal. Kamu juga akan
                            mendapatkan sertifikat.
                            Sijawara juga hadir untuk pembelajaran daring. Pilih materi yang disukai dan segera
                            daftarkan dirimu !!!
                        </p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-main py-2 px-4 rounded"
                                onclick="window.location.href = '/kursus'">Mulai Belajar</button>
                            @if (empty(session('user')))
                                <button class="btn btn-main-outline py-2 px-4 rounded"
                                    onclick="window.location.href = '/daftar'">Daftar</button>
                            @endif
                        </div>
                    </div>
                    <div class="col-0 col-lg-5 text-end d-none d-sm-block">
                        <img src="{{ asset('assets_new/images/new/ANIMASI.png') }}"
                            style="max-width: 90%; height: auto;" />
                    </div>
                </div>

            </div>
        </div>

        <!-- Slide KDMP -->
        <div class="carousel-item bg-indonesia">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-7 py-2 px-4">
                        <h1 class="fw-bold">Selamat Datang di SIJAWARA+ PMDK</h1>
                        <p class="fw-semibold text-dark pt-3">
                            SIJAWARA adalah akronim dari Sistem Informasi Pembelajaran dan Peningkatan Wawasan
                            Perkoperasian.
                            Melalui sijawara, sobat bisa mempelajari secara mandiri ilmu perkoperasian. Tak hanya itu,
                            sobat sijawara bisa juga mempelajari ilmu terkait pengembangan UMKM.
                        </p>
                        <svg class="w-100" width="375" height="34" viewBox="0 0 487 34" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 30C73.6307 10.3798 266.914 -17.0885 483 30" stroke="#45B104" stroke-width="8"
                                stroke-linecap="round" />
                        </svg>
                        <p class="py-3" style="font-size:14px;color:#505050;font-weight:500">
                            Tersedia video pembelajaran, materi tertulis, dan dilengkapi soal-soal. Kamu juga akan
                            mendapatkan sertifikat.
                            Sijawara juga hadir untuk pembelajaran daring. Pilih materi yang disukai dan segera
                            daftarkan dirimu !!!
                        </p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-main py-2 px-4 rounded"
                                onclick="window.location.href = '/kursus'">Mulai PMDK</button>
                            @if (empty(session('user')))
                                <button class="btn btn-main-outline py-2 px-4 rounded"
                                    onclick="window.location.href = '/daftar'">Daftar</button>
                            @endif
                        </div>
                    </div>
                    <div class="col-0 col-lg-5 text-end d-none d-sm-block ">
                        <img src="{{ asset('assets_new/images/new/ANIMASI.png') }}"
                            style="max-width: 90%; height: auto;" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide dinamis -->
        {{-- @foreach ($carousel as $index => $item)
            <div class="carousel-item">
                <div class="row align-items-center justify-content-center w-100 vh-100"
                    style="{{ $item->gambar ? "background-image: url('" . asset($item->gambar) .
                            "'); background-size: cover; background-position: center; background-repeat: no-repeat;" : '' }}">
                    <div class="container text-center text-white">
                        @if (!empty($item->link))
                            <a href="{{ $item->link }}" class="btn btn-success btn-lg rounded-pill">
                                Lihat Detail
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Splide -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

<style>
    /* Card Testimoni */
    .testimonial-card {
        background-color: #D9D9D9;
        border-radius: 10px;
        padding: 1.5rem;
        box-sizing: border-box;
        transition: 0.3s ease-in-out;
    }

    .testimonial-card .user-info {
        font-weight: bold;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .testimonial-card .user-info img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 15px;
    }

    .testimonial-card i {
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: auto;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var splide = new Splide('.splide', {
            type: 'loop',
            focus: 0,
            autoplay: true,
            interval: 5000,
        });
        splide.mount();

        function setEqualHeight() {
            let cards = document.querySelectorAll('.testimonial-card');
            let maxHeight = 0;

            cards.forEach(card => {
                card.style.height = "auto";
            });

            cards.forEach(card => {
                if (card.offsetHeight > maxHeight) {
                    maxHeight = card.offsetHeight;
                }
            });

            cards.forEach(card => {
                card.style.height = maxHeight + "px";
            });
        }

        setEqualHeight();

        window.addEventListener('resize', setEqualHeight);
    });
</script>


<div style="">
    <div class="container px-0 pt-5">
        {{-- <div class="row">
            <div class="col-12 col-lg-7 py-2 px-4">
                <h1 class="fw-bold">Selamat Datang di SIJAWARA+</h1>
                <p class="fw-600 text-dark pt-3">SIJAWARA adalah akronim dari Sistem Informasi Pembelajaran dan
                    Peningkatan Wawasan Perkoperasian. Melalui sijawara, sobat bisa mempelajari secara mandiri ilmu
                    perkoperasian. Tak hanya itu, sobat sijawara bisa juga mempelajari ilmu terkait pengembangan UMKM.
                </p>
                <svg class="w-100" width="375" height="34" viewBox="0 0 487 34" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 30C73.6307 10.3798 266.914 -17.0885 483 30" stroke="#45B104" stroke-width="8"
                        stroke-linecap="round" />
                </svg>
                <p class="py-3" style="font-size:14px;color:#505050;font-weight:500">
                    Tersedia video pembelajaran, materi tertulis, dan dilengkapi soal-soal. Kamu juga akan mendapatkan
                    sertifikat. Sijawara juga hadir untuk pembelajaran daring. Pilih materi yang disukai dan segera
                    daftarkan dirimu !!!
                </p>
                <div class="d-flex gap-2">
                    <button class="btn btn-main py-2 px-4 rounded" onclick="window.location.href = '/kursus'">Mulai
                        Belajar</button>
                    @if (empty(session('user')))
                        <button class="btn btn-main-outline py-2 px-4 rounded"
                            onclick="window.location.href = '/daftar'">Daftar</button>
                    @endif
                </div>
            </div>
            <div class="col-0 col-lg-5 text-end d-none d-sm-block">
                <img src="{{ asset('assets_new') }}/images/new/ANIMASI.png" style="max-width: 90%;height: auto;" />
            </div>
        </div> --}}

        <div style="margin:auto;max-width: 1208px;max-height: 400px;">
            <div class="splide img-header"
                style="margin-top:120px; overflow:hidden;border-radius:1rem;max-width: 1208px;max-height: 400px;">
                <div class="splide__track" style="aspect-ratio:151/50;">
                    <ul class="splide__list">
                        @foreach ($carousel as $item)
                            <li class="splide__slide">
                                <section class="bg-fixed division" onclick="window.open('<?= $item->link ?>', '_blank')"
                                    style="background-size:cover;aspect-ratio:151/50;
                                background-image: url(<?= $item->gambar ?>);
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
    <div class="bg-danger" style="background-color: rgb(255 255 255 / 25%) !important;backdrop-filter: blur(10px);">
        <div class="container py-5 ">
            <h3 class="text-center" style="font-weight:600">Mulai dan Pilih Pelatihan Anda</h3>
            <div class="row  pt-3 pt-lg-0">
                <div class="col-12 col-lg-6 text-center" id="belajar-mandiri">
                    <a href="{{ url('kursus') }}">
                        <img class="mandiri-img" src="{{ asset('assets_new') }}/images/new/event.png" />
                    </a>
                    <h4 class="fw-semibold pt-2 mandiri-text">Belajar Mandiri</h4>
                </div>
                <div class="col-12 col-lg-6 text-center pt-4 pt-sm-0" id="webinar">
                    <a href="{{ url('webinar') }}">
                        <img class="webinar-img" src="{{ asset('assets_new') }}/images/new/webinar.png" />
                    </a>
                    <h4 class="fw-semibold pt-2 webinar-text">Webinar & Pelatihan</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="pb-7">
            <h3 class="text-center mb-2" style="font-weight:600">Apa Kata Mereka ?</h3>
            <h6 class="text-center" style="font-weight:300;color:#A2A2A2">
                Testimoni dari beberapa peserta Pelatihan,<br>
                apakah kamu selanjutnya?
            </h6>

            <!-- Carousel Start -->
            <div class="splide testimonial-carousel" style="margin-top:20px;">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($testimoni as $item)
                            <li class="splide__slide">
                                <div class="col-12 p-4">
                                    <div class="testimonial-card shadow">
                                        <div class="user-info">
                                            <img src="<?= empty($item->gambar_testimoni) ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973461_1280.png' : $item->gambar_testimoni ?>"
                                                alt="<?= $item->nama ?>">
                                            <?= $item->nama ?>
                                        </div>
                                        <i><?= $item->testimoni ?></i>
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
            <div class=" pt-4 text-center">
                <img src="{{ asset('assets_new') }}/images/new/sponsor/jatim.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/kemenkop.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/diskop.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/uptp.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/perpustakaan.png"
                    class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/bankjatim.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/stiki.png" class="img-fluid px-2 py-2"
                    style="width:140px" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/machung.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/its.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/uin.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/linkaja.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/sijawara.png" class="img-fluid px-2 py-2" />
                <img src="{{ asset('assets_new') }}/images/new/sponsor/eperpus.png" class="img-fluid px-2 py-2" />
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var splide = new Splide('.splide', {
            type: 'loop',
            focus: 0,
            autoplay: true,
            interval: 5000,
        });
        splide.mount();

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
        });
        testimonialSplide.mount();

        function setEqualHeight() {
            let cards = document.querySelectorAll('.testimonial-card');
            let maxHeight = 0;

            cards.forEach(card => {
                card.style.height = "auto";
            });

            cards.forEach(card => {
                if (card.offsetHeight > maxHeight) {
                    maxHeight = card.offsetHeight;
                }
            });

            cards.forEach(card => {
                card.style.height = maxHeight + "px";
            });
        }

        setEqualHeight();
        window.addEventListener('resize', setEqualHeight);
    });
</script>


<script>
    <?php if (!empty(session('user')[0])) { ?>
    document.addEventListener('DOMContentLoaded', function() {
        window.scrollTo(0, 0);

        const intro = introJs();

        intro.setOptions({
            steps: [{
                    title: "Hallo",
                    intro: "Selamat datang di SIJAWARA+"
                },
                {
                    element: document.getElementById('belajar-mandiri'),
                    intro: "Anda bisa mencari kursus kelas untuk belajar mandiri disini!"
                }, {
                    element: document.getElementById('webinar'),
                    intro: "Anda juga bisa mencari webinar menarik disini!"
                }
            ]
        }).setOptions({
            showBullets: false,
            scrollToElement: false
        })

        intro.onbeforechange(function(targetElement) {
            let width = $(window).width();

            if (width > 991) {
                if (this._currentStep == 1) {
                    // window.scrollTo(0, $(targetElement).offset().top - 500);

                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top - (
                            85)) + 'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top - (
                            85)) + 'px !important;';
                    });

                    intro.refresh()
                }
            } else {
                if (this._currentStep == 1) {

                    window.scrollTo(0, $(targetElement).offset().top - 400);

                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top - (
                            85)) + 'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top - (
                            85)) + 'px !important;';
                    });

                    intro.refresh()
                } else if (this._currentStep == 2) {

                    window.scrollTo(0, $(targetElement).offset().top - 400);

                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top + 10) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top + 10) +
                            'px !important;';
                    });

                    intro.refresh()
                }
            }
        });

        window.scrollTo(0, 0)

        function showIntroIfNeeded(userId) {
            if (!localStorage.getItem(`intro_home_${userId}`)) {
                if ($(window).scrollTop() === 0) {

                    intro.start()
                    intro.oncomplete(() => {
                        localStorage.setItem(`intro_home_${userId}`, "true")
                    })
                    intro.onexit(() => {
                        localStorage.setItem(`intro_home_${userId}`, "true")
                    })
                } else {
                    $(window).on('scroll', function checkScroll() {
                        if ($(window).scrollTop() === 0) {
                            intro.start()
                            intro.oncomplete(() => {
                                localStorage.setItem(`intro_home_${userId}`, "true")
                            })
                            intro.onexit(() => {
                                localStorage.setItem(`intro_home_${userId}`, "true")
                            })

                            $(window).off('scroll', checkScroll)
                        }
                    });
                }

                localStorage.setItem(`intro_home_${userId}`, 'true')
            }
        }

        function onLogin(userId) {
            showIntroIfNeeded(userId)
        }

        onLogin('<?= session('user')[0]['ID_USER'] ?>')
    });
    <?php } ?>
</script>
