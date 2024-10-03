@extends('template_guest.profile.profile_template')
@section('content')
<style>
    .form-select {
        border: 2px solid #F5F5F5;
        height: 55px;
        padding-left: 20px;
        background-color: #F5F5F5;
    }
</style>
<div class="col ms-0 ms-md-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">

    <form action="profile/update" method="POST" enctype="multipart/form-data" id="form-profile">
        @csrf
        <div class="nav-link rounded-circle">
            <input type="file" id="file" name="foto_profile" accept="image/jpeg, image/png" style="display: none;" readonly>
            <button type="button" id="choose-button" style="border: none; background-color: transparent; position: relative;">
                <i class="fa fa-pencil" hidden style="position: absolute; bottom: 140px; right: 30px; font-size: 20px; color: #000; background-color: #a7abb5; border-radius: 50%; padding: 10px;"></i>
                <img class="nav-link rounded-circle mb-2" src="<?= (!empty($data_personal->FOTO_PROFILE) ? $data_personal->FOTO_PROFILE : 'assets/images/person-circle.svg') ?>" id="preview" style="height:150px; width:150px; object-fit: cover;" />
            </button>
        </div>
        <h3 class="fw-bold py-4" style="color:#45b104">Data Pribadi</h3>
        <h5 class="text-black ps-1">NIK</h5>
        <div class="my-3 float-label-control">
            <input type="number" name="nik" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="nik" placeholder="Masukkan NIK Anda" value="<?= $data_personal->NIK ?>" aria-describedby="nik" readonly>
        </div>
        <h5 class="text-black ps-1">Email</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="email" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Email" value="<?= $data_personal->EMAIL ?>" aria-describedby="emailHelp" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Nama</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="name_user" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama" value="<?= $data_personal->NAME ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Nomor Telepon</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="no_hp" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Number" value="<?= $data_personal->TELP ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Jenis Kelamin</h5>
        <div class="my-3 float-label-control">
            <select class="form-select woocommerce-Input woocommerce-Input--text jk" disabled>
                <option value="Laki-laki" <?= ($data_personal->JK == "Laki-laki") ? "selected" : "" ?>>
                    Pria</option>
                <option value="Perempuan" <?= ($data_personal->JK == "Perempuan") ? "selected" : "" ?>>
                    Wanita</option>
            </select>
        </div>
        <h5 class="text-black ps-1 mt-4">Tempat Lahir</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="tempat_lahir" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Banyumas" value="<?= $data_personal->TEMPAT_LAHIR ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Tanggal Lahir</h5>
        <div class="my-3 float-label-control">
            <input type="date" name="tgl_lahir" class="form-control" placeholder="04-03-2004" value="<?= $data_personal->TGL_LAHIR ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Jenis Instansi</h5>
        <div class="my-3 float-label-control">
            <select class="select2 woocommerce-Input woocommerce-Input--text jenis_instansi" name="jenis_instansi" disabled>
                <option value="UKM" <?= ($data_personal->JENIS_INSTANSI == "UKM") ? "selected" : "" ?>>
                    UKM</option>
                <option value="KOPERASI" <?= ($data_personal->JENIS_INSTANSI == "KOPERASI") ? "selected" : "" ?>>
                    KOPERASI</option>
                <option value="INSTANSI" <?= ($data_personal->JENIS_INSTANSI == "INSTANSI") ? "selected" : "" ?>>
                    INSTANSI</option>
                <option value="UMUM" <?= ($data_personal->JENIS_INSTANSI == "UMUM") ? "selected" : "" ?>>
                    UMUM</option>
            </select>
        </div>
        <h5 class="text-black ps-1 mt-4">Nama UKM/Koperasi/Instansi</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="nama_instansi" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Nama Instansi Anda" value="<?= $data_personal->NAMA_INSTANSI ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Jabatan</h5>
        <div class="my-3 float-label-control">
            <input type="text" name="jabatan" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Jabatan Anda" value="<?= $data_personal->JABATAN ?>" readonly>
        </div>
        <h5 class="text-black ps-1 mt-4">Alamat</h5>
        <div class="my-3 float-label-control">
            <textarea name="alamat" class="form-control input-text woocommerce-Input woocommerce-Input--text" placeholder="Alamat Lengkap" readonly rows="3"><?= ($data_personal->ALAMAT) ?></textarea>
        </div>
        <h5 class="text-black ps-1 mt-4">Provinsi</h5>
        <div class="my-3 float-label-control">
            <select class="form-select woocommerce-Input woocommerce-Input--text provinsi" name="provinsi" id="provinsi-select" disabled>
                <option value="" <?= ($data_personal->PROVINSI == "" || $data_personal->PROVINSI == null) ? "selected" : "" ?>>
                    Pilih Provinsi...</option>
            </select>
        </div>
        <input type="hidden" name="jk" id="setJK" value="<?= $data_personal->JK ?>">
        <input type="hidden" name="jenis_instansi" id="setJenis_instansi" value="<?= $data_personal->JENIS_INSTANSI ?>">
        <input type="hidden" name="provinsi" id="setProvinsi" value="<?= $data_personal->PROVINSI ?>">
    </form>

    <button type="submit" class="btn btn-primary btn-main rounded rounded-4 fw-semibold py-2 w-100 mt-5 edit" style="--bs-btn-padding-x: 4.5rem;">Edit</button>
</div>

<script>
    const edit = document.querySelector(".edit");
    if (edit.innerHTML == "Edit") {
        $('#choose-button').css('cursor', 'default')
    }
    edit.addEventListener('click', function() {
        $('.form-control').prop('readonly', (i, v) => !v);
        $('.fa-pencil').prop('hidden', (i, v) => !v);
        $('.form-select').css('background', '#FFFFFF');
        $('.form-select').prop('disabled', (i, v) => !v);
        edit.innerHTML = edit.innerHTML === "Edit" ? "Save" : "Edit";
        $('#choose-button').css('cursor', 'pointer')
        if (edit.innerHTML == "Edit") {
            $('#form-profile').submit()
        }
    })

    $(document).ready(function() {
        // Variable holding the selected province from PHP
        var selectedProvince = '<?= $data_personal->PROVINSI ?>';

        // Fetch provinces data from the API
        $.getJSON('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function(provinces) {

            // Loop through each province and append it to the select options
            $.each(provinces, function(index, province) {
                var isSelected = (province.name == selectedProvince) ? true : false;
                
                $('#provinsi-select').append(
                    $('<option>', {
                        value: province.name,
                        text: province.name,
                        selected: isSelected
                    })
                );
            });
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

    $(document).ready(function() {
        $(".phone").inputmask({
            "mask": "9999-9999-9999",
            // "placeholder": " "
        });
        $(".nik").inputmask({
            "mask": "9999999999999999",
            // "placeholder": " "
        });
        $(function() {
            $(".date").datepicker({
                dateFormat: 'dd MM yy'
            });
            $(".date").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", "2000-12-30"));
        });
    });

    $('#choose-button').click(function() {
        if (edit.innerHTML == "Save") {
            $('#file').click();
        } else {
            $('#choose-button').css('cursor', 'default')
        }
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
</script>
@endsection