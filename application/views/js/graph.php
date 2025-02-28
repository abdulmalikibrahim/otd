<!-- <script src="<?= base_url("assets/chartjs/Chart.min.js") ?>"></script>
<script src="<?= base_url("assets/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.min.js" integrity="sha512-9hzM/Gfa9KP1hSBlq3/zyNF/dfbcjAYwUTBWYX+xi8fzfAPHL3ILwS1ci0CTVeuXTGkRAWgRMZZwtSNV7P+nfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.0"></script>

<?php
    $get_data_dot = $this->model->gd("set_ot","*","tanggal = '$day_sum'","row");
    $day = date("Y-m-d",strtotime(date($year_sum."-".$month_sum."-").sprintf("%02d",$day_sum)));
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
    FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$day." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($day)))." 07:00:00' AND u1.otd IS NOT NULL","row");
    
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

    $maxVal = max($dataDay)+(ceil(max($dataDay)/15));

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
<script>
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
                    display: true
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
                            size: 11 // Ukuran font ticks di sumbu X
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
</script>

<script>
    $("#periodeGraph").change(function() {
        $("#form-adjust").submit();
        $("#periodeGraph").attr("disabled",true);
    });
    
    setInterval(() => {
        location.reload();
    }, 300000);
</script>