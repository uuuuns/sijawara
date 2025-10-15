<div class="mb-5">
    <div class="container d-grid d-md-flex p-0 p-md-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block"></div>
            <h1 class="col-lg-6 p-4 pe-4 pe-md-5">Perbarui Kata sandi anda</h1>
            <div class="col-12 col-lg-6 h-100 p-4 pe-4 pe-md-5 bg-white rounded-5 position-relative" id="formLogin">
                <form id="form-change-password" action="{{ url('submit_sandi') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <p>Kata Sandi Baru</p>
                        <div class="row">
                            <div class="input-group mb-4 pb-lg-3">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="registerPassword1" placeholder="Buat Kata Sandi Baru" name="password"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword1"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                            <p>Konfirmasi Kata Sandi Baru</p>
                            <div class="input-group mb-4 pb-lg-3">
                                <input type="password"
                                    class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                    id="registerPassword2" placeholder="Konfirmasi Kata Sandi"
                                    aria-describedby="passwordHelp" required>
                                <span class="align-self-center fw-semibold" id="togglePassword2"
                                    style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                        class="far fa-eye fs-4"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-main" onclick="changePassword()">Perbarui Kata
                            Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword1 = document.querySelector("#togglePassword1");
    const password = document.querySelector("#registerPassword1");

    const togglePassword2 = document.querySelector("#togglePassword2");
    const password2 = document.querySelector("#registerPassword2");

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
            password2.setCustomValidity("Kata Sandi Tidak Cocok!");
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

    function changePassword() {
        validatePassword();

        const passwordOld = document.querySelector("#registerPasswordOld");
        const password1 = document.querySelector("#registerPassword1");
        const password2 = document.querySelector("#registerPassword2");
        const btn = document.querySelector('.btn.btn-main');

        if (!password1.checkValidity() || !password2.checkValidity()) {
            document.getElementById('form-change-password').reportValidity();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Memproses...`;

        $.ajax({
            url: "{{ url('submit_sandi') }}",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                password: password1.value,
            },
            success: function(response) {
                if (response.status_code === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Kata sandi berhasil diperbarui!',
                        timer: 2000,
                        showConfirmButton: true,
                        didClose: () => {
                            window.location.href = "/";
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: xhr.responseJSON?.message || 'Tidak dapat memproses permintaan.',
                });
            },
            complete: function() {
                btn.disabled = false;
                btn.innerHTML = 'Simpan';
            }
        });
    }
</script>
