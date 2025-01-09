@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<style>
    .disabled-btn {
        background-color: #6c757d !important;
        /* Gray background */
        border-color: #6c757d !important;
        /* Matching border */
        color: #fff !important;
        /* White text color */
        cursor: not-allowed;
        /* Shows that the button is disabled */
        opacity: 1 !important;
        /* Make sure the button isn't faded */
        box-shadow: none !important;
        /* Remove any default box-shadow */
    }

    .disabled-btn:disabled {
        opacity: 1 !important;
        /* Ensure button opacity is set to 1 */
        pointer-events: none;
        /* Prevent any interaction with the button */
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
                    <h3 class="fw-bold" style="color:#45b104">Undang user</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-end align-items-center">
                    <div class="mt-3 mt-md-0">
                        <button id="send_invitation" onClick="batch_invitation()" class="text-end btn btn-sm-2 rounded btn-primary">Kirim Undangan</button>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <form id="invitation-form" class="mt-3" action="{{ url('kursus-admin/invite_batch') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_act" value="<?= $activity->ID_ACTIVITY ?>">
                    <input type="hidden" name="selected_users" id="selected-users">
                    <div class="table-responsive">
                        <table class="table mb-0" id="dtTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>No Telpon</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Action</th>
                                    <th><input type="checkbox" id="check-all"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>

                                @foreach ($users as $item)
                                <?php $number++; ?>
                                <tr>
                                    <td><?= $number ?></td>
                                    <td><?= $item->NAME ?></td>
                                    <td><?= $item->EMAIL ?></td>
                                    <td><?= $item->TELP ?></td>
                                    <td><?= $item->JK ?></td>
                                    <td>
                                        @if ($item->is_invited)
                                        <button type="button" class="btn btn-warning rounded btn-sm-2  waves-effect waves-light fs-8 px-2" onclick="openmodalDelete(`<?= $item->ID_USER?>`, `<?=$activity->ID_ACTIVITY ?>`)">
                                            <i class="bx bx-trash font-size-16 align-middle"></i> Batalkan Undangan
                                        </button>
                                        @else
                                        <button type="button" id="send_cfl_individu<?= $item->ID_USER ?>" onclick="opensendModal(`<?= htmlentities(json_encode($item)) ?>`)" class="btn btn-primary rounded btn-sm-2  waves-effect waves-light fs-8 px-2">
                                            <i class="bx bx-send font-size-16 align-middle send_cfl_individu<?= $item->ID_USER ?>"></i>
                                            Kirim Undangan
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->is_invited)
                                        @else
                                        <input class="dt-checkbox" type="checkbox" value="<?= $item->ID_USER ?>" name="id_user[]" id="check-all">
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->

{{-- Start Modal Invite --}}
<div class="modal" id="sendModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Undang User ?</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-add" action="{{ url('kursus-admin/invite_individu') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <p>Undang user ke kursus "{{ $activity->TITLE_ACTIVITY }}"</p>
                        <input type="hidden" name="id_user">
                        <input type="hidden" name="id_activity" value="<?= $activity->ID_ACTIVITY ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary rounded waves-effect waves-light">
                        <i class="bx bx-send font-size-16 align-middle"></i> Undang User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Invite --}}

{{-- Start Undo Invite --}}
<div class="modal" id="DeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Batalkan Undangan?</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-delete" action="{{ url('kursus-admin/batalkan_undangan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <p>Batalkan undangan user ini dari kursus "{{ $activity->TITLE_ACTIVITY }}"</p>
                        <input type="hidden" name="id_user">
                        <input type="hidden" name="id_activity" value="<?= $activity->ID_ACTIVITY ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-warning rounded waves-effect waves-light">
                        <i class="bx bx-trash font-size-16 align-middle"></i> Batalkan Undangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Undo Invite --}}

<script>
    $('#dtTable').DataTable();

    function opensendModal(viewData) {
        var data = JSON.parse(viewData)
        $('input[name="id_user"]').val(data.ID_USER)
        $('#sendModal').modal('show')
    }

    function openmodalDelete(id_user, id_activity) {
        $('input[name="id_user"]').val(id_user)
        $('#DeleteModal').modal('show')
    }

    $('#check-all').on('click', function(e) {
        e.stopPropagation()
        $('.dt-checkbox').prop('checked', this.checked);
    });

    function batch_invitation() {
        var selectedUsers = $('.dt-checkbox:checked').map(function() {
            return $(this).val();
        }).get().join(',');

        $('#selected-users').val(selectedUsers);
        $('#invitation-form').submit();
    }
</script>
@endsection