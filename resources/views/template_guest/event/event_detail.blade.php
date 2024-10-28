<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="page-wrapper">
    <div class="tutori-course-content">
        <div class="container">
            <?php if ($event->EXPIRED == 1) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <h5 class="py-2">Webinar telah dilaksanakan</h5>
            </div>
            <?php } ?>
            <div class="row pt-3">
                <div class="col-lg-5">
                    <!-- event Sidebar start -->
                    <div class="course-sidebar course-sidebar-2 mt-5 mt-lg-0">
                        <div class="">
                            <div class="course-thumbnail d-flex justify-content-center">
                                <div class="pe-0 pe-sm-5 rounded-1">
                                    <img src="<?= $event->IMAGE_ACTIVITY ?>" class="d-block img-fluid h-auto ">
                                </div>
                            </div>

                            <div class="container">
                                <?php if ($event->DATA_CHECKING == 0 && $event->EXPIRED != 1) : ?>
                                @if ($is_full == false)
                                    <div class="">
                                        <form class="" id="FormBuyNow-info" method="POST"
                                            action="<?= url('event/add') ?>">
                                            @csrf
                                            <div id="data-input-info"></div>
                                            <input type="hidden" name="id_event" value="<?= $event->ID_ACTIVITY ?>">
                                            <button type="submit">Ambil Sekarang</button>
                                        </form>
                                    </div>
                                @endif
                                @if ($is_full == true && is_null($event->DATA_CHECKING))
                                    <span class="bg-warning text-dark" disable> Mohon Maaf Kuota Penuh </span>
                                @endif
                                <?php endif ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7 ps-3">
                    <div class="course-header-wrapper">

                        <div>
                            <h2 class="course-title bg-white">
                                <?= $event->TITLE_ACTIVITY ?>
                            </h2>
                        </div>
                    </div>
                    <nav class="course-single-tabs learn-press-nav-tabs">
                        <div class="nav nav-tabs course-nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home-tab" aria-selected="true">Ringkasan</a>
                            <a class="nav-item nav-link" id="nav-instructor-tab" data-bs-toggle="tab"
                                href="#nav-instructor" role="tab" aria-controls="nav-instructor-tab"
                                aria-selected="false">Deskripsi</a>
                            <?php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) : ?>
                            <a class="nav-item nav-link" id="nav-link-tab" data-bs-toggle="tab" href="#nav-link"
                                role="tab" aria-controls="nav-link-tab" aria-selected="false">Link Konferensi</a>
                            @if (!is_null($event->SERTIF_CODE))
                                <a class="nav-item nav-link" id="nav-certificate-tab" data-bs-toggle="tab"
                                    href="#nav-certificate" role="tab" aria-controls="nav-certificate-tab"
                                    aria-selected="false">Sertifikat</a>
                            @endif
                            <?php endif ?>

                        </div>
                    </nav>

                    <div class="tab-content tutori-course-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="single-course-details">
                                <h4 class="event-title mb-0">Tempat</h4>
                                <p>
                                    <?= $event->LOCATION ? $event->LOCATION : '-' ?>
                                </p>

                                <h4 class="course-title mb-0">Tanggal</h4>
                                <p><?= date_format(date_create($event->DATE_START), 'j F Y') ?></p>

                                <h4 class="course-title mb-0">Waktu</h4>
                                <p><?= date_format(date_create($event->DATE_START), 'H:i') ?></p>

                                <h4 class="course-title mb-0">Penyelenggara</h4>
                                <p>
                                    <?= $event->ORGANIZER ?>
                                </p>

                                <h4 class="course-title mb-0">Narahubung</h4>
                                <p>
                                    <?= $event->CONTACT_CUSTOMER ?>
                                </p>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-instructor" role="tabpanel"
                            aria-labelledby="nav-instructor-tab">
                            <div class="courses-instructor">
                                <div class="single-instructor-box">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="instructor-content">
                                                <?= $event->DESKRIPSI_EVENT != null || $event->DESKRIPSI_EVENT != '' ? $event->DESKRIPSI_EVENT : 'Tidak Ada Deskripsi' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) : ?>
                        <div class="tab-pane fade" id="nav-link" role="tabpanel" aria-labelledby="nav-link-tab">
                            <div class="courses-instructor">
                                <div class="single-instructor-box">
                                    <div class="row align-items-center">

                                        <div class="col-12">
                                            <div class="instructor-content">
                                                <a class="pe-4"
                                                    href="<?= $event->LINK_ZOOM != null || $event->LINK_ZOOM != '' ? $event->LINK_ZOOM : '#' ?>"
                                                    style="color: #000EFF; word-wrap: break-word;">
                                                    <?= $event->LINK_ZOOM != null || $event->LINK_ZOOM != '' ? $event->LINK_ZOOM : 'Tidak Ada Link' ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="upload-file">
                                                <h4 class="event-title mmb-0 mt-5">Upload File</h4>
                                                <small class="text-danger">* Hanya bisa mengumpulkan sekali, konfirmasi
                                                    sebelum mengumpulkan</small>
                                                <?php if (empty($materi_file)) { ?>
                                                <form action="{{ url('event/upload_file') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div id="file-upload-container">
                                                        <!-- Input file pertama -->
                                                        <div
                                                            class="file-input-wrapper mb-2 d-flex justify-content-between align-items-center">
                                                            <input type="hidden" name="id_activity"
                                                                value="{{ $event->ID_ACTIVITY }}">
                                                            <input type="hidden" name="id_user"
                                                                value="{{ session('user')[0]['ID_USER'] }}">
                                                            <input type="file" name="file_materi[]" accept=".pdf"
                                                                data-allowed-file-extensions="pdf"
                                                                class="form-control d-inline-block">
                                                            <button class="btn btn-danger btn-sm remove-file-btn"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                    <!-- Tombol untuk menambah input file -->
                                                    <button type="button" id="add-file-btn"
                                                        class="btn btn-primary mt-2">Tambah File</button>
                                                    <button type="submit"
                                                        class="btn btn-success mt-2">Submit</button>
                                                </form>
                                                <?php } else { ?>
                                                <label class="alert alert-success">Sudah Mengupload</label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-certificate" role="tabpanel"
                            aria-labelledby="nav-certificate-tab">
                            <div class="courses-instructor">
                                <div class="single-instructor-box">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="instructor-content">
                                                {{-- <?php if (date('Y-m-d h:i:s') > $event->DATE_END) { ?> --}}
                                                <div class="blurred-image d-none d-lg-block"
                                                    style="pointer-events: none">
                                                    <embed class="overlay"
                                                        style="width:200px; height:352px; pointer-events: none;"
                                                        src="<?= $sertif->FILE_SERTIFIKAT ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0"
                                                        type="text/plain"></embed>
                                                </div>
                                                <div class="mt-3 rounded-4 d-flex align-items-center">
                                                    <div class="mx-4 py-3 bg-white">
                                                        <label>Kode Sertifikat</label>
                                                        <input type="text" class="form-control mb-4"
                                                            name="" id="input-code">
                                                        <button type="button" class="btn btn-primary col-md-12 my-3"
                                                            onclick="DownloadPdf(this)">Unduh PDF</button>
                                                    </div>
                                                </div>
                                                {{-- <?php } else if (date('Y-m-d h:i:s') < $event->DATE_START) { ?>
                                                <h4 class="event-title mb-0">Event belum dimulai</h4>
                                                <?php } else { ?>
                                                <h4 class="event-title mb-0">Event sedang berlangsung</h4>
                                                <?php } ?> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pt-4">
            <hr class="mt-4" />

            <div class="course-latest">
                <h4 class="mb-4">Event Lainnya</h4>
                <div class="row course-gallery ">
                    <?php foreach ($other_event as $item) : ?>
                    <div class="course-item cat1 cat5 col-lg-6 col-md-6">
                        <div class="px-0 px-sm-3">
                            <div class="single-course style-2 bg-shade border-0">
                                <div class="row g-0 align-items-center">
                                    <div class="col-xl-5">
                                        <div class="course-thumb"
                                            style="min-height: 150px !important;background:url(<?= str_replace(' ', '%20', $item->IMAGE_ACTIVITY) ?>)">
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="course-content">
                                            <div class="course-price">
                                                <?= date_format(date_create($item->LOG_TIME), 'j F Y') ?></div>
                                            <h3 class="course-title"> <a
                                                    href="<?= 'event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY ?>"><?= $item->TITLE_ACTIVITY ?>
                                                </a> </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
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

    $(document).ready(function() {
        $('#add-file-btn').click(function() {
            // Create a new file input wrapper
            const newFileInput = `
                <div class="file-input-wrapper mb-2 d-flex justify-content-between align-items-center">
                    <input type="hidden" name="id_activity" value="{{ $event->ID_ACTIVITY }}">
                    <input type="hidden" name="id_user" value="{{ session('user')[0]['ID_USER'] }}">
                    <input type="file" name="file_materi[]" accept=".pdf" data-allowed-file-extensions="pdf" class="form-control d-inline-block">
                    <button class="btn btn-danger btn-sm remove-file-btn" type="button">X</button>
                </div>
            `;

            // Append the new file input to the container
            $('#file-upload-container').append(newFileInput);
        });

        // Event delegation for removing file inputs
        $('#file-upload-container').on('click', '.remove-file-btn', function() {
            $(this).closest('.file-input-wrapper').remove();
        });
    });

    $('#FormBuyNow-info').submit(function(e) {
        @if (empty(session('user')))
            e.preventDefault();
            Toast.fire({
                icon: 'error',
                title: 'Harap Masuk Terlebih dulu!'
            });
        @endif
    });

    function DownloadPdf(e) {
        if ($('#input-code').val() == '<?= $event->SERTIF_CODE ?>') {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            let file = <?= json_encode(empty($sertif->FILE_SERTIFIKAT) ? null : $sertif->FILE_SERTIFIKAT) ?>

            $.ajax({
                url: '<?= Request::segment(0) ?>/update-sertif',
                type: "POST",
                data: {
                    id_activity: "<?= $event->ID_ACTIVITY ?>",
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
                                window.location.href = '<?= Request::segment(0) ?>/profile';
                            }
                        });
                    } else {
                        window.open(file, '_blank');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: ", textStatus, errorThrown);
                    console.error("Response Text: ", jqXHR.responseText);
                }
            });
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Wrong Code!'
            })
        }
    }

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
            },
            didDestroy: (toast) => {
                location.reload();
            }
        })
        <?php if (!empty(session('user'))) { ?>
        $.ajax({
            url: '<?= Request::segment(0) ?>/add/order',
            type: "GET",
            data: {
                id_activity: $(e).data("id-activity"),
                type: 2
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
            title: 'Harap Masuk Terlebih dulu!'
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
            title: 'Anda mempunyai transaksi yang belum selesai!'
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
                id_activity: '<?= $event->ID_ACTIVITY ?>',
                type: 2
            },
            dataType: 'json',
            success: function(data) {
                let timerInterval
                $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' +
                    data.IdOrder + '" />')
                Swal.fire({
                    title: 'Create Order!',
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
            title: 'Harap Masuk Terlebih dulu!'
        })
        <?php } ?>
    }
    <?php if (!empty(session('user')) && $event->DATA_CHECKING <> 0) { ?>


    function filename(path) {
        path = path.substring(path.lastIndexOf("/") + 1);
        return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
    }
    <?php } ?>
</script>
