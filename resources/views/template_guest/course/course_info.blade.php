<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="page-wrapper">
    <div class="tutori-course-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="course-header-wrapper">

                        <div>
                            <h2 class="course-title bg-white">
                                <?= $course->TITLE_ACTIVITY ?>
                            </h2>
                        </div>
                    </div>
                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home-tab" aria-selected="true">Ringkasan</a>
                            <?php if (!empty(session('user'))) : ?>
                                <a class="nav-item nav-link" id="nav-topics-tab" data-bs-toggle="tab" href="#nav-topics" role="tab" aria-controls="nav-topics-tab" aria-selected="false">Kurikulum</a>
                            <?php endif ?>
                            <a class="nav-item nav-link" id="nav-instructor-tab" data-bs-toggle="tab" href="#nav-instructor" role="tab" aria-controls="nav-instructor-tab" aria-selected="false">Instruktur</a>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="single-course-details">
                                <h4 class="course-title">Deskripsi</h4>
                                <p>
                                    <?= $course->DESKRIPSI_COURSE ?>
                                </p>

                                <div class="course-widget course-info">
                                    <h4 class="course-title">Apa yang akan anda pelajari?</h4>
                                    <?= $course->DESKRIPSI_COURSE_ITEM ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-topics" role="tabpanel" aria-labelledby="nav-topics-tab">
                            <div class="tutori-course-curriculum">
                                <div class="curriculum-scrollable">
                                    <ul class="curriculum-sections">
                                        <li class="section">
                                            <ul class="section-content">
                                                <?php if (!empty($item_course)) { ?>
                                                    <?php foreach ($item_course as $item) :  ?>
                                                        <li class="course-item has-status">
                                                            <a class="section-item-link">
                                                                <span class="item-name"> <?= $item->TITLE ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php } else { ?>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <img src="{{ asset('assets_new') }}/images/empty.svg" width="350">
                                                        <h4 class="font-sm text-center">Tidak ada bab</h4>
                                                    </div>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                    </ul>
                                    <!-- Main ul end -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-instructor" role="tabpanel" aria-labelledby="nav-instructor-tab">
                            <!-- Course instructor start -->
                            <div class="courses-instructor">
                                <div class="single-instructor-box">
                                    <div class="row align-items-center">

                                        <div class="col-lg-8 col-md-8">
                                            <div class="instructor-content">
                                                <h4><?= $course->NAME ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Conurse  instructor end -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-xl-4">
                    <!-- Course Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="course-widget course-details-info">
                            <div class="course-thumbnail">
                                <img src="<?= $course->IMAGE_ACTIVITY ?>" alt="" class="img-fluid w-100" />
                                <div class="my-3 fw-bold d-flex align-self-end justify-content-end pe-0 align-items-center text-black">
                                    Bagikan :<span class="fs-5"> <i class="fab fa-facebook mx-2" style="cursor: pointer"></i><i class="fab fa-twitter me-2" style="cursor: pointer"></i><i class="fab fa-instagram" style="cursor: pointer"></i></span>
                                </div>
                            </div>

                            <div class="price-header">
                                <h2 class="course-price">
                                    <?= ($course->PRICE_ACTIVITY == 0) ? "Free" : "Rp " . number_format($course->PRICE_ACTIVITY, 2, ',', '.') ?>
                                </h2>
                            </div>

                            <ul class="course-sidebar-list">
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="far fa-sliders-h"></i>Total Bab</span>
                                        <?= $total_item['materi'] ?>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-play-circle"></i>Total Kuis</span>
                                        <?= $total_item['quiz'] ?>
                                    </div>
                                </li>
                            </ul>
                            <div class="">
                                <form class="" id="FormBuyNow-info" method="POST" action="<?= url('purchase') ?>">
                                    @csrf
                                    <div id="data-input-info"></div>
                                    <div class="w-100 button button-enroll-course btn btn-main-2 rounded" onclick="BuyNow()">Beli Sekarang</div>
                                </form>
                                <button data-id-activity="<?= $course->ID_ACTIVITY ?>" onclick="AddToCart(this)" class="mt-2 w-100 button button-enroll-course btn btn-secondary btn-sm rounded">
                                    Tambahkan ke keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function AddToCart(e) {
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        <?php if (!empty(session('user'))) { ?>
            $.ajax({
                url: '<?= Request::segment(0) ?>/add/order',
                type: "GET",
                data: {
                    id_activity: $(e).data("id-activity"),
                    type: 1
                },
                dataType: 'json',
                success: function(data) {
                    Toast.fire({
                        icon: (data.Status) ? 'success' : 'error',
                        title: data.Message
                    })
                }
            });
        <?php } else { ?>
            Toast.fire({
                icon: 'error',
                title: 'Harap Masuk terlebih dulu!'
            })
        <?php } ?>
    }

    function BuyNow() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        <?php if (!empty(session('user'))) { ?>
            <?php if (!empty($checking_trans)) { ?>
                Toast.fire({
                    icon: 'error',
                    title: 'Anda punya transaksi yang belum selesai!'
                })
            <?php } else { ?>
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                $.ajax({
                    url: '<?= Request::segment(0) ?>/add/order',
                    type: "GET",
                    data: {
                        id_activity: '<?= $course->ID_ACTIVITY ?>',
                        type: 1
                    },
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval
                        $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' + data.IdOrder + '" />')
                        Swal.fire({
                            title: 'Membuat Pesanan!',
                            html: 'Please Wait ...',
                            timer: 2000,
                            timerProgressBar: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#FormBuyNow-info").submit();
                            }
                        })
                    }
                });
            <?php } ?>
        <?php } else { ?>
            Toast.fire({
                icon: 'error',
                title: 'Harap Masuk Terlebih Dulu!'
            })
        <?php } ?>
    }
</script>