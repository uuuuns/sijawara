@extends('template_admin.admin_template')
@section('content')
    <!-- Content Wrapper START -->
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
                        <h3 class="fw-bold" style="color:#45b104">Pelatihan dan Webinar</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                        <div class="mt-3 mt-md-0">
                            <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openModal()">
                                <i class="mdi mdi-plus me-1"></i>
                                Tambah Webinar / Pelatihan</button>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <table class="table mb-0" id="dtTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width: 500px;">Nama</th>
                                <th>Status</th>
                                <th>Status Private</th>
                                <th>Kuota Peserta</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event as $key => $item)
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $item->TITLE_ACTIVITY ?></td>
                                    <td><?= $item->STATUS == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' ?>
                                    <td><?= $item->IS_PUBLIC == 1 ? '<span class="badge bg-success">Publik</span>' : '<span class="badge bg-danger">Private</span>' ?>
                                    </td>
                                    <td><?= empty($item->KUOTA_PESERTA) ? 'Tidak Ada batasan' : $item->KUOTA_PESERTA ?></td>
                                    </td>
                                    <td><?= date_format(date_create($item->DATE_START), 'j F Y H:i:s') ?></td>
                                    <td><?= date_format(date_create($item->DATE_END), 'j F Y H:i:s') ?></td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <button type="button"
                                                onclick="location.href='webinar-admin/lihat_peserta?ID_ACTIVITY={{ $item->ID_ACTIVITY }}'"
                                                class="btn btn-warning mb-1 btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2"
                                                style="min-width: 155px !important;">
                                                <i class="bx bxs-user-detail font-size-16 align-middle"></i> Lihat Peserta
                                            </button>
                                            @if ($item->IS_PUBLIC == 0)
                                                <form action="kursus-admin/invite" method="GET">
                                                    <input type="hidden" name="id_activity" value="<?= $item->ID_ACTIVITY ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2" style="min-width: 155px !important;">
                                                        <i class="bx bx-send font-size-16 align-middle"></i> Undang User
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button"
                                                onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                                class="btn btn-dark btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2"
                                                style="min-width: 155px !important; margin: 5px 0px;">
                                                <i class="bx bx-edit-alt font-size-16 align-middle"></i> Edit Webinar/Pelatihan
                                            </button>
                                            <button type="button"
                                                onclick="<?= $item->CHECK_PARTICIPANT ? "opendeleteModal('{$item->ID_ACTIVITY}')" : "NotifDelete()" ?>"
                                                class="btn btn-danger btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2"
                                                style="min-width: 155px !important;">
                                                <i class="bx bx-trash font-size-16 align-middle"></i> Hapus Webinar/Pelatihan
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
    <!-- Content Wrapper END -->

    {{-- Start Modal Add --}}
    <div class="modal" id="addModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Event</h4>
                    <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-3">&times;</span>
                    </button>
                </div>
                <form id="form-user" action="{{ url('webinar-admin/add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kover <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="image_activity" accept=".jpg, .png" data-max-file-size="5M"
                                    data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input placeholder="Title" type="text" name="title_activity" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Tanggal Mulai<span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="date_start" required
                                placeholder="Date Start">
                        </div>
                        <div class="form-group mb-3">
                            <label>Tanggal Selesai<span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="date_end" required
                                placeholder="Date End">
                        </div>
                        <div class="form-group">
                            <label>Template Sertifikat <span class="text-danger">*</span></label>
                            <div class="custom-file">
                            <input type="file" name="sertif_image" class="custom-file-input dropify"
                                        accept=".jpg" data-allowed-file-extensions="jpg" required>
                                <small class="text-danger" data-max-file-size="5M">* Hanya Masukkan file JPG dan Ukuran Template adalah Horizontal A4</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kode Sertifikat <span class="text-danger">*</span></label>
                            <input placeholder="Kosongi apabila tidak ada sertifikat" type="text" name="sertif_code"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select class="form-control select-category" name="category" id="cars"
                                onchange="zoomLinkCheck(this)" required>
                                <option value="0">Hybrid</option>
                                <option value="1">Online</option>
                                <option value="2">Offline</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kontak Penyelenggara <span class="text-danger">*</span></label>
                            <input placeholder="+62 83342457452" type="text" name="contact" class="form-control"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Penyelenggara <span class="text-danger">*</span></label>
                            <input placeholder="Penyelenggara" type="text" name="penyelenggara" class="form-control"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kuota Peserta <span class="text-danger"></span></label>
                            <input placeholder="Kosongi apabila tidak ada batasan" type="number" name="kuota_peserta"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Lokasi <span class="text-danger">*</span></label>
                            <input placeholder="Location" type="text" name="location" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Link Zoom </label>
                            <input placeholder="zoom.com/" type="text" name="link_zoom" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="is_aktif">Status Aktif</label>
                            <span class="d-flex align-items-center mt-2">
                                Tidak Aktif
                                <div class="switch m-r-10" style="margin-left: 7px;">
                                    <input type="checkbox" checked id="is_aktif" name="status">
                                    <label for="is_aktif"></label>
                                </div>
                                Aktif
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label>Status Public <span class="text-danger">*</span></label>
                            <select class="form-control select-category" name="status_public" id="status_public" required>
                                <option value="0">Private</option>
                                <option value="1">Public</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Deskripsi Event</label>
                            <textarea name="desc_event" id="desc_event" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded waves-effect waves-light"
                            id="confirmButton">
                            <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                                Loading</span>
                            <span class="main-btn">Konfirmasi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Add --}}

    {{-- Start Modal Update --}}
    <div class="modal" id="updateModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Event</h4>
                    <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-3">&times;</span>
                    </button>
                </div>
                <form id="form-user" action="{{ url('webinar-admin/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="hidden">
                            <input type="hidden" name="up_id_activity" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kover <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="up_image_activity" accept=".jpg, .png"
                                    data-max-file-size="5M" data-allowed-file-extensions="jpg png"
                                    class="custom-file-input dropify">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input placeholder="Title" type="text" name="up_title_activity" class="form-control"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Tanggal Mulai<span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="up_date_start"
                                placeholder="Date Start">
                        </div>
                        <div class="form-group mb-3">
                            <label>Tanggal Selesai<span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="up_date_end"
                                placeholder="Date Start">
                        </div>
                        <div class="form-group">
                            <label>Template Sertifikat <span class="text-danger">*</span></label>
                            <div class="custom-file">
                            <input type="file" name="up_sertif_image" class="custom-file-input dropify"
                                        accept=".jpg" data-allowed-file-extensions="jpg">
                            <small class="text-danger" data-max-file-size="5M">* Hanya Masukkan file JPG dan Ukuran Template adalah Horizontal A4</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kode Sertifikat <span class="text-danger">*</span></label>
                            <input placeholder="Certificate Code" type="text" name="up_sertif_code"
                                class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select class="form-control select-category" name="up_category" id="up_category"
                                onchange="zoomLinkCheck(this)" required>
                                <option value="0">Hybrid</option>
                                <option value="1">Online</option>
                                <option value="2">Offline</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kontak Penyelenggara <span class="text-danger">*</span></label>
                            <input placeholder="+62 83342457452" type="text" name="up_contact" class="form-control"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Penyelenggara <span class="text-danger">*</span></label>
                            <input placeholder="Penyelenggara" type="text" name="up_penyelenggara"
                                class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kuota Peserta <span class="text-danger">*</span></label>
                            <input placeholder="Kosongi Apabila Tidak ada batasan peserta" type="number"
                                name="up_kuota_peserta" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Lokasi <span class="text-danger">*</span></label>
                            <input placeholder="Location" type="text" name="up_location" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Link Zoom </label>
                            <input placeholder="zoom.com/" type="text" name="up_link_zoom" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="up_status">Status Aktif</label>
                            <span class="d-flex align-items-center mt-2">
                                Tidak Aktif
                                <div class="switch m-r-10" style="margin-left: 7px;">
                                    <input type="checkbox" name="up_status" id="up_status">
                                    <label for="up_status"></label>
                                </div>
                                Aktif
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label>Status Public <span class="text-danger">*</span></label>
                            <select class="form-control select-category" name="up_status_public" id="up_status_public" required>
                                <option value="0">Private</option>
                                <option value="1">Public</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Deskripsi Event</label>
                            <textarea name="up_desc_event" id="up_desc_event"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded waves-effect waves-light"
                            id="confirmButton">
                            <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                                Loading</span>
                            <span class="main-btn">Konfirmasi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Update --}}

    {{-- Start Modal Delete --}}
    <div class="modal" id="deleteModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Event</h4>
                    <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-3">&times;</span>
                    </button>
                </div>
                <form id="form-user" action="{{ ('webinar-admin/delete') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Apakah Anda Ingin Menghapus Event ini ?</label>
                        <div class="hidden">
                            <input placeholder="Title" type="hidden" name="id_activity" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Delete --}}

    <script>
        $('#dtTable').DataTable();

        $(document).ready(function() {
            var $editor = $('#desc_event');
            $editor.summernote({
                height: 200,
                callbacks: {
                    onImageUpload: function(files) {
                        $summernote.summernote('insertNode', imgNode);
                    }
                },
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['height', ['height']],
                    ['operation', ['undo', 'redo']],
                    ['para', ['paragraph']],
                    ['object', ['link']]
                ]
            });

            $('#insert-btn').click(() => {
                $editor.summernote('insertParagraph');
            });

            $('#bold-btn').click(() => {
                $editor.summernote('bold');
            });
        });

        $(document).ready(function() {
            var $editor = $('#up_desc_event');
            $editor.summernote({
                height: 200,
                callbacks: {
                    onImageUpload: function(files) {
                        $summernote.summernote('insertNode', imgNode);
                    }
                },
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['height', ['height']],
                    ['operation', ['undo', 'redo']],
                    ['para', ['paragraph']],
                    ['object', ['link']]
                ]
            });

            $('#insert-btn').click(() => {
                $editor.summernote('insertParagraph');
            });

            $('#bold-btn').click(() => {
                $editor.summernote('bold');
            });
        });

        $('.loader').hide();
        $('.main-btn').show();

        $('.modal').on('shown.bs.modal', function() {
            $('#myInput').trigger('focus')
        })

        function openModal() {
            $('#addModal').modal('show')
        }

        function openviewModal(viewData) {
            var data = JSON.parse(viewData)
            var price = data.PRICE_ACTIVITY
            var cat = data.CATEGORY_EVENT
            
            function initializeDropify(inputName, fileUrl) {
                var dropifyElement = $('input[name="' + inputName + '"]').dropify();
                var instance = dropifyElement.data('dropify');
                instance.resetPreview();
                instance.clearElement();
                instance.settings['defaultFile'] = fileUrl;
                instance.destroy();
                instance.init();
            }
            initializeDropify('up_image_activity', data.IMAGE_ACTIVITY);
            initializeDropify('up_sertif_image', data.SERTIF_IMAGE);

            $('input[name="up_id_activity"]').val(data.ID_ACTIVITY)
            $('input[name="up_title_activity"]').val(data.TITLE_ACTIVITY)
            if (price == 0) {
                $('#up_setFree').prop('checked', true);
                $('.up_CurrencyInput').prop('readonly', true)
                $('input[name="up_price_activity"]').val(price)
            } else {
                $('#up_setFree').prop('checked', false);
                $('.up_CurrencyInput').prop('readonly', false)
                $('input[name="up_price_activity"]').val(price)
            }

            $('#up_status').prop('checked', data.STATUS == 1 ? true : false);
            $('input[name="up_date_start"]').val(data.DATE_START)
            $('input[name="up_date_end"]').val(data.DATE_END)
            $('input[name="up_sertif_code"]').val(data.SERTIF_CODE)
            $('select[name="up_category"]').val(cat).change()
            $('input[name="up_contact"]').val(data.CONTACT_CUSTOMER)
            $('input[name="up_penyelenggara"]').val(data.ORGANIZER)
            $('input[name="up_kuota_peserta"]').val(data.KUOTA_PESERTA)
            $('input[name="up_location"]').val(data.LOCATION)
            $('input[name="up_link_zoom"]').val(data.LINK_ZOOM)
            $('input[name="up_status_public"]').val(data.IS_PUBLIC)
            $.ajax({
                url: 'webinar-admin/get/' + data.ID_ACTIVITY,
                method: 'GET',
                dataType: 'JSON',

                success: function(response) {
                    $('#up_desc_event').summernote('code', response[0].event.DESKRIPSI_EVENT);
                },
                error: function(xhr, status, error) {}
            });
            $('#updateModal').modal('show')
        }

        function opendeleteModal(id_activity) {
            $('input[name="id_activity"]').val(id_activity)
            $('#deleteModal').modal('show')
        }

        $('#setFree').change(function() {
            if ($(this).prop('checked')) {
                $('.CurrencyInput').prop('readonly', true)
                $('.CurrencyInput').val(0)
            } else {
                $('.CurrencyInput').prop('readonly', false)
                $('.CurrencyInput').val('')
            }
        })

        $('#up_setFree').change(function() {
            if ($(this).prop('checked')) {
                $('.up_CurrencyInput').prop('readonly', true)
                $('.up_CurrencyInput').val(0)
            } else {
                $('.up_CurrencyInput').prop('readonly', false)
                $('.up_CurrencyInput').val('')
            }
        })

        function zoomLinkCheck(e) {
            if ($(e).val() == 2) {
                $('input[name="link_zoom"]').prop('disabled', true);
                $('input:text[name="link_zoom"]').val('')
                $('input[name="up_link_zoom"]').prop('disabled', true);
                $('input:text[name="up_link_zoom"]').val('')
                $('input[name="location"]').prop('disabled', false).prop('required', true);
                $('input[name="up_location"]').prop('disabled', false).prop('required', true);
            } else if ($(e).val() == 1) {
                $('input[name="location"]').prop('disabled', true);
                $('input:text[name="location"]').val('')
                $('input[name="up_location"]').prop('disabled', true);
                $('input:text[name="up_location"]').val('')
                $('input[name="link_zoom"]').prop('disabled', false).prop('required', true);
                $('input[name="up_link_zoom"]').prop('disabled', false).prop('required', true);
            } else {
                $('input[name="link_zoom"]').prop('disabled', false).prop('required', true);
                $('input[name="up_link_zoom"]').prop('disabled', false).prop('required', true);
                $('input[name="location"]').prop('disabled', false).prop('required', true);
                $('input[name="up_location"]').prop('disabled', false).prop('required', true);
            }
        }

        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih file',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
        $(document).ready(function() {});

        function NotifDelete() {
        Swal.fire({
            title: 'Mohon Maaf',
            text: 'Webinar ini tidak bisa dihapus karena sudah ada peserta yang mengambil Webinar ini',
            icon: 'warning',
            confirmButtonText: 'Oke',
            confirmButtonColor: '#3085d6'
        })
    }
    </script>
@endsection
