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
                    <h3 class="fw-bold" style="color:#45b104">Top 10 Pengguna Teraktif</h3>
                </div>
                <div class="col-12">
                    <hr style="border: 1px solid #ddd; margin-top: 15px;">
                </div>
                <div class="col-md-6 align-self-center">
                    Filter:
                    <select class="form-control select-category jenisInstansi"
                        onchange="filterJenisInstansi(this.value)">
                        <option value="">Pilih Jenis Instansi...</option>
                        <option value="UMUM">UMUM</option>
                        <option value="UKM">UKM</option>
                        <option value="KOPERASI">KOPERASI</option>
                        <option value="INSTANSI">INSTANSI</option>
                    </select>
                </div>
                <div class="col-md-6 align-self-center kategori">
                    
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
                                <th>Jenis Instansi</th>
                                <th>Nama Instansi</th>
                                <th>Jenis Kategori</th>
                                <th>Jumlah Aktivitas</th>
                                <th width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ranking as $key => $item)
                            <tr>
                                <td><?= ($key + 1) ?></td>
                                <td><?= $item->NAME ?></td>
                                <td><?= $item->EMAIL ?></td>
                                <td><?= $item->JENIS_INSTANSI ?></td>
                                <td><?= $item->NAMA_INSTANSI ?? '<span class="badge bg-warning">Belum Mengisi</span>'?></td>
                                <td>
                                    <?= ($item->JENIS_INSTANSI != 'KOPERASI' && $item->JENIS_INSTANSI != 'UKM') 
                                        ? $item->JENIS_INSTANSI 
                                        : (empty($item->KATEGORI) 
                                            ? '<span class="badge bg-warning">Belum Mengisi</span>' 
                                            : $item->KATEGORI) 
                                    ?>
                                </td>
                                <td><?= $item->TOTAL_AKTIVITAS ?></td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button" onclick="location.href='user/detail_pengambilan?id_user=<?=$item->ID_USER?>'" style="min-width: 155px !important;" class="btn btn-dark btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2">
                                            <i class="bx bx-list-ul font-size-16 align-middle"></i> Lihat Aktivitas User
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

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $('#dtTable').DataTable();

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

    function filterJenisInstansi(jenis) {        
        $.ajax({
            url: '<?= Request::segment(0) ?>ranking/filter_jenis_instansi',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                jenis: jenis
            },
            success: function (data) {
                $('#dtTable tbody').html(data.html);
                $('.kategori').html(data.filterKategori);
            }
        });
    }

    function filterKategori(kategori) {
        $.ajax({
            url: '<?= Request::segment(0) ?>ranking/filter_kategori',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                kategori: kategori,
                jenis: $('.jenisInstansi').val()
            },
            success: function (data) {
                $('#dtTable tbody').html(data.html);
            }
        });
    }
</script>
@endsection




















