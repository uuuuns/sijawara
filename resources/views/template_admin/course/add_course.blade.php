@extends('template_admin.admin_template')
@section('content')
<style>
    .accordion>.card>.card-header>.card-title>a:not(.collapsed):after {
        transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -ms-transform: rotate(90deg)
    }

    .accordion>.card>.card-header>.card-title>a:after {
        content: "\f054";
        font-family: "Font Awesome 5 Pro";
        float: left;
        margin-right: 10px;
        transition: all 0.3s ease-in-out;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out
    }

    .accordion-link {
        color: #77838F !important;
        font-weight: 500;
    }
</style>

<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <div class="">
        <div class="card-body">
            <div class="row px-3">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Tambah Kursus Baru</h3>
                </div>
            </div>
            <div class="mt-5 px-3">
                <form id="form-user" action="store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kover Depan <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <div class="custom-file">
                                <input type="file" name="image_activity" class="custom-file-input dropify" accept=".jpg, .png" data-allowed-file-extensions="jpg png" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-2 col-form-label control-label">Judul Kursus <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title_activity" placeholder="Judul Kursus" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Harga <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <input type="number" class="form-control CurrencyInput" name="price_course" placeholder="0" required>
                            <span class="d-flex align-items-center gap-2 mt-2">
                                <div class="switch mt-2">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Gratis
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start" id="date_start" required>
                                <span class="p-h-10">sampai</span>
                                <input type="datetime-local" class="form-control" name="date_end" id="date_end" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Deskripsi <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="desc_course" id="desc_course" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Benefit <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="benefit" id="benefit" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Tipe Kursus <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="select2" name="is_public">
                                <option value="1">Umum</option>
                                <option value="0">Pribadi</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kategori <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="select2" name="category">
                                @foreach ($kategori as $item)
                                <option value="<?= $item->ID_KATEGORI ?>"><?= $item->KATEGORI ?>
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row gap-2">
                        <label class="col-sm-2 col-form-label control-label">Status</label>
                        <div class="col-md-5 row fw-600">
                            Tidak Aktif
                            <div class="switch w-auto" style="margin-left: 12px;margin-right: 12px;">
                                <input type="checkbox" id="switch-1" name="status" checked="">
                                <label for="switch-1"></label>
                            </div>
                            Aktif
                        </div>
                    </div>
                    <div class="accordion d-flex flex-column gap-3 materi_form" id="accordion-default">

                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-md-12">
                            <div data-bs-toggle="modal" id="add_item" data-bs-target="#exampleModalCenter" class="btn btn-primary btn-sm rounded col-md-12" style="cursor: pointer;">
                                <span class="col-md-12">Tambahkan Bab atau Kuis</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-end mt-5">
                        <button type="submit" class="btn btn-primary rounded btn-submit-form">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Start Add Item --}}
<div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">Tambahkan Bab atau Kuis?</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around py-4">
                    <a href="javascript.void(0)" id="add_materi" data-bs-dismiss="modal" class="rounded btn btn-success col-md-5 py-5 h-100 text-white">
                        <h1><i class="far fa-book text-white"></i></h1> BAB
                    </a>
                    <a href="javascript.void(0)" id="add_quiz" data-bs-dismiss="modal" class="rounded btn btn-danger col-md-5 py-5 h-100">
                        <h1><i class="far fa-trophy text-white"></i></h1> KUIS
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
        var $editor = $('#benefit');
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
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_materi/' + i,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                i++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_quiz/' + i + '/' + id_quiz,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
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
@endsection