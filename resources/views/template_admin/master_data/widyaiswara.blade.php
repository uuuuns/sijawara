@extends('template_admin.admin_template')
@section('content')
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
    <!-- Content Wrapper END -->
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Widyaiswara</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openaddModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Tambah Data</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 15%">Profile</th>
                            <th style="width: 30%;">Nama</th>
                            <th style="width: 30%;">Posisi</th>
                            <th style="width: 25%">Tentang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($widyaiswara as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td>
                                <img src="<?= $item->IMAGE ?>" alt="Profile Image" style="width: 80px; height: auto;">
                            </td>
                            <td><?= $item->NAMA ?></td>
                            <td><?= $item->POSISI ?></td>
                            <td><?= $item->TENTANG ?></td>
                            <td>
                                <div class="d-flex flex-row gap-2">
                                    <button type="button" onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-warning px-4 py-2 rounded">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button" onclick="opendeleteModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-danger px-4 py-2 rounded">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
                                </div>
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

{{-- Start Modal Add blom --}}
<div class="modal" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Widyaiswara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="{{ url('widyaiswara/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                    <label>Gambar Profil<span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" name="image_profile" class="custom-file-input dropify"
                                    accept=".jpg, .png, .jpeg" data-allowed-file-extensions="jpg png jpeg" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama<span class="text-danger">*</span></label>
                        <input placeholder="Nama" type="text" name="nama" class="form-control" required>
                        <label>Posisi <span class="text-danger">*</span></label>
                        <input placeholder="Posisi" type="text" name="posisi" class="form-control" required>
                        <label>Tentang<span class="text-danger">*</span></label>
                        <input placeholder="Tentang" type="text" name="tentang" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update blom --}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Widyaiswara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="{{ url('widyaiswara/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                <label>Foto Profil</label>
                    <div class="custom-file">
                        <input type="file" name="up_image_profile" class="custom-file-input dropify" accept=".jpg, .png, .jpeg" data-allowed-file-extensions="jpg png jpeg">
                    </div>
                    <input type="hidden" name="up_id_widyaiswara" value="" readonly>
                    <label>Nama<span class="text-danger">*</span></label>
                    <input placeholder="Nama" type="text" name="up_nama" class="form-control" required>
                    <label>Posisi<span class="text-danger">*</span></label>
                    <input placeholder="Posisi" type="text" name="up_posisi" class="form-control" required>
                    <label>Tentang<span class="text-danger">*</span></label>
                    <input placeholder="Tentang" type="text" name="up_tentang" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete blom --}}
<div class="modal" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="{{ url('widyaiswara/delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Apakah kamu ingin menghapus data ini?</p>
                    <input type="hidden" name="del_id_widyaiswara" value="" readonly>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

<script>
    $('#dtTable').DataTable()

    function openaddModal() {
        $('#addModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)

        var profile_image = $('input[name="up_image_profile"]').dropify();
        profile_image = profile_image.data('dropify');
        profile_image.resetPreview();
        profile_image.clearElement();
        profile_image.settings['defaultFile'] = data.IMAGE;
        profile_image.destroy();
        profile_image.init();

        $('input[name="up_nama"]').val(data.NAMA)
        $('input[name="up_posisi"]').val(data.POSISI)
        $('input[name="up_tentang"]').val(data.TENTANG)
        $('input[name="up_id_widyaiswara"]').val(data.ID)

        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="del_id_widyaiswara"]').val(data.ID)
        $('#deleteModal').modal('show')
    }

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Tarik dan lepas gambar disini atau klik',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'Error'
            },
            error: {
                'fileSize': 'File terlalu besar (1MB maksimal).'
            }
        });
    });
</script>
@endsection