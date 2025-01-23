@extends('template_guest.profile.profile_template')
@section('content')
<style>
    .form-select {
        border: 2px solid #F5F5F5;
        height: 55px;
        padding-left: 20px;
        background-color: #F5F5F5;
    }

    .profile-container {
        position: relative;
        display: inline-block;
    }

    .profile-button {
        border: none;
        background-color: transparent;
        position: relative;
        cursor: pointer;
        padding: 0;
    }

    .profile-button img {
        height: 150px;
        width: 150px;
        object-fit: cover;
        border-radius: 50%;
        transition: opacity 0.3s ease;
    }

    .profile-text {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.6);
        color: #fff;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 8px;
        opacity: 0;
        white-space: nowrap;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .profile-button:hover .profile-text {
        opacity: 1;
    }

    .profile-button:hover img {
        opacity: 0.8;
    }

</style>
<div class="col ms-0 ms-md-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold py-4" style="color:#45b104">Data Pribadi</h3>
    <form action="{{ url('profil/update') }}" method="POST" enctype="multipart/form-data" id="form-profile">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="profile-container">
                <input type="file" id="file" name="foto_profile" accept="image/jpeg, image/png" style="display: none;">
                <button type="button" id="choose-button" class="profile-button">
                    <i class="fa fa-pencil" hidden></i>
                    <img class="nav-link rounded-circle mb-2" 
                        src="<?= (!empty($data_personal->FOTO_PROFILE) ? $data_personal->FOTO_PROFILE : 'assets/images/person-circle.svg') ?>" 
                        id="preview" 
                        alt="Profile Photo" />
                    <span class="profile-text">Ganti Foto Profil</span>
                </button>
            </div>
        </div>
        <h5 class="text-black ps-1">NIK</h5>
        <div class="my-3 float-label-control">
            <input type="number" name="nik" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="nik" placeholder="Masukkan NIK Anda" value="<?= $data_personal->NIK ?>" aria-describedby="nik" required>
        </div>
        <h5 class="text-black ps-1">Email</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="email" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="email" placeholder="Email" value="<?= $data_personal->EMAIL ?>" aria-describedby="emailHelp" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Nama</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="name_user" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama" value="<?= $data_personal->NAME ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Nomor Telepon</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="no_hp" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Number" value="<?= $data_personal->TELP ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Jenis Kelamin</h5>
        <div class="my-3 float-label-control">
            <select class="form-select woocommerce-Input woocommerce-Input--text jk" required>
                <option value="" <?= (is_null($data_personal->JK)) ? "selected" : "" ?> disabled>Pilih Jenis Kelamin</option>
                <option value="Laki-laki" <?= ($data_personal->JK == "Laki-laki") ? "selected" : "" ?>>
                    Pria</option>
                <option value="Perempuan" <?= ($data_personal->JK == "Perempuan") ? "selected" : "" ?>>
                    Wanita</option>
            </select>
        </div>
        <h5 class="text-black ps-1 mt-4">Tempat Lahir</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="tempat_lahir" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Banyumas" value="<?= $data_personal->TEMPAT_LAHIR ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Tanggal Lahir</h5>
        <div class="my-3 float-label-control">
            <input type="date" name="tgl_lahir" class="form-control" placeholder="04-03-2004" value="<?= $data_personal->TGL_LAHIR ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Jenis Instansi</h5>
        <div class="my-3 float-label-control">
            <select id="jenis_instansi" name="display_jenis_instansi[]" multiple="multiple" disabled placeholder="Pilih Jenis Instansi">
                <option></option>
                <option value="UKM">UKM</option>
                <option value="KOPERASI">KOPERASI</option>
                <option value="INSTANSI">INSTANSI</option>
                <option value="UMUM">UMUM</option>
            </select>
            <input type="hidden" name="jenis_instansi" multiple="multiple" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama Instansi Anda" value="<?= $data_personal->JENIS_INSTANSI ?>" required disabled>
        </div>
        <h5 class="text-black ps-1 mt-4">Nama Instansi</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="nama_instansi" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama Instansi Anda" value="<?= $data_personal->NAMA_INSTANSI ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Jabatan</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="jabatan" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Jabatan Anda" value="<?= $data_personal->JABATAN ?>" required>
        </div>
        <h5 class="text-black ps-1 mt-4">Alamat</h5>
        <div class="my-3 float-label-control">
            <textarea name="alamat" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Alamat Lengkap" required rows="3"><?= ($data_personal->ALAMAT) ?></textarea>
        </div>
        <h5 class="text-black ps-1 mt-4">Provinsi</h5>
        <div class="my-3 float-label-control">
            <select class="form-select woocommerce-Input woocommerce-Input--text provinsi" name="provinsi" id="provinsi-select" required>
            <option disabled value="" {{empty($data_personal->ID_PROVINSI) ? 'selected' : ''}}>Pilih Provinsi...</option>
                @foreach ($provinsi as $item)
                    <option value="{{$item->id_provinsi}}" {{$data_personal->ID_PROVINSI == $item->id_provinsi? 'selected' : ''}}>{{$item->nama_province}}</option>
                @endforeach
            </select>
        </div>
        <h5 class="text-black ps-1 mt-4">Kota</h5>
        <div class="my-3 float-label-control kota-div">
            <select class="form-select woocommerce-Input woocommerce-Input--text kota" name="kota" id="kota-select" required>
                <option disabled value="" {{empty($data_personal->ID_PROVINSI) ? 'selected' : ''}}>Pilih Kota...</option>
            </select>
        </div>
        <input type="hidden" name="jk" id="setJK" value="<?= $data_personal->JK ?>">
        <input type="hidden" name="jenis_instansi" id="setJenis_instansi" value="<?= $data_personal->JENIS_INSTANSI ?>">
        <input type="hidden" name="provinsi" id="setProvinsi" value="<?= $data_personal->ID_PROVINSI ?>">
        <input type="hidden" name="kota" id="setKota" value="<?= $data_personal->ID_KOTA ?>">
        <button type="submit" class="btn btn-primary btn-main rounded rounded-4 fw-semibold py-2 w-100 mt-5" style="--bs-btn-padding-x: 4.5rem;">Simpan</button>
    </form>

