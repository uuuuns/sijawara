<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <h5 class="py-2 fw-semibold">Course</h5>
    <hr class="opacity-25">
    <div class="row mt-5 flex-column-reverse flex-lg-row">
        <div class="col-12 col-lg-6">
            <div class="d-flex flex-column flex-lg-row px-lg-0 ps-lg-3 px-3 justify-content-between align-items-lg-center align-items-start">
                <div class="d-flex flex-row align-items-center gap-2 h-100">
                    <?php if ($tot_proggress == 100) { ?>
                        <p class="fw-semibold fs-5 m-0">Done</p>
                        <i class="bi bi-check-circle-fill text-success" style="font-size:24px; margin-top:2px"></i>
                    <?php } else { ?>
                        <p class="fw-semibold fs-5 m-0">Progress <?= ceil($tot_proggress) ?>%</p>
                    <?php } ?>
                </div>
                <div>
                    <span class="fw-bold">Kategori</span> : <?= $course->KATEGORI ?>
                </div>
            </div>
            <div class="px-3 py-3 readmore position-relative">
                <span class="fw-semibold fs-3"><?= $course->TITLE_ACTIVITY ?></span>
                <div class="text-muted m-0 pt-2 fs-6 readmore-text" style="overflow:hidden">
                    <?= (!empty($course->DESKRIPSI_COURSE)) ? $course->DESKRIPSI_COURSE : "Tidak ada deskripsi" ?>
                </div>
                <span class="readmore-btn position-absolute w-100 fw-semibold justify-content-center align-items-end d-flex" style="background: linear-gradient( to bottom, transparent, white 60%); height:70px; margin-left:-1rem; margin-top:-4rem">
                    <div class="w-100 text-center " style="cursor:pointer;">
                        <span class="text-btn-content">
                            More Info
                        </span>
                        <i id="icon-btn" class="bi bi-chevron-down" style="font-size: 1rem;-webkit-text-stroke: 1px;margin-left:0.4rem;"></i>
                    </div>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-flex justify-content-end ps-0 ps-lg-4">
                <img src="<?= $course->IMAGE_ACTIVITY ?>" class="d-block img-fluid rounded-5" width="380">
            </div>
            <div class="my-3 fw-bold d-flex justify-content-start justify-content-lg-end align-items-center me-2 text-black">
                Share :<span class="fs-5"> <i class="fab fa-facebook mx-2" style="cursor: pointer"></i><i class="fab fa-twitter me-2" style="cursor: pointer"></i><i class="fab fa-instagram" style="cursor: pointer"></i></span>
            </div>
        </div>
    </div>
    <div class="row project-tab">
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active border-0 col col-lg-2 fs-5" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">Course</button>
                    <button class="nav-link border-0 col col-lg-2 fs-5" id="nav-announcement-tab" data-bs-toggle="tab" data-bs-target="#nav-announcement" type="button" role="tab" aria-controls="nav-announcement" aria-selected="false">Announcement</button>

                    <?php if ($tot_proggress == 100) { ?>
                        <button class="nav-link border-0 col col-lg-2 fs-5" id="nav-sertif-tab" data-bs-toggle="tab" data-bs-target="#nav-sertif" type="button" role="tab" aria-controls="nav-sertif" aria-selected="false">Certificate</button>
                    <?php } ?>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                    <div class="row flex-row gap-3">
                        <div class="col-3 my-4 d-none d-lg-block">
                            <?php
                            $quiz = 0;
                            $materi = 0;
                            foreach ($item_course as $item) {
                                if ($item->TYPE <> 2) { ?>
                                    <button class="btn <?= ($item->STATUS == 1) ? "border-primary" : "text-disable" ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>" data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>" onclick="ShowDetailItem(this)" <?= ($item->STATUS == 0) ? "disabled" : "" ?>>
                                        <?= $item->TITLE ?>
                                    </button>
                                <?php } else { ?>
                                    <button class="btn <?= ($item->STATUS == 1) ? "border-primary" : "text-disable" ?> px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="show-detail-<?= $item->ID_ITEM ?>" data-status="<?= $item->STATUS ?>" data-iditem="<?= $item->ID_ITEM ?>" data-type="<?= $item->TYPE ?>" onclick="ShowDetailItem(this)" <?= ($item->STATUS == 0) ? "disabled" : "" ?>>
                                        Quiz <?= ++$quiz ?>
                                    </button>
                            <?php }
                            } ?>
                            <?php     
                            $grade = !empty($nilai->NILAI) ? $nilai->NILAI : 0; 
                            if ($tot_proggress == 100 ) { ?>

                                <button class="btn border-primary px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100 btn-code" onclick="ShowCertificateCode(this)" data-type="5">
                                    Show Certificate Code
                                </button>
                            <?php } ?>
                        </div>
                        <div class="col bg-secondary" id="detail-item">
                            <div class="py-5">
                                <div class="d-flex justify-content-center">
                                    <img src="https://img.freepik.com/free-vector/hr-management-hiring-employees-people-cv_107791-11222.jpg" alt="Loader.gif" style="max-width: 50%;">
                                </div>
                                <div class="d-flex justify-content-center pt-4">
                                    Choose Materi
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
                if ($tot_proggress == 100 && $grade > 75) { ?>
                    <div class="tab-pane fade" id="nav-sertif" role="tabpanel" aria-labelledby="nav-sertif-tab" tabindex="0">
                        <div class="d-flex justify-content-center">
                            <div class="blurred-image" style="pointer-events: none">
                                <embed class="overlay" style="width:600px; height:500px; pointer-events: none;" src="<?= $sertif->FILE_SERTIFIKAT ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0" type="text/plain"></emb>
                            </div>
                            <div class="shadow mx-5 mt-3 rounded-4 box-input d-flex align-items-center">
                                <div class="mx-4 py-3 bg-white">
                                    <label>Sertificate Code</label>
                                    <form action="javascript:void(0)">
                                        <input type="text" class="form-control mb-4" name="" id="input-code">
                                        <button type="button" class="btn btn-primary col-md-12 my-3" onclick="DownloadPdf(this)">Download PDF</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="mx-3 mx-lg-7 my-4 text-muted">
                        Please complete the entire course and achieve a score above 75 poin.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

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
            $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-primary bg-primary')
        <?php endforeach; ?>
        $(e).addClass('btn-primary bg-primary')
        $("#detail-item").html('<div class="d-flex justify-content-center align-items-center"><img src="https://assets.materialup.com/uploads/b68f4460-aaa9-4e19-99d8-232dfea1c537/preview.gif" alt="Loader.gif" style="max-width: 50%;" /></div>');
        $("#detail-item").html(`<div class="d-flex justify-content-center align-items-center h-100">
                <div class="bg-white px-3 py-2 rounded-3 shadow fw-semibold">
                    <i class="bi bi-file-text me-2" style="font-size: 1.1rem; -webkit-text-stroke: 0.2px;"></i>
                    Your Certificate Code :
                    <?= $course->SERTIF_CODE ?>
                </div>
            </div>`);
    }

    function ShowDetailItem(e) {
        if ($(e).data("type") != 4) {
            $('.btn-code').removeClass('btn-primary bg-primary')
            <?php foreach ($item_course as $item) :  ?>
                $('#show-detail-' + <?= $item->ID_ITEM ?>).removeClass('btn-primary bg-primary')
            <?php endforeach; ?>
        }
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
                        location.reload()
                    })
                }
            })
        } else {
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
            url: "<?= url('course/item/mapping') ?>",
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
        $(e).addClass('btn-primary bg-primary');
        $("#detail-item").html('<div class="d-flex justify-content-center align-items-center"><img src="https://assets.materialup.com/uploads/b68f4460-aaa9-4e19-99d8-232dfea1c537/preview.gif" alt="Loader.gif" style="max-width: 50%;" /></div>');

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