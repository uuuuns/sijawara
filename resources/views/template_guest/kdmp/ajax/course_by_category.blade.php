<?php if (!empty($course)) { ?>
    <div class="row mt-md-4">
        <?php foreach ($course as $item) : ?>
            @php
                $check_is_invited = false;
                if ($item->is_invited == 1 && !empty(session('user')) && $item->IS_PUBLIC == 0) {
                    $check_is_invited = true;
                } else if ($item->IS_PUBLIC == 1) {
                    $check_is_invited = true;
                }
            @endphp
            <?php if (session('user') != null && $item->DATA_CHECKING == 1) { ?>
                <!-- VIEW SUDAH BAYAR -->
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="px-0 px-sm-3">
                        <div class="course-grid course-style-4 bg-white px-1 px-md-2 mt-4 pb-2">
                            <div class="course-header">
                                <a <?= $check_is_invited ? 'href="' . url('kursus/detail/' . preg_replace("/[^A-Za-z0-9\-]/", "", str_replace(" ", "-", $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>>
                                    <img src="<?= $item->IMAGE_ACTIVITY ?>" alt="" style="width: 100%; height: 300px; object-fit: cover;">
                                </a>
                            </div>

                            <div class="course-content">
                                <?php if ($item->PROGRESS == 100) { ?>
                                    <span class="course-price bg-success">Selesai</span>
                                <?php } else { ?>
                                    <span class="course-price bg-success">Progress <?= ceil($item->PROGRESS) ?>%</span>
                                <?php } ?>
                                <h3 class="course-title"> <a <?= $check_is_invited ? 'href="' . url('kdmp/detail/' . preg_replace("/[^A-Za-z0-9\-]/", "", str_replace(" ", "-", $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>><?= $item->TITLE_ACTIVITY ?></a></h3>
                            </div>
                            <div class="course-meta">
                                <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important;
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
                                    <a <?= $check_is_invited ? 'href="' . url('kursus/info/' . preg_replace("/[^A-Za-z0-9\-]/", "", str_replace(" ", "-", $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>>
                                        <img src="<?= $item->IMAGE_ACTIVITY ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                </div>
                            </div>

                            <div class="course-content">
                                <span class="course-price <?= ($item->participant == 0) ? 'bg-success' : 'bg-primary' ?>"><?= ($item->participant == 0) ? 'Ayo Segera Ikuti!' : $item->participant . ' Orang' ?></span>
                                <h3 class="course-title">
                                    <a <?= $check_is_invited ? 'href="' . url('kursus/info/' . preg_replace("/[^A-Za-z0-9\-]/", "", str_replace(" ", "-", $item->TITLE_ACTIVITY))) . '?id_activity=' . $item->ID_ACTIVITY . '"' : 'class="link_kursus"' ?>><?= $item->TITLE_ACTIVITY ?></a>
                                </h3>
                            </div>
                            <div class="course-meta">
                                <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important; text-overflow: ellipsis !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
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
            <h3 class="font-sm text-center">Kursus tidak tersedia</h2>

        </div>
    </div>
<?php } ?>

<script>
    $('.link_kursus').click(function() {
        var url = $(this).attr('href');
        Swal.fire({
            title: 'Mohon Maaf',
            text: 'Kursus ini hanya bisa diakses oleh peserta tertentu yang telah diundang',
            icon: 'warning',
            confirmButtonText: 'Oke',
            confirmButtonColor: '#3085d6'
        })
    });
</script>