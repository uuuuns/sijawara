<div class="form-soal-{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label control-label" id="label_soal">Question</label>
        <input type="hidden" class="form-control" name="order_list_question[{{ $item['ID_QUIZ'] - 1 }}][]"
            value="{{ $item['NO'] }}">
        <input type="hidden" class="form-control" name="list_quiz[{{ $item['ID_QUIZ'] - 1 }}][]"
            value="{{ $item['ID_QUIZ'] - 1 }}">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-11">
                    <input type="text" class="form-control" name="question[{{ $item['ID_QUIZ'] - 1 }}][]"
                        value="{{ $item['SOAL'] }}">
                </div>
                <div id="delete_question_{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}"
                    class="btn btn-danger px-1 py-0 float-right d-flex align-items-center" style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
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
                    <input id="radio1{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}"
                        name="kunci_soal_[{{ $item['ID_QUIZ'] - 1 }}][{{ $item['NO'] - 1 }}]" type="radio"
                        value="a">
                    <label for="radio1{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}" class="mr-1"
                        <?= $item['KUNCI'] == 'a' ? 'checked' : '' ?>>A. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_a[{{ $item['ID_QUIZ'] - 1 }}][]"
                        value="<?= $item['PIL_A'] ?>">
                    <input type="text" value="{{ $item['KUNCI'] }}">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio2{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}"
                        name="kunci_soal_[{{ $item['ID_QUIZ'] - 1 }}][{{ $item['NO'] - 1 }}]" type="radio"
                        value="b">
                    <label for="radio2{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}" class="mr-1">B. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_b[{{ $item['ID_QUIZ'] - 1 }}][]"
                        value="<?= $item['PIL_B'] ?>">

                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio3{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}"
                        name="kunci_soal_[{{ $item['ID_QUIZ'] - 1 }}][{{ $item['NO'] - 1 }}]" type="radio"
                        value="c" <?= $item['KUNCI'] == 'c' ? 'checked' : '' ?>>
                    <label for="radio3{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}" class="mr-1">C. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_c[{{ $item['ID_QUIZ'] - 1 }}][]"
                        value="<?= $item['PIL_C'] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio1{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}"
                        name="kunci_soal_[{{ $item['ID_QUIZ'] - 1 }}][{{ $item['NO'] - 1 }}]" type="radio"
                        value="a" <?= $item['KUNCI'] == 'd' ? 'checked' : '' ?>>
                    <label for="radio1{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}" class="mr-1">D. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_d[{{ $item['ID_QUIZ'] - 1 }}][]"
                        value="<?= $item['PIL_D'] ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var wah = 1;
    console.log(wah);
    $('#delete_question_{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_question_{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}").removeClass("is-loading")
        $(".form-soal-{{ $item['NO'] }}{{ $item['ID_QUIZ'] }}").remove();
        e.preventDefault();
    });
</script>
