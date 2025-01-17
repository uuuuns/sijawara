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
        <div class="card-body" style="min-height: 600px;    ">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Users</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
            </div>

            <div class="row">
                <div class="mt-4 col-2 d-flex align-items-center justify-content-center">
                    <h5>Filter Instansi :</h5>
                </div>

                <div class="mt-4 col-4">
                    <select class="form-control instansi" name="filter-instansi" id="filter-instansi">
                        <option value="ALL">Tampilkan Semua</option>
                        <option value="UKM">UKM</option>
                        <option value="KOPERASI">KOPERASI</option>
                        <option value="INSTANSI">INSTANSI</option>
                        <option value="UMUM">UMUM</option>
                    </select>
                </div>
                <div class="mt-4 col-2"></div>
                <div class="mt-4 col-4 text-end">
                    <button onclick="location.href='/pengguna/reporting/ukm'" class="btn btn-sm btn-success text-white"><i class="fas fa-file-excel text-white"></i> LAPORAN UKM</button>
                    <button onclick="location.href='/pengguna/reporting/koperasi'" class="btn btn-sm btn-success text-white"><i class="fas fa-file-excel text-white"></i> LAPORAN KOPERASI</button>
                </div>
            </div>

            <div class="hidden-select" style="display: none;">
                <div class="row">
                    <div class="mt-4 col-2 d-flex align-items-center justify-content-center">
                        Jenis Usaha :
                    </div>
                    <div class="mt-4 col-4">
                        <select class="form-control instansi" name="" id="">
                            <option value="ALL">Tampilkan Semua</option>
                            <option value="UKM">Jamu</option>
                            <option value="KOPERASI">Meh</option>
                            <option value="INSTANSI">weh</option>
                            <option value="UMUM">heh</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" id="user-paper"></div>
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
            <form id="form-add" action="{{ url('pengguna/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Foto Profil <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="foto_profile" class="custom-file-input dropify" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="5M" required>
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

{{-- Start Modal Detail --}}
<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">Detail User</h5>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="nav-link rounded-circle">
                            <img class="nav-link rounded-circle mb-2" src='assets/images/person-circle.svg' id="preview" style="height:150px; width:150px; object-fit: cover;" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5 id="userName" class="mb-3"></h5>
                        <p class="mb-0">Email: <span id="userEmail"></span></p>
                        <p class="mb-0">Telepon: <span id="userTelp"></span></p>
                        <p class="mb-0">Jenis Kelamin: <span id="userJK"></span></p>
                        <p class="mb-0">NIK: <span id="userNIK"></span></p>
                        <p class="mb-0">Tanggal Lahir: <span id="userTglLahir"></span></p>
                        <p class="mb-0">Tempat Lahir: <span id="userTempatLahir"></span></p>
                        <p class="mb-0">ID Kota: <span id="userIdKota"></span></p>
                        <p class="mb-0">ID Provinsi: <span id="userIdProvinsi"></span></p>
                        <p class="mb-0">Alamat: <span id="userAlamat"></span></p>
                        <p class="mb-0">Jenis Instansi: <span id="userJenisInstansi"></span></p>
                        <p class="mb-0">Nama Instansi: <span id="userInstansi"></span></p>
                        <p class="mb-0">Jabatan: <span id="userJabatan"></span></p>
                        <p class="mb-0">Status Aktif: <span id="userStatus"></span></p>
                        <p class="mb-0">Status Ban: <span id="userIsDelete"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="jadikanInstruktur()" class="btn btn-primary rounded">Jadikan Instruktur</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Detal --}}

