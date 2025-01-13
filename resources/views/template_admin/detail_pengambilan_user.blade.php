@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<style>
    [onclick] {
        cursor: pointer;
    }
</style>
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
                    <h3 class="fw-bold" style="color:#45b104">Detail Pengambilan Kursus, Webinar, dan Pelatihan</h3>
                    <br>
                    <p style="margin-bottom: 0;">Nama           : {{$nama_user->NAME}}</p>
                    <p style="margin-bottom: 0;">Jenis Instansi : {{$nama_user->JENIS_INSTANSI}}</p>
                    <p>Nama Instansi                            : {{$nama_user->NAMA_INSTANSI}}</p>
                    <a href="{{ url()->previous() }}" class="btn btn-sm rounded-4 btn-danger">
                        <i class="font-size-16 fas fa-chevron-left"></i> KEMBALI
                    </a>
                </div>
            </div>
            <div class="mt-2">
                @if (empty($activities))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div><span>{{$nama_user->NAME}} Belum pernah mengambil kursus, webinar dan pelatihan</span></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="dtTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Tanggal Diambil</th>
                            </tr>
                        </thead>
                        <tbody class="tableContent">
                            @foreach ($activities as $key => $act)
                            <tr onclick="window.open('<?= url($act->TYPE_ACTIVITY == 1 ? 'courses/lihat_peserta?ID_ACTIVITY=' . $act->ID_ACTIVITY : 'events/lihat_peserta?ID_ACTIVITY=' . $act->ID_ACTIVITY) ?>', '_blank')">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $act->TITLE_ACTIVITY }}</td>
                                <td>
                                    @if ($act->TYPE_ACTIVITY == 1)
                                        <span class="badge bg-warning text-dark">Kursus</span>
                                    @else
                                        <span class="badge bg-success">Webinar/Pelatihan</span>
                                    @endif
                                </td>
                                <td>{{ $act->LOG_TIME }}</td>
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

<script>
    $('#dtTable').DataTable()

    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

</script>
@endsection