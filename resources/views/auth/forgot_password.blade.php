<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= url('assets/images/login-1.png') ?>"
                    class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 position-absolute" id="formLogin">
                <div class="d-flex ps-4 flex-column justify-content-center h-100">
                    <?= !empty($msg) ? $msg : '' ?>
                    <h4 class="ps-1 fw-semibold">Reset Kata Sandi</h4>
                    <h5 class="fw-normal mt-5">Tolong Masukkan Alamat Email Anda Untuk<br>Reset Kata Sandi Anda</h5>
                    <form class="fw-normal" action="<?= url('lupakatasandi') ?>" method="POST">
                        @csrf
                        <div class="my-4 float-label-control">
                            <input type="email"
                                class="form-control input-text woocommerce-Input woocommerce-Input--text"
                                id="exampleInputEmail1" name="email" id="email" placeholder="Email"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="my-4">
                            <button type="button" onclick="resetPassword()"
                                class="btn btn-main-2 btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0"
                                id="btn-reset">Reset
                                Kata Sandi</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
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
        @if (session()->has('resp_msg'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('resp_msg') }}'
            });
        @endif
        @if (session()->has('succ'))
            Swal.fire({
                icon: 'warning',
                title: '{{ session('succ') }}'
            });
        @endif
    });

    function resetPassword() {
        const btn = $('#btn-reset');
        const originalText = btn.html();

        $.ajax({
            url: "{{ url('/lupakatasandi') }}",
            method: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                email: $('input[name="email"]').val(),
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
            },
            success: function(res) {
                if (res.status_code == 200) {
                    const newPassword = String(res.data);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: `
                            <p>Password berhasil direset.<br>
                            Gunakan kata sandi berikut untuk melakukan login:</p>
                            <div style="margin-top:10px; padding:10px; background:#f3f4f6; border-radius:8px; display:inline-flex; align-items:center;">
                                <span id="new-password"
                                    style="font-size:18px; font-weight:bold; color:#2e7d32; user-select:text;">
                                    ${newPassword}
                                </span>
                                <button id="copy-password"
                                    style="margin-left:10px; padding:4px 8px; font-size:12px; border:none; border-radius:6px; background:#4CAF50; color:white; cursor:pointer;">
                                    📋 Salin
                                </button>
                            </div>
                        `,
                        didOpen: () => {
                            document.getElementById('copy-password').addEventListener('click',
                                function() {
                                    navigator.clipboard.writeText(newPassword).then(() => {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Password disalin ke clipboard!',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    });
                                });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message ||
                            'Terjadi kesalahan pada server saat mereset kata sandi.'
                    });
                }

                btn.prop('disabled', false);
                btn.html(originalText);
            },
            error: function(xhr) {
                let message = 'Gagal mengubah password. Silakan cek kembali input Anda.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: message
                });

                btn.prop('disabled', false);
                btn.html(originalText);
            }
        });
    }
</script>
