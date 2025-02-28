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
                <div class="card-body bg-primary text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ADV. > 8H</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body bg-success text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ONTIME</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body bg-danger text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">DELAY > 8H</div>
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
                        <th class="pt-1 pb-1 text-center cell-9 text-light" colspan="11">Advance</th>
                        <th class="pt-1 pb-1 text-center align-middle cell-0" rowspan="2">Ontime<br>-1 Hour ~ +1 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9 text-light" colspan="11">Delay</th>
                    </tr>
                    <tr>
                        <th class="pt-1 pb-1 text-center cell-9">>32 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">32 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">24 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">16 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-2">2 Hour</th>

                        <th class="pt-1 pb-1 text-center cell-2">2 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">16 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">24 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">32 Hour</th>
                        <th class="pt-1 pb-1 text-center cell-9">>32 Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
                    SUM(CASE WHEN u2.balance <= -1921 THEN 1 ELSE 0 END) AS adv_more_32jam,
                    SUM(CASE WHEN u2.balance BETWEEN -1920 AND -1441 THEN 1 ELSE 0 END) AS adv_32jam,
                    SUM(CASE WHEN u2.balance BETWEEN -1440 AND -961 THEN 1 ELSE 0 END) AS adv_24jam,
                    SUM(CASE WHEN u2.balance BETWEEN -960 AND -481 THEN 1 ELSE 0 END) AS adv_16jam,
                    SUM(CASE WHEN u2.balance BETWEEN -480 AND -421 THEN 1 ELSE 0 END) AS adv_8jam,
                    SUM(CASE WHEN u2.balance BETWEEN -420 AND -361 THEN 1 ELSE 0 END) AS adv_7jam,
                    SUM(CASE WHEN u2.balance BETWEEN -360 AND -301 THEN 1 ELSE 0 END) AS adv_6jam,
                    SUM(CASE WHEN u2.balance BETWEEN -300 AND -241 THEN 1 ELSE 0 END) AS adv_5jam,
                    SUM(CASE WHEN u2.balance BETWEEN -240 AND -181 THEN 1 ELSE 0 END) AS adv_4jam,
                    SUM(CASE WHEN u2.balance BETWEEN -180 AND -121 THEN 1 ELSE 0 END) AS adv_3jam,
                    SUM(CASE WHEN u2.balance BETWEEN -120 AND -61 THEN 1 ELSE 0 END) AS adv_2jam,

                    SUM(CASE WHEN u2.balance BETWEEN -60 AND 60 THEN 1 ELSE 0 END) AS total_ontime,

                    SUM(CASE WHEN u2.balance BETWEEN 61 AND 120 THEN 1 ELSE 0 END) AS delay_2jam,
                    SUM(CASE WHEN u2.balance BETWEEN 121 AND 180 THEN 1 ELSE 0 END) AS delay_3jam,
                    SUM(CASE WHEN u2.balance BETWEEN 181 AND 240 THEN 1 ELSE 0 END) AS delay_4jam,
                    SUM(CASE WHEN u2.balance BETWEEN 241 AND 300 THEN 1 ELSE 0 END) AS delay_5jam,
                    SUM(CASE WHEN u2.balance BETWEEN 301 AND 360 THEN 1 ELSE 0 END) AS delay_6jam,
                    SUM(CASE WHEN u2.balance BETWEEN 361 AND 420 THEN 1 ELSE 0 END) AS delay_7jam,
                    SUM(CASE WHEN u2.balance BETWEEN 421 AND 480 THEN 1 ELSE 0 END) AS delay_8jam,
                    SUM(CASE WHEN u2.balance BETWEEN 481 AND 960 THEN 1 ELSE 0 END) AS delay_16jam,
                    SUM(CASE WHEN u2.balance BETWEEN 961 AND 1440 THEN 1 ELSE 0 END) AS delay_24jam,
                    SUM(CASE WHEN u2.balance BETWEEN 1441 AND 1920 THEN 1 ELSE 0 END) AS delay_32jam,
                    SUM(CASE WHEN u2.balance >= 1921 THEN 1 ELSE 0 END) AS delay_more_32jam
                    FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$this->input->get("print-from")." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($this->input->get("print-to"))))." 07:00:00' AND u1.otd IS NOT NULL","row");
                    
                    // Assign results to variables
                    $totalUnit = $total_unit->total_unit;
                    
                    $adv_2jam = $total_unit->adv_2jam;
                    $adv_3jam = $total_unit->adv_3jam;
                    $adv_4jam = $total_unit->adv_4jam;
                    $adv_5jam = $total_unit->adv_5jam;
                    $adv_6jam = $total_unit->adv_6jam;
                    $adv_7jam = $total_unit->adv_7jam;
                    $adv_8jam = $total_unit->adv_8jam;
                    $adv_16jam = $total_unit->adv_16jam;
                    $adv_24jam = $total_unit->adv_24jam;
                    $adv_32jam = $total_unit->adv_32jam;
                    $adv_more_32jam = $total_unit->adv_more_32jam;
                    $totalAdvance = $adv_16jam + $adv_24jam + $adv_32jam + $adv_more_32jam;
                    
                    $total_ontime = $total_unit->total_ontime;

                    $delay_2jam = $total_unit->delay_2jam;
                    $delay_3jam = $total_unit->delay_3jam;
                    $delay_4jam = $total_unit->delay_4jam;
                    $delay_5jam = $total_unit->delay_5jam;
                    $delay_6jam = $total_unit->delay_6jam;
                    $delay_7jam = $total_unit->delay_7jam;
                    $delay_8jam = $total_unit->delay_8jam;
                    $delay_16jam = $total_unit->delay_16jam;
                    $delay_24jam = $total_unit->delay_24jam;
                    $delay_32jam = $total_unit->delay_32jam;
                    $delay_more_32jam = $total_unit->delay_more_32jam;

                    $dataDay = [
                        intval($adv_more_32jam),
                        intval($adv_32jam),
                        intval($adv_24jam),
                        intval($adv_16jam),
                        intval($adv_8jam),
                        intval($adv_7jam),
                        intval($adv_6jam),
                        intval($adv_5jam),
                        intval($adv_4jam),
                        intval($adv_3jam),
                        intval($adv_2jam),
                        intval($total_ontime),
                        intval($delay_2jam),
                        intval($delay_3jam),
                        intval($delay_4jam),
                        intval($delay_5jam),
                        intval($delay_6jam),
                        intval($delay_7jam),
                        intval($delay_8jam),
                        intval($delay_16jam),
                        intval($delay_24jam),
                        intval($delay_32jam),
                        intval($delay_more_32jam)
                    ];

                    $maxVal = max($dataDay)+(ceil(max($dataDay)/5));

                    $dataLabel = [
                        "Adv. > 32jam",
                        "Adv. 32jam",
                        "Adv. 24jam",
                        "Adv. 16jam",
                        "Adv. 8jam",
                        "Adv. 7jam",
                        "Adv. 6jam",
                        "Adv. 5jam",
                        "Adv. 4jam",
                        "Adv. 3jam",
                        "Adv. 2jam",
                        "Ontime",
                        "Delay 2jam",
                        "Delay 3jam",
                        "Delay 4jam",
                        "Delay 5jam",
                        "Delay 6jam",
                        "Delay 7jam",
                        "Delay 8jam",
                        "Delay 16jam",
                        "Delay 24jam",
                        "Delay 32jam",
                        "Delay > 32jam"
                    ];
                    ?>
                    <tr>
                        <?php
                        $totalOntime = 0;
                        $totalDelay = 0;
                        foreach ($dataDay as $key => $value) {
                            if($key >= 0 && $key <= 3){
                                $bg_row = "cell-9";
                            }else if($key >= 19){
                                $bg_row = "cell-9";
                                $totalDelay += $value;
                            }else if($key >= 4 && $key <= 18){
                                $bg_row = "cell-0";
                                $totalOntime += $value;
                            }
                            echo '<td class="align-middle '.$bg_row.' text-center p-1 td-row text-light" data-tipe="'.$key.'">'.$value.'</td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$percentAdvance = number_format(($totalAdvance / $totalUnit)*100,2,",",".");
$percentOntime = number_format(($totalOntime / $totalUnit)*100,2,",",".");
$percentDelay = number_format(($totalDelay / $totalUnit)*100,2,",",".");
?>

<span hidden id="total-unit-span"><?= number_format($totalUnit,0,"","."); ?></span>
<span hidden id="total-adv-span"><?= number_format($totalAdvance,0,"","."); ?></span>
<span hidden id="total-ontime-span"><?= number_format($totalOntime,0,"","."); ?></span>
<span hidden id="total-delay-span"><?= number_format($totalDelay,0,"","."); ?></span>

<span hidden id="total-adv-span-percent"><?= $percentAdvance; ?>%</span>
<span hidden id="total-ontime-span-percent"><?= $percentOntime; ?>%</span>
<span hidden id="total-delay-span-percent"><?= $percentDelay; ?>%</span>
<center><h3 class="mt-4">GRAPH OTD</h3></center>
<div class="chart-container mt-3" style="width:80%; height:29rem;">
    <canvas id="myChart" style="width:100% !important;"></canvas>
</div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
 
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.0"></script>

<script>
    function open_chart() {
        const maxVal = <?= $maxVal; ?>;
        const xValues = <?= json_encode($dataLabel); ?>;
        var chart = <?= json_encode($dataDay); ?>;
        // Memuat chart
        const ctx = document.getElementById('myChart').getContext('2d');
        const annoOK = {
            type: 'line',
            borderColor: 'green',
            borderDash: [6, 6],
            borderWidth: 3,
            label: {
                display: true,
                backgroundColor: 'lightGreen',
                borderRadius: 0,
                color: 'green',
                content: 'Ontime Delivery',
                position: 'center'
            },
            arrowHeads: {
                end: {
                    display: true,
                    fill: true,
                    borderDash: [],
                    borderColor: 'green'
                },
                start: {
                    display: true,
                    fill: true,
                    borderDash: [],
                    borderColor: 'green'
                }
            },
            xMin: 4,
            xMax: 18,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: maxVal,
            yScaleID: 'y'
        };
        const annoOKY1 = {
            type: 'line',
            borderColor: 'green',
            borderDash: [6, 6],
            borderWidth: 3,
            xMin: 4,
            xMax: 4,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: 0,
            yScaleID: 'y'
        };
        const annoOKY2 = {
            type: 'line',
            borderColor: 'green',
            borderDash: [6, 6],
            borderWidth: 3,
            xMin: 18,
            xMax: 18,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: 0,
            yScaleID: 'y'
        };
        const annoOKArea = {
            type: 'box',
            backgroundColor:'rgba(182, 250, 200, 0.2)',
            borderWidth: 0,
            xMin: 4,
            xMax: 18,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: 0,
            yScaleID: 'y'
        };
        const annoNGAdv = {
            type: 'line',
            borderColor: 'red',
            borderDash: [6, 6],
            borderWidth: 3,
            label: {
                display: true,
                backgroundColor: 'lightRed',
                borderRadius: 0,
                color: 'red',
                content: 'NG',
                position: 'center'
            },
            arrowHeads: {
                end: {
                    display: true,
                    fill: true,
                    borderDash: [],
                    borderColor: 'red'
                },
                start: {
                    display: true,
                    fill: true,
                    borderDash: [],
                    borderColor: 'red'
                }
            },
            xMin: 0,
            xMax: 4,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: maxVal,
            yScaleID: 'y'
        };
        const annoNGDelay = {
            type: 'line',
            borderColor: 'red',
            borderDash: [6, 6],
            borderWidth: 3,
            label: {
                display: true,
                backgroundColor: 'lightRed',
                borderRadius: 0,
                color: 'red',
                content: 'NG',
                position: 'center'
            },
            arrowHeads: {
                end: {
                    display: true,
                    fill: true,
                    borderDash: [],
                    borderColor: 'red'
                },
                start: {
                    display: true,
                    fill: true,
                    borderDash: [],
                    borderColor: 'red'
                }
            },
            xMin: 18,
            xMax: 22,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: maxVal,
            yScaleID: 'y'
        };
        const annoNGAreaAdv = {
            type: 'box',
            backgroundColor:'rgba(237, 173, 166, 0.2)',
            borderWidth: 0,
            xMin: 0,
            xMax: 4,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: 0,
            yScaleID: 'y'
        };
        const annoNGAreaDelay = {
            type: 'box',
            backgroundColor:'rgba(237, 173, 166, 0.2)',
            borderWidth: 0,
            xMin: 18,
            xMax: 22,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: 0,
            yScaleID: 'y'
        };
        const myChart = new Chart(ctx, {
            type: 'line', // Tipe chart: bisa juga 'line', 'pie', dll.
            data: {
                labels: xValues,
                datasets: [{
                    label: 'Periode',
                    data: chart,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    // Plugin DataLabels
                    datalabels: {
                        color: 'black',
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value; // Menampilkan nilai dengan satuan 'units'
                        },
                        font: {
                            weight: 'bold',
                            size: 18,
                        },
                        padding: 3
                    },
                    // Plugin Annotations
                    annotation: {
                        annotations: {
                            annoOKArea,
                            annoOK,
                            annoOKY1,
                            annoOKY2,
                            annoNGAdv,
                            annoNGDelay,
                            annoNGAreaAdv,
                            annoNGAreaDelay,
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    x: {
                        display: true, // Menampilkan sumbu X
                        title: {
                            display: true,
                            text: 'Periode' // Label untuk sumbu X
                        },
                        grid: {
                            color: "rgba(0, 0, 0, 0)" // Menghapus garis grid untuk sumbu X
                        },
                        ticks: {
                            font: {
                                size: 9 // Ukuran font ticks di sumbu X
                            }
                        }
                    },
                    y: {
                        display: true, // Menampilkan sumbu Y
                        title: {
                            display: true,
                            text: 'Unit Delivery' // Label untuk sumbu Y
                        },
                        grid: {
                            color: "rgba(0, 0, 0, 0)" // Menghapus garis grid untuk sumbu Y
                        },
                        ticks: {
                            beginAtZero: true // Memulai sumbu Y dari 0
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Mengaktifkan plugin DataLabels
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
            $('.cell-' + i).attr('style',"background-color: #dc3545 !important; color: white !important; font-size:8pt;");
        }

        for (var i = 0; i <= otd_adjust; i++) {
            $('.cell-' + i).attr('style',"background-color: #dc3545 !important; color: white !important; font-size:8pt;");
            $('.cell-' + i).attr("style","background-color: #28a745 !important; color: white !important; font-size:8pt;");
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