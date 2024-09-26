<div class="card" id="quiz_item_{{ $id_quiz }}">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row my-1">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12 accordion-link">
                <div class="float-start" style="width: 65px; margin-right: 10px;">
                    <input type="number" class="form-control" name="order_list[]" value="{{ $no }}">
                </div>
                <div class="row align-items-center" style="height: 16px;">
                    &nbsp;
                </div>
                <span class="col-md-11">Detail - Kuis</span>
                <input type="hidden" class="form-control" name="type[]" value="2">
                <div id="delete_quiz_{{ $no }}" class="btn btn-danger px-1 py-0 float-end"
                    style="cursor: pointer;">
                    <span><i class="far fa-times"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <input type="hidden" name="materi_file[]">
    <input type="hidden" name="materi_title[]">
    <input type="hidden" name="materi_link[]">
    <input type="hidden" name="desc_materi[]">
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default">
        <div class="form-group ps-3 pe-3 row mt-3">
            <label class="col mt-3">Batasi Soal<span class="text-danger">*</span></label>
            <div class="col-md-10">
                <input type="number" class="form-control" id="limit_soal_{{ $no }}" name="limit_soal_{{ $no }}" placeholder="10" required>
                <small class="text-danger">Batasi Soal yang akan dikeluarkan di quiz ini</small>
            </div>
        </div>
        <div class="form-group ps-3 pe-3 row mt-3">
            <label class="col mt-3">Minimum Nilai Lulus<span class="text-danger">*</span></label>
            <div class="col-md-10">
                <input type="number" class="form-control" id="min_nilai_{{ $no }}" name="min_nilai_{{ $no }}" placeholder="75" required>
                <small class="text-danger">Minimal Nilai lulus di quiz ini</small>
            </div>
        </div>
        <div class="card-body">
            <div class="soal_form_{{ $no }}"></div>
            <div class="form-group row">
                <div class="col-md-7">
                    <div id="add_new_soal_{{ $no }}{{ $id_quiz }}"
                        class="btn btn-success rounded col-md-4 float-end mx-2" style="cursor: pointer;">
                        <span class="col-md-12 text-white">Tambahkan Pertanyaan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#collapse{{ $no }}').collapse('hide')

    $('#delete_quiz_{{ $no }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_quiz_{{ $no }}").removeClass("is-loading")
        $("#quiz_item_{{ $id_quiz }}").remove();
    });

    var no_quiz = 1;
    $('#add_new_soal_{{ $no }}{{ $id_quiz }}').click(function() {
        $('#add_new_batch_soal_{{ $no }}').toggleClass("is-loading");
        $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
        $.ajax({
            url: 'add_question/{{ $no }}/' + no_quiz,
            success: function(html) {
                $(".soal_form_{{ $no }}").append(html);
                $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                $('#add_new_soal_{{ $no }}').removeClass("is-loading");
                no_quiz++;
            },
            error: function(xhr, status, error) {
                console.log('Error adding question:', error);
                console.log(xhr.responseText);
            }
        });
    });
</script>
