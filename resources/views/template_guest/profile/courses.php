<div class="col ms-0 ms-md-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#45b104">Kursus</h3>
    <div class="table-responsive">
        <table class="table" style="color: #8A8A8E">
            <thead>
                <tr class="fw-normal text-black">
                    <td scope="col" class="fw-semibold fs-5" width="60%">Kursus</td>
                    <td scope="col" class="fw-semibold fs-5" width="20%">Kategori</td>
                    <td scope="col" class="fw-semibold fs-5" width="20%">Status</td>
                </tr>
            </thead>
            <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                <tr onclick="location.href='<?= base_url('kursus') ?>" style="cursor:pointer">
                    <td class="py-3">
                        <div class="d-flex align-items-center" style="width: max-content;">
                            <img src="{{ asset('assets/images/course-1.png') }}" class="d-block img-fluid rounded-2" style="width: 80px; height: 80px; object-fit: cover">
                            <span class="ms-2">Pelatihan desain grafis</span>
                        </div>
                    </td>
                    <td class="py-3">UIUX Designer</td>
                    <td class="py-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span>Disetujui</span>
                    </td>
                </tr>
                <tr onclick="location.href='<?= base_url('kursus') ?>" style="cursor:pointer">
                    <td class="py-3">
                        <div class="d-flex align-items-center" style="width: max-content;">
                            <img src="{{ asset('assets/images/course-1.png') }}" class="d-block img-fluid rounded-2" style="width: 80px; height: 80px; object-fit: cover">
                            <span class="ms-2">[BOOT CAMP STIKI] UI/UX Design with Adnan Zulkarnain & Hannie Modesty</span>
                        </div>
                    </td>
                    <td class="py-3">UIUX Designer</td>
                    <td class="py-3">
                        <i class="bi bi-x-circle-fill text-danger"></i>
                        <span>Tidak Disetujui</span>
                    </td>
                </tr>
                <tr onclick="location.href='<?= base_url('kursus') ?>" style="cursor:pointer">
                    <td class="py-3">
                        <div class="d-flex align-items-center" style="width: max-content;">
                            <img src="{{ asset('assets/images/course-1.png') }}" class="d-block img-fluid rounded-2" style="width: 80px; height: 80px; object-fit: cover">
                            <span class="ms-2">Business Talk #4 How to an Opportunity from Different Prespective with Geby
                                Agatha CEO akululus</span>
                        </div>
                    </td>
                    <td class="py-3">UIUX Designer</td>
                    <td class="py-3">
                        <i class="bi bi-exclamation-circle-fill text-warning"></i>
                        <span>Tertunda</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
</script>