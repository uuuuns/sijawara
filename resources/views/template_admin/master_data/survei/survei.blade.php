@extends('template_admin.admin_template')
@section('content')
    <div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
        <div class="">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <h3 class="fw-bold" style="color:#45b104">Master Survei</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end justify-content-center align-items-center">
                        <div class="mt-3 mt-md-0">
                            <button type="button" class="btn btn-primary btn-sm-2 rounded" onclick="openaddModal()">
                                <i class="mdi mdi-plus me-1"></i>
                                Tambah Survei
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="table-responsive">
                        <table class="table mb-0" id="dtTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Kategori</th>
                                    <th>Opsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($survei as $item)
                                    <?php $number++; ?>
                                    <tr>
                                        <td><?= $number ?></td>
                                        <td>{{ $item->TEXT }}</td>
                                        <td>{{ $item->KATEGORI }}</td>
                                        <td>
                                            @if ($item->KATEGORI == 'checkbox')
                                                @foreach ($item->checkbox as $c)
                                                    <div>- {{ $c->VALUE }}</div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row gap-2">
                                                <button type="button"
                                                    onclick="openviewModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                                    class="btn btn-warning px-4 py-2 rounded">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>

                                                <button type="button"
                                                    onclick="opendeleteModal(`<?= htmlentities(json_encode($item)) ?>`)"
                                                    class="btn btn-danger px-4 py-2 rounded">
                                                    <i class="bx bx-trash"></i>
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

    <div class="modal" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Survei</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{ url('survei/store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label>Kategori</label>
                            <select name="kategori" id="kategori_add" class="form-control" required>
                                <option value="">-- pilih --</option>
                                <option value="rating">Rating</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="komentar">Komentar</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Pertanyaan</label>
                            <textarea name="text" class="form-control" required></textarea>
                        </div>

                        <div id="checkbox-area-add" style="display:none;">
                            <label>Opsi Checkbox</label>
                            <div id="checkbox-list-add">
                                <input type="text" name="checkbox[]" class="form-control mb-2">
                            </div>
                            <button type="button" onclick="addCheckboxAdd()">Tambah Opsi</button>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="updateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Survei</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{ url('survei/update') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="id_survei">

                        <div class="form-group mb-3">
                            <label>Kategori</label>
                            <select name="kategori" id="kategori_edit" class="form-control">
                                <option value="rating">Rating</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="komentar">Komentar</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Pertanyaan</label>
                            <textarea name="text" class="form-control"></textarea>
                        </div>

                        <div id="checkbox-area-edit" style="display:none;">
                            <label>Opsi Checkbox</label>
                            <div id="checkbox-list-edit"></div>
                            <button type="button" onclick="addCheckboxEdit()">Tambah Opsi</button>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Hapus</h5>
                </div>

                <form action="{{ url('survei/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Yakin hapus data?</p>
                        <input type="hidden" name="id_survei">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $('#dtTable').DataTable()

        function openaddModal() {
            $('#addModal').modal('show')
        }

        function openviewModal(viewData) {
            let data = JSON.parse(viewData)

            $('input[name="id_survei"]').val(data.ID_SURVEI)
            $('textarea[name="text"]').val(data.TEXT)
            $('#kategori_edit').val(data.KATEGORI).trigger('change')
            $('#checkbox-list-edit').html('')

            if (data.KATEGORI === 'checkbox' && data.checkbox) {
                $('#checkbox-area-edit').show()

                data.checkbox.forEach(function(item) {
                    $('#checkbox-list-edit').append(
                        `<input type="text" name="checkbox[]" value="${item.VALUE}" class="form-control mb-2">`
                    )
                })
            } else {
                $('#checkbox-area-edit').hide()
            }
            $('#updateModal').modal('show')
        }

        function opendeleteModal(viewData) {
            let data = JSON.parse(viewData)
            $('input[name="id_survei"]').val(data.ID_SURVEI)
            $('#deleteModal').modal('show')
        }

        function addCheckboxAdd() {
            $('#checkbox-list-add').append(
                `<input type="text" name="checkbox[]" class="form-control mb-2">`
            )
        }

        function addCheckboxEdit() {
            $('#checkbox-list-edit').append(
                `<input type="text" name="checkbox[]" class="form-control mb-2">`
            )
        }

        $('#kategori_add').change(function() {
            if (this.value === 'checkbox') {
                $('#checkbox-area-add').show()
            } else {
                $('#checkbox-area-add').hide()
            }
        })

        $('#kategori_edit').change(function() {
            if (this.value === 'checkbox') {
                $('#checkbox-area-edit').show()
            } else {
                $('#checkbox-area-edit').hide()
            }
        })
    </script>
@endsection
