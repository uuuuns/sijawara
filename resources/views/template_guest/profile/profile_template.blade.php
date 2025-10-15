<style>
    .sidebar-profile li a {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        line-height: 1.4;
        text-transform: capitalize;
        font-family: var(--theme-heading-font);
    }

    .sidebar-profile li a:hover {
        color: var(--theme-primary-color);
    }
</style>

<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <h5 class="py-2 fw-semibold">Profil</h5>
    <hr class="opacity-25">
    <div class="container-fluid">
        <div class="row main-content flex-column-reverse flex-md-row">
            <div class="col-md-3 sidebar">
                <div class="sidebar__inner">
                    <div class="px-0" style="z-index: 0;">
                        <div class="bg-white shadow rounded-2 overflow-hidden" style="height:max-content">
                            <div class="d-flex flex-column align-items-center align-items-sm-start text-white">
                                <ul class="sidebar-profile nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100"
                                    id="menu">
                                    <li class="nav-item w-100 pt-2">
                                        <a href="{{ url('profil') }}"
                                            class=" {{ request()->is('profil') ? 'active' : '' }}  .  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-user"></i> <span
                                                class="ms-1 ps-2 fs-6 align-self-center ">Data
                                                Pribadi</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>

                                    <!-- INSTRUCTOR SIDEBAR START -->
                                    <!-- if(instructor) -->
                                    <?php if (session('user')[0]['ID_ROLE'] == 2) { ?>
                                    <!-- <li class="nav-item w-100">
                                            <a href="{{ url('profil/overview') }}" class="overview  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-bookmark"></i> <span class="ms-1 ps-2 fs-6 align-self-center ">Ringkasan
                                                    Penjualan</span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li> -->
                                    <li class="nav-item w-100">
                                        <a href="{{ url('dashboard') }}"
                                            class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-book-medical"></i> <span
                                                class="ms-1 ps-2 fs-6 align-self-center ">Buat
                                                Aktifitas</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <?php } ?>
                                    <!-- endif -->
                                    <!-- INSTRUCTOR SIDEBAR END -->

                                    <li class="nav-item w-100">
                                        <a data-bs-toggle="collapse" data-bs-target="#submenu" aria-expanded="true"
                                            aria-controls="submenu"
                                            class="nav-link d-flex align-middle px-4 py-3 rounded-0"
                                            style="cursor: pointer;">
                                            <i class="fs-6 d-flex align-items-center far fa-book-open"></i>
                                            <span class="ms-1 ps-2 fs-6 align-self-center ">Aktifitas Saya</span>
                                            <svg class="svg-inline--fa fa-chevron-down ms-auto" style="width: 18px"
                                                aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="chevron-down" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z">
                                                </path>
                                            </svg>
                                        </a>
                                        <ul class="nav nav-list collapse" id="submenu">
                                            @if (session('user') == null || session('user')[0]['JENIS_INSTANSI'] == 'KDMP')
                                            <li class="nav-item w-100">
                                                <a href="{{ url('profil/kdmpku') }}"
                                                    class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center ">Kursus KDMP Ku</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if (session('user') == null || session('user')[0]['JENIS_INSTANSI'] !== 'KDMP')
                                            <li class="nav-item w-100">
                                                <a href="{{ url('profil/kursusku') }}"
                                                    class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center ">Kursus Ku</span>
                                                </a>
                                            </li>
                                            <li class="w-100">
                                                <hr class="my-0 border border-1 mx-3">
                                            </li>
                                            <li class="nav-item w-100">
                                                <a href="{{ url('profil/webinarku') }}"
                                                    class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center ">Webinar Ku</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    <li class="nav-item w-100">
                                        <a href="{{ url('profil/sertifikatku') }}"
                                            class="nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-file-alt"></i> <span
                                                class="ms-1 ps-2 fs-6 align-self-center ">ٍSertifikat Ku</span>
                                        </a>
                                    </li>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a target="_blank" href="https://kubuku.id/download/e-perpus-sijawara/"
                                            class="nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-book"></i> <span
                                                class="ms-1 ps-2 fs-6 align-self-center ">Perpustakaan</span>
                                        </a>
                                    </li>
                                    @if (
                                        $data_personal->JENIS_INSTANSI == 'UKM' ||
                                            $data_personal->JENIS_INSTANSI == 'KOPERASI;UKM' ||
                                            $data_personal->JENIS_INSTANSI == 'UKM;KOPERASI')
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="{{ url('data_ukm') }}"
                                                class="nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-book"></i> <span
                                                    class="ms-1 ps-2 fs-6 align-self-center ">Data UKM</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (
                                        $data_personal->JENIS_INSTANSI == 'KOPERASI' ||
                                            $data_personal->JENIS_INSTANSI == 'KOPERASI;UKM' ||
                                            $data_personal->JENIS_INSTANSI == 'UKM;KOPERASI')
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="{{ url('data_koperasi') }}"
                                                class="nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center far fa-book"></i> <span
                                                    class="ms-1 ps-2 fs-6 align-self-center ">Data Koperasi</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="#" class="nav-link  d-flex align-middle px-4 py-3 rounded-0"
                                            onclick="resetPassword()">
                                            <i class="fs-6 d-flex align-items-center far fa-lock"></i> <span
                                                class="ms-1 ps-2 fs-6 align-self-center ">Ganti
                                                Kata Sandi</span>
                                        </a>
                                    </li>

                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100 pb-3">
                                        <a href="<?= url('keluar') ?>"
                                            class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center far fa-arrow-alt-to-left"></i>
                                            <span class="ms-1 ps-2 fs-6 align-self-center ">Keluar
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9 content py-4 py-md-0">
                <!-- Page -->
                @yield('content')
            </div>
        </div>
    </div>
