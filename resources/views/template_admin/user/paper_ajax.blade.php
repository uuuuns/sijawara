<div class="mt-5">
    <div class="table-responsive">
        <table class="table mb-0" id="dtTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama User</th>
                    <th width="10%">Usia</th>
                    <th>Jenis Instansi</th>
                    <th>Lokasi</th>
                    <th width="100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $key => $item)
                <tr>
                    <td><?= ($key + 1) ?></td>
                    <td>3573010407020007</td>
                    <td style="white-space: normal; word-wrap: break-word; word-break: break-word; width: 300px;"><?= $item->NAME ?></td>
                    <td><?= Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse($item->TGL_LAHIR)) ?> Tahun</td>
                    <td><?= $item->JENIS_INSTANSI ?></td>
                    <td><?= $item->nama_kota ?> - <?= $item->nama_province ?></td>
                    <td>
                        <div class="d-flex flex-column gap-2">
                            <button type="button" onclick="location.href='pengguna/detail_pengambilan?id_user=<?=$item->ID_USER?>'" class="btn btn-dark px-4 py-2 rounded">
                                <i class="bx bx-list-ul font-size-16 align-middle"></i> Detail Aktifitas
                            </button>
                            @if (session('user')[0]['ID_ROLE'] == 1)
                            <button type="button" onclick="openUpdateModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-warning px-4 py-2 rounded">
                                <i class="bx bx-edit-alt font-size-16 align-middle"></i> Detail Pengguna
                            </button>
                            @endif
                            @if (session('user')[0]['ID_ROLE'] == 4)
                            <button type="button" onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-warning px-4 py-2 rounded">
                                <i class="bx bx-edit-alt font-size-16 align-middle"></i> Detail Pengguna
                            </button>
                            @endif
                            <button type="button" onclick="opendeleteModal('<?= $item->ID_USER?>')" class="btn btn-danger px-4 py-2 rounded">
                                <i class="bx bx-trash font-size-16 align-middle"></i> Hapus User
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>