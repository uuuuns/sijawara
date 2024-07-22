<div class="form-soal-<?= $no . "" . $id_quiz ?>">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label control-label" id="label_soal">Question</label>
        <input type="hidden" class="form-control" name="order_list_question[<?= ($id_quiz - 1) ?>][]" value="<?= $no; ?>">
        <input type="hidden" class="form-control" name="list_quiz[<?= ($id_quiz - 1) ?>][]" value="<?= ($id_quiz - 1); ?>">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-11">
                    <input type="text" class="form-control" name="question[<?= ($id_quiz - 1) ?>][]" value="<?= $item['SOAL'] ?>">
                </div>
                <div id="delete_question_<?= $no . "" . $id_quiz ?>" class="btn btn-danger px-1 py-0 float-right d-flex align-items-center" style="cursor: pointer;">
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
                    <input id="radio1<?= $no . "" . $id_quiz ?>" name="kunci_soal_[<?= ($id_quiz - 1); ?>][<?= ($no - 1); ?>]" type="radio" value="a" <?= ($item['KUNCI'] == "a") ? "checked" : "" ?>>
                    <label for="radio1<?= $no . "" . $id_quiz ?>" class="mr-1">A. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_a[<?= ($id_quiz - 1) ?>][]" value="<?= $item['PIL_JWB'][0] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio2<?= $no . "" . $id_quiz ?>" name="kunci_soal_[<?= ($id_quiz - 1); ?>][<?= ($no - 1); ?>]" type="radio" value="b" <?= ($item['KUNCI'] == "b") ? "checked" : "" ?>>
                    <label for="radio2<?= $no . "" . $id_quiz ?>" class="mr-1">B. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_b[<?= ($id_quiz - 1) ?>][]" value="<?= $item['PIL_JWB'][1] ?>">
                </div>
            </div>
            <div class="radio col-md-12 mb-2">
                <div class="row">
                    <input id="radio3<?= $no . "" . $id_quiz ?>" name="kunci_soal_[<?= ($id_quiz - 1); ?>][<?= ($no - 1); ?>]" type="radio" value="c" <?= ($item['KUNCI'] == "c") ? "checked" : "" ?>>
                    <label for="radio3<?= $no . "" . $id_quiz ?>" class="mr-1">C. </label>
                    <input type="text" class="form-control col-md-10" name="jawaban_c[<?= ($id_quiz - 1) ?>][]" value="<?= $item['PIL_JWB'][2] ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#delete_question_<?= $no . "" . $id_quiz ?>').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_question_<?= $no . "" . $id_quiz ?>").removeClass("is-loading")
        $(".form-soal-<?= $no . "" . $id_quiz ?>").remove();
        e.preventDefault();
    });
</script>