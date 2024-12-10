<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print OTD</title>
    <link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('css/sb-admin.css'); ?>" rel="stylesheet">
</head>
<body onafterprint="window.close()">
<style>
    .highlight-green {
        background-color: #28a745 !important;
        color: white;
    }
    @media print{
        body{
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
    }
    /* Mengatur orientasi menjadi landscape */
    @page {
        size: A4 landscape;
        margin: 10mm;
    } /* Mengatur warna dan tampilan untuk pencetakan */
    .table-bordered, .table-bordered th, .table-bordered td {
        border: 1px solid black !important; /* Pastikan border tetap terlihat */
    }
</style>
<div style="position:relative;">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">
            <h1 style="font-family:ms gothic; font-size:2.5rem;" align="center">Summary Ontime Process Achievement<br>ADM KAP-1<br>Periode <?= date("d",strtotime($this->input->get("print-from"))) ?> - <?= date("d M Y",strtotime($this->input->get("print-to"))); ?></h1>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-3">
            <div class="card">
                <div class="card-body text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black; background-color: #000;">DELIVERY</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body bg-primary text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ADVANCE</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body bg-success text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ONTIME</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body bg-danger text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">DELAY</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3 mt-2">
            <div class="card" style="height:150px;">
                <div class="counting card-body d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:70pt; font-family:calibri; background-color:#000;" id="count-delivery-month">0</div>
            </div>
        </div>
        <div class="col-3 mt-2">
            <div class="card" style="height:150px;">
                <div class="counting card-body bg-primary d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:40pt; font-family:calibri;" id="count-advance-month">0</div>
                <div class="counting mt-2 card-body bg-primary d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:30pt; font-family:calibri;" id="percent-advance-month">0</div>
            </div>
        </div>
        <div class="col-3 mt-2">
            <div class="card" style="height:150px;">
                <div class="counting card-body bg-success d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:40pt; font-family:calibri;" id="count-ontime-month">0</div>
                <div class="counting mt-2 card-body bg-success d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:30pt; font-family:calibri;" id="percent-ontime-month">0</div>
            </div>
        </div>
        <div class="col-3 mt-2">
            <div class="card" style="height:150px;">
                <div class="counting card-body bg-danger d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:40pt; font-family:calibri;" id="count-delay-month">0</div>
                <div class="counting mt-2 card-body bg-danger d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:30pt; font-family:calibri;" id="percent-delay-month">0</div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <table class="table table-bordered table-hover m-0">
                <thead>
                    <tr>
                        <th style="font-size:14pt; background-color: #007bff !important; color: white !important;" class="pt-1 pb-1 text-center" rowspan="2">Advance</th>
                        <th style="font-size:14pt; background-color: #28a745 !important; color: white !important;" class="pt-1 pb-1 text-center align-middle" rowspan="3">Ontime</th>
                        <th style="font-size:14pt; background-color: #dc3545 !important; color: white !important;" class="pt-1 pb-1 text-center text-light" colspan="9">Delay</th>
                    </tr>
                    <tr>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-1">1 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-9">>8 Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
                    SUM(CASE WHEN u2.balance <= -481 THEN 1 ELSE 0 END) AS adv_otd,
                    SUM(CASE WHEN u2.balance BETWEEN -480 AND 0 THEN 1 ELSE 0 END) AS total_ontime,
                    SUM(CASE WHEN u2.balance BETWEEN 1 AND 60 THEN 1 ELSE 0 END) AS total_1jam,
                    SUM(CASE WHEN u2.balance BETWEEN 61 AND 120 THEN 1 ELSE 0 END) AS total_2jam,
                    SUM(CASE WHEN u2.balance BETWEEN 121 AND 180 THEN 1 ELSE 0 END) AS total_3jam,
                    SUM(CASE WHEN u2.balance BETWEEN 181 AND 240 THEN 1 ELSE 0 END) AS total_4jam,
                    SUM(CASE WHEN u2.balance BETWEEN 241 AND 300 THEN 1 ELSE 0 END) AS total_5jam,
                    SUM(CASE WHEN u2.balance BETWEEN 301 AND 360 THEN 1 ELSE 0 END) AS total_6jam,
                    SUM(CASE WHEN u2.balance BETWEEN 361 AND 420 THEN 1 ELSE 0 END) AS total_7jam,
                    SUM(CASE WHEN u2.balance BETWEEN 421 AND 480 THEN 1 ELSE 0 END) AS total_8jam,
                    SUM(CASE WHEN u2.balance >= 481 THEN 1 ELSE 0 END) AS total_more8jam
                    FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$this->input->get("print-from")." 07:00:00' AND '".$this->input->get("print-to")." 07:00:00';","row");
                    
                    // Assign results to variables
                    $totalUnit = $total_unit->total_unit;
                    $adv_otd = $total_unit->adv_otd;
                    
                    $Totalontime = $total_unit->total_ontime;
                    $total_ontime = $total_unit->total_ontime;
                    $total_adv = $adv_otd;

                    $total_1jam = $total_unit->total_1jam;
                    $total_2jam = $total_unit->total_2jam;
                    $total_3jam = $total_unit->total_3jam;
                    $total_4jam = $total_unit->total_4jam;
                    $total_5jam = $total_unit->total_5jam;
                    $total_6jam = $total_unit->total_6jam;
                    $total_7jam = $total_unit->total_7jam;
                    $total_8jam = $total_unit->total_8jam;
                    $total_more8jam = $total_unit->total_more8jam;
                    
                    $ontimeDev = 0;
                    if($totalUnit > 0){
                        switch ($otd_adjust) {
                            case 0:
                                $ontimeDev = $total_ontime;
                                break;
                            case 1:
                                $ontimeDev = ($total_1jam + $total_ontime);
                                break;
                            case 2:
                                $ontimeDev = ($total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 3:
                                $ontimeDev = ($total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 4:
                                $ontimeDev = ($total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 5:
                                $ontimeDev = ($total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 6:
                                $ontimeDev = ($total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 7:
                                $ontimeDev = ($total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 8:
                                $ontimeDev = ($total_8jam + $total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            default:
                                // Handle case where $otd_adjust is outside the expected range
                                $ontimeDev = $total_ontime;
                                break;
                        }
                    }
                    ?>
                    <tr>
                        <td style="font-size:14pt;background-color: #007bff !important; color: white !important;" class="align-middle text-center p-1 td-row" data-tipe="-3" data-pdd="allday"><?= number_format($adv_otd,0,"","."); ?></td>

                        <td style="font-size:14pt; background-color: #28a745 !important; color: white !important;" class="align-middle text-center p-1 td-row cell-0" data-tipe="0" data-pdd="allday"><?= number_format($total_unit->total_ontime,0,"","."); ?></td>

                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-1" data-tipe="1" data-pdd="allday"><?= number_format($total_1jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-2" data-tipe="2" data-pdd="allday"><?= number_format($total_2jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-3" data-tipe="3" data-pdd="allday"><?= number_format($total_3jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-4" data-tipe="4" data-pdd="allday"><?= number_format($total_4jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-5" data-tipe="5" data-pdd="allday"><?= number_format($total_5jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-6" data-tipe="6" data-pdd="allday"><?= number_format($total_6jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-7" data-tipe="7" data-pdd="allday"><?= number_format($total_7jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-8" data-tipe="8" data-pdd="allday"><?= number_format($total_8jam,0,"","."); ?></td>
                        <td style="font-size:14pt;" class="align-middle text-center p-1 td-row cell-9" data-tipe="9" data-pdd="allday"><?= number_format($total_more8jam,0,"","."); ?></td>

                        <td style="font-size:9pt;" hidden class="align-middle text-center p-1 td-row"><a href="javascript:void(0);" id="data-chart" data-chart1="<?= $adv_otd; ?>" data-chart4="<?= $Totalontime; ?>" data-chart5="<?= $total_1jam; ?>" data-chart6="<?= $total_2jam; ?>" data-chart7="<?= $total_3jam; ?>" data-chart8="<?= $total_4jam; ?>" data-chart9="<?= $total_5jam; ?>" data-chart10="<?= $total_6jam; ?>" data-chart11="<?= $total_7jam; ?>" data-chart12="<?= $total_8jam; ?>" data-chart13="<?= $total_more8jam; ?>" title="Show Chart" class="btn btn-sm btn-success"><i class="fas fa-chart-line"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<span hidden id="total-unit-span"><?= number_format($totalUnit,0,"","."); ?></span>
<span hidden id="total-adv-span"><?= number_format($total_adv,0,"","."); ?></span>
<span hidden id="total-ontime-span"><?= number_format($ontimeDev,0,"","."); ?></span>
<span hidden id="total-delay-span"><?= number_format(($totalUnit - ($total_adv + $ontimeDev)),0,"","."); ?></span>

<span hidden id="total-adv-span-percent"><?= number_format(($total_adv/$totalUnit*100),2,",","."); ?>%</span>
<span hidden id="total-ontime-span-percent"><?= number_format(($ontimeDev/$totalUnit*100),2,",","."); ?>%</span>
<span hidden id="total-delay-span-percent"><?= number_format((($totalUnit - ($total_adv + $ontimeDev))/$totalUnit*100),2,",","."); ?>%</span>
<center><h3 class="mt-2">Graph OTD</h3></center>
<div class="chart-container mt-3" style="width:80%; height:29rem;">
    <canvas id="myChart"></canvas>
</div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url("assets/chartjs/Chart.min.js") ?>"></script>
<script src="<?= base_url("assets/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js") ?>"></script>
<script>
    function open_chart() {
        // Prepare the dataset array from incoming data
        let chart = [
            $("#data-chart").attr("data-chart1"), $("#data-chart").attr("data-chart4"),
            $("#data-chart").attr("data-chart5"), $("#data-chart").attr("data-chart6"), $("#data-chart").attr("data-chart7"), $("#data-chart").attr("data-chart8"),
            $("#data-chart").attr("data-chart9"), $("#data-chart").attr("data-chart10"), $("#data-chart").attr("data-chart11"), $("#data-chart").attr("data-chart12"),
            $("#data-chart").attr("data-chart13")
        ];

        // Get context from canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        
        // Define the X-axis labels
        const xValues = [
            "Advance", "Ontime", "1 Hour", "2 Hour", 
            "3 Hour", "4 Hour", "5 Hour", "6 Hour", "7 Hour", "8 Hour", "> 8 Hour"
        ];

        // Create the line chart
        var plugin = 
        {
            datalabels: {
                backgroundColor: function(context) {
                    return context.dataset.backgroundColor;
                },
                borderRadius: 4,
                color: 'black',
                font: {
                    weight: 'bold',
                    size: 20,
                },
                formatter: Math,
                padding: 2
            },
            
        }
        var lineChart = new Chart(ctx, {
            type: 'line', // Define the chart type
            data: {
                labels: xValues, // X-axis labels
                datasets: [{
                    label: 'OTD', // Legend label
                    data: chart, // Data points for the chart
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Background color (under the line)
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    borderWidth: 2, // Line width
                    fill: true, // Fill area under the line
                    datalabels: {
                        align: 'end',
                        anchor: 'end'
                    }
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 30,
                        bottom: 0
                    }
                },
                responsive: true, // Make the chart responsive
                plugins:plugin,
                scales: {
                    xAxes: [{
                        display: true, // Show X-axis
                        scaleLabel: {
                            display: true,
                            labelString: 'Periode' // X-axis label
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            fontSize: 15
                        }
                    }],
                    yAxes: [{
                        display: true, // Show Y-axis
                        scaleLabel: {
                            display: true,
                            labelString: 'Unit Delivery' // Y-axis label
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true // Start Y-axis from 0
                        }
                    }]
                }
            }
        });
    }
    open_chart();
    
    $("#day, #month, #year").change(function() {
        $("#form-adjust").submit();
        $("#month").attr("disabled",true);
        $("#year").attr("disabled",true);
        $("#day").attr("disabled",true);
    });
    
    setInterval(() => {
        location.reload();
    }, 300000);
</script>
<script>
    $("#count-delivery-month").html($("#total-unit-span").html());
    $("#count-advance-month").html($("#total-adv-span").html());
    $("#count-ontime-month").html($("#total-ontime-span").html());
    $("#count-delay-month").html($("#total-delay-span").html());
    
    $("#percent-advance-month").html($("#total-adv-span-percent").html());
    $("#percent-ontime-month").html($("#total-ontime-span-percent").html());
    $("#percent-delay-month").html($("#total-delay-span-percent").html());
    setInterval(() => {
        get_data("jigin");
    }, 299000);

    setInterval(() => {
        get_data_andon();
    }, 300000);
    
    function updateClock() {
        const now = new Date();

        // Format options for day, date, month, year
        const options = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' };
        const currentDate = now.toLocaleDateString('en-US', options);

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        // Format date to dd-MM-YYYY
        const currentTime = `${hours}:${minutes}:${seconds}`;
        
        $("#date-now").html(currentDate);
        $("#time-now").html(currentTime);
    }

    // Update the clock every second
    setInterval(updateClock, 1000);

    // Initialize clock when page loads
    updateClock();
    
    function checkNull() {
        var otd_adjust = "<?php echo $otd_adjust; ?>"; // Ambil nilai dari PHP

        for (var i = 0; i <= 9; i++) {
            $('.cell-' + i).attr('style',"background-color: #dc3545 !important; color: white !important;");
        }

        for (var i = 0; i <= otd_adjust; i++) {
            $('.cell-' + i).attr('style',"background-color: #dc3545 !important; color: white !important;");
            $('.cell-' + i).attr("style","background-color: #28a745 !important; color: white !important;");
        }

        $('.td-row').each(function() {
            if ($(this).text().trim() === '0') {
                $(this).text('');
            }
            
            if ($(this).text().trim() === '0%') {
                $(this).text('');
            }
        });
    }
    checkNull();

    setInterval(() => {
        window.print();
    }, 1000);
</script>