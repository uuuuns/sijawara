<!-- Register -->
<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= asset('assets/images/login-1.png') ?>"
                    class="float-end d-block img-fluid rounded-5 rounded-start h-auto " alt="Gambar nih bos">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 position-absolute" id="formLogin">
                <div class="d-flex ps-md-4 flex-column justify-content-center h-100">
                    <h4 class="ps-1 fw-semibold">Daftar Sebagai Peserta</h4>
                    <form class="fw-normal" id="form_regist" action="{{ url('register/store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div id="form-1">
                            <div class="my-4 float-label-control">
                                <input type="text"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="Inputname1" placeholder="Nama Lengkap" name="name" aria-describedby=""
                                    required>
                            </div>
                            <div class="my-4 float-label-control">
                                <input type="email"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="exampleInputEmail1" placeholder="Alamat Email" name="email"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="my-4 float-label-control">
                                <select id="jenis_instansi" name="jenis_instansi" placeholder="&nbsp;&nbsp; Pilih Jenis Instansi" required>
                                    <option></option>
                                    <option value="KDMP">&nbsp;&nbsp;KDMP</option>
                                    <option value="UKM">&nbsp;&nbsp;UKM</option>
                                    <option value="KOPERASI">&nbsp;&nbsp;KOPERASI</option>
                                    <option value="INSTANSI">&nbsp;&nbsp;INSTANSI</option>
                                    <option value="UMUM">&nbsp;&nbsp;UMUM</option>
                                </select>
                            </div>
                            <div class="input-group my-4">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="registerPassword1" placeholder="Buat Kata Sandi" name="password"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword1"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <div class="input-group my-4 pb-lg-3">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="registerPassword2" placeholder="Konfirmasi Kata Sandi"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword2"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <div class="col-md-12 mr-2 px-md-1 mt-1">
                                <button type="submit"
                                    class="btn btn-primary btn-main-2 w-100 rounded-3 fw-semibold py-2 text-black border-0"
                                    id="next-2">Daftar</button>
                            </div>
                            <div class="my-4 text-center">
                                <span>Sudah punya akun? <a href="<?= url('masuk') ?>" class="text-decoration-none fw-bold text-black">Masuk</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Register -->
<script>
    $(document).ready(function() {
        // Initialize select2 with placeholder
        $("#jenis_instansi").select2({
            placeholder: "Select Requirement ...",
            allowClear: true
        });

        $("#form_regist").submit(function(e) {
            if ($("#jenis_instansi").val() == "") {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Pilih Jenis Instansi'
                });
            }
        });
    });

    // $("#jenis_instansi").on("change", function () {
    //     let selectedValues = $(this).val();

    //     if (selectedValues.length > 1) {
    //         // Filter out invalid values
    //         const validValues = selectedValues.filter(value => value === "UKM" || value === "KOPERASI");

    //         if (selectedValues.length !== validValues.length) {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Jenis Instansi Ganda hanya untuk koperasi dan UKM',
    //                 confirmButtonColor: '#3085d6',
    //                 confirmButtonText: 'OK'
    //             });

    //             // Update the selection and refresh the UI
    //             $(this).val(validValues);
    //             $(this).select2().trigger("change");
    //         }
    //     }
    // });

    var x = document.getElementById("form-1");
    var y = document.getElementById("form-2");

    const togglePassword1 = document.querySelector("#togglePassword1");
    const password = document.querySelector("#registerPassword1");

    const togglePassword2 = document.querySelector("#togglePassword2");
    const password2 = document.querySelector("#registerPassword2");

    function funcNext() {
        x.classList.add("d-none");
        y.classList.remove("d-none");
    }

    function funcPrev() {
        y.classList.add("d-none");
        x.classList.remove("d-none");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if (session()->has('error_msg'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('error_msg') }}'
            });
        @endif
    });


    togglePassword1.addEventListener("click", function(e) {
        if (password.value) {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            togglePassword1.innerHTML = password.getAttribute("type") === "password" ?
                "<i class='far fa-eye fs-4'></i>" :
                "<i class='far fa-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });

    togglePassword2.addEventListener("click", function(e) {
        if (password2.value) {
            const type = password2.getAttribute("type") === "password" ? "text" : "password";
            password2.setAttribute("type", type);
            togglePassword2.innerHTML = password2.getAttribute("type") === "password" ?
                "<i class='far fa-eye fs-4'></i>" :
                "<i class='far fa-eye-slash fs-4'></i>";
            e.preventDefault();
        }
    });

    function validatePassword() {
        if (password.value != password2.value) {
            password2.setCustomValidity("Passwords Don't Match");
        } else {
            password2.setCustomValidity('');
        }

        if (password.value.length < 8) {
            password.setCustomValidity("Passwords harus lebih dari atau sama dengan 8 karakter");
        } else {
            password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    password2.onkeyup = validatePassword;
</script>
