<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .page-header-custom {
        background: url('<?= asset('assets_new') ?>/images/bg/illustration-bg.png') 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: initial;
    }

    .float-container {
        position: relative; /* Ensure the tooltip text is positioned relative to the container */
    }

    .float {
        position: fixed;
        width: 50px;
        height: 50px;
        bottom: 120px;
        right: 20px;
        background-color: #45b104;
        color: #FFF;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: visible; /* Ensure the tooltip can be seen outside the button */
    }

    .my-float {
        font-size: 24px;
    }

    .float-text {
        position: absolute;
        top: 50%;
        right: 110%; /* Position the text to the left of the button */
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent black background */
        color: #FFF;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none; /* Prevent the tooltip from interfering with hover events */
        transition: opacity 0.3s ease, right 0.3s ease;
        z-index: 101; /* Ensure tooltip is above other elements */
    }

    .float:hover .float-text {
        opacity: 1;
        right: 120%; /* Slightly shift the text on hover for animation */
    }
</style>

<section class="page-header page-header-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-8">
                <div class="title-block">
                    <h1>Kursus</h1>
                    <ul class="header-bradcrumb justify-content-center">
                        <li><a href="{{ url('') }}">Beranda</a></li>
                        <li class="active" aria-current="page">Kursus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding page">
    <div class="course-top-wrap mb-50">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4">
                    <div class="topbar-search ">
                        <input type="text" placeholder="Cari Kursus" class="form-control search" id="search-form">
                        <label><i class="fa fa-search"></i></label>
                    </div>
                    <div class="dropdown mt-2">
                        <div id="search-result"
                            class="col-12 dropdown-menu rounded-2 custom-scrollbar-js dropdown-primary"
                            style="min-height: 512px; overflow-y:scroll;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="filter-wrap text-center">
            <ul class="course-filter ">
                <li class="py-2 py-md-0"><a href="#" data-value="0" id="nav-all"
                        onclick="ChangeNav(this, event)">Lihat Semua</a></li>
                <?php foreach ($kategori as $item_kategori) : ?>
                <li class="py-2 py-md-0"><a href="#" data-value="<?= $item_kategori->ID_KATEGORI ?>"
                        id="nav-<?= $item_kategori->ID_KATEGORI ?>"
                        onclick="ChangeNav(this, event)"><?= $item_kategori->KATEGORI ?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="container-fluid container-padding">
            <div class="row course-gallery justify-content-center">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active show" id="nav-content" role="tabpanel"
                        aria-labelledby="nav-content-tab" tabindex="0">
                        <div class="row justify-content-center" id="nav-content-item">
                            <h3 class="font-sm text-center">Tidak ada kursus tersedia</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="float-container">
            <a href="<?= !empty(session('user')) ? 'kursus/aspirasi-kursus' : 'masuk'?>" class="btn btn-warning rounded float">
                <i class="bx bx-help-circle my-float"></i>
                <span class="float-text">Tidak menemukan yang anda cari? Klik disini</span>
            </a>
        </div>
    </div>
    <!--course-->
</section>

<script>
    $(document).on('click', function(event) {
        var clickedElement = $(event.target);
        var element = $('#search-result');
        if (!clickedElement.is(element) && !clickedElement.closest(element).length) {
            $('#search-result').hide()
        }
    });

    $('#search-form').keyup(function(e) {
        if (e.which == 13) {
            $('#search-result').html("");
            getData($(this).val())
        }
    });

    function getData(key) {
        $.ajax({
            url: "kursus/search",
            method: 'GET',
            data: {
                keyword: key
            },
            success: function(result) {
                if (result != "") {
                    $('#search-result').append(result)
                } else {
                    $('#search-result').append(" <a class='dropdown-item'>No matching records found</a>")
                }

                if ($('#search-result').html() != "") {
                    $('#search-result').show();
                }
            }
        });
    }

    $("#nav-all").trigger('click')

    function ChangeNav(element, event) {
        event.preventDefault()
        $("#nav-all").parent().removeClass("active")
        <?php foreach ($kategori as $item_kategori) : ?>
        $("#nav-<?= $item_kategori->ID_KATEGORI ?>").parent().removeClass("active")
        <?php endforeach; ?>
        $(element).parent().addClass("active")
        GetCourse($(element).data('value'))
    }

    function GetCourse(category) {
        $('#nav-content-item').html(`<div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
            <div class=" rounded-5 p-3 pb-4 h-auto d-flex flex-column">
                <div class="d-flex justify-content-center py-4">
                    <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" />
                </div>
            </div>
        </div>`);

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $.ajax({
            url: '<?= Request::segment(0) ?>/kursus/category',
            method: 'GET',
            data: {
                category: category
            },
            success: function(result) {
                $('#nav-content-item').html();
                $('#nav-content-item').html(result);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let url = $(this).attr('href');
        if (url.startsWith('http://')) {
            url = url.replace('http://', 'https://');
        }
        loadPaginatedContent(url);
    });

    function loadPaginatedContent(url) {
        $('#nav-content-item').html(`
            <div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
                <div class="rounded-5 p-3 pb-4 h-auto d-flex flex-column">
                    <div class="d-flex justify-content-center py-4">
                        <img src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" />
                    </div>
                </div>
            </div>
        `);

        $.get(url, function(result) {
            $('#nav-content-item').html(result);
        }).fail(function(xhr) {
            console.error(xhr.responseText);
        });
    }

    @if (session()->has('succ_msg'))
    Swal.fire({
        icon: 'success',
        title: '{{ session('succ_msg') }}'
    });
    @endif
</script>
