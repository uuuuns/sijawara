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
        <button class="nav-link {{$check->COUNT_DATA_PEMILIK < 8 ? 'active' : ''}}" id="process1-tab" data-bs-toggle="tab" data-bs-target="#process1" type="button" role="tab" aria-controls="process1" aria-selected="true">Data Pemilik UKM</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{$check->COUNT_DATA_PEMILIK >= 8 && $check->COUNT_DATA_UKM < 17 ? 'active' : ''}}" id="process2-tab" data-bs-toggle="tab" data-bs-target="#{{$check->COUNT_DATA_PEMILIK < 8 ? '' : 'process2'}}" type="button" role="tab" aria-controls="process2" aria-selected="false">Data UKM</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{$check->COUNT_DATA_PEMILIK >= 8 && $check->COUNT_DATA_UKM >= 17 ? 'active' : ''}}" id="process3-tab" data-bs-toggle="tab" data-bs-target="#{{$check->COUNT_DATA_UKM < 17 ? '' : 'process3'}}" type="button" role="tab" aria-controls="process3" aria-selected="false">Lain Lain</button>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="formTabsContent">
      <!-- Data Pemilik Form -->
      <div class="tab-pane fade show {{$check->COUNT_DATA_PEMILIK < 8 ? 'active' : ''}}" id="process1" role="tabpanel" aria-labelledby="dataPemilik-tab">
        <form id="data_pemilik" method="post" action="data_ukm/store_pemilik">
            @csrf
          <div class="mb-3">
            <label for="namaPemilik" class="form-label">Nama Pemilik</label>
            <input type="text" class="form-control" name="namaPemilik" value="{{$data_ukm->nama_pemilik}}" id="namaPemilik" placeholder="Nama Pemilik" required>
          </div>
          <div class="mb-3">
            <label for="nikPemilik" class="form-label">No NIK Pemilik</label>
            <input type="text" class="form-control" id="nikPemilik" value="{{$data_ukm->nik_pemilik}}" placeholder="No NIK (Pemilik/guild UKM)" 
                pattern="\d{16}" minlength="16" maxlength="16" name="nikPemilik" required title="NIK harus terdiri dari 16 angka">
          </div>
          <div class="mb-3">
            <label for="telpPemilik" class="form-label">No Telp Pemilik</label>
            <input type="text" class="form-control" id="telpPemilik" value="{{$data_ukm->phone_pemilik}}" name="telpPemilik" placeholder="No Telp (Pemilik/guild UKM)" 
                minlength="10" maxlength="13" required title="No Harus lebih dari atau sama dengan 10 angka">
          </div>
          <div class="mb-3">
            <label for="jenisKelaminPemilik" class="form-label">Jenis Kelamin Pemilik</label>
            <select class="form-select" name="jenisKelaminPemilik" id="jenisKelaminPemilik" required>
                <option value="" disabled {{empty($data_ukm->pendidikan_terakhir_pemilik) ? 'selected' : ''}}>Pilih...</option>
                <option value="L" {{$data_ukm->jenis_kelamin_pemilik == 'L'? 'selected' : ''}}>Laki-laki</option>
                <option value="P" {{$data_ukm->jenis_kelamin_pemilik == 'P'? 'selected' : ''}}>Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="tempatLahirPemilik" class="form-label">Tempat Lahir Pemilik</label>
            <input type="text" class="form-control" name="tempatLahirPemilik" value="{{$data_ukm->tempat_lahir_pemilik}}" id="tempatLahirPemilik" placeholder="Tempat Lahir" required>
          </div>
          <div class="mb-3">
            <label for="tanggalLahirPemilik" class="form-label">Tanggal Lahir Pemilik</label>
            <input type="date" class="form-control" name="tanggalLahirPemilik" value="{{$data_ukm->tanggal_lahir_pemilik}}" id="tanggalLahirPemilik" required>
          </div>
          <div class="mb-3">
            <label for="pendidikanTerakhirPemilik" class="form-label">Pendidikan Terakhir Pemilik</label>
            <select class="form-select" name="pendidikanTerakhirPemilik" id="pendidikanTerakhirPemilik" required>
                <option value="" disabled {{empty($data_ukm->pendidikan_terakhir_pemilik) ? 'selected' : ''}}>Pilih...</option>
                <option value="S3" {{$data_ukm->pendidikan_terakhir_pemilik == 'S3'? 'selected' : ''}} >S3</option>
                <option value="S2" {{$data_ukm->pendidikan_terakhir_pemilik == 'S2'? 'selected' : ''}}>S2</option>
                <option value="S1" {{$data_ukm->pendidikan_terakhir_pemilik == 'S1'? 'selected' : ''}}>S1</option>
                <option value="D4" {{$data_ukm->pendidikan_terakhir_pemilik == 'D4'? 'selected' : ''}}>D4</option>
                <option value="D3" {{$data_ukm->pendidikan_terakhir_pemilik == 'D3'? 'selected' : ''}}>D3</option>
                <option value="SMA" {{$data_ukm->pendidikan_terakhir_pemilik == 'SMA' ? 'selected' : ''}}>SMA</option>
                <option value="SMP" {{$data_ukm->pendidikan_terakhir_pemilik == 'SMP' ? 'selected' : ''}}>SMP</option>
                <option value="SD" {{$data_ukm->pendidikan_terakhir_pemilik == 'SD'? 'selected' : ''}}>SD</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="alamatPemilik" class="form-label">Alamat Pemilik</label>
            <input type="text" class="form-control" name="alamatPemilik" value="{{$data_ukm->alamat_pemilik}}" id="alamatPemilik" placeholder="Alamat" required>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Selanjutnya
            </button>
            </div>
        </form>
      </div>

      <!-- Data UKM Form -->
      <div class="tab-pane fade {{$check->COUNT_DATA_PEMILIK >= 8 && $check->COUNT_DATA_UKM < 17 ? 'show active' : ''}}" id="process2" role="tabpanel" aria-labelledby="dataUKM-tab">
        <form id="data_ukm" action="data_ukm/store_ukm" method="post">
            @csrf
          <div class="mb-3">
            <label for="namaUKM" class="form-label">Nama UKM</label>
            <input type="text" value="{{$data_ukm->nama_ukm}}" class="form-control" id="namaUKM" name="namaUKM" placeholder="Nama UKM" required>
          </div>
          <div class="mb-3">
            <label for="kegiatanUsaha" class="form-label">Kegiatan Usaha</label>
            <input type="text" class="form-control" value="{{$data_ukm->kegiatan_usaha}}" id="kegiatanUsaha" name="kegiatanUsaha" placeholder="Kegiatan Usaha" required>
          </div>
          <div class="mb-3">
            <label for="produkUKM" class="form-label">Produk yang Dihasilkan</label>
            <input type="text" class="form-control" value="{{$data_ukm->produk_dihasilkan}}" id="produkUKM" name="produkUKM" placeholder="Produk yang Dihasilkan" required>
          </div>
          <div class="mb-3">
            <label for="kategoriProduk" class="form-label">Kategori Jenis Produk</label>
            <select class="form-select" value="{{$data_ukm->id_kategori_ukm}}" name="kategoriProduk" id="kategoriProduk" required>
            <option value="" disabled {{empty($data_ukm->id_kategori_ukm) ? 'selected' : ''}}>Pilih...</option>
                @foreach ($kategori_ukm as $item)
                <option value="{{$item->ID}}" {{$data_ukm->id_kategori_ukm == $item->ID ? 'selected' : ''}}>{{$item->NAMA_KATEGORI_UKM}}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="tahunMemulai" class="form-label">Tahun Memulai Usaha</label>
            <input type="number" class="form-control" value="{{$data_ukm->tahun_mulai}}" 
              id="tahunMemulai" name="tahunMemulai" placeholder="Tahun Memulai Usaha" 
              min="1000" max="9999" title="Isi sesuai tahun UKM anda dimulai" required>
          </div>
          <div class="mb-3 input-group">
              <label for="kapasitasProduksi" class="form-label">Kapasitas Produksi</label>
              <div class="mb-3 input-group">
                  <div class="input-group-text">Pcs</div>
                  <input type="text" class="form-control rupiah" value="{{$data_ukm->kapasitas_produksi}}" id="kapasitasProduksi" name="kapasitasProduksi" placeholder="Kapasitas Produksi" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="volumePerbulan" class="form-label">Volume Perbulan (Omzet)</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_ukm->volume_usaha}}" id="volumePerbulan" name="volumePerbulan" placeholder="Volume Perbulan (Omzet)" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="tenagaLaki" class="form-label">Jumlah Tenaga Kerja Laki-laki</label>
            <input type="number" class="form-control" id="tenagaLaki" value="{{$data_ukm->tenaga_pria}}" name="tenagaLaki" placeholder="Jumlah Tenaga Kerja Laki-laki" required>
          </div>
          <div class="mb-3">
            <label for="tenagaPerempuan" class="form-label">Jumlah Tenaga Kerja Perempuan</label>
            <input type="number" class="form-control" id="tenagaPerempuan" value="{{$data_ukm->tenaga_wanita}}"name="tenagaPerempuan" placeholder="Jumlah Tenaga Kerja Perempuan" required>
          </div>
          <div class="mb-3">
            <label for="bentukUsaha" class="form-label">Bentuk Badan Usaha</label>
            <select class="form-select" name="bentukUsaha" id="bentukUsaha" value="{{$data_ukm->id_badan_usaha}}"required>
              <option value="" disabled {{empty($data_ukm->id_badan_usaha) ? 'selected' : ''}}>Pilih...</option>
              @foreach ($badan_usaha as $item)
                <option value="{{$item->ID}}" {{$data_ukm->id_badan_usaha == $item->ID? 'selected' : ''}}>{{$item->NAMA_BADAN_USAHA}}</option>
              @endforeach
              <!-- Add options from master -->
            </select>
          </div>
          <div class="mb-3">
            <label for="npwp" class="form-label">NPWP</label>
            <select class="form-select" name="npwp" value="{{$data_ukm->npwp}}" id="npwp">
              <option value="" {{empty($data_ukm->npwp) ? 'selected' : ''}}>Pilih...</option>
              <option value="1" {{$data_ukm->npwp == 1 ? 'selected' : ''}}>Ada</option>
              <option value="0" {{$data_ukm->npwp == 0 ? 'selected' : ''}}>Tidak Ada</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="lokasiPemasaran" class="form-label">Lokasi Pemasaran</label>
            <input type="text" class="form-control" id="lokasiPemasaran" value="{{$data_ukm->lokasi_pemasaran}}" name="lokasiPemasaran" placeholder="Lokasi Pemasaran" required>
          </div>
          <div class="mb-3">
            <label for="nilaiRealisasi" class="form-label">Nilai Realisasi (Kredit/Pinjaman)</label>
            <div class="mb-3 input-group">
                <div class="input-group-text">Rp.</div>
                <input type="text" class="form-control rupiah" value="{{$data_ukm->nilai_realisasi}}"id="nilaiRealisasi" name="nilaiRealisasi" placeholder="Nilai Realisasi" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="tahunRealisasi" class="form-label">Tahun Realisasi Pinjaman</label>
            <input type="text" pattern="\d{4}" class="form-control" value="{{$data_ukm->tahun_realisasi}}" id="tahunRealisasi"name="tahunRealisasi" placeholder="Tahun Realisasi Pinjaman" minlength="4" maxlength="4" title="Isi sesuai tahun yang valid" required>
          </div>
          <div class="mb-3">
            <label for="alamatUsaha" class="form-label">Alamat Usaha</label>
            <textarea type="text" class="form-control" id="alamatUsaha" name="alamatUsaha" placeholder="Alamat Usaha" required>{{$data_ukm->alamat_ukm}}</textarea>
          </div>
          <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi</label>
            <select class="form-select" name="provinsi" id="provinsi" required>
              <option disabled value="" {{empty($data_ukm->id_provinsi) ? 'selected' : ''}}>Pilih...</option>
              @foreach ($provinsi as $item)
                <option value="{{$item->id_provinsi}}" {{$data_ukm->id_provinsi == $item->id_provinsi? 'selected' : ''}}>{{$item->nama_province}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3 kota" hidden>
            
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Selanjutnya
            </button>
          </div>
        </form>
      </div>

      <!-- Data Lain-lain Form -->
      <div class="tab-pane fade {{$check->COUNT_DATA_PEMILIK >= 8 && $check->COUNT_DATA_UKM >= 17 ? 'show active' : ''}}" id="process3" role="tabpanel" aria-labelledby="dataLain-tab">
        <form action="data_ukm/store_lain" method="POST" id="data_lain">
          @csrf
          <div class="mb-3">
              <label for="sumberBahanBaku" class="form-label">Sumber Bahan Baku</label>
              <select class="form-control select2" id="sumberBahanBaku" name="sumberBahanBaku[]" multiple="multiple" required>
                @foreach ($sumber as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA_SUMBER_BAHAN_BAKU}}</option>
                @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="legalitasUsaha" class="form-label">Legalitas Usaha yang Dimiliki</label>
              <select class="form-control select2" id="legalitasUsaha" name="legalitasUsaha[]" multiple="multiple" required>
                @foreach ($legalitas as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA}}</option>
                @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="wilayahPemasaran" class="form-label">Wilayah Pemasaran</label>
              <select class="form-control select2" id="wilayahPemasaran" name="wilayahPemasaran[]" multiple="multiple" required>
                @foreach ($pemasaran as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA_WILAYAH_PEMASARAN}}</option>
                @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="standarisasiProduk" class="form-label">Standarisasi Produk</label>
              <select class="form-control select2" id="standarisasiProduk" name="standarisasiProduk[]" multiple="multiple" required>
                @foreach ($standart as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA_STANDAR_PRODUK}}</option>
                @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="fasilitas" class="form-label">Fasilitas/Kegiatan yang Pernah Diikuti</label>
              <select class="form-control select2" id="fasilitas" name="fasilitas[]" multiple="multiple" required>
                @foreach ($fasilitas as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA_FASILITAS_KEGIATAN}}</option>
                @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="permasalahan" class="form-label">Permasalahan</label>
              <select class="form-control select2" id="permasalahan" name="permasalahan[]" multiple="multiple" required>
                @foreach ($permasalahan as $item)
                  <option value="{{$item->ID}}">{{$item->NAMA_MASALAH_UKM}}</option>
                @endforeach
              </select>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Selanjutnya
            </button>
          </div>
        </form>
    </div>
  </div>
