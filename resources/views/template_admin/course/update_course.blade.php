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
                <form id="form-user" action="store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kover Depan <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <div class="custom-file">
                                <input type="file" name="image_activity" class="custom-file-input dropify" accept=".jpg, .png" data-allowed-file-extensions="jpg png">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Judul <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title_activity" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Harga <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <input type="number" class="form-control CurrencyInput" name="price_course" placeholder="0">
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
                        <label class="col-sm-2 col-form-label control-label">Tanggal Kursus<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start" placeholder="Date Start" required>
                                <span class="p-h-10">to</span>
                                <input type="datetime-local" class="form-control" name="date_end" placeholder="Date End" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Deskripsi<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="desc_course" id="desc_course" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Benefit<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="benefit" id="benefit" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kode Sertifikat<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="certif_code" placeholder="Certificate Code" style="text-transform: uppercase" required>
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
                            <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter" class="btn btn-primary btn-sm rounded col-md-12" style="cursor: pointer;">
                                <span class="col-md-12">Tambahkan Materi atau Kuis</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-end mt-5">
                        <button type="submit" class="btn btn-primary rounded btn-submit-form">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Start Add Item --}}
<div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">Tambahkan Bab atau kuis ?</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
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
    var j = 0;
    var limit = 0;

    var data = {!! $jsonData !!};
    var price = data.PRICE_ACTIVITY;

    $('input[name="title_activity"]').val(data.TITLE_ACTIVITY);
    if (price == 0) {
        $('input[name="price_course"]').val(price);
        $('#setFree').prop('checked', true);
    } else {
        $('input[name="price_course"]').val(price);
        $('#setFree').prop('checked', false);
    }
    $('input[name="date_start"]').val(data.DATE_START);
    $('input[name="date_end"]').val(data.DATE_END);
    $('input[name="benefit"]').val(data.BENEFIT);
    $('input[name="certif_code"]').val(data.SERTIF_CODE);
    $('input[name="is_public"]').val(data.STATUS ? '1' : '0');
    $('input[name="category"]').val(data.KATEGORI);
    $('input[name="status"]').prop('checked', data.STATUS);
    $('input[name="desc_course"]').summernote('code', data.DESKRIPSI_COURSE);
    $.ajax({
        url: 'courses/get/' + data.ID_ACTIVITY,
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            if(response.desc) {
                $('input[name="benefit"]').summernote('code', response.desc.BENEFIT);
            }
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
            url: 'add_quiz/' + j,
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
</script>
@endsection