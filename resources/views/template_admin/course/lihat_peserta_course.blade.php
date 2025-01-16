@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<style>
    [onclick] {
        cursor: pointer;
    }
</style>
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
                    <h3 class="fw-bold" style="color:#45b104">List Peserta Kursus</h3>
                </div>
                <div class="mb-3 mt-3 row headerz" style="">
                    <div class="col-md-6 col-sm-12">
                        <div class="d-flex">
                            <div class="d-flex flex-column flex-grow-1"><span
                                    class="font-weight-bolder font-size-lg text-primary mb-1">{{$kursus->TITLE_ACTIVITY}}</span> <span class="text-dark-50 font-weight-normal font-size-sm"></span>
                                <img src="{{$kursus->IMAGE_ACTIVITY}}" style="display: block; margin-left: auto; margin-right: auto; max-width: 250px" alt="">
                            </div>
                        </div>
                    </div>
                    <?php 
                        $date_start_format = new DateTime($kursus->DATE_START);
                        $date_end_format = new DateTime($kursus->DATE_END);

                        $date_start = $date_start_format->format('d M Y');
                        $date_end = $date_end_format->format('d M Y');

                        $date_start_time = $date_start_format->format('H.i');
                        $date_end_time = $date_end_format->format('H.i');
                    ?>
                    <div class="col-md-6 col-sm-12">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column flex-grow-1">
                                <br>
                                <br>
                                <span
                                    class="font-weight-bolder font-size-lg text-primary mb-1">Online</span>
                                <table>
                                    <tr>
                                        <td valign="top" class="font-weight-bolder" style="width: 120px;">Tanggal</td>
                                        <td valign="top"> : </td>
                                        <td valign="top" class="font-weight-boldest">{{$date_start}} - {{$date_end}}</td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="font-weight-bolder">Waktu</td>
                                        <td valign="top"> : </td>
                                        <td valign="top" class="font-weight-boldest">{{$date_start_time}} WIB - {{$date_end_time}} WIB</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-danger">
                    <i class="fas fa-chevron-left"></i> KEMBALI</a> 
                    <button id="exportButton" onclick="location.href='/kursus-admin/laporan_course?ID_ACTIVITY=<?=$kursus->ID_ACTIVITY?>'" class="btn btn-sm btn-success text-white"><i class="fas fa-file-excel text-white"></i> LAPORAN</button>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <button id="lihatKomen" class="btn btn-sm btn-success text-white"><i class="bx bx-comment-dots text-white"></i> Lihat Komentar</button>
                </div>
            </div>
            <div class="mt-5">
                <table class="table mb-0 table-hover" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 500px;">Nama Peserta</th>
                            <th>Email</th>
                            <th>Lokasi</th>
                            <th>Progress</th>
                            <th>Nilai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($list_peserta as $item)
                            <?php $number++; ?>
                            <tr onclick="window.open('/user/detail_pengambilan?id_user=<?=$item->ID_USER?>', '_blank')">
                                <td><?= $number ?></td>
                                <td><?= $item->NAME ?></td>
                                <td><?= $item->EMAIL?></td>
                                <td><?= $item->ALAMAT?></td>
                                <td><?= $item->PROGRESS?></td>
                                <td><?= $item->NILAI?></td>
                                <td><?= empty($item->DATE_COMPLETED) ? "Belum Selesai" : $item->DATE_COMPLETED?></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->


{{-- Start Modal Komentar --}}
<div class="modal fade" id="modalKomentar" tabindex="-1" aria-labelledby="modalKomentarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Komentar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table inside the modal -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Komentar</th>
                            <th scope="col">Tanggal Komentar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komentar as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->NAME}}</td>
                            <td>{{$item->komentar}}</td>
                            <td>{{ date('H:i d-m-Y', strtotime($item->LOG_TIME)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Komentar --}}

<script>
    $('#dtTable').DataTable();

    $('.loader').hide();
    $('.main-btn').show();

    $('.modal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    $('#lihatKomen').click(function () {
        $('#modalKomentar').modal('show');
    });
</script>
@endsection