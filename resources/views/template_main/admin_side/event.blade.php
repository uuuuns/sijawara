<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= url('dashboard') ?>" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Home</a>
                <span class="breadcrumb-item active"><?= $title ?></span>
            </nav>
        </div>
    </div>
    {{-- <?php if (!empty($this->session->flashdata('msg'))) { ?>
    <div class="alert alert-success">
        <div class="d-flex align-items-center justify-content-start">
            <span class="alert-icon">
                <i class="anticon anticon-check-o"></i>
            </span>
            <span><?= $this->session->flashdata('msg') ?></span>
        </div>
    </div>
    <?php } ?> --}}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <label class="card-title" style="font-size: 20px">Event</label>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" onclick="openModal()">
                            <i class="mdi mdi-plus me-1"></i>
                            Add Event</button>
                    </div>
                </div>
            </div>
            <div class="m-t-25">
                <table class="table mb-0" id="dtTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 500px;">Nama Event</th>
                            <th>Status</th>
                            <th>Event Price</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>

                        @foreach ($event as $item)
                            <?php $number++; ?>
                            <tr>
                                <td><?= $number ?></td>
                                <td><?= $item->TITLE_ACTIVITY ?></td>
                                <td><?= $item->STATUS ?></td>
                                <td><?= $item->PRICE_ACTIVITY ?></td>
                                <td><?= date_format(date_create($item->DATE_START), 'j F Y H:i:s') ?></td>
                                <td>
                                    <button type="button"
                                        onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-primary waves-effect waves-light">
                                        <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button"
                                        onclick="opendeleteModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                        class="btn btn-subtle-danger waves-effect waves-light">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
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
<div class="modal" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image_activity" accept=".jpg, .png" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="title_activity" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control CurrencyInput" name="price_activity">
                        <div class="col-md-5">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Free
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="date_start" placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Certificate Code <span class="text-danger">*</span></label>
                        <input placeholder="Certificate Code" type="text" name="sertif_code" class="form-control"
                            required>
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
                        <label>Contact Person <span class="text-danger">*</span></label>
                        <input placeholder="+62 83342457452" type="text" name="contact" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="Penyelenggara" type="text" name="penyelenggara" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Location <span class="text-danger">*</span></label>
                        <input placeholder="Location" type="text" name="location" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Link Zoom </label>
                        <input placeholder="zoom.com/" type="text" name="link_zoom" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi Event</label>
                        <textarea name="desc_event" id="editor"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="confirmButton">
                        <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                            Loading</span>
                        <span class="main-btn">Confirm</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Add --}}

{{-- Start Modal Update--}}
<div class="modal" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="id_activity" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Cover <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image_activity" accept=".jpg, .png" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input placeholder="Title" type="text" name="title_activity" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control CurrencyInput" name="price_activity">
                        <div class="col-md-5">
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Free
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="date_start"
                            placeholder="Date Start">
                    </div>
                    <div class="form-group mb-3">
                        <label>Certificate Code <span class="text-danger">*</span></label>
                        <input placeholder="Certificate Code" type="text" name="sertif_code" class="form-control"
                            required>
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
                        <label>Contact Person <span class="text-danger">*</span></label>
                        <input placeholder="+62 83342457452" type="text" name="contact" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Penyelenggara <span class="text-danger">*</span></label>
                        <input placeholder="Penyelenggara" type="text" name="penyelenggara" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Location <span class="text-danger">*</span></label>
                        <input placeholder="Location" type="text" name="location" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Link Zoom </label>
                        <input placeholder="zoom.com/" type="text" name="link_zoom" class="form-control"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi Event</label>
                        <textarea name="up_desc_event" id="up_desc_event"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="confirmButton">
                        <span class="loader"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                            Loading</span>
                        <span class="main-btn">Confirm</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Update --}}

{{-- Start Modal Delete --}}
<div class="modal" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-user" action="events/delete" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Apakah Anda Ingin Menghapus Event ini ?</label>
                    <div class="hidden">
                        <input placeholder="Title" type="hidden" name="id_activity" class="form-control" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Delete --}}

<script>
    $('#dtTable').DataTable();

    CKEDITOR.replace('desc_event');
    CKEDITOR.replace('up_desc_event');
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
        $('input[name="id_activity"]').val(data.ID_ACTIVITY)
        $('input[name="image_activity"]').attr('data-default-file', data.IMAGE_ACTIVITY)
        $('input[name="title_activity"]').val(data.TITLE_ACTIVITY)
        $('input[name="price_activity"]').val(data.PRICE_ACTIVITY)
        $('input[name="date_start"]').val(data.DATE_START)
        $('input[name="sertif_code"]').val(data.SERTIF_CODE)
        $('input[name="category"]').val(data.CATEGORY)
        $('input[name="contact"]').val(data.CONTACT_CUSTOMER)
        $('input[name="penyelenggara"]').val(data.ORGANIZER)
        $('input[name="location"]').val(data.LOCATION)
        $('input[name="link_zoom"]').val(data.LINK_ZOOM)
        $.ajax({
            url: 'events/get/' + data.ID_ACTIVITY, // Ganti 'URL_target' dengan URL yang tepat
            method: 'GET', // Atau 'POST' tergantung pada kebutuhan Anda
            dataType: 'JSON', // Ganti 'json' dengan 'html', 'text', dll. tergantung pada jenis respons yang diharapkan

            success: function(response) {
                CKEDITOR.instances.up_desc_event.setData(response[0].event.DESKRIPSI_EVENT);
            },
            error: function(xhr, status, error) {}
        });
        $('#updateModal').modal('show')
    }

    function opendeleteModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id_activity"]').val(data.ID_ACTIVITY)
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

    function zoomLinkCheck(e) {
        if ($(e).val() == 2) {
            $('input[name="link_zoom"]').prop('disabled', true);
            $('input:text[name="link_zoom"]').val('')
        } else {
            $('input[name="link_zoom"]').prop('disabled', false);
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
</script>
