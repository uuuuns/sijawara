@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <?php if (!empty(session('err_msg'))) { ?>
        <div class="alert alert-danger">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span><?= session('err_msg') ?></span>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty(session('succ_msg'))) { ?>
        <div class="alert alert-success">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span><?= session('succ_msg') ?></span>
            </div>
        </div>
    <?php } ?>
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Kursus</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <a href="courses/add" style="color: white"><button type="button" class="btn btn-primary btn-sm-2 rounded">
                                <i class="mdi mdi-plus me-1"></i>
                                Tambahkan Kursus</button></a>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kursus</th>
                            <th>Status Aktif</th>
                            <th width="15%">Status Private</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($activity as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td><?= $item->TITLE_ACTIVITY ?></td>
                            <td><span class="badge {{ $item->STATUS == 0 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $item->STATUS == 0 ? 'Tidak Aktif' : 'Aktif' }}
                                </span></td>
                            <td><span class="badge {{ $item->IS_PUBLIC == 0 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $item->IS_PUBLIC == 0 ? 'Private' : 'Public' }}
                                </span>
                            </td>
                            <td><?= date_format(date_create($item->DATE_START), 'j F Y H:i:s') ?></td>
                            <td><?= date_format(date_create($item->DATE_END), 'j F Y H:i:s') ?></td>
                            <td>
                                @if ($item->IS_PUBLIC == 0)
                                    <form action="courses/invite" method="GET">
                                        <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                        <button type="submit" class="btn btn-primary btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important;">
                                            <i class="bx bx-send font-size-16 align-middle"></i> Undang User
                                        </button>
                                    </form>
                                @endif
                                <form action="courses/edit" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                    <button type="submit" class="btn btn-dark btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important; margin: 5px 0px;">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i> Edit Kursus
                                    </button>
                                </form>
                                <button type="button" onclick="opendeleteModal('<?= $item->ID_ACTIVITY ?>')" class="btn btn-danger btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important;">
                                    <i class="bx bx-trash font-size-16 align-middle"></i> Hapus Kursus
                                </button>
                            </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

{{-- Start Modal Delete blom --}}
<div class="modal fade" id="deleteModal" style="z-index: 1060;" id="exampleModalCenter" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Materi</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-user" action="courses/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <p>Apakah kamu ingin menghapus kursus ini?</p>
                        <input type="hidden" name="id_activity" value="" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm rounded btn-primary">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

<script>
    $('#dtTable').DataTable()

    function opendeleteModal(id_activity) {
        $('input[name="id_activity"]').val(id_activity)
        $('#deleteModal').modal('show')
    }
</script>
@endsection