</div>

<script>
    $('#form-profile').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Loading...',
            text: 'Harap Tunggu.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        if ($('#file')[0].files.length === 0 && <?= $data_personal->FOTO_PROFILE ? 'true' : 'false' ?> === false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Foto Profile Harus Diisi!',
            });
            return;
        }

        var email = $('#email').val();
        cekEmail(email, (response) => {
            if (response) {
                this.submit();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Telah Terdaftar',
                    text: 'Silakan masukkan email lain.',
                });
            }
        });
    });

    $('#provinsi-select').change(function() {
        var selectedProvince = $(this).val();
        $('#setProvinsi').val(selectedProvince);
        $.ajax({
            url: 'get-kota-option',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: selectedProvince
            },
            success: function(data) {                
                $('#kota-select').empty().append('<option disabled selected value="">Pilih Kota...</option>');

                $.each(data, function(index, value) {
                    $('#kota-select').append(
                        $('<option></option>').val(value.id_kota).text(value.nama_kota)
                    );
                });
            }
        });
    });

    $('.jk').change(function() {
        $('#setJK').val($(this).val())
    })
    $('.jenis_instansi').change(function() {
        $('#setJenis_instansi').val($(this).val())
    })
    $('.provinsi').change(function() {
        $('#setProvinsi').val($(this).val())
    })
    $('.kota').change(function() {
        $('#setKota').val($(this).val())
    })

    $('#choose-button').click(function() {
        $('#file').click();
    });

    $('#file').change(function() {
        var file = this.files[0];
        if (file.type.match(/image.*/)) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var dataURL = event.target.result;
                $('#preview').attr('src', dataURL);
            };
            reader.readAsDataURL(file);
        } else {
            $('#preview').empty();
        }
    });

    $(document).ready(function() {
        $("#jenis_instansi").select2()
        @php
            $value = explode(';', $data_personal->JENIS_INSTANSI);
        @endphp
        $('#jenis_instansi').val({!!json_encode($value)!!}).trigger('change');
        var selectedProvince = {{$data_personal->ID_PROVINSI ?? 0}};
        $('#setProvinsi').val(selectedProvince);
        
        $.ajax({
            url: 'get-kota-option',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: selectedProvince,
                id_kota: {{$data_personal->ID_KOTA ?? 'null'}}
            },
            success: function(data) {
                $('#kota-select').empty().append('<option disabled selected value="">Pilih Kota...</option>');

                $.each(data, function(index, value) {
                    $('#kota-select').append(
                        $('<option></option>').val(value.id_kota).text(value.nama_kota).attr('selected', value.id_kota == {{$data_personal->ID_KOTA ?? '0'}})
                    );
                });
            }
        });
    });

    function cekEmail(email, callback) {
        $.ajax({
            url: 'profil/cekEmail',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: email
            },
            success: function(data) {
                if (data.code == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Email sudah terdaftar!',
                    })
                    callback(false);
                }else{
                    callback(true);
                }
            }
        });
    }
</script>
@endsection