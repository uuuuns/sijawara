@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-0 ms-md-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#45b104">Kursus Ku</h3>
    <div class="table-responsive">
        <table class="table table-hover" style="color: #8A8A8E">
            <thead>
                <tr class="fw-normal text-black">
                    <td scope="col" class="fw-semibold fs-5" width="60%">Kursus</td>
                    <td scope="col" class="fw-semibold fs-5" width="20%">Kategori</td>
                    <td scope="col" class="fw-semibold fs-5" width="20%">Status</td>
                </tr>
            </thead>
            <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                <?php foreach ($course as $item) : ?>
                    <tr onclick="window.location = '<?= url('kursus/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->TITLE_ACTIVITY)) . '?id_activity=' . $item->ID_ACTIVITY) ?>'" style="cursor:pointer">
                        <td class="py-3">
                            <div class="d-flex align-items-center" style="width: max-content;">
                                <img src="<?= $item->IMAGE_ACTIVITY ?>" class="d-block img-fluid rounded-2" style="width: 80px; height: 80px; object-fit: cover">
                                <span class="ms-2"><?= $item->TITLE_ACTIVITY ?></span>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <?= $item->KATEGORI ?>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <?php if ($item->PROGRESS == 100) { ?>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Tuntas</span>
                                <?php } else { ?>
                                    <span class="ms-2">
                                        <?= ceil($item->PROGRESS) ?>%
                                    </span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    if (empty($course)) {
        echo "<div class='text-center fs-4 fw-semibold h-75 d-flex align-items-center justify-content-center'>No Course Available</div>";
    }
    ?>
</div>

<script>
</script>
@endsection