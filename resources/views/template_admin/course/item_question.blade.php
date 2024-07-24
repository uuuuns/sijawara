<div class="form-soal-{{ $no }}{{ $index }}">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label control-label" id="label_soal">Pertanyaan</label>
        <input type="hidden" class="form-control" name="order_list_question[]" value="{{ $no }}">
        <input type="hidden" class="form-control" name="no_quiz[]" value="{{ $index }}">
        <div class="col-md-10">
            <div class="d-flex flex-row">
                <div class="pe-3 flex-1 w-100">
                    <input type="text" class="form-control" name="question[{{ $no }}][{{ $index }}]">
                </div>
                <div id="delete_question_{{ $no }}{{ $index }}" class="justify-content-center rounded btn btn-danger px-3 py-0 float-end d-flex align-items-center" style="cursor: pointer;">
                    <span><i class="far fa-times"></i> </span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 d-flex align-self-center">
        </label>
        <div class="col-md-10">
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio1{{ $no }}{{ $index }}" name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio" value="a" checked="">
                    <label for="radio1{{ $no }}{{ $index }}" class="mr-1">A. </label>
                    <input type="text" class="form-control col-md-10 mt-2" name="jawaban_a[]">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio2{{ $no }}{{ $index }}" name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio" value="b">
                    <label for="radio2{{ $no }}{{ $index }}" class="mr-1">B. </label>
                    <input type="text" class="form-control col-md-10 mt-2" name="jawaban_b[]">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio3{{ $no }}{{ $index }}" name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio" value="c">
                    <label for="radio3{{ $no }}{{ $index }}" class="mr-1">C. </label>
                    <input type="text" class="form-control col-md-10 mt-2" name="jawaban_c[]">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio3{{ $no }}{{ $index }}" name="kunci_soal[{{ $no }}][{{ $index }}]" type="radio" value="d">
                    <label for="radio3{{ $no }}{{ $index }}" class="mr-1">D. </label>
                    <input type="text" class="form-control col-md-10 mt-2" name="jawaban_d[]">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('#delete_question_{{ $no }}{{ $index }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_question_{{ $no }}{{ $index }}").removeClass("is-loading")
        $(".form-soal-{{ $no }}{{ $index }}").remove();
        e.preventDefault();
    });
</script>