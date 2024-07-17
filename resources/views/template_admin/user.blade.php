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
                    <h3 class="fw-bold" style="color:#45b104">Users</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openaddModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Tambah User</button>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($user as $item)
                        <?php $number++; ?>
                        <tr>
                            <td><?= $number ?></td>
                            <td><?= $item->NAME ?></td>
                            <td><?= $item->EMAIL ?></td>
                            <td><?= $item->TELP ?></td>
                            <td><?= $item->JK ?></td>
                            <td>
                                <div class="d-flex flex-column gap-2">
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

{{-- Start Modal Add --}}
<div class="modal" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah User</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-add" action="user/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Foto Profil <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="foto_profile" class="custom-file-input dropify" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="1M" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input placeholder="Nama Lengkap" type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="Laki-Laki" checked>
                                <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="Perempuan">
                                <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email <span class="text-danger">*</span></label>
                        <input placeholder="Email@gmail.com" type="text" name="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nomor HP <span class="text-danger">*</span></label>
                        <input placeholder="085141xxxx" type="text" name="contact" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kata Sandi <span class="text-danger">*</span></label>
                        <input placeholder="Password" type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                        <input placeholder="Konfirmasi Password" type="password" id="cnfirm_password" name="cnfirm_password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Apakah sudah lulus ? <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_graduated" id="inlineRadio3" value="0" checked>
                            <label class="form-check-label" for="inlineRadio3">Belum</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_graduated" id="inlineRadio4" value="1">
                            <label class="form-check-label" for="inlineRadio4">Sudah</label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Universitas <span class="text-danger">*</span></label>
                        <input placeholder="Universitas ..." type="univ" name="univ" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>NIM <span class="text-danger">*</span></label>
                        <input placeholder="NIM" type="text" name="nim" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Program Studi <span class="text-danger">*</span></label>
                        <input placeholder="Informatika" type="text" name="study" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Gelar <span class="text-danger">*</span></label>
                        <select class="form-control select-degree" name="degree" required>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Semester <span class="text-danger">*</span></label>
                        <input placeholder="8" type="text" id="semester" name="semester" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label><span class="text-danger">*</span>Dokumen CV :</label>
                            <div class="custom-file">
                                <input type="file" name="cv_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M">
                            </div>
                        </div>
                        <div class="col">
                            <label><span class="text-danger">*</span>Dokumen Sertifikat :</label>
                            <div class="custom-file">
                                <input type="file" name="certi_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M">
                            </div>
                        </div>
                        <div class="w-100" style="margin: 20px 0px;"></div>
                        <div class="col">
                            <label><span class="text-danger">*</span>Dokumen Portofolio :</label>
                            <div class="custom-file">
                                <input type="file" name="portofolio_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M">
                            </div>
                        </div>
                        <div class="col">
                            <label><span class="text-danger">*</span>Dokumen Surat Rekomendasi :</label>
                            <div class="custom-file">
                                <input type="file" name="recommend_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary rounded">Tambah User</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update --}}
<div class="modal" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail User</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-update" action="user/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="hidden" name="up_id_user" value="" readonly>
                        <div class="form-group">
                            <label>Foto Profil</label>
                            <div class="custom-file photo">
                                <input type="file" name="up_foto_profile" class="custom-file-input dropify" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="1M" data-default-file="">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Nama Lengkap</label>
                            <input placeholder="Nama Lengkap" type="text" name="up_name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Jenis Kelamin</label>
                            <div class="col-md-5">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="up_jk" id="inlineRadio11" value="Laki-Laki" checked>
                                    <label class="form-check-label" for="inlineRadio11">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="up_jk" id="inlineRadio22" value="Perempuan">
                                    <label class="form-check-label" for="inlineRadio22">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input placeholder="Email@gmail.com" type="text" name="up_email" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Nomor HP</label>
                            <input placeholder="085141xxxx" type="text" name="up_contact" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Apakah sudah lulus ?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="up_is_graduated" id="inlineRadio33" value="0" checked>
                                <label class="form-check-label" for="inlineRadio33">Belum</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="up_is_graduated" id="inlineRadio44" value="1">
                                <label class="form-check-label" for="inlineRadio44">Sudah</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Universitas</label>
                            <input placeholder="Universitas ..." type="univ" name="up_univ" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>NIM</label>
                            <input placeholder="NIM" type="text" name="up_nim" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Program Studi</label>
                            <input placeholder="Informatika" type="text" name="up_study" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Gelar</label>
                            <select class="form-control select-degree" name="up_degree" required>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 hide_this">
                            <label>Semester</label>
                            <input placeholder="8" type="text" id="up_semester" name="up_semester" class="form-control" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label>Dokumen CV :</label>
                                <div class="custom-file show-file">
                                    <iframe width="100%" height="512" style="border: 5px #3d3d3d solid;" name="frame_cv_doc" src=""></iframe>
                                </div>
                                <div class="hidden" style="display: none;">
                                    <input type="file" name="up_cv_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M" data-default-file="">
                                </div>
                            </div>
                            <div class="col ">
                                <label>Dokumen Sertifikat :</label>
                                <div class="custom-file show-file">
                                    <iframe width="100%" height="512" style="border: 5px #3d3d3d solid;" name="frame_certi_doc" src=""></iframe>
                                </div>
                                <div class="hidden" style="display: none;">
                                    <input type="file" name="up_certi_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M" data-default-file="">
                                </div>
                            </div>
                            <div class="w-100" style="margin: 20px 0px;"></div>
                            <div class="col">
                                <label>Dokumen Portofolio :</label>
                                <div class="custom-file show-file">
                                    <iframe width="100%" height="512" style="border: 5px #3d3d3d solid;" name="frame_portofolio_doc" src=""></iframe>
                                </div>
                                <div class="hidden" style="display: none;">
                                    <input type="file" name="up_portofolio_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M" data-default-file="">
                                </div>
                            </div>
                            <div class="col">
                                <label>Dokumen Surat Rekomendasi :</label>
                                <div class="custom-file show-file">
                                    <iframe width="100%" height="512" style="border: 5px #3d3d3d solid;" name="frame_recommend_doc" src=""></iframe>
                                </div>
                                <div class="hidden" style="display: none;">
                                    <input type="file" name="up_recommend_doc" class="custom-file-input dropify" data-allowed-file-extensions="pdf" data-max-file-size="5M" data-default-file="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="button" class="btn btn-secondary" id="ganti">Ganti Dokumen</button>
                            <button type="button" class="btn btn-danger" id="cancel">Batalkan</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete --}}
