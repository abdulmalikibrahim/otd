<!-- <script src="<?= base_url("assets/chartjs/Chart.min.js") ?>"></script> -->
<!-- <script src="<?= base_url("assets/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js") ?>"></script> -->
 
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.0"></script>

<script src="<?= base_url("assets/datatables/datatables.min.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function tracking_time(data) {
        kap = "<?= $this->input->get("kap"); ?>";
        $.ajax({
            type:"post",
            url:"<?= base_url("tracking_time"); ?>",
            data:{
                vin:data.dataset.vin,
                kap:kap,
            },
            dataType:"JSON",
            beforeSend:function() {
                $("#modal-tracking").modal("show");
                $("#tracking").html('<i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>');
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(d);
                if(d.statusCode == 200){
                    $("#tracking").html(d.data.tracking);
                }else{
                    $("#tracking").html('<center><h4>'+d.data.message+'</h4></center>');
                }
            },
            error:function(a,b,c) {
                $("#tracking").html('<center><h4>'+a.responseText+'</h4></center>');
            }
        });
    }
    
    function tracking_unit(data) {
        $.ajax({
            type:"post",
            url:"<?= base_url("tracking_unit"); ?>",
            data:{
                vin:data.dataset.vin,
            },
            dataType:"JSON",
            beforeSend:function() {
                $("#modal-tracking-unit").modal("show");
                $("#tracking-unit").html('<i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>');
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(d);
                if(d.statusCode == 200){
                    $("#tracking-unit").html(d.data.tracking);
                }else{
                    $("#tracking-unit").html('<center><h4>'+d.data.message+'</h4></center>');
                }
            },
            error:function(a,b,c) {
                $("#tracking-unit").html('<center><h4>'+a.responseText+'</h4></center>');
            }
        })
    }

    function open_chart1(data) {
        $("#modal-chart").modal("show");
        $("#title-chart").html("Chart OTD "+data.dataset.tanggal);
        // Prepare the dataset array from incoming data
        let chart = [
            data.dataset.chart1, data.dataset.chart2, data.dataset.chart3, data.dataset.chart4,
            data.dataset.chart5, data.dataset.chart6, data.dataset.chart7, data.dataset.chart8,
            data.dataset.chart9, data.dataset.chart10, data.dataset.chart11, data.dataset.chart12,
            data.dataset.chart13, data.dataset.chart14, data.dataset.chart15, data.dataset.chart16,
            data.dataset.chart17, data.dataset.chart18, data.dataset.chart19
        ];

        // Get context from canvas element
        var ctx = document.getElementById('myChart').getContext('2d');

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
                    size: 12,
                },
                formatter: Math,
                padding: 2
            },
            
        }
        var lineChart = new Chart(ctx, {
            type: 'line', // Define the chart type
            data: {
                labels: dataLabel, // X-axis labels
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
                legend: {
                    display: false
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
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

    var myChart;
    function open_chart(data) {
        $("#modal-chart").modal("show");
        $("#title-chart").html("Chart OTD "+data.dataset.tanggal);
        const maxVal = data.dataset.max;
        const xValues = [ "Adv. > 32h", "Adv. 32h", "Adv. 24h", "Adv. 16h", "Adv. 8h", "Adv. 7h", "Adv. 6h", "Adv. 5h", "Adv. 4h", "Adv. 3h", "Adv. 2h", "Ontime", "Delay 2h", "Delay 3h", "Delay 4h", "Delay 5h", "Delay 6h", "Delay 7h", "Delay 8h", "Delay 16h", "Delay 24h", "Delay 32h", "Delay > 32h" ];
        var chart = JSON.parse(data.dataset.chart);
        console.log(chart,xValues);
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
            xMax: 20,
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
            xMax: 25,
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
            xMax: 25,
            xScaleID: 'x',
            yMax: maxVal,
            yMin: 0,
            yScaleID: 'y'
        };
        if (myChart) {
            myChart.destroy(); // Menghapus chart lama
        }
        myChart = new Chart(ctx, {
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
                                size: 10 // Ukuran font ticks di sumbu X
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

    function checkNull() {
        var otd_adjust = "<?php echo $otd_adjust; ?>"; // Ambil nilai dari PHP

        for (var i = 0; i <= 8; i++) {
            if(i <= otd_adjust){
                $('.cell-' + i).addClass('highlight-green');
            }else{
                $('.cell-' + i).addClass('bg-danger text-light');
            }
            $('.cell-' + i).map(function(index,el) {
                if(el.dataset.day == "SatSun"){
                    $(this).removeClass('bg-danger text-light');
                    $(this).addClass('bg-secondary');
                }
            });
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

    $("#adjust, #month, #year").change(function() {
        $("#form-adjust").submit();
        $("#month").attr("disabled",true);
        $("#year").attr("disabled",true);
        $("#adjust").attr("disabled",true);
    });

    $("#datatable-summary").DataTable({
        searching: false,
        paging: false,
        info: false,
        ordering: false,
        scrollY: '540px', // Tinggi maksimal tabel
        scrollCollapse: true, // Mengaktifkan scroll jika tinggi tabel kurang dari scrollY
        paging: false, // Hapus pagination jika tidak diperlukan (opsional)
        fixedHeader: true // Mengaktifkan sticky header
    });
    
    var table;
    function showListUnit(data) {
        tipe = data.dataset.tipe;
        pdd = data.dataset.pdd;
        kap = "<?= $this->input->get("kap"); ?>";
        // Jika DataTable sudah ada, hancurkan terlebih dahulu
        if ($.fn.DataTable.isDataTable('#datatable')) {
            table.destroy(true);  // Tambahkan true untuk menghancurkan dengan bersih
            $('#datatable').empty(); // Kosongkan tabel agar data lama benar-benar terhapus
        }
        $.ajax({
            url:"<?= base_url("list_unit") ?>/"+tipe+"/"+pdd+"?kap="+kap,
            dataType:"JSON",
            beforeSend:function() {
                $("#modal-list-unit").modal("show");
                $("#list-unit").html('<i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>');
                $("#title-list-unit").html("");
                $("#btn-re-calculate").hide();
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                $("#list-unit").html(d.html);
                tipe = parseInt(tipe);
                arrayTipe = {
                    "-11"   : "Adv. > 32 Hour",
                    "-10"   : "Adv. 32 Hour",
                    "-9"    : "Adv. 24 Hour",
                    "-8"    : "Adv. 16 Hour",
                    "-7"    : "Adv. 8 Hour",
                    "-6"    : "Adv. 7 Hour",
                    "-5"    : "Adv. 6 Hour",
                    "-4"    : "Adv. 5 Hour",
                    "-3"    : "Adv. 4 Hour",
                    "-2"    : "Adv. 3 Hour",
                    "-1"    : "Adv. 2 Hour",
                    "0"     : "Ontime (-1 ~ +1 Hour)",
                    "1"     : "Delay 2 Hour",
                    "2"     : "Delay 3 Hour",
                    "3"     : "Delay 4 Hour",
                    "4"     : "Delay 5 Hour",
                    "5"     : "Delay 6 Hour",
                    "6"     : "Delay 7 Hour",
                    "7"     : "Delay 8 Hour",
                    "8"     : "Delay 16 Hour",
                    "9"     : "Delay 24 Hour",
                    "10"    : "Delay 32 Hour",
                    "11"    : "Delay > 32 Hour",
                };
                titleDownload = arrayTipe[tipe];
                $("#btn-re-calculate").html("Kalkulasi Ulang");
                $("#btn-re-calculate").show();
                $("#btn-re-calculate").attr("data-vin",d.vin);
                $("#btn-re-calculate").attr("data-pdd",pdd);
                $("#title-list-unit").html(titleDownload);
                table = $('#datatable').DataTable({
                    searching: true,
                    dom: 'Bfrtip', // Menambahkan elemen untuk tombol
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel mr-2"></i> Excel', // Ganti teks tombol
                            title: titleDownload, // Judul file Excel
                            messageTop: 'Laporan Data', // Pesan tambahan di atas tabel
                            className: 'btn btn-success buttons-excel buttons-html5 mr-2 mb-3'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf mr-2"></i> PDF', // Ganti teks tombol
                            title: titleDownload,
                            messageTop: 'Laporan Data',
                            className: 'btn btn-danger buttons-pdf buttons-html5 mr-2 mb-3'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print mr-2"></i> Print',
                            title: titleDownload,
                            messageTop: 'Laporan Data',
                            className: 'btn btn-info buttons-print mr-2 mb-3'
                        }
                    ]
                });
                $(".dt-search").addClass("text-left mb-2");
            },
            error:function(a,b,c) {
                $("#list-unit").html(a.responseText);
            }
        })
    }
    function showListUnit1(data) {
        swal.fire("Informasi","Masih dalam tahap development","warning");
    }
    // Event ketika modal ditutup
    $('#modal-list-unit').on('hidden.bs.modal', function () {
        if ($.fn.DataTable.isDataTable('#datatable')) {
            table.destroy(true); // Hancurkan DataTable dengan parameter true
            table = null; // Set variabel ke null untuk menghindari masalah
        }
    });
    
    setInterval(() => {
        location.reload();
    }, 300000);

    function re_calculate(data) {
        kap = "<?= $this->input->get("kap"); ?>";
        $.ajax({
            type:"post",
            url:"<?= base_url("re_calculate") ?>",
            data:{
                vin:data.dataset.vin,
                pdd:data.dataset.pdd,
                kap:kap,
            },
            dataType:"JSON",
            beforeSend:function() {
                $("#btn-re-calculate").attr("disabled",true);
                $("#btn-re-calculate").html("Sedang Mengkalkulasi...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(d);
                if(d.statusCode == 200){
                    $("#btn-re-calculate").removeClass("btn-info");
                    $("#btn-re-calculate").addClass("btn-success");
                    $("#btn-re-calculate").html("Kalkulasi Selesai. Reload page...");
                    location.reload();
                }else{
                    Swal.fire("Error",d.data.message,"error");
                    $("#btn-re-calculate").html("Kalkulasi Ulang");
                    $("#btn-re-calculate").attr("disabled",false);
                }
            },
            error:function(a,b,c) {
                Swal.fire("Error",a.responseText,"error");
                $("#btn-re-calculate").html("Kalkulasi Ulang");
                $("#btn-re-calculate").attr("disabled",false);
            }
        })
    }
</script>