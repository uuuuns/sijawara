@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#45b104">Statistik Per kategori</h3>
    <div style="display: flex; justify-content: center;">
        <div class="row" style="max-width: 60rem; text-align: center;">
            <h4 id="title_chart">Statistik Tiap Kategori Kursus</h4>
            <div id="chart">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('myPieChart').getContext('2d');
        $.ajax({
            url: 'get-data-chart-kategori',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var myLineChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.labels,  // An array of month names or abbreviations, e.g., ['January', 'February', ...]
                        datasets: [{
                            label: 'Total Kursus yang diambil',  // Label for the dataset
                            data: response.data, // An array of registration numbers per month
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',  // Line fill color
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
                            }
                        }
                    }
                });
            }
        });
    });
</script>
@endsection