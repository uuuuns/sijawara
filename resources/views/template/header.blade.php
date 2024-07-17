<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Edumel- Education Html Template by dreambuzz">
    <meta name="keywords" content="education,edumel,instructor,lms,online,instructor,dreambuzz,bootstrap,kindergarten,tutor,e learning">
    <meta name="author" content="dreambuzz">

    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="<?= asset('assets_admin\images\logo\favicon_sijawara.svg') ?>">

    <!-- Mobile Specific Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/bootstrap/bootstrap.css">
    <!-- Iconfont Css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/flaticon/flaticon.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/magnific-popup/magnific-popup.css">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/animate-css/animate.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/animated-headline/animated-headline.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/owl/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/vendors/owl/assets/owl.theme.default.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/woocomerce.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets_new') }}/css/responsive.css">

    <!-- Main jQuery -->
    <script src="{{ asset('assets_new') }}/vendors/jquery/jquery.js"></script>

    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

    <!-- sweetalert2 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Select2 css -->
    <link href="<?= asset('assets_admin/vendors/select2/select2.css') ?>" rel="stylesheet">
    <!-- DatePicker css -->
    <link href="<?= asset('assets_admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
    <!-- page css -->
    <link href="<?= asset('assets_admin/vendors/datatables/dataTables.bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Dropify css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <!-- Core css -->
    <!-- <link href="<?= asset('assets_admin/css/app.min.css') ?>" rel="stylesheet"> -->
    <!-- Icon css -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">


    <!-- Core Vendors JS -->
    <script src="<?= asset('assets_admin/js/vendors.min.js') ?>"></script>
    <!-- Select2 JS -->
    <script src="<?= asset('assets_admin/vendors/select2/select2.min.js') ?>"></script>
    <!-- Dropify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <!-- DatePicker JS -->
    <script src="<?= asset('assets_admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Validate JS -->
    <script src="<?= asset('assets_admin/vendors/jquery-validation/jquery.validate.min.js') ?>"></script>
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Core JS -->
    <script src="<?= asset('assets_admin/js/app.min.js') ?>"></script>
    <!-- Vendor Chart -->
    <script src="<?= asset('assets_admin/vendors/chartjs/Chart.min.js') ?>"></script>
    <!-- Dashboard JS -->
    <script src="<?= asset('assets_admin/js/pages/dashboard-default.js') ?>"></script>
    <!-- DataTable JS -->
    <script src="<?= asset('assets_admin/vendors/datatables/jquery.dataTables.min.js') ?>"></script>
    <!-- Core Bootstrap JS -->
    <script src="<?= asset('assets_admin/vendors/datatables/dataTables.bootstrap.min.js') ?>"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js">
    </script>
</head>

