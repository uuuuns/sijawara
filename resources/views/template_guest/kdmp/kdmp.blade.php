<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .page-header-custom {
        background: url('<?= asset('assets_new') ?>/images/bg/illustration-bg.png') 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: initial;
    }

    .float-container {
        position: relative;
    }

    .float {
        position: fixed;
        width: 50px;
        height: 50px;
        bottom: 120px;
        right: 20px;
        background-color: #FF0000;
        color: #FFF;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: visible;
    }

    .my-float {
        font-size: 24px;
    }

    .float-text {
        position: absolute;
        top: 50%;
        right: 110%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: #FFF;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease, right 0.3s ease;
        z-index: 101;
    }

    .float:hover .float-text {
        opacity: 1;
        right: 120%;
    }
</style>

<section class="page-header page-header-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-10">
                <div class="title-block">
                    <h1>Kursus Koperasi Desa Merah Putih</h1>
                    <ul class="header-bradcrumb justify-content-center">
                        <li><a href="{{ url('') }}" style="color: white !important;">Beranda</a></li>
                        <li class="active" aria-current="page">KDMP</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding page">
    <div class="course-top-wrap mb-50">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4">
                    <div class="topbar-search ">
                        <input type="text" placeholder="Cari Kursus" class="form-control search" id="search-form">
                        <label><i class="fa fa-search"></i></label>
                    </div>
                    <div class="dropdown mt-2">
                        <div id="search-result"
                            class="col-12 dropdown-menu rounded-2 custom-scrollbar-js dropdown-primary"
                            style="min-height: 512px; overflow-y:scroll;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid container-padding">
        <?php if (!empty($course)) { ?>
        <div class="row mt-md-4">
            <?php foreach ($course as $item) : ?>
            @php
                $check_is_invited = false;
                if ($item->is_invited == 1 && !empty(session('user')) && $item->IS_PUBLIC == 0) {
                    $check_is_invited = true;
                } elseif ($item->IS_PUBLIC == 1) {
                    $check_is_invited = true;
                }
            @endphp
            <?php if (session('user') != null && $item->DATA_CHECKING == 1) { ?>
            <!-- VIEW SUDAH BAYAR -->
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="px-0 px-sm-3">
                    <div class="course-grid course-style-4 bg-white px-1 px-md-2 mt-4 pb-2">
                        <div class="course-header">
                            <a
                                <?= $check_is_invited ? 'href="' . url('kdmp/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>>
                                <img src="<?= $item->IMAGE_ACTIVITY ?>" alt=""
                                    style="width: 100%; height: 300px; object-fit: cover;">
                            </a>
                        </div>

                        <div class="course-content">
                            <?php if ($item->PROGRESS == 100) { ?>
                            <span class="course-price bg-danger">Selesai</span>
                            <?php } else { ?>
                            <span class="course-price bg-danger">Progress <?= ceil($item->PROGRESS) ?>%</span>
                            <?php } ?>
                            <h3 class="course-title"> <a
                                    <?= $check_is_invited ? 'href="' . url('kdmp/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>><?= $item->TITLE_ACTIVITY ?></a>
                            </h3>
                        </div>
                        <div class="course-meta">
                            <div class="text-muted m-0 pt-2 fs-6"
                                style="overflow: hidden !important;
                                text-overflow: ellipsis !important;
                                display: -webkit-box !important;
                                -webkit-line-clamp: 2 !important;
                                -webkit-box-orient: vertical !important;">
                                <?= $item->DESKRIPSI_COURSE ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php } else { ?>
            <!-- VIEW BELUM BAYAR -->
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="px-0 px-sm-3">
                    <div class="course-grid course-style-4 bg-white px-1 px-md-2 mt-4 pb-2">
                        <div class="course-header">
                            <div class="" style="width: 100%; height: 300px; overflow: hidden;">
                                <a
                                    <?= $check_is_invited ? 'href="' . url('kdmp/info/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>>
                                    <img src="<?= $item->IMAGE_ACTIVITY ?>" alt=""
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                            </div>
                        </div>

                        <div class="course-content">
                            <span
                                class="course-price <?= $item->participant == 0 ? 'bg-success' : 'bg-primary' ?>"><?= $item->participant == 0 ? 'Ayo Segera Ikuti!' : $item->participant . ' Orang' ?></span>
                            <h3 class="course-title">
                                <a
                                    <?= $check_is_invited ? 'href="' . url('kdmp/info/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>><?= $item->TITLE_ACTIVITY ?></a>
                            </h3>
                        </div>
                        <div class="course-meta">
                            <div class="text-muted m-0 pt-2 fs-6"
                                style="overflow: hidden !important; text-overflow: ellipsis !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
                                <?= $item->DESKRIPSI_COURSE ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php } ?>
            <?php endforeach; ?>
        </div>
        <div
            class="px-3 d-grid d-md-flex text-center justify-content-md-between justify-content-center align-items-center">
            <div class="order-2 order-md-1 pt-3 pt-md-0">
                <span class="fs-8 pagination-text">Menampilkan {{ $course->currentPage() }} dari
                    {{ $course->lastPage() }} Halaman</span>
            </div>
            <div class="order-1 order-md-2">
                {{ $course->links() }}
            </div>
        </div>

        <?php } else { ?>
        <div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
            <div class=" rounded-5 px-3 pb-4 h-auto d-flex flex-column" style="margin-top: -60px;">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('assets_new') }}/images/empty.svg" width="350">
                </div>
                <h3 class="font-sm text-center">Kursus KDMP tidak tersedia</h2>

            </div>
        </div>
        <?php } ?>
        <div class="float-container">
            <a href="<?= !empty(session('user')) ? 'kdmp/aspirasi-kursus' : 'masuk' ?>"
                class="btn btn-warning rounded float">
                <i class="bx bx-help-circle my-float"></i>
                <span class="float-text">Tidak menemukan yang anda cari? Klik disini</span>
            </a>
        </div>
    </div>
    <!--course-->
</section>

<script>    
    $(document).on('click', function(event) {
        var clickedElement = $(event.target);
        var element = $('#search-result');
        if (!clickedElement.is(element) && !clickedElement.closest(element).length) {
            $('#search-result').hide()
        }
    });

    $('#search-form').keyup(function(e) {
        if (e.which == 13) {
            $('#search-result').html("");
            getData($(this).val())
        }
    });

    function getData(key) {
        $.ajax({
            url: "kdmp/search",
            method: 'GET',
            data: {
                keyword: key
            },
            success: function(result) {
                if (result != "") {
                    $('#search-result').append(result)
                } else {
                    $('#search-result').append(" <a class='dropdown-item'>No matching records found</a>")
                }

                if ($('#search-result').html() != "") {
                    $('#search-result').show();
                }
            }
        });
    }
</script>