{{-- Start Modal Update --}}
<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Update Detail User</h5>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="updateUserForm" action="{{ url('pengguna/update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="nav-link rounded-circle d-flex justify-content-center">
                        <input type="file" id="file" name="foto_profile" accept="image/jpeg, image/png" style="display: none;">
                        <button type="button" id="choose-button" style="border: none; background-color: transparent; position: relative;">
                            <i class="fa fa-pencil" hidden style="position: absolute; bottom: 140px; right: 30px; font-size: 20px; color: #000; background-color: #a7abb5; border-radius: 50%; padding: 10px;"></i>
                            <img class="nav-link rounded-circle mb-2" src="<?= (!empty($data_personal->FOTO_PROFILE) ? $data_personal->FOTO_PROFILE : 'assets/images/person-circle.svg') ?>" id="up_preview" style="height:150px; width:150px; object-fit: cover;" />
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="up_userId" id="up_userId" value="12345" readonly>
                    <div class="form-group">
                        <label for="userName">Nama</label>
                        <input type="text" class="form-control" name="up_userName" id="up_userName" value="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" name="up_userEmail" id="up_userEmail" value="john.doe@example.com">
                    </div>
                    <div class="form-group">
                        <label for="userTelp">Telepon</label>
                        <input type="text" class="form-control" name="up_userTelp" id="up_userTelp" value="08123456789">
                    </div>
                    <div class="form-group">
                        <label for="userJK">Jenis Kelamin</label>
                        <select class="form-select" name="up_userJK" id="up_userJK">
                            <option value="Laki-Laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userNIK">NIK</label>
                        <input type="text" class="form-control" name="up_userNIK" id="up_userNIK" value="1234567890123456">
                    </div>
                    <div class="form-group">
                        <label for="userTglLahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="up_userTglLahir" id="up_userTglLahir" value="2000-01-01">
                    </div>
                    <div class="form-group">
                        <label for="userTempatLahir">Tempat Lahir</label>
                        <input type="text" class="form-control" name="up_userTempatLahir" id="up_userTempatLahir" value="Jakarta">
                    </div>
                    <div class="form-group">
                        <label for="userIdProvinsi">Provinsi</label>
                        <select class="form-select woocommerce-Input woocommerce-Input--text provinsi" name="up_userIdProvinsi" id="up_userIdProvinsi" required>
                        <option disabled value="" {{empty($data_personal->ID_PROVINSI) ? 'selected' : ''}}>Pilih Provinsi...</option>
                            @foreach ($provinsi as $item)
                                <option value="{{$item->id_provinsi}}">{{$item->nama_province}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userIdKota">Kota</label>
                        <select class="form-select woocommerce-Input woocommerce-Input--text kota" name="up_userIdKota" id="up_userIdKota" required>
                            <option disabled value="" {{empty($data_personal->ID_PROVINSI) ? 'selected' : ''}}>Pilih Kota...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userAlamat">Alamat</label>
                        <textarea class="form-control" name="up_userAlamat" id="up_userAlamat">Jl. Contoh No. 1</textarea>
                    </div>
                    <div class="form-group">
                        <label for="userInstansi">Nama Instansi</label>
                        <input type="text" class="form-control" name="up_userInstansi" id="up_userInstansi" value="Instansi Contoh">
                    </div>
                    <div class="form-group">
                        <label for="userJabatan">Jabatan</label>
                        <input type="text" class="form-control" name="up_userJabatan" id="up_userJabatan" value="Manager">
                    </div>
                    <div class="form-group">
                        <label for="userJenisInstansi">Jenis Instansi</label>
                        <select class="form-select" id="up_userJenisInstansi" name="up_userJenisInstansi" placeholder="Pilih Jenis Instansi">
                            <option></option>
                            <option value="UKM">UKM</option>
                            <option value="KOPERASI">KOPERASI</option>
                            <option value="INSTANSI">INSTANSI</option>
                            <option value="UMUM">UMUM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userStatus">Status Aktif</label>
                        <select class="form-select" name="up_userStatus" id="up_userStatus">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user IsDelete">Status Ban</label>
                        <select class="form-select" name="up_userIsDelete" id="up_userIsDelete">
                            <option value="0" selected>Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-update" onclick="jadikanInstruktur()">
                        <span class="loading">
                            <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                        </span> Jadikan Instruktur
                    </button>
                    <button type="button" class="btn btn-primary btn-update" onclick="jadikanAdmin()">
                        <span class="loading">
                            <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                        </span> Jadikan Admin
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="loading">
                            <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                        </span> Simpan Perubahan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            <form id="form-delete" action="{{ url('pengguna/delete') }}" method="POST" enctype="multipart/form-data">
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

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $('.instansi').select2();
    var Instansi = 'ALL'

    setPaper()

    $('.instansi').on('change', function() {
        var instansi = $(this).val();
        Instansi = instansi

        setPaper()
    });

    function setPaper() {
        $('#user-paper').html(`
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="column text-center">
                            <i class="fa-spinner"></i> Sedang Memuat ...
                        </div>
                    </div>
                </div>
            </div>
        `)
        $.ajax({
            url: '<?= Request::segment(0) ?>/pengguna/ajax/paper-view?JENIS_INSTANSI=' + Instansi,

            method: 'GET',
            success: function(data) {
                $('#user-paper').html(data)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
            }
        });
    }

    const password = document.querySelector("#password");
    const password2 = document.querySelector("#cnfirm_password");

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    function validatePassword() {
        if (password.value != password2.value) {
            password2.setCustomValidity("Passwords Don't Match");
        } else {
            password2.setCustomValidity('');
        }
    }

    function openaddModal() {
        $('#addModal').modal('show')
    }

    function openviewModal(viewData) {
        var data = JSON.parse(viewData);

        // Set user details
        $('#userName').text('Nama: ' + data.NAME);
        $('#userEmail').text(data.EMAIL);
        $('#userTelp').text(data.TELP);
        $('#userJK').text(data.JK);
        $('#userNIK').text(data.NIK);
        $('#userAlamat').text(data.ALAMAT);
        $('#userTglLahir').text(data.TGL_LAHIR);
        $('#userTempatLahir').text(data.TEMPAT_LAHIR);
        $('#userInstansi').text(data.NAMA_INSTANSI);
        $('#userJabatan').text(data.JABATAN);
        $('#userJenisInstansi').text(data.JENIS_INSTANSI);
        
        if (data.STATUS == 1) {
            $('#userStatus').text('Aktif').attr('class', 'badge bg-success');
        } else {
            $('#userStatus').text('Tidak Aktif').attr('class', 'badge bg-danger');
        }
        
        if (data.IS_DELETE == 0) {
            $('#userIsDelete').text('Tidak Di Ban').attr('class', 'badge bg-success');
        } else {
            $('#userIsDelete').text('Di Banned').attr('class', 'badge bg-danger');
        }

        $('#userIdKota').text(data.nama_kota);
        $('#userIdProvinsi').text(data.nama_province);
        $('#preview').attr('src', (data.FOTO_PROFILE == null) ? 'assets/images/person-circle.svg' : data.FOTO_PROFILE);

        $('#userDetailModal').modal('show');
    }

    function openUpdateModal(viewData) {
        var data = JSON.parse(viewData)

        $.ajax({
            url: 'get-kota-option',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: data.ID_PROVINSI ?? 'null',
                id_kota: 'null'
            },
            success: function(response) {
                $('#up_userIdKota').empty().append('<option disabled value="">Pilih Kota...</option>');

                $.each(response, function(index, value) {
                    $('#up_userIdKota').append(
                        $('<option></option>').val(value.id_kota).text(value.nama_kota)
                    );
                });
                $('#up_userIdKota').val(data.ID_KOTA)
                
            }
        });
        $('#up_userId').val(data.ID_USER)
        $('#up_userName').val(data.NAME)
        $('#up_userEmail').val(data.EMAIL)
        $('#up_userTelp').val(data.TELP)
        $('#up_userJK').val(data.JK)
        $('#up_userNIK').val(data.NIK)
        $('#up_userAlamat').val(data.ALAMAT)
        $('#up_userTglLahir').val(data.TGL_LAHIR)
        $('#up_userTempatLahir').val(data.TEMPAT_LAHIR)
        $('#up_userInstansi').val(data.NAMA_INSTANSI)
        $('#up_userJabatan').val(data.JABATAN)
        $('#up_userJenisInstansi').val(data.JENIS_INSTANSI)
        $('#up_userStatus').val(data.STATUS)
        $('#up_userIsDelete').val(data.IS_DELETE)
        $('#up_userIdProvinsi').val(data.ID_PROVINSI)
        $('#up_preview').attr('src', (data.FOTO_PROFILE == null) ? 'assets/images/person-circle.svg' : data.FOTO_PROFILE)
        $('.loading').hide();
        $('.btn-update').data('id_role', data.ID_ROLE);

        $('#updateUserModal').modal('show')
    }

    function opendeleteModal(id_user) {
        $('input[name="del_id_user"]').val(id_user)
        $('#deleteModal').modal('show')
    }

    function jadikanAdmin() {
        var id_user = $('#up_userId').val()
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.loading').show();
        $('.btn').prop('disabled', true);
        if ($('.btn-update').data('id_role') == 4) {
            Toast.fire({
                icon: 'error',
                title: 'User Sudah Menjadi Admin'
            });
            $('.loading').hide();
            $('.btn').prop('disabled', false);
            return;
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        $.ajax({
            url: 'pengguna/jadikanAdmin',
            type: 'POST',
            data: {
                id_user: id_user,
            },
            success: function(data) {
                $('#updateModal').modal('hide')
                Swal.fire({
                    title: 'Success',
                    text: 'User berhasil dijadikan admin',
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    clickOutside: false,
                });
                location.reload()
            },error: function(data) {
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal Menjadikan Admin'
                });
                $('.loading').hide();
                $('.btn').prop('disabled', false);
            }
        })
    
    }
    
    function jadikanInstruktur() {
        var id_user = $('#up_userId').val()
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.loading').show();
        $('.btn').prop('disabled', true);
        
        if ($('.btn-update').data('id_role') == 2) {
            Toast.fire({
                icon: 'error',
                title: 'User Sudah Menjadi Instruktur'
            });
            $('.loading').hide();
            $('.btn').prop('disabled', false);
            return;
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        // $.ajax({
        //     url: 'pengguna/jadikanInstruktur',
        //     type: 'POST',
        //     data: {
        //         id_user: id_user,
        //     },
        //     success: function(data) {
        //         $('#updateModal').modal('hide')
        //         Swal.fire({
        //             title: 'Success',
        //             text: 'User berhasil dijadikan instruktur',
        //             icon: 'success',
        //             showCancelButton: false,
        //             showConfirmButton: false,
        //             clickOutside: false,
        //         });
        //         location.reload()
        //     },error: function(data) {
        //         Toast.fire({
        //             icon: 'error',
        //             title: 'Gagal Menjadikan Instruktur'
        //         });
        //         $('.loading').hide();
        //         $('.btn').prop('disabled', false);
        //     }
        // })
    }
    
    $('#choose-button').click(function() {
        $('#file').click();
    });

    $('#file').change(function() {
        var file = this.files[0];
        if (file.type.match(/image.*/)) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var dataURL = event.target.result;
                $('#up_preview').attr('src', dataURL);
            };
            reader.readAsDataURL(file);
        } else {
            $('#up_preview').empty();
        }
    });

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




















