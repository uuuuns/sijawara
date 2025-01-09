@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <?php if (!empty(session('msg'))) { ?>
    <div class="alert alert-success">
        <div class="d-flex align-items-center justify-content-start">
            <span class="alert-icon">
                <i class="anticon anticon-check-o"></i>
            </span>
            <span><?= session('msg') ?></span>
        </div>
    </div>
    <?php } ?>
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Instruktur</h3>
                </div>
            </div>
            <div class="mt-5">
                <div class="table-responsive">
                    <table class="table mb-0" id="dtTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0; ?>

                            @foreach ($instructor as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->NAME ?></td>
                                <td><?= $item->EMAIL ?></td>
                                <td>
                                    <button type="button" onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-warning px-4 py-2 rounded">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button" onclick="openDelModal(`<?= $item->ID_USER ?>`)" class="btn btn-danger px-4 py-2 rounded">
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
</div>
<!-- Content Wrapper END -->

{{-- Start Modal view --}}
<div class="modal" id="addviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Materi</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="max-width: 100px !important;">NAMA</th>
                                <td name="name"></td>
                            </tr>
                            <tr>
                                <th scope="row">UNIV</th>
                                <td name="univ"></td>
                            </tr>
                            <tr>
                                <th scope="row">NIM</th>
                                <td name="nim"></td>
                            </tr>
                            <tr>
                                <th scope="row">STUDI</th>
                                <td name="study"></td>
                            </tr>
                            <tr>
                                <th scope="row">GELAR</th>
                                <td name="degree"></td>
                            </tr>
                            <tr class="col-semester">
                                <th scope="row">SEMESTER</th>
                                <td name="semester"></td>
                            </tr>
                            <tr>
                                <th scope="row">LULUS</th>
                                <td name="is_graduated"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Dokumen CV :</label>
                        <iframe width="100%" height="512" id="cv_doc" style="border: 5px #3d3d3d solid;" src=""></iframe>
                    </div>
                    <div class="col">
                        <label>Dokumen Sertifikat :</label>
                        <iframe width="100%" height="512" id="cer_doc" style="border: 5px #3d3d3d solid;" src=""></iframe>
                    </div>
                    <div class="w-100" style="margin: 20px 0px;"></div>
                    <div class="col">
                        <label>Dokumen Portofolio :</label>
                        <iframe width="100%" height="512" id="por_doc" style="border: 5px #3d3d3d solid;" src=""></iframe>
                    </div>
                    <div class="col">
                        <label>Dokumen Surat Rekomendasi :</label>
                        <iframe width="100%" height="512" id="rec_doc" style="border: 5px #3d3d3d solid;" src=""></iframe>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <form id="form-user" action="{{ url('instruktur/decline') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="dec_id_instructor" id="dec_id_instructor" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-danger btn-reject">Tolak</button>
                </form>
                <form id="form-user" action="{{ url('instruktur/accept') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="acc_id_instructor" id="acc_id_instructor" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-success btn-accept">Terima</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal View --}}

{{-- Start Modal Delete --}}
<div class="modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal lg">
            <div class="modal-header">
                <h4 class="modal-title">Hapus User Dari Instruktur</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-delete" action="{{ url('instruktur/delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p>Apakah anda ingin menghapus user ini ?</p>
                    <input type="hidden" name="del_id_user" value="" readonly>
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

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)
        var id_user = data.ID_USER;

        $('td[name="name"]').html(': ' + data.NAME)
        $('td[name="univ"]').html(': ' + data.UNIV)
        $('td[name="nim"]').html(': ' + data.NIM)
        $('td[name="study"]').html(': ' + data.STUDY)
        $('td[name="degree"]').html(': ' + data.DEGREE)
        $('td[name="semester"]').html(': ' + data.SEMESTER)
        var statusValue = data.STATUS === 1 ? ': ' + '<span class="badge badge-success">Yes</span>' : ': ' +
            '<span class="badge badge-danger">No</span>'
        $('td[name="is_graduated"]').html(statusValue)

        $('#cv_doc').attr('src', data.CV)
        $('#cer_doc').attr('src', data.PORTOFOLIO)
        $('#por_doc').attr('src', data.SERTIFIKAT)
        $('#rec_doc').attr('src', data.SURAT_RECOM)

        $('#acc_id_instructor').val(id_user)
        $('#dec_id_instructor').val(id_user)
        $('#addviewModal').modal('show')
    }

    function openDelModal(id_user) {
        $('input[name="del_id_user"]').val(id_user)
        $('#deleteModal').modal('show')
    }
</script>
@endsection