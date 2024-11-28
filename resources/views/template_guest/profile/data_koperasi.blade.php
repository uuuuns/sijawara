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
<div class="col ms-0 ms-md-4 px-5 py-4 shadow rounded-3 overflow-hidden bg-white">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="formTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link {{$check->COUNT_DATA_KOPERASI < 16 ? 'active' : ''}}" id="process1-tab" data-bs-toggle="tab" data-bs-target="#process1" type="button" role="tab" aria-controls="process1" aria-selected="true">Data Koperasi</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{$check->COUNT_DATA_KOPERASI >= 16 && $check->COUNT_DATA_HUKUM < 7 ? 'active' : ''}}" id="process2-tab" data-bs-toggle="tab" data-bs-target="#{{$check->COUNT_DATA_KOPERASI < 16 ? '' : 'process2'}}" type="button" role="tab" aria-controls="process2" aria-selected="false">Data Badan Hukum</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{$check->COUNT_DATA_KOPERASI >= 16 && $check->COUNT_DATA_HUKUM >= 7 && $check->COUNT_DATA_PENGURUS < 12 ? 'active' : ''}}" id="process3-tab" data-bs-toggle="tab" data-bs-target="#{{$check->COUNT_DATA_HUKUM < 7 ? '' : 'process3'}}" type="button" role="tab" aria-controls="process3" aria-selected="false">Data Pengurus & Anggota</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{$check->COUNT_DATA_KOPERASI >= 16 && $check->COUNT_DATA_HUKUM >= 7 && $check->COUNT_DATA_PENGURUS >= 12 ? 'active' : ''}}" id="process4-tab" data-bs-toggle="tab" data-bs-target="#{{$check->COUNT_DATA_PENGURUS < 12 ? '' : 'process4'}}" type="button" role="tab" aria-controls="process3" aria-selected="false">Data Lain Lain</button>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="formTabsContent">
      <!-- Data Pemilik Form -->
      <div class="tab-pane fade show {{$check->COUNT_DATA_KOPERASI < 16 ? 'active' : ''}}" id="process1" role="tabpanel" aria-labelledby="dataPemilik-tab">
        <form id="data_pemilik" method="post" action="data_koperasi/store_data_koperasi">
            @csrf
          <div class="mb-3">
            <label for="namaKoperasi" class="form-label">Nama Koperasi</label>
            <input type="text" class="form-control" name="namaKoperasi" value="{{$data_koperasi->nm_koperasi}}" id="namaKoperasi" placeholder="Nama Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="nikKoperasi" class="form-label">No NIK Koperasi</label>
            <input type="text" class="form-control number" id="nikKoperasi" value="{{$data_koperasi->nik}}" placeholder="No NIK Koperasi" 
                    minlength="1" maxlength="16" name="nikKoperasi" required title="NIK harus terdiri dari 16 angka, jika belum memiliki NIK isikan 0">
            <small>Jika belum bersertifikat bisa dituliskan angka 0</small>
          </div>
          <div class="mb-3">
            <label for="telpKoperasi" class="form-label">No Telp/HP</label>
            <input type="text" class="form-control number" id="telpKoperasi" value="{{$data_koperasi->phone}}" name="telpKoperasi" placeholder="No Telp Koperasi" 
                minlength="10" maxlength="13" required title="No Telp Harus lebih dari atau sama dengan 10 angka">
          </div>
          <div class="mb-3">
            <label for="alamatKoperasi" class="form-label">Alamat Koperasi</label>
            <textarea type="text" class="form-control" id="alamatKoperasi" name="alamatKoperasi" placeholder="Alamat Koperasi" required>{{$data_koperasi->alamat_koperasi}}</textarea>
          </div>
          <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi</label>
            <select class="form-select" name="provinsi" id="provinsi" required>
              <option disabled value="" {{empty($data_koperasi->id_provinsi) ? 'selected' : ''}}>Pilih...</option>
              @foreach ($provinsi as $item)
                <option value="{{$item->id_provinsi}}" {{$data_koperasi->id_provinsi == $item->id_provinsi? 'selected' : ''}}>{{$item->nama_province}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3 kota">
          </div>
          <div class="mb-3">
            <label for="bentukKoperasi" class="form-label">Bentuk Koperasi</label>
            <select class="form-select" name="bentukKoperasi" id="bentukKoperasi" value="{{$data_koperasi->id_bentuk_koperasi}}"required>
              <option value="" disabled {{empty($data_koperasi->id_bentuk_koperasi) ? 'selected' : ''}}>Pilih...</option>
              @foreach ($bentuk_koperasi as $item)
                <option value="{{$item->ID}}" {{$data_koperasi->id_bentuk_koperasi == $item->ID? 'selected' : ''}}>{{$item->NAMA}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="jenisKoperasi" class="form-label">Jenis Koperasi</label>
            <select class="form-select" value="{{$data_koperasi->id_jenis_koperasi}}" name="jenisKoperasi" id="jenisKoperasi" required>
            <option value="" disabled {{empty($data_koperasi->id_jenis_koperasi) ? 'selected' : ''}}>Pilih...</option>
                @foreach ($jenis_koperasi as $item)
                <option value="{{$item->ID}}" {{$data_koperasi->id_jenis_koperasi == $item->ID ? 'selected' : ''}}>{{$item->NAMA}}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="kelompokKoperasi" class="form-label">Kelompok Koperasi</label>
            <select class="form-select" value="{{$data_koperasi->id_kelompok_koperasi}}" name="kelompokKoperasi" id="kelompokKoperasi" required>
            <option value="" disabled {{empty($data_koperasi->id_kelompok_koperasi) ? 'selected' : ''}}>Pilih...</option>
                @foreach ($kelompok_koperasi as $item)
                <option value="{{$item->ID}}" {{$data_koperasi->id_kelompok_koperasi == $item->ID ? 'selected' : ''}}>{{$item->NAMA}}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="sektorUsaha" class="form-label">Sektor Usaha</label>
            <select class="form-select" value="{{$data_koperasi->id_sektor_usaha}}" name="sektorUsaha" id="sektorUsaha" required>
            <option value="" disabled {{empty($data_koperasi->id_sektor_usaha) ? 'selected' : ''}}>Pilih...</option>
                @foreach ($sektor_usaha as $item)
                <option value="{{$item->ID}}" {{$data_koperasi->id_sektor_usaha == $item->ID ? 'selected' : ''}}>{{$item->NAMA}}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="volumePerbulan" class="form-label">Volume Perbulan (Omzet)</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_koperasi->volume_usaha}}" id="volumePerbulan" name="volumePerbulan" placeholder="Volume Perbulan (Omzet)" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="asset" class="form-label">Asset</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_koperasi->asset}}" id="asset" name="asset" placeholder="Asset" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="UnitUsaha" class="form-label">Unit Usaha Penyumbang (Omzet) Terbesar</label>
            <select class="form-select" value="{{$data_koperasi->id_unit_usaha}}" name="UnitUsaha" id="UnitUsaha" required>
            <option value="" disabled {{empty($data_koperasi->id_unit_usaha) ? 'selected' : ''}}>Pilih...</option>
                @foreach ($unit_usaha as $item)
                <option value="{{$item->id}}" {{$data_koperasi->id_unit_usaha == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="
          <div class="mb-3">
            <label for="modalSendiri" class="form-label">Modal Sendiri</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_koperasi->modal_sendiri}}" id="modalSendiri" name="modalSendiri" placeholder="Modal Sendiri" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="modalLuar" class="form-label">Modal Luar</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_koperasi->modal_luar}}" id="modalLuar" name="modalLuar" placeholder="Modal Luar" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="sisaHasilUsaha" class="form-label">Sisa Hasil Usaha</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_koperasi->sisa_hasil_usaha}}" id="sisaHasilUsaha" name="sisaHasilUsaha" placeholder="Sisa Hasil Usaha" required>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            </div>
        </form>
      </div>

      <!-- Data UKM Form -->
      <div class="tab-pane fade {{$check->COUNT_DATA_KOPERASI >= 16 && $check->COUNT_DATA_HUKUM < 7 ? 'show active' : ''}}" id="process2" role="tabpanel" aria-labelledby="dataUKM-tab">
        <form id="data_koperasi" action="data_koperasi/store_hukum_koperasi" method="post">
            @csrf
          <div class="mb-3">
            <label for="noBadanHukum" class="form-label">No Badan Hukum UKM</label>
            <input type="text" value="{{$data_koperasi->no_badan_hukum}}" class="form-control" id="noBadanHukum" name="noBadanHukum" placeholder="XX/BH/X.XX/XX/XXX" required>
          </div>
          <div class="mb-3">
            <label for="tglBadanHukum" class="form-label">Tanggal Badan Hukum</label>
            <input type="date" class="form-control" value="{{$data_koperasi->tgl_badan_hukum}}" id="tglBadanHukum" name="tglBadanHukum" required>
          </div>
          <div class="mb-3">
            <label for="noPAD" class="form-label">No PAD (Perubahan Anggaran Dasar)</label>
            <input type="text" class="form-control number" value="{{$data_koperasi->no_pad}}" id="noPAD" name="noPAD" placeholder="No PAD" required>
          </div>
          <div class="mb-3">
            <label for="tglPAD" class="form-label">Tanggal PAD (Perubahan Anggaran Dasar)</label>
            <input type="date" class="form-control" value="{{$data_koperasi->tgl_pad}}" 
              id="tglPAD" name="tglPAD" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status Koperasi</label>
            <select class="form-select" name="status" value="{{$data_koperasi->status}}" id="status">
              <option value="" {{empty($data_koperasi->status) ? 'selected' : ''}}>Pilih...</option>
              <option value="1" {{$data_koperasi->status == 1 ? 'selected' : ''}}>Aktif</option>
              <option value="0" {{$data_koperasi->status == 0 ? 'selected' : ''}}>Tidak Aktif</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="jmlKantorCabang" class="form-label">Jumlah Kantor Cabang Koperasi</label>
            <input type="number" class="form-control number" id="jmlKantorCabang" value="{{$data_koperasi->cabang}}" name="jmlKantorCabang" placeholder="Jumlah Kantor Cabang" required>
          </div>
          <div class="mb-3">
            <label for="tglRAT" class="form-label">Tanggal RAT</label>
            <input type="date" class="form-control" id="tglRAT" value="{{$data_koperasi->tgl_rat}}" name="tglRAT" required>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
          </div>
        </form>
      </div>

      <!-- Data Lain-lain Form -->
      <div class="tab-pane fade {{$check->COUNT_DATA_KOPERASI >= 16 && $check->COUNT_DATA_HUKUM >= 7 && $check->COUNT_DATA_PENGURUS < 12 ? 'show active' : ''}}" id="process3" role="tabpanel" aria-labelledby="dataLain-tab">
        <form action="data_koperasi/store_anggota_koperasi" method="POST" id="data_lain">
          @csrf
          <div class="mb-3">
            <label for="namaKetua" class="form-label">Nama Ketua Koperasi</label>
            <input type="text" value="{{$data_koperasi->nm_ketua}}" class="form-control" id="namaKetua" name="namaKetua" placeholder="Nama Ketua Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="noHPKetua" class="form-label">No Telp/HP Ketua</label>
            <input type="number" minlength="10" maxlength="13" value="{{$data_koperasi->phone_ketua}}" class="form-control number" id="noHPKetua" name="noHPKetua" placeholder="Nomor Ketua Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="namaSekre" class="form-label">Nama Sekretaris</label>
            <input type="text" value="{{$data_koperasi->nm_sekretaris}}" class="form-control" id="namaSekre" name="namaSekre" placeholder="Nama Sekretaris Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="noHPSekre" class="form-label">No Telp/HP Sekretaris</label>
            <input type="number" value="{{$data_koperasi->phone_sekretaris}}" class="form-control number" id="noHPSekre" name="noHPSekre" placeholder="Nomor Sekretaris Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="namaBendahara" class="form-label">Nama Bendahara</label>
            <input type="text" value="{{$data_koperasi->nm_bendahara}}" class="form-control" id="namaBendahara" name="namaBendahara" placeholder="Nama Bendahara Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="noHPBendahara" class="form-label">No Telp/HP</label>
            <input type="number" value="{{$data_koperasi->phone_bendahara}}" class="form-control number" id="noHPBendahara" name="noHPBendahara" placeholder="Nomor Bendahara Koperasi" required>
          </div>
          <div class="mb-3">
            <label for="jmlAnggotaPria" class="form-label">Jumlah Anggota Koperasi Pria</label>
            <input type="number" value="{{$data_koperasi->anggota_pria}}" class="form-control number" id="jmlAnggotaPria" name="jmlAnggotaPria" placeholder="Jumlah Anggota" required>
          </div>
          <div class="mb-3">
            <label for="jmlAnggotaWanita" class="form-label">Jumlah Anggota Koperasi Wanita</label>
            <input type="number" value="{{$data_koperasi->anggota_wanita}}" class="form-control number" id="jmlAnggotaWanita" name="jmlAnggotaWanita" placeholder="Jumlah Anggota" required>
          </div>
          <div class="mb-3">
            <label for="jmlManajerPria" class="form-label">Jumlah Manajer Koperasi Pria</label>
            <input type="number" value="{{$data_koperasi->manager_pria}}" class="form-control number" id="jmlManajerPria" name="jmlManajerPria" placeholder="Jumlah Manajer" required>
          </div>
          <div class="mb-3">
            <label for="jmlManajerWanita" class="form-label">Jumlah Manajer Koperasi Wanita</label>
            <input type="number" value="{{$data_koperasi->manager_wanita}}" class="form-control number" id="jmlManajerWanita" name="jmlManajerWanita" placeholder="Jumlah Manajer" required>
          </div>
          <div class="mb-3">
            <label for="jmlKaryawanPria" class="form-label">Jumlah Karyawan Koperasi Pria</label>
            <input type="number" value="{{$data_koperasi->karyawan_pria}}" class="form-control number" id="jmlKaryawanPria" name="jmlKaryawanPria" placeholder="Jumlah Karyawan" required>
          </div>
          <div class="mb-3">
            <label for="jmlKaryawanWanita" class="form-label">Jumlah Karyawan Koperasi Wanita</label>
            <input type="number" value="{{$data_koperasi->karyawan_wanita}}" class="form-control number" id="jmlKaryawanWanita" name="jmlKaryawanWanita" placeholder="Jumlah Karyawan" required>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
          </div>
        </form>     
    </div>
      <!-- Data Lain-lain Permasalahan Form -->
      <div class="tab-pane fade {{$check->COUNT_DATA_KOPERASI >= 16 && $check->COUNT_DATA_HUKUM >= 7 && $check->COUNT_DATA_PENGURUS >= 12 ? 'show active' : ''}}" id="process4" role="tabpane4" aria-labelledby="dataMasalah-tab">
        <form action="data_koperasi/store_masalah_koperasi" method="POST" id="data_lain">
          @csrf
          <div class="mb-3">
              <label for="permasalahan" class="form-label">Permasalahan</label>
              <select class="form-control select2" id="permasalahan" name="permasalahan[]" multiple="multiple" required>
                @foreach ($permasalahan as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA}}</option>
                @endforeach
              </select>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
          </div>
        </form>     
    </div>
  </div>
