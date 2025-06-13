<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="page-wrapper">
    <div class="container">
        <h1 class="text-center mb-3">{{ $title }}</h1>
        <small class="text-center">Sampaikan kebutuhan anda tentang kursus atau pelatihan apa yang anda perlukan</small>
        <div class="feedback-form">
            <form action="{{ url('kursus/store_aspirasi') }}" id="feedback_form" method="post">
                @csrf
                <input type="hidden" name="id_user" value="{{ session('user')[0]->get('ID_USER') }}">
                <div class="form-group">
                    <label for="email">Jenis Aktivitas:</label>
                    <select name="type_activity" id="type_activity" class="form-control" required>
                        <option value="">Pilih Jenis Aktivitas..</option>
                        <option value="1">Kursus</option>
                        <option value="2">Pelatihan/Webinar</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Keterangan:</label><br>
                    <small>Berikan keterangan atau detail tentang aktivitas yang anda butuhkan</small>
                    <textarea class="form-control" rows=6 id="keterangan" name="keterangan" required></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-3">Kirim Aspirasi</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

</script>