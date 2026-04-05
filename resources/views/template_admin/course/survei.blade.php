@extends('template_admin.admin_template')
@section('content')
    <div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
        <div class="">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold">Hasil Survei Aktivitas: {{ $judul->TITLE_ACTIVITY }}</h4>
                    <a href="{{ url('/kursus-admin') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    <form action="{{ url('/kursus-admin/laporan_survei') }}" method="GET" style="display:inline;">
                        <input type="hidden" name="id_activity" value="{{ $id_activity }}">
                        <button type="submit"
                            class="btn btn-success btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2"
                            style="min-width: 155px !important; margin: 5px 0px;">
                            <i class="bx bx-file font-size-16 align-middle"></i> Export Excel Survei
                        </button>
                    </form>
                </div>

                @if (empty($survei_questions))
                    <div class="alert alert-info">Belum ada data survei untuk aktivitas ini.</div>
                @else
                    @foreach ($survei_questions as $q)
                        <div class="mb-5 border-bottom pb-3">
                            <h5 class="text-primary">{{ $loop->iteration }}. {{ $q->TEXT }}</h5>

                            <div class="table-responsive mt-3">
                                <table class="table table-hover table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="150">ID User</th>
                                            <th>Jawaban / Hasil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $has_data = false; @endphp

                                        {{-- Logika Menampilkan Data Berdasarkan Kategori --}}
                                        @if ($q->KATEGORI == 'rating')
                                            @foreach ($rating_data as $r)
                                                @if ($r->ID_SURVEI == $q->ID_SURVEI)
                                                    <tr>
                                                        <td>{{ $r->NAME }}</td>
                                                        <td>
                                                            <span class="text-warning">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="bi {{ $i <= $r->RATING ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                                @endfor
                                                            </span>
                                                            ({{ $r->RATING }}/5)
                                                        </td>
                                                    </tr>
                                                    @php $has_data = true; @endphp
                                                @endif
                                            @endforeach
                                        @elseif($q->KATEGORI == 'checkbox')
                                            @foreach ($checkbox_data as $c)
                                                @if ($c->ID_SURVEI == $q->ID_SURVEI)
                                                    <tr>
                                                        <td>{{ $c->NAME }}</td>
                                                        <td><span
                                                                class="badge bg-info text-dark">{{ $c->VALUE }}</span>
                                                        </td>
                                                    </tr>
                                                    @php $has_data = true; @endphp
                                                @endif
                                            @endforeach
                                        @elseif($q->KATEGORI == 'komentar')
                                            @foreach ($komentar_data as $k)
                                                @if ($k->ID_SURVEI == $q->ID_SURVEI)
                                                    <tr>
                                                        <td>{{ $k->NAME }}</td>
                                                        <td class="fst-italic">"{{ $k->TEXT }}"</td>
                                                    </tr>
                                                    @php $has_data = true; @endphp
                                                @endif
                                            @endforeach
                                        @endif

                                        @if (!$has_data)
                                            <tr>
                                                <td colspan="2" class="text-muted text-center">Tidak ada jawaban</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
