@extends('template_admin.admin_template')
@section('content')
    <div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
        <div class="">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <h3 class="fw-bold" style="color:#45b104">Ubah Kursus </h3>
                    </div>
                </div>
                <div class="mt-5">
                    <form id="form-user" action="update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ID_ACTIVITY">
                        <input type="hidden" name="ID_COURSE">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Kover Depan <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" name="image_activity" class="custom-file-input dropify"
                                        accept=".jpg, .png" data-allowed-file-extensions="jpg png">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Judul <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title_activity" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label"></label>
                            <div class="col-md-5 row fw-600">
                                Tanpa Persyaratan
                                <div class="switch w-auto" style="margin-left: 12px;margin-right: 12px;">
                                    <input type="checkbox" id="req">
                                    <label for="req"></label>
                                </div>
                                Dengan Persyaratan
                            </div>
                        </div>
                        <div id="requirement-container"></div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Tanggal Kursus<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="d-flex align-items-center">
                                    <input type="datetime-local" class="form-control" name="date_start"
                                        placeholder="Date Start" required>
                                    <span class="p-h-10">to</span>
                                    <input type="datetime-local" class="form-control" name="date_end" placeholder="Date End"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Deskripsi<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="desc_course" id="desc_course" rows=11 cols=50 maxlength=250 required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Benefit<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="benefit" id="benefit" rows=11 cols=50 maxlength=250 required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Kode Sertifikat<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="certif_code" placeholder="Certificate Code"
                                    style="text-transform: uppercase" required>
                                <small class="text-danger">Jangan Gunakan Spasi Gunakan huruf besar contoh : BLJKPR9</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Tipe Kursus <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select class="select2" name="is_public">
                                    <option value="1">Umum</option>
                                    <option value="0">Pribadi</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Kategori <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select class="select2" name="category">
                                    @foreach ($data['kategori'] as $item)
                                        <option value="<?= $item->ID_KATEGORI ?>"><?= $item->KATEGORI ?>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Status</label>
                            <div class="col-md-5 column">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="switch-1" name="status" checked="">
                                    <label for="switch-1"></label>
                                </div>
                            </div>
                        </div>
                        <div class="accordion materi_form" id="accordion-default">

                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter"
                                    class="btn btn-primary btn-sm rounded col-md-12" style="cursor: pointer;">
                                    <span class="col-md-12">Tambahkan Materi atau Kuis</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-end mt-5">
                        <button type="button" onclick="cek_soal()" class="btn btn-primary rounded btn-submit-form">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Start Add Item --}}
    <div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalCenterTitle">Tambahkan Bab atau Kuis?</h4>
                    <button type="button" class="btn px-2 py-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-3">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 text-center d-flex justify-content-around py-4">
                        <a href="javascript.void(0)" id="add_materi" data-dismiss="modal"
                            class="rounded btn btn-success col-md-5 py-5 h-100 text-white">
                            <h1><i class="far fa-book text-white"></i></h1> BAB
                        </a>
                        <a href="javascript.void(0)" id="add_quiz" data-dismiss="modal"
                            class="rounded btn btn-danger col-md-5 py-5 h-100">
                            <h1><i class="far fa-trophy text-white"></i></h1> KUIS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End add Item --}}

<script>
    var id_quiz = 1;
    var limit = 0;

    var data = {!! $jsonData !!};
    var id_course = data.ID_COURSE;
    var id_act = data.ID_ACTIVITY;

    var item = <?= $data['item'] ?>;

    // Load Image
    var cover_book = $('input[name="image_activity"]').dropify();
    cover_book = cover_book.data('dropify');
    cover_book.resetPreview();
    cover_book.clearElement();
    cover_book.settings['defaultFile'] = data.IMAGE_ACTIVITY;
    cover_book.destroy();
    cover_book.init();


    $('input[name="ID_ACTIVITY"]').val(id_act);
    $('input[name="ID_COURSE"]').val(id_course);
    $('input[name="title_activity"]').val(data.TITLE_ACTIVITY);
    $('input[name="date_start"]').val(data.DATE_START);
    $('input[name="date_end"]').val(data.DATE_END);
    $('input[name="certif_code"]').val(data.SERTIF_CODE);
    $('select[name="is_public"]').val(data.STATUS ? '1' : '0');
    $('select[name="category"]').val(data.ID_KATEGORI);
    $('input[name="status"]').prop('checked', data.STATUS);

    $.ajax({
        url: 'get/' + id_act,
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            $('#desc_course').summernote('code', response[0].DESKRIPSI_COURSE);
            $('#benefit').summernote('code', response[0].BENEFIT);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $(document).ready(function() {
        var $editor = $('#desc_course');
        $editor.summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['paragraph']],
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
        var $editor = $('#benefit');
        $editor.summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    $summernote.summernote('insertNode', imgNode);
                }
            },
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
                ['operation', ['undo', 'redo']],
                ['para', ['paragraph']],
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

    $('#add_materi').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_materi/' + item,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                item++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_quiz/' + item + '/' + id_quiz,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                item++;
                limit++;
                id_quiz++;
            }
        });
        e.preventDefault();
    });

    $.ajax({
        url: 'get_course_item/' + id_course,
        type: "GET",
        beforeSend: function() {
            $('#add_item').toggleClass("is-loading");
        },
        success: function(html) {
            $("#add_item").removeClass("is-loading");
            $(".materi_form").append(html);
            limit = item;
        }
    });

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Tarik dan lepas gambar disini atau klik',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'Error'
            },
            error: {
                'fileSize': 'File terlalu besar (1MB maksimal).'
            }
        });
    });

    $(document).ready(function() {
        $('#req').change(function() {
            if ($(this).is(':checked')) {
                $('#requirement-container').html(`
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label control-label">Persyaratan Kursus</label>
                    <div class="col-md-5">
                        <select name="req" id="reqSelect" class="select2" placeholder="Pilih Persyaratan ...">
                            @foreach ($data['requirement'] as $item)
                                <option value="{{ $item->ID_ACTIVITY }}">{{ $item->TITLE_ACTIVITY }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            `);

                $('#reqSelect').select2({
                    placeholder: "Select Requirement ...",
                    allowClear: true,
                    width: '100%'
                });
            } else {
                $('#requirement-container').empty();
            }
        });
    });

    $('#form-user').submit(function(e) {
        Swal.fire({
            icon: 'warning',
            title: 'Mohon Tunggu',
            text: 'jangan tutup halaman ini sampai proses selesai',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    });
    

    function cek_soal() {
        no_accordion = 1;
        while ($('#quiz_item_' + no_accordion).length) {
            var limit_soal = $('#limit_soal_' + no_accordion).val();
            if (limit_soal == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Limit soal tidak boleh kosong di quiz nomor ' + no_accordion,
                });
                return false;
            } else {
                var questionCount = $('.soal_form_'+no_accordion+' input[name^="question["]').length;
                if (limit_soal > questionCount) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Soal Quiz Kurang',
                        text: 'Jumlah soal kurang dari limit yang ditentukan di quiz nomor ' + no_accordion,
                    });
                    return false;
                }
            }
            no_accordion++;
        }
        $('#form-user').submit();
    }
</script>
@endsection