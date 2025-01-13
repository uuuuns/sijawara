@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#45b104">Statistik Per kategori</h3>
    <div class="row" style="display: flex; justify-content: center;">
        <div class="row mb-5" style="max-width: 60rem; text-align: center;">
            <h4 id="title_chart">Statistik Tiap Kategori Kursus</h4>
            <div id="chart">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
        <div class="row mb-5" style="max-width: 60rem; text-align: center;">
            <h4 id="title_chart">Statistik 10 Kursus Terpopuler</h4>
            <div id="chart_kursus">
                <canvas id="myPieChart_kursus"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        const chartData = {!! $chartData !!}; // Decode JSON into JavaScript object

        const ctx_kursus = document.getElementById('myPieChart_kursus').getContext('2d');
        const myChart = new Chart(ctx_kursus, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Statistik Per Kategori' }
                }
            }
        });

        var ctx = document.getElementById('myPieChart').getContext('2d');
        $.ajax({
            url: 'get-data-chart-kategori',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var myLineChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: '',
                            data: response.data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Statistik Tiap Kategori Kursus' }
                        }
                    }
                });
            }
        });
    });
</script>
@endsection