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
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home-tab" aria-selected="true">Ringkasan</a>
                            <a class="nav-item nav-link" id="nav-benefit-tab" data-bs-toggle="tab" href="#nav-benefit"
                                role="tab" aria-controls="nav-benefit-tab" aria-selected="false">Benefit</a>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="single-course-details pe-lg-3 pe-0">
                                <h4 class="course-title">Deskripsi</h4>
                                <p>
                                    <?= !empty($course->DESKRIPSI_COURSE) ? $course->DESKRIPSI_COURSE : 'Tidak ada deskripsi' ?>
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-benefit" role="tabpanel" aria-labelledby="nav-benefit-tab">
                            <!-- Course benefit start -->
                            <div class="courses-benefit">
                                <div class="single-benefit-box">
                                    <div class="row align-items-center">

                                        <div class="col-lg-8 col-md-8">
                                            <div class="benefit-content">
                                                <h4><?= $course->BENEFIT ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Conurse  benefit end -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-xl-4">
                    <!-- Course Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="course-widget course-details-info">
                            <div class="course-thumbnail">
                                <img src="<?= $course->IMAGE_ACTIVITY ?>" alt="" class="img-fluid w-100" />
                            </div>

                            <ul class="course-sidebar-list">
                                <li>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="far fa-sliders-h"></i>Progress</span>
                                        <div class="price-header">
                                            <h2
                                                class="course-price <?= $tot_proggress == 100 ? 'text-success' : 'text-danger' ?>">
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
                            <a class="nav-item nav-link active" id="nav-course-tab" data-bs-toggle="tab"
                                href="#nav-course" role="tab" aria-controls="nav-course-tab"
                                aria-selected="true">Kursus</a>
                            <!-- <a class="nav-item nav-link" id="nav-announcement-tab" data-bs-toggle="tab" href="#nav-announcement" role="tab" aria-controls="nav-announcement-tab" aria-selected="false">Pengumuman</a> -->
                            <?php if ($tot_proggress == 100) { ?>
                            <a class="nav-item nav-link" id="nav-survei-tab" data-bs-toggle="tab" href="#nav-survei"
                                role="tab" aria-controls="nav-survei-tab" aria-selected="false">Survei</a>
                            <a class="nav-item nav-link" id="nav-sertif-tab" data-bs-toggle="tab" href="#nav-sertif"
                                role="tab" aria-controls="nav-sertif-tab" aria-selected="false">Sertifikat</a>
                            <a class="nav-item nav-link" id="nav-komen-tab" data-bs-toggle="tab" href="#nav-komen"
                                role="tab" aria-controls="nav-komen-tab" aria-selected="false">Komentar</a>
                            <?php } ?>
                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-course" role="tabpanel"
                            aria-labelledby="nav-course-tab" tabindex="0">
                            <div class="flex-column flex-md-row gap-3 row">
                                <div class="d-grid d-md-flex justify-content-md-end">
                                    <button id="refreshPageBtn" type="button" class="btn btn-danger rounded"
                                        style="padding: 5px !important;">Refresh</button>
                                </div>
                                <div class="col-12 col-md-3 mb-4">
                                    <?php
                                    $quiz = 0;
                                    $materi = 0;
                                    foreach ($item_course as $item) {
                                        if ($item->TYPE <> 2) { ?>
                                    <button
                                        class="button <?= $item->STATUS == 1 ? 'btn-main-outline' : 'btn-grey' ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100"
                                        id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>"
                                        data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>"
                                        onclick="ShowDetailItem(this)" <?= $item->STATUS == 0 ? 'disabled' : '' ?>>
                                        <?= $item->TITLE ?>
                                    </button>
                                    <?php } else { ?>
                                    <button
                                        class="button <?= $item->STATUS == 1 ? 'btn-main-outline' : 'btn-grey' ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100"
                                        id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>"
                                        data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>"
                                        onclick="ShowDetailItem(this)" <?= $item->STATUS == 0 ? 'disabled' : '' ?>>
                                        Kuis <?= ++$quiz ?>
                                    </button>
                                    <?php }
                                    } ?>
                                    <?php
                                    $grade = !empty($nilai->NILAI) ? $nilai->NILAI : 0;
                                    if ($tot_proggress == 100) { ?>
                                    <button
                                        class="button btn-main-outline px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100 btn-code"
                                        id="certif-buttn" onclick="ShowCertificateCode(this)" data-type="5">
                                        Tampilkan Kode Sertifikat
                                    </button>
                                    <?php } ?>
                                </div>
                                <div class="col bg-white shadow rounded" id="detail-item">
                                    <div class="py-5">
                                        <div class="d-flex justify-content-center py-4">
                                            <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif"
                                                alt="Loader.gif" />
                                        </div>
                                        <div class="d-flex justify-content-center pt-4">
                                            Pilih Materi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab" tabindex="0">
                            <div class="mx-3 mx-lg-7 my-4 text-muted">
                                <?= !empty($course->PENGUMUMAN) ? $course->PENGUMUMAN : 'Tidak ada pengumuman' ?>
                            </div>
                        </div> -->
                        <?php
                        if ($tot_proggress == 100) { ?>
                        <div class="tab-pane fade" id="nav-survei" role="tabpanel" aria-labelledby="nav-survei-tab"
                            tabindex="0">
                            <div style="display: flex; justify-content: center; width: 100%;">
                                <form action="{{ url('kursus/detail/addsurvei') }}" method="POST"
                                    style="width: 100%; max-width: 800px;">
                                    @csrf
                                    <input type="hidden" name="id_activity" value="{{ $id_activity }}">
                                    <input type="hidden" name="id_user" value="{{ session('user')[0]['ID_USER'] }}">
                                    <div
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); margin: 1rem auto; border-radius: 0.5rem; padding: 1rem; display: flex; flex-direction: column; align-items: center;">

                                        @foreach ($survei as $item)
                                            @php
                                                $prev = $checking_survei[$item->ID_SURVEI] ?? null; // jawaban sebelumnya jika ada
                                                $disabled = $checking_survei ? 'disabled' : '';
                                            @endphp

                                            <div style="width: 100%; padding: 1rem; border-bottom:1px solid #eee;">
                                                <label class="fw-bold mb-2">
                                                    {{ $loop->iteration }}. {{ $item->TEXT }}
                                                </label>

                                                <style>
                                                    .rating-box {
                                                        cursor: pointer;
                                                    }

                                                    .rating-box span {
                                                        display: inline-block;
                                                        padding: 10px 14px;
                                                        border: 1px solid #ccc;
                                                        border-radius: 6px;
                                                        min-width: 40px;
                                                        text-align: center;
                                                        transition: all 0.2s;
                                                    }

                                                    .rating-box:hover span {
                                                        background-color: #f0f0f0;
                                                    }

                                                    .rating-box input:checked+span,
                                                    .rating-box span.active {
                                                        background-color: #45b104;
                                                        color: #fff;
                                                        border-color: #45b104;
                                                    }
                                                </style>

                                                {{-- ================= RATING ================= --}}
                                                @if ($item->KATEGORI == 'rating')
                                                    @php $prevRating = $checking_survei[$item->ID_SURVEI]['rating'] ?? null; @endphp
                                                    <div class="d-flex flex-wrap gap-2 mt-2 rating-group"
                                                        data-id="{{ $item->ID_SURVEI }}">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <label class="rating-box">
                                                                <input type="radio"
                                                                    name="rating[{{ $item->ID_SURVEI }}]"
                                                                    value="{{ $i }}" hidden
                                                                    @if ($prevRating == $i) checked @endif>
                                                                <span
                                                                    @if ($prevRating == $i) class="active" @endif>{{ $i }}</span>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                @endif

                                                {{-- ================= CHECKBOX ================= --}}
                                                @if ($item->KATEGORI == 'checkbox')
                                                    @php $prevCheckbox = $checking_survei[$item->ID_SURVEI]['checkbox'] ?? []; @endphp
                                                    <div class="mt-2">
                                                        @foreach ($item->checkbox as $c)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="checkbox[{{ $item->ID_SURVEI }}][]"
                                                                    value="{{ $c->ID_CHECKBOX }}"
                                                                    @if (in_array($c->ID_CHECKBOX, $prevCheckbox)) checked @endif>
                                                                <label
                                                                    class="form-check-label">{{ $c->VALUE }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                {{-- ================= KOMENTAR ================= --}}
                                                @if ($item->KATEGORI == 'komentar')
                                                    @php $prevKomentar = $checking_survei[$item->ID_SURVEI]['komentar'] ?? ''; @endphp
                                                    <div class="mt-2">
                                                        <textarea name="komentar[{{ $item->ID_SURVEI }}]" class="form-control" rows="4" style="resize:none;"
                                                            required>{{ $prevKomentar }}</textarea>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        <div style="display: flex; justify-content: flex-end; padding:1rem;">
                                            @if (!$checking_survei)
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                            @else
                                                <div style="color: green; font-weight: bold; padding:0.5rem;">Anda
                                                    sudah mengisi survei ini.</div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-sertif" role="tabpanel" aria-labelledby="nav-sertif-tab"
                            tabindex="0">
                            <div class="d-flex justify-content-center">
                                <div class="blurred-image d-none d-lg-block" style="pointer-events: none">
                                    <embed class="overlay" style="width:600px; height:500px; pointer-events: none;"
                                        src="<?= $sertif->FILE_SERTIFIKAT ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0"
                                        type="text/plain"></emb>
                                </div>
                                <div class="shadow mx-5 mt-3 rounded-4 box-input d-flex align-items-center"
                                    id="certif-box">
                                    <div class="mx-4 py-3 bg-white">
                                        <label>Kode Sertifikat</label>
                                        <form action="javascript:void(0)">
                                            <input type="text" class="form-control mb-4" name=""
                                                id="input-code" style="text-transform:uppercase">
                                            <button type="button" id="downloadSertif"
                                                class="btn btn-primary rounded col-md-12 my-3"
                                                onclick="DownloadPdf(this)">
                                                <span class="loading">
                                                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                                                </span> Unduh PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-komen" role="tabpanel" aria-labelledby="nav-komen-tab"
                            tabindex="0">
                            <div style="display: flex; justify-content: center; width: 100%;">
                                <form action="{{ url('kdmp/detail/addkomen') }}" method="POST"
                                    style="width: 100%; max-width: 800px;">
                                    @csrf
                                    <input type="hidden" name="id_activity" value="<?= $id_activity ?>">
                                    <input type="hidden" name="id_user"
                                        value="<?= session('user')[0]['ID_USER'] ?>">
                                    <div
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); margin: 1rem auto; border-radius: 0.5rem; padding: 1rem; display: flex; flex-direction: column; align-items: center;">
                                        <div style="width: 100%; padding: 1rem;">
                                            <label for="komentar">Komentar</label>
                                            <textarea class="form-control mb-4" rows="4" name="komentar" id="komentar" required style="width: 100%;"></textarea>
                                            <div style="display: flex; justify-content: flex-end;">
                                                <button type="submit" class="btn btn-primary"
                                                    style="width: 20%;">Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="container my-2 py-2">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-lg-10">
                                        <div class="card text-body">
                                            @foreach ($komentar as $item)
                                                <div class="card-body p-4">
                                                    <div class="d-flex flex-start">
                                                        <img class="rounded-circle shadow-1-strong me-3"
                                                            src="<?= $item->FOTO_PROFILE == null ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973461_1280.png' : $item->FOTO_PROFILE ?>"
                                                            alt="avatar" width="60" height="60" />
                                                        <div>
                                                            <h6 class="fw-bold mb-1"><?= $item->NAME ?></h6>
                                                            <div class="d-flex align-items-center mb-3">
                                                                <p class="mb-0">
                                                                    <?= date('F d, Y', strtotime($item->LOG_TIME)) ?>
                                                                </p>
                                                            </div>
                                                            <p class="mb-0">
                                                                <?= $item->komentar ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-0" />
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    document.querySelectorAll('.rating-group').forEach(group => {
        group.querySelectorAll('.rating-box').forEach(box => {
            box.addEventListener('click', function() {
                group.querySelectorAll('.rating-box span').forEach(el => {
                    el.classList.remove('active')
                })

                this.querySelector('span').classList.add('active')
            })
        })
    })

    $('#refreshPageBtn').click(function() {
        // Reload the page
        location.reload();
    });
    $('.loading').hide();

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
        $('#downloadSertif').prop('disabled', true);
        $('.loading').show();
        if ($('#input-code').val() == '<?= $course->SERTIF_CODE ?>') {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $.ajax({
                url: '<?= Request::segment(0) ?>/update-sertif',
                type: "POST",
                data: {
                    id_activity: "<?= $id_activity ?>",
                },
                success: function(data) {
                    if (data.code == 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: data.message,
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Lengkapi Data',
                            cancelButtonText: 'Nanti'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= Request::segment(0) ?>/profil';
                            }
                        });
                        $('#downloadSertif').prop('disabled', false);
                        $('.loading').hide();
                    } else {
                        window.open('<?= $sertif->FILE_SERTIFIKAT ?>', '_blank');
                        $('#downloadSertif').prop('disabled', false);
                        $('.loading').hide();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: ", textStatus, errorThrown);
                    console.error("Response Text: ", jqXHR.responseText);
                    $('#downloadSertif').prop('disabled', false);
                    $('.loading').hide();
                }
            });
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Wrong Code!'
            })
            $('#downloadSertif').prop('disabled', false);
            $('.loading').hide();
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
        $("#detail-item").html(
            '<div class="d-flex justify-content-center align-items-center h-100 py-4"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>'
        );
        $("#detail-item").html(`<div class="d-flex justify-content-center align-items-center h-100 py-4">
                <div class="bg-white px-3 py-2 rounded-3 shadow fw-semibold text-center" id="code-sertif">
                    <i class="bi bi-file-text me-2" style="font-size: 1.1rem; -webkit-text-stroke: 0.2px;"></i>
                    Your Certificate Code :
                    <h6><?= $course->SERTIF_CODE ?></h6>
                </div>
            </div>`);
    }

    function ShowDetailItem(e) {

        if ($(e).data("type") == 3) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "anda tidak dapat membatalkan hal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Coba lagi!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let timerInterval
                    Swal.fire({
                        title: 'Mengulangi Kuis dalam proses!',
                        html: 'Harap tunggu!',
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

            if ($(e).data("nilai") >= 75 && ($(e).data("iditem") == $(e).data("iditemmax"))) {
                location.reload()
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
            url: "<?= Request::segment(0) ?>/kdmp/item/mapping",
            type: "POST",
            data: {
                id_activity: "<?= $id_activity ?>"
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
        $("#detail-item").html(
            '<div class="d-flex justify-content-center align-items-center h-100 py-4"><img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" /></div>'
        );

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: '<?= Request::segment(0) ?>/kdmp/item',
            type: "POST",
            data: {
                id_item: $(e).data("iditem"),
                type: $(e).data("type"),
                id_activity: "<?= $id_activity ?>",
                status: $(e).data("status")
            },
            success: function(data) {
                CheckingMapping();
                $("#detail-item").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
                console.error("Response Text: ", jqXHR.responseText);
                $("#detail-item").html(
                    '<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>'
                );
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
</script>


<script>
    <?php if ($tot_proggress == 100) { ?>
    document.addEventListener('DOMContentLoaded', function() {
        window.scrollTo(0, 0);
        $("#certif-buttn").click()

        const intro = introJs();

        intro.setOptions({
            steps: [{
                    title: "Congratulations",
                    intro: "Selamat telah menyelesaikan kursus, berikut panduan untuk mendapat sertifikat anda"
                },
                {
                    element: document.getElementById('certif-buttn'),
                    intro: "Anda bisa menuju ke tampilkan sertifikat",
                    tooltipPosition: "bottom-center"
                }, {
                    element: document.getElementById('code-sertif'),
                    intro: "Copy kode sertifikat anda"
                }, {
                    element: document.getElementById('nav-sertif-tab'),
                    intro: "Kemudian masuk ke bagian sertifikat"
                }, {
                    element: document.getElementById('certif-box'),
                    intro: "Masukkan kode sebelumnya dan unduh pdf"
                }
            ]
        }).setOptions({
            showBullets: false,
            scrollToElement: false,
            exitOnOverlayClick: false,
        })

        intro.onbeforechange(function(targetElement) {
            let width = $(window).width();

            if (width > 991) {
                if (this._currentStep == 1) {
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top - (
                            97)) + 'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top - (
                            97)) + 'px !important;';
                    });
                    intro.refresh()
                    $("#certif-buttn").click()
                } else if (this._currentStep == 2) {
                    $("#certif-buttn").click()

                    $(".introjs-helperLayer").css('height', '').attr('style', function(i, style) {
                        return (style || '') + 'height: ' + ($("#code-sertif").outerHeight(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('width', '').attr('style', function(i, style) {
                        return (style || '') + 'width: ' + ($("#code-sertif").outerWidth(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('left', '').attr('style', function(i, style) {
                        return (style || '') + 'left: ' + ($("#code-sertif").offset().left) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($("#code-sertif").offset().top) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('left', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'left: ' + ($("#code-sertif").offset().left) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($("#code-sertif").offset().top + $(
                            "#code-sertif").outerHeight(true)) + 'px !important;';
                    });
                    intro.refresh()
                } else if (this._currentStep == 3) {
                    intro.refresh()
                    window.scrollTo(0, $(targetElement).offset().top - 250);

                    $(".introjs-helperLayer").css('height', '').attr('style', function(i, style) {
                        return (style || '') + 'height: ' + ($(targetElement).outerHeight(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('width', '').attr('style', function(i, style) {
                        return (style || '') + 'width: ' + ($(targetElement).outerWidth(true)) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('left', '').attr('style', function(i, style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('left', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    intro.refresh()

                    $('#nav-sertif-tab').tab('show')

                } else if (this._currentStep == 4) {
                    intro.refresh()
                    $(".introjs-helperLayer").css('height', '').attr('style', function(i, style) {
                        return (style || '') + 'height: ' + ($(targetElement).outerHeight(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('width', '').attr('style', function(i, style) {
                        return (style || '') + 'width: ' + ($(targetElement).innerWidth(true)) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('left', '').attr('style', function(i, style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left -
                            10) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('left', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top + 20) +
                            'px !important;';
                    });
                    intro.refresh()
                }
            } else {
                if (this._currentStep == 1) {
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top - (
                            87)) + 'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top - (
                            87)) + 'px !important;';
                    });
                    intro.refresh()
                    $("#certif-buttn").click()
                } else if (this._currentStep == 2) {
                    $("#certif-buttn").click()

                    $(".introjs-helperLayer").css('height', '').attr('style', function(i, style) {
                        return (style || '') + 'height: ' + ($("#code-sertif").outerHeight(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('width', '').attr('style', function(i, style) {
                        return (style || '') + 'width: ' + ($("#code-sertif").outerWidth(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('left', '').attr('style', function(i, style) {
                        return (style || '') + 'left: ' + ($("#code-sertif").offset().left) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($("#code-sertif").offset().top) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('left', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'left: ' + ($("#code-sertif").offset().left) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($("#code-sertif").offset().top + $(
                            "#code-sertif").outerHeight(true)) + 'px !important;';
                    });
                    intro.refresh()
                } else if (this._currentStep == 3) {

                    $(".introjs-helperLayer").css('height', '').attr('style', function(i, style) {
                        return (style || '') + 'height: ' + ($(targetElement).outerHeight(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('width', '').attr('style', function(i, style) {
                        return (style || '') + 'width: ' + ($(targetElement).outerWidth(true)) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('left', '').attr('style', function(i, style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('left', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    intro.refresh()

                    $('#nav-sertif-tab').tab('show')
                    window.scrollTo(0, $(targetElement).offset().top - 300);


                } else if (this._currentStep == 4) {
                    intro.refresh()
                    window.scrollTo(0, $(targetElement).offset().top - 250);

                    $(".introjs-helperLayer").css('height', '').attr('style', function(i, style) {
                        return (style || '') + 'height: ' + ($(targetElement).outerHeight(
                            true)) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('width', '').attr('style', function(i, style) {
                        return (style || '') + 'width: ' + ($(targetElement).innerWidth(true)) +
                            'px !important;';
                    });
                    $(".introjs-helperLayer").css('left', '').attr('style', function(i, style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left -
                            10) + 'px !important;';
                    });
                    $(".introjs-helperLayer").css('top', '').attr('style', function(i, style) {
                        return (style || '') + 'top: ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('left', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'left: ' + ($(targetElement).offset().left) +
                            'px !important;';
                    });
                    $(".introjs-tooltipReferenceLayer").css('top', '').attr('style', function(i,
                        style) {
                        return (style || '') + 'top:  ' + ($(targetElement).offset().top) +
                            'px !important;';
                    });
                    intro.refresh()
                }
            }
        });
        window.scrollTo(0, 0);

        function showIntroIfNeeded(userId) {
            if (!localStorage.getItem(`intro_course_${userId}`)) {
                if ($(window).scrollTop() === 0) {

                    intro.start()
                    intro.oncomplete(() => {
                        localStorage.setItem(`intro_course_${userId}`, "true")
                    })
                    intro.onexit(() => {
                        localStorage.setItem(`intro_course_${userId}`, "true")
                    })
                } else {
                    $(window).on('scroll', function checkScroll() {
                        if ($(window).scrollTop() === 0) {
                            intro.start()
                            intro.oncomplete(() => {
                                localStorage.setItem(`intro_course_${userId}`, "true")
                            })
                            intro.onexit(() => {
                                localStorage.setItem(`intro_course_${userId}`, "true")
                            })

                            $(window).off('scroll', checkScroll)
                        }
                    });
                }

                localStorage.setItem(`intro_course_${userId}`, 'true')
            }
        }

        function onLogin(userId) {
            showIntroIfNeeded(userId)
        }

        onLogin('<?= session('user')[0]['ID_USER'] ?>')
    });

    <?php } ?>
</script>
