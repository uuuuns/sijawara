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
                        <h3 class="fw-bold" style="color:#45b104">List Peserta Webinar</h3>
                    </div>
                    <div class="mb-3 mt-3 row headerz" style="">
                        <div class="col-md-6 col-sm-12">
                            <div class="d-flex">
                                <div class="d-flex flex-column flex-grow-1"><span
                                        class="font-weight-bolder font-size-lg text-primary mb-1">{{ $event->TITLE_ACTIVITY }}</span>
                                    <span class="text-dark-50 font-weight-normal font-size-sm"></span>
                                    <img src="{{ $event->IMAGE_ACTIVITY }}"
                                        style="display: block; margin-left: auto; margin-right: auto; max-width: 250px"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <?php
                        $date_start_format = new DateTime($event->DATE_START);
                        $date_end_format = new DateTime($event->DATE_END);
                        
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
                                    <span class="font-weight-bolder font-size-lg text-primary mb-1">Online</span>
                                    <table>
                                        <tr>
                                            <td valign="top" class="font-weight-bolder" style="width: 120px;">Tanggal</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ $date_start }} -
                                                {{ $date_end }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="font-weight-bolder">Waktu</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ $date_start_time }} WIB -
                                                {{ $date_end_time }} WIB</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="font-weight-bolder">Kuota Peserta</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">
                                                <?= empty($event->KUOTA_PESERTA) ? 'Tidak Ada Batasan' : $event->KUOTA_PESERTA . ' Orang' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="font-weight-bolder">Meeting URL</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest"><a href="{{ $event->LINK_ZOOM }}"
                                                    target="_blank">{{ $event->LINK_ZOOM }}</a>
                                            </td>
                                        </tr> <!---->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <a href="/events" class="btn btn-sm btn-danger">
                                <i class="fas fa-chevron-left"></i> KEMBALI</a>
                            <button id="exportButton"
                                onclick="location.href='/events/laporan_event?ID_ACTIVITY=<?= $event->ID_ACTIVITY ?>'"
                                class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> LAPORAN</button>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <table class="table mb-0" id="dtTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width: 30%;">Nama Peserta</th>
                                <th>Email</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th style="width: 10%;">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0; ?>

                            @foreach ($list_peserta as $item)
                                <?php $number++; ?>
                                <tr>
                                    <td><?= $number ?></td>
                                    <td><?= $item->NAME ?></td>
                                    <td><?= $item->EMAIL ?></td>
                                    <td><?= $item->TELP ?></td>
                                    <td><?= $item->ALAMAT ?></td>
                                    <td style="text-align: center">
                                        <?php if (!empty($item->FILE)) { ?>
                                        <button type="button"
                                            onclick="openlinkModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                            class="btn btn-primary px-4 py-2 rounded">
                                            Lihat Link
                                        </button>
                                        <?php } else { ?>
                                        <span class="badge bg-warning">Tidak Ada</span>
                                        <?php } ?>
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

    {{-- Start Modal Link --}}
    <div class="modal" id="linkModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Semua Link</h4>
                    <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-3">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div id="file-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal Link --}}

        <script>
            $('#dtTable').DataTable();

            $(document).ready(function() {
                var $editor = $('#desc_event');
                $editor.summernote({
                    height: 200,
                    callbacks: {
                        onPaste: function(e) {
                            console.log('Called event paste', e);
                        },
                        onImageUpload: function(files) {
                            console.log(files);
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
                        onPaste: function(e) {
                            console.log('Called event paste', e);
                        },
                        onImageUpload: function(files) {
                            console.log(files);
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

            function openlinkModal(viewData) {
                var data = JSON.parse(viewData)

                var fileContainer = document.getElementById('file-container');

                var file = data.FILE.split(';');

                // Clear any previous content inside the container
                fileContainer.innerHTML = '';

                // Loop through each item and append it to the modal body
                file.forEach(function(file,index) {
                    // Create a new paragraph element for each file
                    var a = document.createElement('a');
                    a.href = file; // Set the file URL
                    a.textContent = (index + 1) + ". file berkas "; // Set the text for the link
                    a.target = "_blank"; // Open the link in a new tab
                    a.classList.add('d-block'); // Optional: Add a class for styling (e.g., block display)

                    // Append the <a> element to the file container
                    fileContainer.appendChild(a);
                });

                $('#linkModal').modal('show')
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

            function laporan(id) {
                $.ajax({
                    url: '/events/laporan_event?ID_ACTIVITY=' + id,
                    method: 'GET',
                    success: function(response) {
                        window.location.href = '/events/laporan/' + id;
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        </script>
    @endsection
