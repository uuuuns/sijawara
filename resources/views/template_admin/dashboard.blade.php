@extends('template_admin.admin_template')
@section('content')
<!-- Content Wrapper START -->
<div class="col ms-0 ms-md-4 p-4 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#45b104">Dashboard</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="card my-3 me-2">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-profile"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">
                                <?= isset($total_event[0]->TOTAL) && $total_event[0]->TOTAL !== null ? $total_event[0]->TOTAL : '0' ?>
                            </h2>
                            <p class="m-b-0 text-muted">Total Webinar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card my-3 mx-2">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-gold">
                            <i class="anticon anticon-profile"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">
                                <?= isset($total_course[0]->TOTAL) && $total_course[0]->TOTAL !== null ? $total_course[0]->TOTAL : '0' ?>
                            </h2>
                            <p class="m-b-0 text-muted">Total Kursus</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (session('user')[0]['ID_ROLE'] == 1 || session('user')[0]['ID_ROLE'] == 4) { ?>
            <div class="col-md-4">
                <div class="card my-3 ms-2">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="avatar avatar-icon avatar-lg avatar-purple">
                                <i class="anticon anticon-user"></i>
                            </div>
                            <div class="m-l-15">
                                <h2 class="m-b-0"><?= $total_user[0]->TOTAL ?></h2>
                                <p class="m-b-0 text-muted">Total Pengguna</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <div style="display: flex; justify-content: center;">
        <div class="row" style="max-width: 60rem; text-align: center;">
            <h4>Statistik Pendaftar Tiap Bulan</h4>
            <canvas id="myPieChart"></canvas>
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
</script>
@endsection