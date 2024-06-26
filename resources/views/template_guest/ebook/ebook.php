<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <div class="d-flex justify-content-between">
        <div class="image-ebook rounded-5 text-black me-lg-4">
            <div>
                <h1 class=" fw-bold">Everyone can<br> <span class=" fw-bold">share and learn</span></h1>
            </div>
        </div>
        <div class="image-blur rounded-5 text-white text-center">
            <span class="fs-1 fw-semibold">Best Seller!</span>
            <div class="child-list overflow-hidden my-4 m-auto">
                <img src="<?= $ebook[0]['IMAGE_EBOOK'] ?>" class="img-fluid rounded-2" style="height: 282px; object-fit: cover;" alt="">
            </div>
            <h5><span class="fw-semibold"><?= $ebook[0]['JUDUL'] ?></h5>
            <div>
                <?php if (!empty($this->session->userdata('ID_USER'))) { ?>
                    <button type="button" class="btn btn-light rounded-4 py-2 w-90  mt-3" data-toggle="modal" data-target="#exampleModalCenter" style="--bs-btn-padding-x: 1.5rem; height: 64px; width: 339px;">
                        <!-- <p class="fs-6 m-0">Purchase Now <span class="fw-bold ms-3 fs-4">IDR 60.000</span></p> -->
                        <p class="fs-6 m-0" data-toggle="modal" data-target="#exampleModal">Try Now</p>
                    </button>
                <?php } else { ?>
                    <button type="button" onclick="CheckLogin()" class="btn btn-light rounded-4 py-2 w-90  mt-3" style="--bs-btn-padding-x: 1.5rem; height: 64px; width: 339px;">
                        <!-- <p class="fs-6 m-0">Purchase Now <span class="fw-bold ms-3 fs-4">IDR 60.000</span></p> -->
                        <p class="fs-6 m-0" data-toggle="modal" data-target="#exampleModal">Try Now</p>
                    </button>
                    <script>
                        function CheckLogin() {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'error',
                                title: "Please Login First"
                            })
                        }
                    </script>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<div class="container px-4 px-md-0 py-4 pb-6 pt-3 mt-3 d-flex justify-content-between align-items-center">
    <div class="input-group rounded-pill border px-4 py-2" style="width: 492px;">
        <input class="form-control shadow-none border-0 rounded-pill search" type="text" placeholder="Search" id="example-search-input">
        <div class="vr" style="margin-top:8px;margin-bottom:8px;margin-right:2px"></div>
        <span class=" input-group-append">
            <button class="btn btn-outline-black bg-white rounded-pill" style type="button">
                <i class="bi bi-search"></i>
            </button>
        </span>
    </div>
    <div>
        <a class="nav-link " href="<?= base_url('ebook/list') ?>">See all ></a>
    </div>
</div>
<div class="container p-0 mb-4">
    <div class="row gap-3">
        <!-- List Perulangan start -->
        <?php foreach ($ebook as $book) { ?>
            <div class="col-2 my-3 ">
                <div class="child-list overflow-hidden">
                    <img src="<?= $book['IMAGE_EBOOK'] ?>" class="img-fluid rounded-2" style="height: 282px; object-fit: cover;" alt="">
                </div>
                <div class="mt-2">
                    <span class="fw-semibold"><?= $book['JUDUL'] ?></span>
                    <p class="m-0">By <span class="fw-semibold"><?= $book['AUTHOR'] ?></span></p>
                    <div class="d-flex flex-row align-items-center gap-2">
                        <p class="fw-semibold px-3 fs-8 m-0 rounded-5" style="color:white; background-color:<?= ($book['PRICE'] == 0) ? "#47DE13" : "#5580E9" ?>">
                            <?= ($book['PRICE'] == 0) ? "FREE" : "PAID" ?>
                        </p>
                    </div>
                </div>
                <?php if ($book['DATA_CHECKING'] != 1) { ?>
                    <div class="d-flex mt-3 align-items-center">
                        <form id="FormBuyNow-info" method="POST" action="<?= base_url('purchase') ?>">
                            <div id="data-input-info"></div>
                            <button type="button" onclick="BuyNow()" class="btn btn-primary rounded-2 " style="height: 35px; width: 150px;">
                                <p class="m-0 fw-semibold">Buy now</p>
                            </button>
                        </form>
                        <div class="ms-3" style="">
                            <a data-id-activity="<?= $book['ID_BUKU'] ?>" onclick="AddToCart(this)" href="javascript:void(0)"><i class="border border-3 border-primary rounded-2 bi bi-cart text-black fs-5 px-1"></i></a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="d-flex mt-3 align-items-center">
                        <button type="button" class="btn btn-primary rounded-2 " data-toggle="modal" data-target="#exampleModalCenter" style="height: 35px; width: 150px;">
                            <p class="m-0 fw-semibold" data-toggle="modal" data-target="#exampleModal">Read</p>
                        </button>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <!-- List Perulangan end -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="width: 800px !important;">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLongTitle"><?= $ebook[0]['JUDUL'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= $ebook[0]['LINK_EBOOK'] ?>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    
</div>

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
        $.ajax({
            url: '<?= base_url('add/order') ?>',
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
        <?php if (!empty($this->session->userdata('ID_USER'))) { ?>
            <?php if (!empty($checking_trans)) { ?>
                Toast.fire({
                    icon: 'error',
                    title: 'You have unfinished transactions!'
                })
            <?php } else { ?>
                $.ajax({
                    url: '<?= base_url('add/order') ?>',
                    type: "GET",
                    data: {
                        id_activity: '<?= $book['ID_BUKU'] ?>',
                        type: 2
                    },
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval
                        $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' + data.IdOrder + '" />')
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
                title: 'Please Login First!'
            })
        <?php } ?>
    }
</script>