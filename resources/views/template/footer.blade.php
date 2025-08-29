@if (!isset($admin))
    <section class="footer <?= $title == 'SIJAWARA+' ? 'pt-5' : '' ?>">
        <div class="footer-mid">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 me-auto col-sm-8 col-12">
                        <div class="footer-logo mb-3">
                            <img src="<?= url('assets_admin/images/logo/logo_sijawara.png') ?>" class="w-160 img-fluid">
                        </div>
                        <div class="widget footer-widget mb-5 mb-lg-0 text-center">
                            <p>Semua bisa berbagi dan belajar</p>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="footer-widget mb-5 mb-xl-0 float-start float-sm-end"
                            style="width: fit-content;float: inline-end;padding-right: 50px;">
                            <h5 class="widget-title">Jelajahi</h5>
                            <ul class="list-unstyled footer-links">
                                <li><a href="<?= url('/') ?>">Beranda</a></li>
                                <li><a href="<?= url('kdmp') ?>">KDMP</a></li>
                                <li><a href="<?= url('kursus') ?>">Kursus</a></li>
                                <li><a href="<?= url('webinar') ?>">Webinar</a></li>
                                <li>
                                    <a href="https://docs.google.com/document/d/1fo_SotSR-3lgkLbw1yJ7pGetlldvuW84oq2sJhXBoVI/edit?tab=t.0"
                                        target="_blank">Panduan</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-5 col-sm-6 col-12">
                        <div class="footer-widget mb-5 mb-xl-0">
                            <h5 class="widget-title">Alamat</h5>
                            <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-5">
                                <ul class="list-unstyled footer-links" style="flex:1;">
                                    <li>
                                        <h6 class="text-white">Nomor HP</h6><a href="#">+62 813-3122-0006</a>
                                    </li>
                                    <li>
                                        <h6 class="text-white">Email</h6><a href="#">sijawara@gmail.com</a>
                                    </li>
                                </ul>
                                <ul class="list-unstyled footer-links" style="flex:2">
                                    <li>
                                        <h6 class="text-white">Lokasi</h6><a href="#">
                                            Jl. Raya Ki Ageng Gribig, Madyopuro,<br> Kec. Kedungkandang, Kota Malang,
                                            Jawa Timur 65139</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-btm">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-sm-12 col-lg-6">
                        <p class="mb-0 copyright text-center text-sm-start">© 2024 Sijawara+. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-btm-top">
            <a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
        </div>

    </section>
@endif
<!-- Bootstrap 5:0 -->
<script src="{{ asset('assets_new') }}/vendors/bootstrap/popper.min.js"></script>
<script src="{{ asset('assets_new') }}/vendors/bootstrap/bootstrap.js"></script>
<!-- Counterup -->
<script src="{{ asset('assets_new') }}/vendors/counterup/waypoint.js"></script>
<script src="{{ asset('assets_new') }}/vendors/counterup/jquery.counterup.min.js"></script>
<!--  Owl Carousel -->
<script src="{{ asset('assets_new') }}/vendors/owl/owl.carousel.min.js"></script>
<!-- Isotope -->
<script src="{{ asset('assets_new') }}/vendors/isotope/jquery.isotope.js"></script>
<script src="{{ asset('assets_new') }}/vendors/isotope/imagelaoded.min.js"></script>
<!-- Animated Headline -->
<script src="{{ asset('assets_new') }}/vendors/animated-headline/animated-headline.js"></script>
<!-- Magnific Popup -->
<script src="{{ asset('assets_new') }}/vendors/magnific-popup/jquery.magnific-popup.min.js"></script>

<script src="{{ asset('assets_new') }}/js/script.js"></script>


<script>
    $('#data-table').DataTable();
    $('.select2').select2();
</script>
</body>

</html>
