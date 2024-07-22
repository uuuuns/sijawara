<div class="card" id="quiz_item_<?= $no; ?>">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse<?= $no; ?>" class="col-md-12">
                <span class="col-md-11">Detail - Quiz</span>
                <input type="hidden" class="form-control" name="order_list[]" value="<?= $no; ?>">
                <input type="hidden" class="form-control" name="type[]" value="2">
                <div id="delete_quiz_<?= $no; ?>" class="btn btn-danger px-1 py-0 float-right" style="cursor: pointer;">
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
    <div id="collapse<?= $no; ?>" class="collapse show" data-parent="#accordion-default">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <div id="add_new_soal_<?= $no; ?>" class="btn btn-success col-md-4 float-right mx-2" style="cursor: pointer;">
                        <i class="anticon anticon-loading m-r-5"></i>
                        <span class="col-md-12">Add Single Question</span>
                    </div>
                    <div class="row col-md-4 float-left mx-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Question Amount</span>
                            </div>
                            <input type="number" class="form-control" id="total_question_<?= $no; ?>" placeholder="0">
                        </div>
                    </div>
                    <div id="add_new_batch_soal_<?= $no; ?>" class="btn btn-warning col-md-3 float-left mx-2" style="cursor: pointer;">
                        <i class="anticon anticon-loading m-r-5"></i>
                        <span class="col-md-12">Add Batch Question</span>
                    </div>
                </div>
            </div>
            <div class="soal_form_<?= $no; ?>"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var i_question_<?= $no; ?> = 0;

        $('#collapse<?= $no; ?>').collapse('hide')

        $('#delete_quiz_<?= $no; ?>').click(function(e) {
            $(this).toggleClass("is-loading");
            $.ajax({
                url: '<?= base_url('admin_controller/CourseController/remove_course_quiz/') ?>' + <?= $no; ?>,
                success: function() {
                    $("#delete_quiz_<?= $no; ?>").removeClass("is-loading")
                    $("#quiz_item_<?= $no; ?>").remove();
                }
            });
            i--;
            limit--;
        });

        $.ajax({
            url: '<?= base_url('admin_controller/CourseController/get_quiz_question?id_quiz=' . $no . '&id_item=' . $item["ID_ITEM"] . '&id_question=') ?>' + i_question_<?= $no; ?>,
            type: "GET",
            beforeSend: function() {
                $('#add_new_soal_' + <?= $no; ?>).toggleClass("is-loading");
            },
            success: function(html) {
                $(".soal_form_" + <?= $no; ?>).append(html);
                $('#add_new_soal_' + <?= $no; ?>).removeClass("is-loading");
            }
        });

        $.ajax({
            url: '<?= base_url('admin_controller/CourseController/get_total_question?id_quiz=' . $no . '&id_item=' . $item["ID_ITEM"] . '&id_question=') ?>' + i_question_<?= $no; ?>,
            type: "GET",
            success: function(TotalData) {
                i_question_<?= $no; ?> = (parseInt(TotalData) + 1);

            }
        });

        $('#add_new_soal_' + <?= $no; ?>).click(function() {
            $('#add_new_batch_soal_' + <?= $no; ?>).toggleClass("is-loading");
            $('#add_new_soal_' + <?= $no; ?>).toggleClass("is-loading");
            $.ajax({
                url: '<?= base_url('admin_controller/CourseController/add_quiz_question?id_quiz=' . $no . '&id_question=') ?>' + i_question_<?= $no; ?>,
                success: function(html) {
                    $(".soal_form_" + <?= $no; ?>).append(html);
                    $('#add_new_batch_soal_' + <?= $no; ?>).removeClass("is-loading");
                    $('#add_new_soal_' + <?= $no; ?>).removeClass("is-loading");
                    i_question_<?= $no; ?>++;
                }

            });
        })

        $('#add_new_batch_soal_<?= $no; ?>').click(function() {
            var tot_question = $('#total_question_<?= $no; ?>').val()
            for (let index = 0; index < tot_question; index++) {
                $('#add_new_batch_soal_' + <?= $no; ?>).toggleClass("is-loading");
                $('#add_new_soal_' + <?= $no; ?>).toggleClass("is-loading");
                $.ajax({
                    url: '<?= base_url('admin_controller/CourseController/add_quiz_question?id_quiz=' . $no . '&id_question=') ?>' + (i_question_<?= $no; ?> + index),
                    success: function(html) {
                        $(".soal_form_" + <?= $no; ?>).append(html);
                        $('#add_new_batch_soal_' + <?= $no; ?>).removeClass("is-loading");
                        $('#add_new_soal_' + <?= $no; ?>).removeClass("is-loading");
                        i_question_<?= $no; ?> += index;
                        $('#total_question_<?= $no; ?>').val('')
                    }

                });
            }
        })
    });
</script>