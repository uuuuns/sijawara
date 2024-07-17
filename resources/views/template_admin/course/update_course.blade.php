@extends('template_admin.admin_template')
@section('content')
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    {{-- <?php if (!empty(validation_errors())) { ?>
        <div class="alert alert-warning">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-exclamation-o"></i>
                </span>
                <span><?= validation_errors() ?></span>
            </div>
        </div>
    <?php } ?> --}}
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h3 class="fw-bold" style="color:#45b104">Ubah Kursus {{ $data->TITLE_ACTIVITY }}</h3>
                </div>
            </div>
            <div class="mt-5">
                <form id="form-user" action="store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kover Depan <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <div class="custom-file">
                                <input type="file" name="image_activity" class="custom-file-input dropify" accept=".jpg, .png" data-allowed-file-extensions="jpg png" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Judul <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title_activity" placeholder="Judul Kursus" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">
                            Harga <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <input type="number" class="form-control CurrencyInput" name="price_course" placeholder="0">
                            <span class="d-flex align-items-center gap-2 mt-2">
                                <div class="switch mt-2">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Gratis
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Tanggal Kursus<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start" placeholder="Date Start" required>
                                <span class="p-h-10">to</span>
                                <input type="datetime-local" class="form-control" name="date_end" placeholder="Date End" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Pengumuman</label>
                        <div class="col-md-10">
                            <textarea name="announcement" id="editor"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Deskripsi<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="desc_course" id="editor" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">List Materi<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <textarea name="desc_what_to_learn" id="editor" rows=11 cols=50 maxlength=250 required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kode Sertifikat<span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="certif_code" placeholder="Certificate Code" style="text-transform: uppercase" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kategori <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="select2" name="category">
                                @foreach ($kategori as $item)
                                <option value="<?= $item->ID_KATEGORI ?>"><?= $item->KATEGORI ?>
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Status</label>
                        <div class="col-md-5 column">
                            <div class="switch m-r-10">
                                <input type="checkbox" id="switch-1" name="status" checked="">
                                <label for="switch-1"></label>
                            </div>
                        </div>
                    </div>
                    <div class="accordion materi_form" id="accordion-default">

                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter" class="btn btn-primary btn-sm rounded col-md-12" style="cursor: pointer;">
                                <span class="col-md-12">Tambahkan Materi atau Kuis</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-end mt-5">
                        <button type="submit" class="btn btn-primary rounded btn-submit-form">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Start Add Item --}}
<div class="modal fade" style="z-index: 1060;" id="exampleModalCenter" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">Tambahkan Bab atau kuis ?</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around py-4">
                    <a href="javascript.void(0)" id="add_materi" data-bs-dismiss="modal" class="rounded btn btn-success col-md-5 py-5 h-100 text-white">
                        <h1><i class="far fa-book text-white"></i></h1> BAB
                    </a>
                    <a href="javascript.void(0)" id="add_quiz" data-bs-dismiss="modal" class="rounded btn btn-danger col-md-5 py-5 h-100">
                        <h1><i class="far fa-trophy text-white"></i></h1> KUIS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End add Item --}}

