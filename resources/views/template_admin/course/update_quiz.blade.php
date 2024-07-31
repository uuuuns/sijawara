<div class="card" id="quiz_item_{{ $no }}">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Quiz</span>
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}">
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
        <div class="card-body">
            <div class="soal_form_{{ $no }}"></div>
            <div class="form-group row">
                <div class="col-md-7">
                    <div id="add_new_soal_{{ $no }}" class="btn btn-success rounded col-md-4 float-end mx-2"
                        style="cursor: pointer;">
                        <span class="col-md-12 text-white">Tambahkan Pertanyaan</span>
                    </div>
                    {{-- <input type="text" value="{{ $no }}"> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    var i_question_{{ $no }} = 0;
    var quizData = <?= json_encode($quiz[$id_quiz]) ?>;

    $('#collapse{{ $no }}').collapse('hide')

    $.ajax({
        url: 'get_quiz',
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            quizData: quizData
        }),
        beforeSend: function() {
            $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
        },
        success: function(response) {
            console.log(response);
            $(".soal_form_{{ $no }}").append(response.html);
            $('#add_new_soal_{{ $no }}').removeClass("is-loading");
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + ": " + error);
            $('#add_new_soal_{{ $no }}').removeClass("is-loading");
        }
    });

    $('#add_new_soal_{{ $no }}').click(function() {
        $('#add_new_soal_{{ $no }}').toggleClass("is-loading");
        $.ajax({
            url: 'add_quiz_question?id_quiz=' + {{ $no }},
            success: function(html) {
                $(".soal_form_{{ $no }}").append(html);
                $('#add_new_batch_soal_{{ $no }}').removeClass("is-loading");
                $('#add_new_soal_{{ $no }}').removeClass("is-loading");
                i_question_{{ $no }}++;
            }
        });
    })
</script>