<body id="top-header" style="<?= $title == "SIJAWARA+" ? "background-image: url(assets_new/images/new/bg.png);background-size: cover;" : "" ?>">
    <style>
        :root {
            --theme-heading-font: "Poppins", sans-serif;
            --theme-secondary-font: "Poppins", sans-serif;
            --theme-primary-color: #45b104;
            --theme-secondary-color: #61bd2a;
        }

        html,
        body {
            font-family: "Poppins", sans-serif;
            height: 100%;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Poppins", sans-serif;
        }

        .carousel-control-prev,
        .carousel-control-next {
            top: 45% !important;
            bottom: auto !important;
            border-radius: 50%;
            padding: 8px;
            margin-left: -8px;
            margin-right: -8px;
            background-color: transparent;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: transparent;
        }

        .carousel-indicators [data-bs-target] {
            box-sizing: content-box;
            flex: 0 1 auto;
            width: 30px;
            height: 3px;
            padding: 0;
            margin-right: 3px;
            margin-left: 3px;
            text-indent: -999px;
            cursor: pointer;
            background-color: #fff;
            background-clip: padding-box;
            border: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            opacity: 0.5;
            transition: opacity 0.6s ease;
        }

        .header-topbar {
            background: var(--theme-primary-color);
            padding: 5px 0px;
        }

        .carousel-indicators .active {
            opacity: 1;
        }

        .header-navbar .site-logo {
            width: 15% !important;
        }

        .header-navbar .site-logo a {
            max-width: none;
        }

        .menu-trigger {
            display: none;
        }

        .btn-check:focus+.btn-primary,
        .btn-primary:focus {
            color: #fff;
            background-color: #307704;
            border-color: #307704;
        }

        .select2-container {
            display: block
        }

        .select2-container .select2-choice {
            height: 2.5375rem;
            border: 1px solid #edf2f9;
            color: #53535f;
            line-height: 2.5375rem;
            background-image: none;
            background-color: #fff
        }

        .select2-container .select2-choice .select2-arrow {
            background-image: none;
            background-color: #fff;
            border-left: 0;
            width: 25px
        }

        .select2-container .select2-choice .select2-arrow b {
            background: none
        }

        .select2-container .select2-choice .select2-arrow b:after {
            content: "\f078";
            font-family: "Font Awesome 5 Pro";
            color: rgba(0, 0, 0, 0.25);
        }

        .select2-container-active.select2-container {
            border: 1px solid #45b104;
            border-radius: .25rem;
            box-shadow: 0 0 0 2px rgba(63, 135, 245, 0.2)
        }

        .select2-container-active.select2-container .select2-choice,
        .select2-container-active.select2-container .select2-choices {
            box-shadow: none
        }

        .select2-drop-active {
            border: 0px
        }

        .select2-drop {
            color: #53535f;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15)
        }

        .select2-drop.select2-drop-above.select2-drop-active {
            border-top: 0px
        }

        .select2-results .select2-highlighted {
            color: #45b104;
            background-color: rgba(69, 177, 4, 0.1);
        }

        .select2-results .select2-result-label {
            padding: 5px 12px
        }

        .select2-search {
            padding: 4px
        }

        .select2-search:after {
            content: "\f002";
            font-family: "Font Awesome 5 Pro";
            color: #53535f;
            position: absolute;
            right: 15px;
            top: 10px
        }

        .select2-search input {
            border-color: #edf2f9;
            background: none;
            border-radius: .25rem;
            font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "Helvetica Neue", Helvetica, Arial, sans-serif
        }

        .select2-dropdown-open.select2-container .select2-choice .select2-arrow b:after {
            content: "\f077"
        }

        .select2-dropdown-open.select2-drop-above .select2-choice,
        .select2-dropdown-open.select2-drop-above .select2-choices {
            background: none
        }

        .select2-container-multi .select2-choices {
            min-height: 2.5375rem;
            border: 1px solid #edf2f9;
            background-image: none
        }

        .select2-container-multi .select2-choices .select2-search-choice {
            margin: 8px 0 8px 5px;
            border: 1px solid #e8e8e8;
            background-color: #fafafa;
            background-image: none
        }

        .select2-search-choice-close {
            background-image: none;
            color: #72849a;
            font-size: 12px
        }

        .select2-search-choice-close:after {
            content: "\25";
            font-family: "anticon"
        }

        .select2-search-choice-close:hover {
            color: #2a2a2a
        }

        .switch input[type=checkbox] {
            opacity: 0;
            position: absolute
        }

        .switch input[type=checkbox]+label {
            position: relative;
            display: inline-block;
            transition: 0.4s ease;
            -webkit-transition: 0.4s ease;
            -moz-transition: 0.4s ease;
            -o-transition: 0.4s ease;
            -ms-transition: 0.4s ease;
            height: 25px;
            width: 50px;
            border: 1px solid #bfbfbf;
            background-color: #bfbfbf;
            border-radius: 60px;
            margin-bottom: 0px;
            cursor: pointer
        }

        .switch input[type=checkbox]+label:before {
            content: "";
            position: absolute;
            display: block;
            transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
            -webkit-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
            -moz-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
            -o-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
            -ms-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
            height: 25px;
            width: 50px;
            top: 0;
            left: 0;
            border-radius: 30px
        }

        .switch input[type=checkbox]+label:after {
            content: "";
            position: absolute;
            display: block;
            box-shadow: 0 2px 4px 0 rgba(0, 35, 11, 0.2);
            transition: 0.36s cubic-bezier(0.78, 0.14, 0.15, 0.86);
            -webkit-transition: 0.36s cubic-bezier(0.78, 0.14, 0.15, 0.86);
            -moz-transition: 0.36s cubic-bezier(0.78, 0.14, 0.15, 0.86);
            -o-transition: 0.36s cubic-bezier(0.78, 0.14, 0.15, 0.86);
            -ms-transition: 0.36s cubic-bezier(0.78, 0.14, 0.15, 0.86);
            background: #fff;
            height: 21px;
            width: 21px;
            top: 1px;
            left: 1px;
            border-radius: 60px
        }

        .switch input[type=checkbox]:checked+label {
            background: #45b104;
            border-color: #45b104
        }

        .switch input[type=checkbox]:checked+label:before {
            transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
            -webkit-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
            -moz-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
            -o-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
            -ms-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1)
        }

        .switch input[type=checkbox]:checked+label:after {
            left: 25px
        }

        .switch input[type=checkbox]:checked:active:not(:disabled)+label:after {
            width: 24px;
            left: 22px
        }

        .switch input[type=checkbox]:not(:checked):active:not(:disabled)+label:after {
            width: 24px
        }

        .switch input[type=checkbox]:disabled+label {
            opacity: 0.6;
            cursor: not-allowed
        }

        .form-control:focus {
            border-bottom: 2px solid var(--theme-primary-color) !important;
        }

        .radio {
            min-height: auto;
            position: relative
        }

        .radio label {
            cursor: pointer
        }

        .radio input[type=radio] {
            margin: 0;
            display: none;
            width: 1.25rem
        }

        .radio input[type=radio]+label {
            padding-left: 0
        }

        .radio input[type=radio]+label:before {
            content: "";
            width: 1.25rem;
            height: 1.25rem;
            display: inline-block;
            margin-right: 10px;
            border: 2px solid #edf2f9;
            border-radius: 50%;
            margin-bottom: 5px;
            /* font-weight:400; */
            /* line-height:1.25rem; */
            vertical-align: bottom;
            text-align: center;
            background-color: #fff;
            color: transparent;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out
        }

        .radio input[type=radio]+label:after {
            content: "";
            background-color: transparent;
            border-radius: 50%;
            width: .625rem;
            height: .625rem;
            position: absolute;
            left: 5px;
            top: 10px;
        }

        .radio input[type=radio]:checked+label:before {
            color: #45b104;
            border-color: #45b104
        }

        .radio input[type=radio]:checked+label:after {
            background-color: #45b104
        }

        .radio input[type=radio]:disabled+label,
        .radio input[type=radio].disabled+label {
            opacity: 0.6;
            cursor: not-allowed
        }

        .radio input[type=radio]:disabled+label:before,
        .radio input[type=radio].disabled+label:before {
            background-color: #ededed;
            cursor: not-allowed
        }

        .radio input[type=radio]:disabled:checked+label:before,
        .radio input[type=radio].disabled:checked+label:before {
            background-color: #ededed;
            border-color: #ededed
        }

        .radio input[type=radio]:disabled:checked+label:after,
        .radio input[type=radio].disabled:checked+label:after {
            background-color: rgba(83, 83, 95, 0.9)
        }
    </style>
    <header class="header-style-1">
        <div class="header-topbar topbar-style-1">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-8 col-lg-8 col-sm-6">
                        <div class="header-contact text-center text-sm-start text-lg-start">
                            <a href="#">Jl. Raya Ki Ageng Gribig, Madyopuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65139 </a>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="header-socials text-center text-lg-end">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a target="_blank" href="https://www.facebook.com/uptkukm"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a target="_blank" href="https://www.instagram.com/uptkukmjatim"><i class="fab fa-instagram"></i></a></li>
                                <li class="list-inline-item"><a target="_blank" href="https://www.linkedin.com/company/uptkukmjatim"><i class="fab fa-linkedin-in"></i></a></li>
                                <li class="list-inline-item"><a target="_blank" href="https://www.youtube.com/@UPTPKUKMJATIM"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-navbar navbar-sticky">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="site-logo">
                        <a href="{{ url('') }}" class="d-flex">
                            <img class="" style="width: auto; height: 60px;" src="<?= asset('assets_new\images\new\sponsor\sijawara.png') ?>" alt="">
                            <!-- <img class="ms-3" style="width: auto; height: 35px;" src="<?= asset('assets_admin\images\logo\Logo MBKM.png') ?>" alt="">
                            <img class="ms-3" style="width: auto; height: 35px;" src="<?= asset('assets_admin\images\logo\logo-STIKI-PNG.png') ?>" alt=""> -->
                        </a>
                    </div>

                    <div class="offcanvas-icon d-block d-lg-none">
                        <a href="#" class="nav-toggler"><i class="fal fa-bars"></i></a>
                    </div>


                    <nav class="site-navbar ms-auto">
                        <ul class="primary-menu">
                            <li class="current">
                                <a href="{{ url('course') }}">Kursus</a>
                            </li>
                            <li class="me-0">
                                <a href="{{ url('event') }}">Webinar</a>
                            </li>

                            <?php if (!empty(session('user')[0])) { ?>
                                <li class="d-md-none">
                                    <a href="#" onclick="$('#form_checkout').submit()">Agenda</a>
                                </li>
                                <li class="d-md-none">
                                    <a href="{{ url('profile') }}">Profil</a>
                                </li>
                            <?php } else { ?>
                                <li class="d-md-none">
                                    <a href="{{ url('login') }}">Masuk</a>
                                </li>
                                <li class="d-md-none">
                                    <a href="{{ url('register') }}">Daftar</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <a href="#" class="nav-close"><i class="fal fa-times"></i></a>
                    </nav>


                    <div class="d-none">
                        <form id="form_checkout" action="<?= url('checkout') ?>" method="post">
                            @csrf
                            <input type="hidden" value="">
                        </form>
                    </div>

                    <?php if (!empty(session('user')[0])) { ?>
                        <nav class="header-btn d-none d-md-block">
                            <ul class="primary-menu">
                                <li class="me-4">
                                    <a href="#" class="nav-link w-100 h-100 d-flex align-items-center position-relative rounded-circle" style="padding-left:12px;padding-right:12px;right:0;margin-right:1px" onclick="$('#form_checkout').submit()">
                                        <i class="far fa-calendar"></i>
                                        <?php $totCheckout = (!empty($checkout) ? count($checkout) : 0);
                                        if ($totCheckout > 0) { ?>
                                            <span class="badge bg-danger rounded-circle position-absolute" style="top: 0px; right: -5px;">
                                                <?= count($checkout) ?>
                                            </span>
                                        <?php    } ?>
                                    </a>
                                    <?php if ($title != 'Checkout') { ?>
                                        <ul class="submenu" style="left: initial;right:0;width: max-content;">
                                            <h6 class="title mx-3 fs-5 my-3">Agenda</h6>
                                            <hr class="dropdown-divider">
                                            <ul class="p-0 m-2 overflow-auto" style="max-height:300px">
                                                <?php if (!empty($checkout)) { ?>
                                                    <?php foreach ($checkout as $item) : ?>
                                                        <li class="dropdown-item" style="pointer-events: none;">
                                                            <div class="d-flex dropdown-item align-items-center">
                                                                <div class="img col-2">
                                                                    <img src="<?= (!empty($item->IMAGE_ACTIVITY)) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK; ?>" alt="Image" class="img-fluid" style="width:50px;height:50px" />
                                                                </div>
                                                                <div class="col-7 ms-2" style="white-space:normal">
                                                                    <?= (!empty($item->TITLE_ACTIVITY)) ? $item->TITLE_ACTIVITY : $item->JUDUL; ?>
                                                                </div>
                                                                <div class="col-3 ms-2" style="white-space:normal">
                                                                    <?= ($item->PRICE_ORDER <> 0) ? "Rp " . number_format($item->PRICE_ORDER, 2, ',', '.') : 'Free' ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php        } else { ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="d-flex justify-content-center">
                                                                <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1253.jpg" height="210">
                                                            </div>
                                                            <p class="text-center">Tidak ada produk</p>
                                                        </td>
                                                    </tr>
                                                <?php        } ?>
                                            </ul>
                                            <hr class="dropdown-divider">
                                            <p class="text-center m-0 p-0 mt-2"><a href="#" onclick="$('#form_checkout').submit()" class="small">Lihat Semua</a>
                                            </p>

                                        </ul>
                                    <?php    } ?>
                                </li>
                                <li>
                                    <a href="#">
                                        <?php if (empty(session('user')[0]['PROFILE_PICTURE'])) { ?>
                                            <i class="far fa-user"></i>
                                        <?php    } else { ?>
                                            <img class="nav-link rounded-circle " style="height:40px;width:40px;background-size:cover;background-image: url('<?= session('user')[0]['PROFILE_PICTURE'] ?>')">
                                            </img>
                                        <?php    } ?>
                                        <span class="text-truncate mx-2">
                                            <?= (session('user')[0]['NAME']) ?>
                                        </span>
                                    </a>
                                    <ul class="submenu" style="left: initial;right:0">
                                        <?php if (session('user')[0]['ID_ROLE'] == 1) { ?>
                                            <li><a class="" href="<?= url('dashboard') ?>">Beranda </a></li>
                                        <?php    } else { ?>
                                            <li><a class="" href="<?= url('profile') ?>">Profile</a></li>
                                            <li><a class=" " href="<?= url('profile/mycourses') ?>">Kursus Ku</a></li>
                                            <li><a class="" href="<?= url('profile/myevents') ?>">Webinar Ku</a></li>
                                            <li><a class="" href="<?= url('profile/myebook') ?>">Ebook Ku</a></li>
                                        <?php    } ?>
                                        <hr>
                                        <li><a class="text-danger" href="<?= url('logout') ?>">Keluar</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </nav>
                    <?php  } else { ?>
                        <div class="header-btn d-none d-xl-block">
                            <a href="{{ url('login') }}" class="login">Masuk</a>
                            <a href="{{ url('register') }}" class="btn btn-main-2 btn-sm-2 rounded">Daftar</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>