<script>
    var i = 0;
    var j = 0;
    var limit = 0;

    CKEDITOR.replace('announcement');
    CKEDITOR.replace('desc_course');
    CKEDITOR.replace('desc_what_to_learn');

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('')
        }
    })

    $('#add_materi').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_materi/' + i,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                i++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").addClass("disabled");
        $("#add_item").html("Loading...");
        $.ajax({
            url: 'add_quiz/' + j,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("disabled");
                $("#add_item").html("Tambahkan Bab atau Kuis");
                i++;
                limit++;
            }
        });
        e.preventDefault();
    });

    //GET ALL MATERI
    //Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius corrupti mollitia magni aut consequuntur esse, est labore omnis corporis, libero ea incidunt quasi excepturi molestiae id ut quaerat ab quo reiciendis aperiam in perferendis reprehenderit tenetur quos. Saepe ipsum natus unde quisquam ab, fuga odit vel eligendi eveniet tempora possimus illo incidunt ipsa corrupti inventore accusantium quia voluptate. Facere nam libero, eaque magni fuga quae sit delectus accusamus. Est, molestias animi magni non ex maiores dicta nemo. Laboriosam distinctio, enim vel qui voluptatem veniam modi eligendi? Earum autem, recusandae aliquid deleniti, consequatur sed veritatis totam laborum dolores facere, tempore eligendi quos ipsam sint fuga voluptatem quo ab ad aperiam suscipit. Nisi praesentium quia tempore accusantium omnis repellat? Quod perferendis impedit facilis nulla nemo. Iste nostrum facilis quis, ad placeat dolores nobis repudiandae cupiditate tempora quos officia laboriosam minus dolorum, quas consequuntur possimus distinctio cumque, in amet odio suscipit nemo? Cum nisi itaque sit ad architecto obcaecati consequatur, nobis ipsum, quod officiis cupiditate labore vitae! Alias omnis quisquam deleniti iste veritatis eum! Debitis nobis iure rem fugit fugiat facilis inventore tempora libero amet commodi! Omnis dolorem deserunt aliquam, illo eos expedita quos cupiditate recusandae atque itaque dicta repellat nostrum nesciunt doloribus commodi molestiae? Exercitationem, reiciendis sint. Culpa fugit quae qui, eos, voluptatibus id voluptatem, modi eius nam numquam eveniet! Doloremque delectus, in ipsam ullam odio fugit veritatis labore quidem saepe enim repellat id ea quo perspiciatis voluptates modi ex nobis a aliquid quam, aut facere minus. Voluptate pariatur eos dicta blanditiis deserunt quisquam quo quam consequuntur inventore vitae a nihil corrupti, odit illo officiis eius fuga similique modi quod sit repellat omnis tempore hic? Itaque quidem quas necessitatibus tempora amet laborum molestias, dolorem eos, non unde harum exercitationem nostrum? Neque obcaecati, exercitationem at ea sequi dolores quam deleniti harum necessitatibus voluptatum quas, maiores, minima similique repellat incidunt eius. Ratione quidem temporibus, quae quos amet dolorum explicabo hic, maiores natus velit aliquam quaerat tempore officiis delectus vitae. Quidem perferendis unde eaque praesentium, minus quo facere perspiciatis ullam atque asperiores qui repudiandae accusantium inventore! Accusamus, quos modi. Minus magni ullam magnam quia error corporis libero similique incidunt necessitatibus! Sit, quisquam harum consequatur enim fugit eius tempore dolorum! Error, voluptates fugit reprehenderit eligendi sequi blanditiis iure provident dolore dolorem quae quam maxime sapiente, corrupti est odit odio eaque placeat recusandae cum nulla, officia possimus quisquam officiis? Voluptatum expedita ea neque necessitatibus aliquid unde. Neque sunt illum odit, iusto velit numquam cumque tenetur molestiae non laborum vel reiciendis nam quis fuga molestias maiores excepturi adipisci, quae, blanditiis tempora sequi provident consequatur enim alias. Quibusdam molestias libero asperiores explicabo provident quisquam ratione obcaecati commodi dolor ullam, harum quia nihil consequuntur ducimus facere nesciunt animi culpa adipisci repellendus a corrupti accusamus enim sequi excepturi. Quisquam, consequuntur expedita beatae voluptates in maiores suscipit dolor veritatis sunt ipsum labore amet iure, dicta incidunt distinctio repudiandae voluptatem qui sed. Delectus magni laboriosam nemo ea tempora. Blanditiis porro nobis rerum quo eveniet at quidem praesentium repudiandae repellendus ex hic libero in, dolor ducimus sit non itaque? Quisquam ipsam ipsum in dicta non veritatis fuga omnis recusandae laboriosam aut? Enim omnis officia ipsa quo illum obcaecati aperiam exercitationem sed esse, dolorum, eaque laudantium officiis eveniet fugit nemo hic doloribus tenetur provident porro fugiat labore quos? Magni dolor sed ab corrupti esse tempora accusantium nemo, consectetur ut neque! Esse odio praesentium similique reiciendis quaerat officia! Impedit quod itaque nostrum delectus eos magni placeat. Officiis veritatis adipisci sapiente necessitatibus laboriosam modi officia soluta iure dolores fugiat labore a quibusdam ipsa similique, alias in reprehenderit aut? Exercitationem distinctio ratione ipsa accusantium. Eligendi quo quidem magnam provident earum reiciendis minima, vitae illum, autem officia repellat sunt, tempore necessitatibus error sed iure nam incidunt illo minus. Dolorem in, ut molestias eaque assumenda velit ea itaque, rerum nobis, aliquid porro voluptas molestiae soluta dolore doloremque cum dicta quaerat sunt ullam accusantium qui! Recusandae odit explicabo mollitia voluptatibus magnam velit a doloribus quam, eius porro id earum ducimus fugit minima placeat sunt aut illum enim? Ab cumque dignissimos quam doloremque, voluptatem velit hic temporibus asperiores, maxime eligendi recusandae deserunt! Iusto quis quae maiores enim qui eos excepturi vel, eaque ex temporibus mollitia deserunt quo delectus soluta impedit consequatur ratione at? Unde obcaecati autem sed hic exercitationem voluptates magni iure dolores eum. Consequuntur esse ullam facere, delectus fugiat adipisci ratione magnam dignissimos est! Dolorum, eos! Eaque ullam laboriosam inventore doloremque minima, sapiente ex tenetur voluptatem eius atque hic quia quibusdam voluptas nulla quod ab aliquam tempora quis ut facilis error cupiditate enim adipisci. Sint, aliquid distinctio accusantium nam nobis rerum. Molestiae quibusdam temporibus sapiente earum aut, praesentium tempore dolorem ipsa eaque in nostrum consequatur nesciunt rem deserunt commodi reiciendis magnam doloremque harum placeat! Fuga, qui labore ad pariatur tempore iusto dolor, enim doloribus amet porro nobis! Similique officiis omnis distinctio, animi sunt iusto sapiente, accusamus officia ratione quidem iste, quam tempore velit error eius laborum dicta? Nobis iste quasi earum impedit consequatur nam ipsa aliquam, id perferendis. Quibusdam possimus atque, aliquam reiciendis ex reprehenderit. Eligendi vitae magnam magni harum officia vel dolor quam similique consectetur consequuntur, placeat itaque voluptatibus minus sapiente explicabo distinctio aliquam unde necessitatibus, blanditiis animi? Molestias quia nesciunt optio voluptatibus fuga quibusdam animi delectus. Ea tempora molestiae quae quam, hic quia quibusdam ullam doloribus eaque in adipisci unde labore porro suscipit ratione dolore, fugiat qui modi! Nihil veritatis deserunt voluptatum laudantium dolorem doloribus suscipit corrupti, recusandae et, itaque harum vitae unde provident omnis! Voluptates quae provident dolorem eveniet ratione sapiente sed. Tenetur alias voluptates, quam ad sequi beatae consequatur blanditiis, minus iure voluptatem eveniet, molestias explicabo! Aut saepe doloremque a harum debitis dignissimos quasi corporis, voluptate quae vel nisi voluptates molestiae corrupti veritatis sequi delectus sint accusantium ipsum nam praesentium deserunt enim aspernatur? Nemo in minima consectetur eius, itaque quis cupiditate voluptas nulla perferendis. Esse beatae molestias in saepe. Quidem eos nesciunt nam, amet tenetur aut maxime eveniet sint quaerat minus totam veniam iure quam ipsam, blanditiis nihil voluptatibus omnis beatae! Natus, repudiandae. Earum obcaecati doloribus non?

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Tarik dan lepas gambar disini atau klik',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'Error'
            },
            error: {
                'fileSize': 'File terlalu besar (1MB maksimal).'
            }
        });
    });
</script>
@endsection