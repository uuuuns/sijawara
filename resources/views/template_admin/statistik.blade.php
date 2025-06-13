@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#45b104">Statistik</h3>

    <div class="row">
        <div class="row">
            <select class="form-control mb-3" name="provinsi" id="provinsi">
                <option value="">Pilih provinsi...</option>
                <option value="99">Semua Provinsi</option>
                @foreach ($provinsi as $item)
                <option value="{{$item->id_provinsi}}">{{$item->nama_province}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div style="display: flex; justify-content: center;">
        <div class="row" style="max-width: 60rem; text-align: center;">
            <h4 id="title_chart">Statistik Peserta di semua provinsi</h4>
            <div id="chart">
                <canvas id="myPieChart"></canvas>
            </div>
            <small id="total_user"></small>
        </div>
    </div>
    <div class="row" id="div_kota" hidden>
        <select class="form-control mb-3" name="kota" id="kota">
            <option value="">Pilih Kota...</option>
        </select>
    </div>
    <div style="display: flex; justify-content: center;" id="div_chart_kota" hidden>
        <div class="row" style="max-width: 60rem; text-align: center;">
            <h4 id="title_chart">Statistik User Perdaerah Kabupaten/Kota</h4>
            <div id="chart_kota">
                <canvas id="mybarChart"></canvas>
            </div>
            <small id="total_user"></small>
        </div>
    </div>
</div>

<script>
    var myLineChart;

    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('myPieChart').getContext('2d');
        $.ajax({
            url: 'statistik_per_provinsi',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_provinsi: 99
            },
            success: function(response) {                
                if (myLineChart) {
                    myLineChart.destroy();
                }
                let backgroundColors = response.labels.map((_, index) => `hsl(${index * 360 / response.labels.length}, 70%, 60%)`);
                myLineChart = new Chart(ctx, {
                    type: response.jenis_chart,
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Total Peserta',
                            data: response.data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'left'
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    });

    $('#provinsi').change(function() {
        if (this.value != 99 || this.value != '') {
            $('#div_kota').attr('hidden', false);
            $.ajax({
                url: 'get-kota-option',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: this.value
                },
                success: function(data) {                
                    $('#kota').empty().append('<option disabled selected value="">Pilih Kota...</option>');

                    $.each(data, function(index, value) {
                        $('#kota').append(
                            $('<option></option>').val(value.id_kota).text(value.nama_kota)
                        );
                    });
                }
            });
        } else {
            $('#div_kota').attr('hidden', true);
        }

        $('#chart').empty().append('<canvas id="myPieChart"></canvas>');
        var ctx = document.getElementById('myPieChart').getContext('2d');
        
        let nama_provinsi = this.options[this.selectedIndex].text;
        $.ajax({
            url: 'statistik_per_provinsi',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_provinsi: this.value
            },
            success: function(response) {
                $('#title_chart').empty().append('Statistik Peserta di provinsi ' + nama_provinsi);
                $('#total_user').empty().append('Total Peserta di provinsi ' + nama_provinsi + ' adalah ' + response.Total + ' orang');
                
                if (myLineChart) {
                    myLineChart.destroy();
                }
                let backgroundColors = response.labels.map((_, index) => `hsl(${index * 360 / response.labels.length}, 70%, 60%)`);
                myLineChart = new Chart(ctx, {
                    type: response.jenis_chart,
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Total Peserta',
                            data: response.data,
                            backgroundColor: backgroundColors,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'left'
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    });

    $('#kota').change(function() {
        $('#chart_kota').empty().append('<canvas id="mybarChart"></canvas>');
        var ctx = document.getElementById('mybarChart').getContext('2d');
        let nama_kota = this.options[this.selectedIndex].text;
        var bar_chart;
        $.ajax({
            url: 'statistik_per_kota',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_kota: this.value
            },
            success: function(response) {
                $('#div_chart_kota').attr('hidden', false);
                if (bar_chart) {
                    bar_chart.destroy();
                }

                bar_chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: '',
                            data: response.data,
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Data di Kota ' + nama_kota
                            }
                        }
                    },
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    })

</script>
@endsection