</div>

{{-- Start Ganti Kata Sandi --}}
<div class="modal fade" id="changePassworModal" style="z-index: 1060;" id="exampleModalCenter"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ganti Kata sandi</h4>
                <button type="button" class="btn px-2 py-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </button>
            </div>
            <form id="form-change-password" action="{{ url('gantikatasandi') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <p>Kata Sandi Lama</p>
                        <div class="input-group mb-4 pb-lg-3">
                            <input type="password"
                                class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                id="registerPasswordOld" placeholder="Kata Sandi Lama" name="passwordOld"
                                aria-describedby="passwordHelp" required>
                            <span class="align-self-center fw-semibold" id="togglePasswordOld"
                                style="cursor: pointer;margin-left: -46px;z-index: 5;padding: 10px;"><i
                                    class="far fa-eye fs-4"></i></span>
                        </div>
                        <p>Kata Sandi Baru</p>
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
                    <div class="modal-footer">
                        <button type="button" onclick="changePassword()"
                            class="btn btn-sm rounded btn-primary">Ganti Kata Sandi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Ganti Kata Sandi --}}


<style>
    .rotate180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>

<script>
    const togglePasswordOld = document.querySelector("#togglePasswordOld");
    const passwordOld = document.querySelector("#registerPasswordOld");

    const togglePassword1 = document.querySelector("#togglePassword1");
    const password = document.querySelector("#registerPassword1");

    const togglePassword2 = document.querySelector("#togglePassword2");
    const password2 = document.querySelector("#registerPassword2");

    togglePasswordOld.addEventListener("click", function(e) {
        if (passwordOld.value) {
            const type = passwordOld.getAttribute("type") === "password" ? "text" : "password";
            passwordOld.setAttribute("type", type);
            togglePasswordOld.innerHTML = passwordOld.getAttribute("type") === "password" ?
                "<i class='far fa-eye fs-4'></i>" :
                "<i class='far fa-eye-slash fs-4'></i>";
            e.preventDefault();
        }
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
        const btn = document.querySelector('.btn.btn-primary');

        if (!passwordOld.checkValidity() || !password1.checkValidity() || !password2.checkValidity()) {
            document.getElementById('form-change-password').reportValidity();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Memproses...`;

        $.ajax({
            url: "{{ url('gantikatasandi') }}",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                passwordOld: passwordOld.value,
                password: password1.value,
                password_confirmation: password2.value,
            },
            success: function(response) {
                if (response.status_code === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Kata sandi berhasil diperbarui!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#changePassworModal').modal('hide');
                        $('#form-change-password')[0].reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal!',
                        text: response.message || 'Gagal memperbarui kata sandi.',
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

<script type="text/javascript">
    function resetPassword() {
        $('#changePassworModal').modal('show');
    }

    function openModal() {
        $('#tokenModal').modal('show');
    }

    $('button[data-bs-dismiss="modal"]').click(function() {
        $('#tokenInput').val('');
    });

    $(document).ready(function() {
        $('#submenu').on('show.bs.collapse', function() {
            $('.fa-chevron-down').addClass('rotate180');
        });

        $('#submenu').on('hide.bs.collapse', function() {
            $('.fa-chevron-down').removeClass('rotate180');
        });
    });

    // var sidebar = new StickySidebar('.sidebar', {
    //     topSpacing: 20,
    //     bottomSpacing: 20,
    //     containerSelector: '.main-content',
    //     innerWrapperSelector: '.sidebar__inner'
    // });

    function apply_instructor() {
        Swal.fire({
            title: '<strong class="h4">Apakah kamu yakin akan melamar sebagai instruktur ?</strong>',
            showDenyButton: true,
            showCancelButton: false,
            allowOutsideClick: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= url('apply_instructor') ?>';
            }
        })
    }
</script>
