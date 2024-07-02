<div class="card" id="quiz_item_{{ $id_quiz }}">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Kuis</span>
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}">
                <input type="hidden" class="form-control" name="type[]" value="2">
                <div id="delete_quiz_{{ $no }}" class="btn btn-danger px-1 py-0 float-right"
                    style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <input type="hidden" name="materi_file[]">
    <input type="hidden" name="materi_title[]">
    <input type="hidden" name="materi_link[]">
    <input type="hidden" name="desc_materi[]">
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <div id="add_new_soal_{{ $no }}" class="btn btn-success col-md-4 float-right mx-2"
                        style="cursor: pointer;">
                        <i class="anticon anticon-loading m-r-5"></i>
                        <span class="col-md-12">Tambahkan Pertanyaan Baru</span>

                    </div>
                    <div class="row col-md-4 float-left mx-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Jumlah Pertanyaan</span>
                            </div>
                            <input type="number" class="form-control" id="total_question_{{ $no }}"
                                placeholder="0">
                        </div>
                    </div>
                    <div id="add_new_batch_soal_{{ $no }}" class="btn btn-warning col-md-3 float-left mx-2"
                        style="cursor: pointer;">
                        <i class="anticon anticon-loading m-r-5"></i>
                        <span class="col-md-12">Tambahkan Pertanyaan Batch</span>
                    </div>
                </div>
            </div>
            <div class="soal_form_{{ $no }}"></div>
        </div>
    </div>
</div>

{{-- Start Modal Update blom --}}
{{-- <div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Materi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-user" action="quiz/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> --}}
                    {{-- isi --}}
                {{-- </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div> --}}
{{-- End Modal Update --}}

<script>
    $('#collapse{{ $no }}').collapse('hide')

    $('#delete_quiz_{{ $no }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_quiz_{{ $no }}").removeClass("is-loading")
        $("#quiz_item_{{ $id_quiz }}").remove();
    });

    var no_quiz = 1;
    $('#add_new_soal_' + no_quiz).click(function() {
        $('#add_new_batch_soal_{{ $no }}').toggleClass("is-loading");
        $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
        $.ajax({
            url: 'add_question/' + {{ $no }} + '/' + no_quiz + '/' + {{ $id_quiz }},
            success: function(html) {
                $(".soal_form_{{ $no }}").append(html);
                $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                $('#add_new_soal_{{ $no }}').removeClass("is-loading");
                no_quiz++;
            }
        });
    })

    $('#add_new_batch_soal_{{ $no }}').click(function() {
        var tot_question = $('#total_question_{{ $no }}').val()
        for (let index = 0; index < tot_question; index++) {
            $('#add_new_batch_soal_{{ $no }}').toggleClass("is-loading");
            $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
            $.ajax({
                url: 'add_question/' + {{ $no }} + '/' + index + '/' + {{ $id_quiz }},
                success: function(html) {
                    $(".soal_form_{{ $no }}").append(html);
                    $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                    $('#add_new_soal_{{ $no }}').removeClass("is-loading");
                    no_quiz = no_quiz + index;
                    $('#total_question_{{ $no }}').val('')
                }
            });
        }
    });
</script>
