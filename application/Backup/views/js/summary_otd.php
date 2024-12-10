<script src="<?= base_url("assets/chartjs/Chart.min.js") ?>"></script>
<script src="<?= base_url("assets/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js") ?>"></script>
<script src="<?= base_url("assets/datatables/datatables.min.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function tracking_time(data) {
        $.ajax({
            type:"post",
            url:"<?= base_url("tracking_time"); ?>",
            data:{
                vin:data.dataset.vin,
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

    function open_chart(data) {
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
        
        // Define the X-axis labels
        const xValues = [
            "Adv. > 8 Jam", "Adv. 8 Jam", "Adv. 7 Jam", "Adv. 6 Jam", "Adv. 5 Jam", "Adv. 4 Jam", "Adv. 3 Jam", "Adv. 2 Jam", "Adv. 1 Jam", "Ontime", "1 Jam", "2 Jam", "3 Jam", "4 Jam", "5 Jam", "6 Jam", "7 Jam", "8 Jam", "> 8 Jam"
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
                    size: 12,
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

    function checkNull() {
        var otd_adjust = "<?php echo $otd_adjust; ?>"; // Ambil nilai dari PHP

        for (var i = 0; i <= otd_adjust; i++) {
            $('.cell-' + i).addClass('highlight-green');
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
        // Jika DataTable sudah ada, hancurkan terlebih dahulu
        if ($.fn.DataTable.isDataTable('#datatable')) {
            table.destroy(true);  // Tambahkan true untuk menghancurkan dengan bersih
            $('#datatable').empty(); // Kosongkan tabel agar data lama benar-benar terhapus
        }
        $.ajax({
            url:"<?= base_url("list_unit") ?>/"+tipe+"/"+pdd,
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
                if(tipe == -9){
                    titleDownload = "Advance >8 hour";
                }else if(tipe == 0){
                    titleDownload = "Ontime";
                }else if(tipe == 9){
                    titleDownload = "Delay >8 hour";
                }else if (tipe <= 8 && tipe >= 1) {
                    titleDownload = "Delay " + tipe + " hour";
                }else if(tipe >= -1 && tipe <= -8){
                    titleDownload = "Advance " + tipe + " hour";
                }else{
                    titleDownload = "Data OTD Unit";
                }
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
        $.ajax({
            type:"post",
            url:"<?= base_url("re_calculate") ?>",
            data:{
                vin:data.dataset.vin,
                pdd:data.dataset.pdd,
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
                    // var time = 3;
                    // var interval = 1000;
                    // setInterval(() => {
                    //     $("#btn-re-calculate").removeClass("btn-info");
                    //     $("#btn-re-calculate").addClass("btn-success");
                    //     $("#btn-re-calculate").html("Kalkulasi Selesai. Reload "+time+"s");
                    //     if(time <= 0){
                    //         location.reload();
                    //         interval = 30000;
                    //     }else{
                    //         time--;
                    //     }
                    // }, interval);
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