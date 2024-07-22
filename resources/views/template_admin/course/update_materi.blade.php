<div class="card" id="materi_item_{{ $no }}">
    <div class="card-header">
        <h5 class="card-title d-flex row">
            <a data-toggle="collapse" href="#collapse{{ $no }}" class="col-md-12">
                <span class="col-md-11">Detail - Materi</span>
                <input type="hidden" class="form-control" name="order_list[]" value="{{ $no }}" required>
                <input type="hidden" class="form-control" name="type[]" value="1" required>
                <div id="delete_materi_{{ $no }}" class="btn btn-danger px-1 py-0 float-right" style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <div id="collapse{{ $no }}" class="collapse show" data-parent="#accordion-default">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">File Materi</label>
                <div class="col-md-5">
                    <div class="custom-file">
                        <input type="file" name="materi_file[]" class="custom-file-input file_materi" accept=".pdf" data-allowed-file-extensions="pdf" data-default-file="<?= $item['FILE'] ?>">
                        <input type="hidden" class="form-control" name="old_file[]" value="<?= $item['FILE'] ?>" required>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label" required>Nama Materi</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_title[]" value="<?= $item['TITLE'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Link Youtube</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_link[]" value="<?= $item['LINK_YT'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Deskripsi Materi</label>
                <div class="col-md-5">
                    <textarea name="desc_materi[]" id="mytextarea_<?= $no; ?>" required>
                        <?= $item['DESKRIPSI'] ?>
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var $editor = $('#mytextarea_{{ $no }}');
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
        $('.file_materi').dropify({
            messages: {
                default: 'Drag or Drop to Change Image',
                replace: 'Change',
                remove: 'Delete',
                error: 'Error'
            }
        });
    });

    $('#collapse<?= $no; ?>').collapse('hide')

    $('#delete_materi_{{ $no }}').click(function(e) {
        $(this).toggleClass("is-loading");
        $("#delete_materi_{{ $no }}").removeClass("is-loading")
        $("#materi_item_{{ $no }}").remove();
        i--;
        e.preventDefault();
    });
</script>