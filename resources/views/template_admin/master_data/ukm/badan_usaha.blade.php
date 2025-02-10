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
    <!-- Content Wrapper END -->
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <h3 class="fw-bold" style="color:#45b104">Badan Usaha</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-center align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openaddModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Tambah Badan Usaha</button>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="table-responsive">
                    <table class="table mb-0" id="dtTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width: 60%;">Nama Usaha</th>
                                <th width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0; ?>

                            @foreach ($usaha as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->NAMA_BADAN_USAHA ?></td>
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
</div>
<!-- Content Wrapper END -->

{{-- Start Modal Add blom --}}
<div class="modal" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Badan Usaha</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-user" action="{{ url('ukm/badan_usaha/add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Badan Usaha<span class="text-danger">*</span></label>
                        <input placeholder="Badan Usaha" type="text" name="add_nama_badan_usaha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update blom --}}
<div class="modal" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Materi</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-user" action="{{ url('ukm/badan_usaha/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="" readonly>
                    <label>Badan Usaha<span class="text-danger">*</span></label>
                    <input placeholder="Badan Usaha" type="text" name="nama_badan_usaha" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete blom --}}
<div class="modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-user" action="{{ url('ukm/badan_usaha/delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menghapus kategori ini ?</p>
                    <input type="hidden" name="id" value="" readonly>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded">Hapus</button>
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
        $('input[name="nama_badan_usaha"]').val(data.NAMA_BADAN_USAHA)
        $('input[name="id"]').val(data.ID)
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id"]').val(data.ID)
        $('#deleteModal').modal('show')
    }
</script>
@endsection
