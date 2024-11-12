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
            <h4 id="title_chart">Statistik Pendaftar Tiap Bulan</h4>
            <div id="chart">
                <canvas id="myPieChart"></canvas>
            </div>
            <small id="total_user"></small>
        </div>
    </div>
</div>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('myPieChart').getContext('2d');
        $.ajax({
            url: 'get-data-chart',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.months,  // An array of month names or abbreviations, e.g., ['January', 'February', ...]
                        datasets: [{
                            label: 'Pendafataran Pengguna Baru Tiap Bulan',  // Label for the dataset
                            data: response.register_per_month, // An array of registration numbers per month
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',  // Line fill color
                            borderColor: 'rgba(54, 162, 235, 1)',  // Line color
                            borderWidth: 2,
                            fill: true,  // Fill the area under the line
                            tension: 0.4  // Smooth the line curve
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',  // Position of the legend
                            },
                            tooltip: {
                                enabled: true,  // Show tooltips on hover
                            },
                            title: {
                                display: true,
                                text: 'Registrations Per Month',  // Title text
                                font: {
                                    size: 18
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Registrations'
                                }
                            }
                        }
                    }
                });
            }
        });
    });

    var myLineChart;

    $('#provinsi').change(function() {
        // Remove the existing canvas and create a new one to prevent duplication
        $('#chart').empty().append('<canvas id="myPieChart"></canvas>');
        var ctx = document.getElementById('myPieChart').getContext('2d');
        
        let nama_provinsi = this.options[this.selectedIndex].text;
        
        // Fetch the new data for the selected province
        $.ajax({
            url: 'statistik_per_provinsi',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_provinsi: this.value
            },
            success: function(response) {
                // Update chart title
                $('#title_chart').empty().append('Statistik Peserta di provinsi ' + nama_provinsi);
                $('#total_user').empty().append('Total Peserta di provinsi ' + nama_provinsi + ' adalah ' + response.Total + ' orang');
                
                // Destroy the existing chart if it exists to avoid duplication
                if (myLineChart) {
                    myLineChart.destroy();
                }
                let backgroundColors = response.labels.map((_, index) => `hsl(${index * 360 / response.labels.length}, 70%, 60%)`);
                // Initialize the new chart
                myLineChart = new Chart(ctx, {
                    type: response.jenis_chart,
                    data: {
                        labels: response.labels,  // Array of city names
                        datasets: [{
                            label: 'Total Peserta',
                            data: response.data,  // Array of user totals per city
                            backgroundColor: backgroundColors,  // Slice fill color
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'left'  // Position of the legend
                            },
                            tooltip: {
                                enabled: true  // Show tooltips on hover
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

</script>
@endsection