<div class="container px-md-0 py-4 pb-3 pt-3 mt-3 d-flex justify-content-between align-items-center">
    <div class="input-group rounded-pill border px-4 py-2" style="width: 492px;">
        <input class="form-control shadow-none border-0 rounded-pill search" type="text" placeholder="Search" id="example-search-input">
        <div class="vr" style="margin-top:8px;margin-bottom:8px;margin-right:2px"></div>
        <span class=" input-group-append">
            <button class="btn btn-outline-black bg-white rounded-pill" style type="button">
                <i class="bi bi-search"></i>
            </button>
        </span>
    </div>
</div>
<div class="container">
    <span class="fw-semibold">Sort by</span>
</div>
<div class="container p-0 mb-4">
    <div class="row gap-3 justify-content-between">
        <!-- List Perulangan start -->
        <div class="col-2 my-3 ">
            <div class="child-list overflow-hidden">
                <img src="<?= base_url('assets/images/Promotion.png') ?>" class="img-fluid rounded-2" style="height: 282px; object-fit: cover;" alt="">
            </div>
            <div class="mt-2">
                <span class="fw-semibold">Front End Developer</span>
                <p class="m-0">By <span class="fw-semibold">Dominic Mayers</span></p>
                <span class="fw-semibold">IDR 59,999</span>
            </div>
            <div class="d-flex mt-3 align-items-center">
                <button type="button" onclick="" class="btn btn-primary rounded-2 " style="height: 35px; width: 150px;">
                    <p class="m-0 fw-semibold">Purchase now</p>
                </button>
                <div class="ms-3" style="">
                    <a href="<?= base_url('checkout') ?>"><i class="border border-3 border-primary rounded-2 bi bi-cart text-black fs-5 px-1" ></i></a>
                </div>
            </div>
        </div>
        <!-- List Perulangan end -->
    </div>
</div>