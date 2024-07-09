<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Beranda</a>
                <span class="breadcrumb-item active"><?= $title ?></span>
            </nav>
        </div>
    </div>
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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <label class="card-title" style="font-size: 20px">Kursus</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <a href="courses/add" style="color: white"><button type="button" class="btn btn-primary">
                                <i class="mdi mdi-plus me-1"></i>
                                Tambahkan Kursus</button></a>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kursus</th>
                            <th>Status</th>
                            <th width="15%">Harga Kursus</th>
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
                                <td><?= $item->STATUS ?> </td>
                                <td><?= $item->PRICE_ACTIVITY == 0 ? '<span class="badge badge-success">Gratis</span>' : 'Rp ' . number_format($item->PRICE_ACTIVITY, 0, '.', '.') ?>
                                </td>
                                <td><?= date_format(date_create($item->DATE_START), 'j F Y H:i:s') ?></td>
                                <td><?= date_format(date_create($item->DATE_END), 'j F Y H:i:s') ?></td>
                                <td>
                                    <form action="courses/invite" method="GET">
                                        {{-- @csrf --}}
                                        <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="min-width: 155px !important;">
                                            <i class="bx bx-send font-size-16 align-middle"></i> Undang User
                                        </button>
                                    </form>
                                    <form action="courses/edit" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                        <button type="submit" class="btn btn-secondary waves-effect waves-light" style="min-width: 155px !important;">
                                            <i class="bx bx-edit-alt font-size-16 align-middle"></i> Edit
                                        </button>
                                    </form>
                                    <button type="button"
                                        onclick="opendeleteModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-danger waves-effect waves-light" style="min-width: 155px !important;">
                                        <i class="bx bx-trash font-size-16 align-middle"></i> Hapus
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

{{-- Start Modal Delete blom --}}
<div class="modal fade" id="deleteModal" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

<script>
    $('#dtTable').DataTable()

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)

        $('input[name="id_activity"]').val(data.ID_ACTIVITY)
        $('#deleteModal').modal('show')
    }
</script>