</div>
<script>
    $('#process2-tab').click(function() {
        @if ($check->COUNT_DATA_PEMILIK < 8)
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Pemilik UKM belum lengkap!',
            });
            $(this).removeClass('active');
            $('#process1-tab').addClass('active');
        @endif
    });
    $('#process3-tab').click(function() {
        @if ($check->COUNT_DATA_UKM < 17)
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data UKM belum lengkap!',
            });
            $(this).removeClass('active');
            $('#process2-tab').addClass('active');
        @endif
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

        var bahanBakuValues = {!! json_encode(array_column($tb_bahan_baku_ukm, 'id_bahan_baku')) !!};
        var legalitasValues = {!! json_encode(array_column($tb_legalitas_ukm, 'id_legalitas_usaha')) !!};
        var pemasaranValues = {!! json_encode(array_column($tb_pemasaran_ukm, 'id_pemasaran')) !!};
        var standarisasiValues = {!! json_encode(array_column($tb_standart_ukm, 'id_standarisasi_produk')) !!};
        var fasilitasValues = {!! json_encode(array_column($tb_fasilitas_ukm, 'id_fasilitas')) !!};
        var permasalahanValues = {!! json_encode(array_column($tb_permasalahan_ukm, 'id_permasalahan')) !!};

        // Function to set values and trigger change for Select2 fields
        function setSelect2Values(selector, values) {
            $(selector).val(values).trigger('change');
        }

        // Set values for each Select2 input field
        setSelect2Values('#sumberBahanBaku', bahanBakuValues);
        setSelect2Values('#legalitasUsaha', legalitasValues);
        setSelect2Values('#wilayahPemasaran', pemasaranValues);
        setSelect2Values('#standarisasiProduk', standarisasiValues);
        setSelect2Values('#fasilitas', fasilitasValues);
        setSelect2Values('#permasalahan', permasalahanValues);
    });

    $('#provinsi').change(function() {
        let id = $(this).val();
        $.ajax({
            url: "get-kota",
            type: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('.kota').removeAttr('hidden');
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
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select options",
            allowClear: true
        });
    });
 
</script>

@endsection