<div class="modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal lg">
            <div class="modal-header">
                <h4 class="modal-title">Hapus User</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-delete" action="user/delete" method="POST" enctype="multipart/form-data">
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
    $('#dtTable').DataTable();

    const password = document.querySelector("#password");
    const password2 = document.querySelector("#cnfirm_password");

    const semesterInput = document.getElementById('semester');
    const semesterInput2 = document.getElementById('up_semester');
    const radioGraduatedYes = document.getElementById('inlineRadio4');
    const radioGraduatedNo = document.getElementById('inlineRadio3');
    const radioGraduatedYes2 = document.getElementById('inlineRadio44');
    const radioGraduatedNo2 = document.getElementById('inlineRadio33');

    $('#cancel').hide();

    $('#ganti').click(function(e) {
        $(this).hide();
        $('#cancel').show();
        $('.show-file').hide();
        $('.hidden').show();
    });

    $('#cancel').click(function(e) {
        $(this).hide();
        $('#ganti').show();
        $('.show-file').show();
        $('.hidden').hide();
    });

    function validatePassword() {
        if (password.value != password2.value) {
            password2.setCustomValidity("Passwords Don't Match");
        } else {
            password2.setCustomValidity('');
        }
    }

    function toggleSemesterReadonly() {
        if (radioGraduatedYes.checked || radioGraduatedYes2.checked) {
            semesterInput.setAttribute('readonly', 'readonly');
            semesterInput2.setAttribute('readonly', 'readonly');
            $('#semester').val('0')
            $('#up_semester').val('0')
        } else {
            semesterInput.removeAttribute('readonly');
            semesterInput2.removeAttribute('readonly');
            $('#semester').val('')
            $('#up_semester').val('')
        }
    }

    toggleSemesterReadonly();

    radioGraduatedYes.addEventListener('change', toggleSemesterReadonly);
    radioGraduatedNo.addEventListener('change', toggleSemesterReadonly);
    radioGraduatedYes2.addEventListener('change', toggleSemesterReadonly);
    radioGraduatedNo2.addEventListener('change', toggleSemesterReadonly);

    function openaddModal() {
        $('#addModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData)

        // Helper function to initialize Dropify
        function initializeDropify(inputName, frameName, fileUrl) {
            var dropifyElement = $('input[name="' + inputName + '"]').dropify();
            var instance = dropifyElement.data('dropify');
            instance.resetPreview();
            instance.clearElement();
            instance.settings['defaultFile'] = fileUrl;
            instance.destroy();
            instance.init();
            $('iframe[name="' + frameName + '"]').attr('src', fileUrl + "#toolbar=0&navpanes=0");
        }

        // Initialize Dropify for each document directly with URLs
        initializeDropify('up_foto_profile', 'frame_foto_profile', data.FOTO_PROFILE);
        initializeDropify('up_cv_doc', 'frame_cv_doc', data.CV);
        initializeDropify('up_certi_doc', 'frame_certi_doc', data.SERTIFIKAT);
        initializeDropify('up_portofolio_doc', 'frame_portofolio_doc', data.PORTOFOLIO);
        initializeDropify('up_recommend_doc', 'frame_recommend_doc', data.SURAT_RECOM);

        // Other data
        var graduated = data.IS_GRADUATED;
        $('input[name="up_id_user"]').val(data.ID_USER)
        $('input[name="up_name"]').val(data.NAME)
        $('input[name="up_jk"][value="' + data.JK + '"]').prop('checked', true);
        $('input[name="up_email"]').val(data.EMAIL)
        $('input[name="up_contact"]').val(data.TELP)
        $('input[name="up_is_graduated"][value="' + graduated + '"]').prop('checked', true)
        $('input[name="up_univ"]').val(data.UNIV)
        $('input[name="up_nim"]').val(data.NIM)
        $('input[name="up_study"]').val(data.STUDY)
        $('select[name="up_degree"]').val(data.DEGREE)
        if (graduated == 1) {
            $('.hide_this').hide();
            $('input[name="up_semester"]').val(data.SEMESTER).prop('readonly', true)
        } else {
            $('input[name="up_semester"]').val(data.SEMESTER)
        }
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="del_id_user"]').val(data.ID_USER)
        $('#deleteModal').modal('show')
    }

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
</script>
@endsection