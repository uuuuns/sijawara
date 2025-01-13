@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    {{-- <?php if (!empty($this->session->flashdata('msg'))) { ?>
    <div class="alert alert-success">
        <div class="d-flex align-items-center justify-content-start">
            <span class="alert-icon">
                <i class="anticon anticon-check-o"></i>
            </span>
            <span><?= $this->session->flashdata('msg') ?></span>
        </div>
    </div>
    <?php } ?> --}}
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Setting</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openaddModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Tambah Carousel</button>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th>Link</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($carousel as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td><img src="<?= $item->gambar ?>" alt="" style="max-width: 80%; max-height: 300px;"></td>
                            <td style="max-width: 3rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <span style="display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">
                                    <?= $item->link ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-warning px-4 py-2 rounded">
                                    <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                </button>
                                <button type="button" onclick="deleteModal(<?= $item->id_carousel ?>)" class="btn btn-danger px-4 py-2 rounded">
                                    <i class="bx bx-trash-alt font-size-16 align-middle"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

{{-- Start Update Modal view --}}
<div class="modal" id="addviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Gambar Carousel</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-add" action="{{ url('carousel/edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="up_id_carousel" name="up_link" class="form-control" required>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Gambar Carousel <span class="text-danger">*</span></label> Ukuran yang sesuai adalah 1208px x 400px atau yang serasio.
                        <div class="custom-file">
                            <input type="file" name="up_gambar" id="up_gambar" class="custom-file-input dropify" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="1M" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Link <span class="text-danger">*</span></label>
                        <input placeholder="Link Pada Kursus Atau Webinar" type="text" id="up_link" name="up_link" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary rounded">Edit Carousel</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
{{-- End Update Modal View --}}

{{-- Start Modal Add --}}
<div class="modal" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Gambar</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-add" {{ url('carousel/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Gambar Carousel <span class="text-danger">*</span></label> Ukuran yang sesuai adalah 1208px x 400px atau yang serasio.
                        <div class="custom-file">
                            <input type="file" name="gambar" class="custom-file-input dropify" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="1M" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Link <span class="text-danger">*</span></label>
                        <input placeholder="Link Pada Kursus Atau Webinar" type="text" name="link" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary rounded">Tambah Carousel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Confirmation Delete Modal -->
<div class="modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('carousel/delete') }}" method="post">
            @csrf
            <input type="hidden" id="id_carousel" name="id_carousel">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin meghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="deleteItem">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#dtTable').DataTable()

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih file',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });

    function openaddModal() {
        $('#addModal').modal('show')
    }

    function deleteModal(id) {
        $('#id_carousel').val(id)
        $('#deleteModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)
        $('#up_id_carousel').val(data.id_carousel)
        $('#up_link').val(data.link)
        $('#addviewModal').modal('show')
        
        var myDropify = $("#up_gambar").data('dropify');
        // Reset current preview
        myDropify.resetPreview();
        myDropify.clearElement();
        // Set new default file and re-init the dropify element
        myDropify.settings.defaultFile = data.gambar;
        myDropify.destroy();
        myDropify.init();
    }
</script>
@endsection