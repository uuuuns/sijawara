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
                    <h3 class="fw-bold" style="color:#45b104">Setting Testimoni</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openaddModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Tambah Testimoni</button>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Nama</th>
                            <th>Testimoni</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($testimoni as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td><?= $item->nama ?></td>
                            <td style="max-width: 3rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= $item->testimoni ?>
                            </td>
                            <td>
                                <button type="button" onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-warning px-4 py-2 rounded">
                                    <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                </button>
                                <button type="button" onclick="deleteModal(<?= $item->id_testimoni ?>)" class="btn btn-danger px-4 py-2 rounded">
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
                <h4 class="modal-title">Edit Testimoni</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-add" action="{{ url('testimoni/edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="up_id_testimoni" name="up_id_testimoni" class="form-control" required>
                <div class="modal-body">
                    <div class="form-group">
                        <label> Testimoni <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="up_testimoni" name="up_testimoni"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label> Nama <span class="text-danger">*</span></label>
                        <input placeholder="Nama Pemberi Testimoni" type="text" id="up_nama" name="up_nama" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label> Gambar Testimoni <span class="text-danger">*</span></label>
                        <input type="file" name="up_gambar_testimoni" class="custom-file-input dropify"
                            accept=".jpg, .png, .jpeg" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="5M">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary rounded">Edit Testimoni</button>
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
                <h4 class="modal-title">Tambah Testimoni</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-add" action="{{ url('testimoni/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Testimoni <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" name="testimoni" id="testimoni"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input placeholder="Nama Pemberi Testimoni" type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label> Gambar Testimoni <span class="text-danger">*</span></label>
                        <input type="file" name="gambar_testimoni" class="custom-file-input dropify"
                            accept=".jpg, .png, .jpeg" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="5M" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary rounded">Tambah Testimoni</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Confirmation Delete Modal -->
<div class="modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('testimoni/delete') }}" method="post">
            @csrf
            <input type="hidden" id="id_testimoni" name="id_testimoni">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin meghapus testimoni ini?</p>
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
        $('#id_testimoni').val(id)
        $('#deleteModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)
        $('#up_id_testimoni').val(data.id_testimoni)
        $('#up_testimoni').val(data.testimoni)
        $('#up_nama').val(data.nama)
        
        var gambar_testimoni = $('input[name="up_gambar_testimoni"]').dropify();
        gambar_testimoni = gambar_testimoni.data('dropify');
        gambar_testimoni.resetPreview();
        gambar_testimoni.clearElement();
        gambar_testimoni.settings['defaultFile'] = data.gambar_testimoni;
        gambar_testimoni.destroy();
        gambar_testimoni.init();

        $('#addviewModal').modal('show')
    }
</script>
@endsection