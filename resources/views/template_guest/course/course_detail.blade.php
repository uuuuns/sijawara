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
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home-tab" aria-selected="true">Overview</a>
                            <a class="nav-item nav-link" id="nav-instructor-tab" data-bs-toggle="tab" href="#nav-instructor" role="tab" aria-controls="nav-instructor-tab" aria-selected="false">Instructor</a>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="single-course-details">
                                <h4 class="course-title">Deskripsi</h4>
                                <p>
                                    <?= (!empty($course->DESKRIPSI_COURSE)) ? $course->DESKRIPSI_COURSE : "Tidak ada deskripsi" ?>
                                </p>
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

                            <div class="tutori-course-curriculum">
                                <div class="curriculum-scrollable">
                                    <ul class="curriculum-sections">
                                        <li class="section">
                                            <ul class="section-content">
                                                <?php if (!empty($item_course)) { ?>
                                                    <?php foreach ($item_course as $item) :  ?>
                                                        <li class="course-item has-status">
                                                            <button class="section-item-link">
                                                                <span class="item-name"> <?= $item->TITLE ?></span>
                                                            </button>
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
                    </div>
                </div>

                <div class="col-lg-5 col-xl-4">
                    <!-- Course Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="course-widget course-details-info">
                            <div class="course-thumbnail">
                                <img src="<?= $course->IMAGE_ACTIVITY ?>" alt="" class="img-fluid w-100" />
                                <div class="my-3 fw-bold d-flex align-self-end justify-content-end pe-0 align-items-center text-black">
                                    Bagikan :
                                    <span class="fs-5">
                                        <a href="{{ url('auth/facebook') }}"><i class="fab fa-facebook mx-2" style="cursor: pointer"></i></a>
                                        <a href="{{ url('auth/twitter') }}"><i class="fab fa-twitter me-2" style="cursor: pointer"></i></a>
                                        <a href="{{ url('auth/instagram') }}"><i class="fab fa-instagram" style="cursor: pointer"></i></a>
                                    </span>
                                </div>
                            </div>

                            <ul class="course-sidebar-list">
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="far fa-sliders-h"></i>Progress</span>
                                        <div class="price-header">
                                            <h2 class="course-price <?= $tot_proggress == 100 ? 'text-success' : 'text-danger' ?>">
                                                <?= ceil($tot_proggress) ?>%
                                            </h2>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-play-circle"></i>Kategori</span>
                                        <?= $course->KATEGORI ?>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-course-tab" data-bs-toggle="tab" href="#nav-course" role="tab" aria-controls="nav-course-tab" aria-selected="true">Kursus</a>
                            <a class="nav-item nav-link" id="nav-announcement-tab" data-bs-toggle="tab" href="#nav-announcement" role="tab" aria-controls="nav-announcement-tab" aria-selected="false">Pengumuman</a>
                            <?php if ($tot_proggress == 100) { ?>
                                <a class="nav-item nav-link" id="nav-sertif-tab" data-bs-toggle="tab" href="#nav-sertif" role="tab" aria-controls="nav-sertif-tab" aria-selected="false">Sertifikat</a>
                            <?php } ?>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                            <div class="row flex-row gap-3">
                                <div class="col-3 mb-4 d-none d-lg-block">
                                    <?php
                                    $quiz = 0;
                                    $materi = 0;
                                    foreach ($item_course as $item) {
                                        if ($item->TYPE <> 2) { ?>
                                            <button class="button <?= ($item->STATUS == 1) ? "btn-main-outline" : "btn-grey" ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>" data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>" onclick="ShowDetailItem(this)" <?= ($item->STATUS == 0) ? "disabled" : "" ?>>
                                                <?= $item->TITLE ?>
                                            </button>
                                        <?php } else { ?>
                                            <button class="button <?= ($item->STATUS == 1) ? "btn-main-outline" : "btn-grey" ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>" data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>" onclick="ShowDetailItem(this)" <?= ($item->STATUS == 0) ? "disabled" : "" ?>>
                                                Kuis <?= ++$quiz ?>
                                            </button>
                                    <?php }
                                    } ?>
                                    <?php
                                    $grade = !empty($nilai->NILAI) ? $nilai->NILAI : 0;
                                    if ($tot_proggress == 100) { ?>
                                        <button class="button btn-main-outline px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100 btn-code" onclick="ShowCertificateCode(this)" data-type="5">
                                            Tampilkan Kode Sertifikat
                                        </button>
                                    <?php } ?>
                                </div>
                                <div class="col bg-white shadow rounded" id="detail-item">
                                    <div class="py-5">
                                        <div class="d-flex justify-content-center">
                                            <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" />
                                        </div>
                                        <div class="d-flex justify-content-center pt-4">
                                            Pilih Materi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab" tabindex="0">
                            <div class="mx-3 mx-lg-7 my-4 text-muted">
                                <?= (!empty($course->PENGUMUMAN)) ? $course->PENGUMUMAN : "Tidak ada pengumuman" ?>
                            </div>
                        </div>
                        <?php
                        if ($tot_proggress == 100) { ?>
                            <div class="tab-pane fade" id="nav-sertif" role="tabpanel" aria-labelledby="nav-sertif-tab" tabindex="0">
                                <?php if ($grade > 75) { ?>
                                    <div class="d-flex justify-content-center">
                                        <div class="blurred-image" style="pointer-events: none">
                                            <embed class="overlay" style="width:600px; height:500px; pointer-events: none;" src="<?= $sertif->FILE_SERTIFIKAT ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0" type="text/plain"></emb>
                                        </div>
                                        <div class="shadow mx-5 mt-3 rounded-4 box-input d-flex align-items-center">
                                            <div class="mx-4 py-3 bg-white">
                                                <label>Kode Sertifikat</label>
                                                <form action="javascript:void(0)">
                                                    <input type="text" class="form-control mb-4" name="" id="input-code">
                                                    <button type="button" class="btn btn-primary col-md-12 my-3" onclick="DownloadPdf(this)">Unduh PDF</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="mx-3 mx-lg-7 my-4 text-muted">
                                        Silakan selesaikan seluruh kursus dan raih skor di atas 75 poin.
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .blurred-image {
        overflow: hidden;
    }

    .overlay {
        -webkit-filter: blur(4px);
        filter: blur(4px);
        width: 450px;
        pointer-events: none;
    }

    .box-input {
        max-height: 250px;
    }
</style>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    CheckingMapping()
    $('#show-detail-' + <?= $last_item[0]->ID_ITEM ?>).trigger('click')

    <?php if ($tot_proggress == 100) { ?>

        function DownloadPdf(e) {
            if ($('#input-code').val() == '<?= $course->SERTIF_CODE ?>') {
                window.open("<?= $sertif->FILE_SERTIFIKAT ?>", '_blank');
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Wrong Code!'
                })
            }
        }

        function filename(path) {
            path = path.substring(path.lastIndexOf("/") + 1);
            return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
        }
    <?php } ?>

    function ShowCertificateCode(e) {
        <?php foreach ($item_course as $item) :  ?>
            $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-main-2')
            $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('btn-main-outline')
        <?php endforeach; ?>
        $(e).removeClass('btn-main-outline')
        $(e).addClass('btn-main-2')
        $("#detail-item").html('<div class="d-flex justify-content-center align-items-center h-100"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>');
        $("#detail-item").html(`<div class="d-flex justify-content-center align-items-center h-100">
                <div class="bg-white px-3 py-2 rounded-3 shadow fw-semibold text-center">
                    <i class="bi bi-file-text me-2" style="font-size: 1.1rem; -webkit-text-stroke: 0.2px;"></i>
                    Your Certificate Code :
                    <h6><?= $course->SERTIF_CODE ?></h6>
                </div>
            </div>`);
    }

    function ShowDetailItem(e) {

        if ($(e).data("type") == 3) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Try Again!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let timerInterval
                    Swal.fire({
                        title: 'Reseting Quiz On Proccess !',
                        html: 'it will be over in a few seconds.',
                        timer: 2000,
                        timerProgressBar: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        GetItemCourse(e)
                        // location.reload()
                    })
                }
            })
        } else {
            if ($(e).data("type") != 4) {
                $('.btn-code').removeClass('btn-main-2')
                $('.btn-code').addClass('btn-main-outline')
                <?php foreach ($item_course as $item) :  ?>
                    $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-main-2')
                    $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('btn-main-outline')
                <?php endforeach; ?>
            }
            GetItemCourse(e)
        }
    }

    function CheckingMapping() {
        <?php foreach ($item_course as $item) :  ?>
            if (<?= $item->STATUS ?> != 1) {
                $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('border-primary')
                $('#show-detail-' + <?= $item->ID_ITEM ?>).addClass('text-disable')
                $('#show-detail-' + <?= $item->ID_ITEM ?>).prop("disabled", true)
            }
        <?php endforeach; ?>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $.ajax({
            url: "<?= Request::segment(0) ?>/course/item/mapping",
            type: "POST",
            data: {
                id_activity: "<?= $id_activity; ?>"
            },
            dataType: 'json',
            success: function(data) {
                $.each(data, function(key, value) {
                    if (value.STATUS == 1) {
                        $('#show-detail-' + value.ID_ITEM).removeClass('text-disable')
                        $('#show-detail-' + value.ID_ITEM).addClass('border-primary')
                        $('#show-detail-' + value.ID_ITEM).prop("disabled", false)
                    }
                });
            }
        });
    }

    function GetItemCourse(e) {
        $(e).removeClass('btn-main-outline');
        $(e).addClass('btn-main-2');
        $("#detail-item").html('<div class="d-flex justify-content-center align-items-center h-100"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>');

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: '<?= Request::segment(0) ?>/course/item',
            type: "POST",
            data: {
                id_item: $(e).data("iditem"),
                type: $(e).data("type"),
                id_activity: "<?= $id_activity; ?>",
                status: $(e).data("status")
            },
            success: function(data) {
                CheckingMapping();
                $("#detail-item").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
                console.error("Response Text: ", jqXHR.responseText);
                $("#detail-item").html('<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>');
            }
        });
    }


    const readmoreText = document.querySelector('.readmore-text');
    const readmoreBtn = document.querySelector('.readmore-btn');
    const icon = document.getElementById('icon-btn');
    const textContent = document.querySelector('.text-btn-content');
    let isExpanded = false;
    const realHeight = readmoreText.clientHeight;
    const defaultHeight = '200px';

    const toggleExpandedState = () => {
        isExpanded = !isExpanded;
        const newHeight = isExpanded ? `${realHeight + 30}px` : defaultHeight;
        const newText = isExpanded ? 'Less Info' : 'More Info';
        const upClass = 'bi-chevron-up';
        const downClass = 'bi-chevron-down';

        readmoreText.style.height = newHeight;
        textContent.innerHTML = newText;
        icon.classList.remove(isExpanded ? downClass : upClass);
        icon.classList.add(isExpanded ? upClass : downClass);
    };

    readmoreText.style.height = defaultHeight;
    readmoreBtn.addEventListener('click', toggleExpandedState);


    // document.addEventListener('contextmenu', event => event.preventDefault());
    // document.onkeydown = (e) => {
    //     if (e.key == 123) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.key == 'I') {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.key == 'C') {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.key == 'J') {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.key == 'u') {
    //         return false;
    //     }
    // }
</script>