</div>
<script>
    $('#process2-tab').click(function() {
        @if ($check->COUNT_DATA_KOPERASI < 16)
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Koperasi belum lengkap!',
            });
            $(this).removeClass('active');
            $('#process1-tab').addClass('active');
        @endif
    });
    $('#process3-tab').click(function() {
        @if ($check->COUNT_DATA_HUKUM < 7)
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Badan Hukum belum lengkap!',
            });
            $(this).removeClass('active');
            $('#process2-tab').addClass('active');
        @endif
    });
    $('#process4-tab').click(function() {
        @if ($check->COUNT_DATA_PENGURUS < 12)
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Anggota belum lengkap!',
            });
            $(this).removeClass('active');
            $('#process2-tab').addClass('active');
        @endif
    });

    document.getElementById('noBadanHukum').addEventListener('input', function(e) {
      const allowedCharacters = /^[A-Z0-9.\-/ ]*$/;
      e.target.value = e.target.value.toUpperCase();
      e.target.value = e.target.value.replace(/[^A-Z0-9.\-/ ]/g, '');
    });


    function formatCurrency(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $('.rupiah').on('input', function () {
        let value = $(this).val().replace(/[^\d]/g, '');
        if (value) {
            $(this).val(formatCurrency(value));
        }
    });

    $(document).ready(function () {
        $('.rupiah').each(function () {
            let value = $(this).val().replace(/[^\d]/g, '');
            if (value) {
                $(this).val(formatCurrency(value));
            }
        });
        var permasalahanValues = {!! json_encode(array_column($tb_masalah_koperasi, 'masalah_koperasi_id')) !!};
        
        function setSelect2Values(selector, values) {
            $(selector).val(values).trigger('change');
        }
        setSelect2Values('#permasalahan', permasalahanValues);

        let id_kota = {{ $data_koperasi->id_kota ?? 'null' }};
        $.ajax({
            url: "get-kota",
            type: "POST",
            data: {
                id: $('#provinsi').val(),
                id_kota: id_kota,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('.kota').show();
                $('.kota').empty();
                $('.kota').html(data);
            }
        });
    });

    $('.number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#provinsi').change(function() {
        let id = $(this).val();
        let id_kota = {{ $data_koperasi->id_kota ?? 'null' }};
        $.ajax({
            url: "get-kota",
            type: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}",
                id_kota : id_kota
            },
            success: function(data) {
                $('.kota').show();
                $('.kota').empty();
                $('.kota').html(data);
            }
        });
    });

    $('form').on('submit', function() {
      Swal.fire({
        title: 'Loading...',
        text: 'Harap Tunggu.',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
          Swal.showLoading();
        }
      });
    });

</script>
@endsection