<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Tambah <?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Beranda</a>
                <a class="breadcrumb-item" href="<?= asset('manage/activity/course') ?>"><?= $title ?></a>
                <span class="breadcrumb-item active">Tambah <?= $title ?></span>
            </nav>
        </div>
    </div>
    {{-- <?php if (!empty(validation_errors())) { ?>
        <div class="alert alert-warning">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-exclamation-o"></i>
                </span>
                <span><?= validation_errors() ?></span>
            </div>
        </div>
    <?php } ?> --}}
    <div class="card">
        <div class="card-body">
            <div class="m-t-25">
                <form id="form-user" action="store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kover Depan <span
                                class="text-danger">*</span>
                        </label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="image_activity" class="custom-file-input dropify"
                                    accept=".jpg, .png" data-allowed-file-extensions="jpg png" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Judul Kursus <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title_activity" placeholder="Judul Kursus"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Harga <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="number" class="form-control CurrencyInput" name="price_course" placeholder="0"
                                required>
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Gratis
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Tanggal <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start" id="date_start"
                                    required>
                                <span class="p-h-10">sampai</span>
                                <input type="datetime-local" class="form-control" name="date_end" id="date_end"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Pengunguman <span
                        class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea name="announcement" id="announcement" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Deskripsi <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea name="desc_course" id="desc_course" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Apa yang akan dipelajari? <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea name="desc_what_to_learn" id="desc_what_to_learn" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kode Sertifikat <span
                        class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="certif_code" placeholder="Kode Sertifikat"
                                style="text-transform: uppercase" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Tipe Kursus <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <select class="select2" name="is_public">
                                <option value="1">Umum</option>
                                <option value="0">Pribadi</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kategori <span
                                class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <select class="select2" name="category">
                                @foreach ($kategori as $item)
                                    <option value="<?= $item->ID_KATEGORI ?>"><?= $item->KATEGORI ?>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Status</label>
                        <div class="col-md-5 row">
                            Tidak Aktif
                            <div class="switch m-r-10" style="margin-left: 7px;">
                                <input type="checkbox" id="switch-1" name="status" checked="">
                                <label for="switch-1"></label>
                            </div>
                            Aktif
                        </div>
                    </div>
                    <div class="accordion materi_form" id="accordion-default">

                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter"
                                class="btn btn-primary m-r-5 col-md-12" style="cursor: pointer;">
                                <i class="anticon anticon-loading m-r-5"></i>
                                <span class="col-md-12">Tambahkan Bab atau Kuis</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right mt-5">
                        <button type="submit" class="btn btn-primary btn-submit-form">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Start Add Item --}}
<div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambahkan Bab atau Kuis?</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around">
                    <a href="javascript.void(0)" id="add_materi" data-dismiss="modal"
                        class="btn btn-success col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-book text-white"></i></h1> BAB
                    </a>
                    <a href="javascript.void(0)" id="add_quiz" data-dismiss="modal"
                        class="btn btn-danger col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-trophy text-white"></i></h1> KUIS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End add Item --}}

<script>
    var i = 0;
    var id_quiz = 1;
    var limit = 0;    

    $(document).ready(function() {
        var $editor = $('#desc_course');
        $editor.summernote({
            height: 200,
            callbacks: {
                onPaste: function(e) {
                    console.log('Called event paste', e);
                },
                onImageUpload: function(files) {
                    console.log(files);
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['object', ['link']]
            ]
        });

        $('#insert-btn').click(() => {
            $editor.summernote('insertParagraph');
        });

        $('#bold-btn').click(() => {
            $editor.summernote('bold');
        });
    });

    $(document).ready(function() {
        var $editor = $('#announcement');
        $editor.summernote({
            height: 200,
            callbacks: {
                onPaste: function(e) {
                    console.log('Called event paste', e);
                },
                onImageUpload: function(files) {
                    console.log(files);
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['object', ['link']]
            ]
        });

        $('#insert-btn').click(() => {
            $editor.summernote('insertParagraph');
        });

        $('#bold-btn').click(() => {
            $editor.summernote('bold');
        });
    });

    $(document).ready(function() {
        var $editor = $('#desc_what_to_learn');
        $editor.summernote({
            height: 200,
            callbacks: {
                onPaste: function(e) {
                    console.log('Called event paste', e);
                },
                onImageUpload: function(files) {
                    console.log(files);
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['object', ['link']]
            ]
        });

        $('#insert-btn').click(() => {
            $editor.summernote('insertParagraph');
        });

        $('#bold-btn').click(() => {
            $editor.summernote('bold');
        });
    });

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('')
        }
    })

    const dateStartInput = document.getElementById('date_start');
    const dateEndInput = document.getElementById('date_end');
    $(document).ready(function() {
        dateStartInput.addEventListener('change', function() {
            // Set the minimum value of date_end to the value of date_start
            dateEndInput.min = dateStartInput.value;

            // If date_end is before date_start, clear the date_end input
            if (dateEndInput.value && dateEndInput.value < dateStartInput.value) {
                dateEndInput.value = '';
            }
        });


        dateEndInput.addEventListener('change', function() {
            // Check if date_end is before date_start
            if (dateEndInput.value < dateStartInput.value) {
                alert('Akhir tanggal tidak bisa dipilih sebelum tanggal dimulai');
                dateEndInput.value = '';
            }
        });
    });

    $('#add_materi').click(function(e) {
        $("#add_item").toggleClass("is-loading");
        $.ajax({
            url: 'add_materi/' + i,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("is-loading");
                i++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").toggleClass("is-loading");
        $.ajax({
            url: 'add_quiz/' + i + '/' + id_quiz,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("is-loading");
                i++;
                limit++;
                id_quiz++;
            }
        });
        e.preventDefault();
    });

    $('.dropify').dropify({
        messages: {
            default: 'Drag dan drop untuk memilih file',
            replace: 'Ganti',
            remove: 'Hapus',
            error: 'error'
        }
    });
</script>
