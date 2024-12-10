<script src="<?= base_url("assets/datatables/datatables.min.js") ?>"></script>
<script>
    function get_data_andon() {
        $.ajax({
            url:base_url+"getDataAndon",
            dataType:"JSON",
            beforeSend:function() {
                $(".counting").html('<i class="fas fa-spinner fa-spin m-0 p-0"></i>');
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(d);
                if(d.statusCode == "200"){
                    $("#count-delivery").html(d.data.Day.TotalUnit);
                    $("#count-ontime").html(d.data.Day.TotalOntime);
                    $("#percent-ontime").html(d.data.Day.PercentOntime+"%");
                    $("#count-delay").html(d.data.Day.TotalDelay);
                    $("#percent-delay").html(d.data.Day.PercentDelay+"%");
                    $("#count-advance").html(d.data.Day.TotalAdvance);
                    $("#percent-advance").html(d.data.Day.PercentAdvance+"%");
                }
            },
            error:function(a,b,c) {
                $(".counting").html('<i class="fas fa-times-circle m-0 p-0"></i>');
                console.log(a.responseText);
            }
        });
    }    
    $("#count-delivery-month").html($("#totalUnit").attr("data-total"));
    $("#count-ontime-month").html($("#totalOntime").attr("data-total"));
    $("#percent-ontime-month").html($("#totalOntime").attr("data-percent")+"%");
    $("#count-delay-month").html($("#totalDelay").attr("data-total"));
    $("#percent-delay-month").html($("#totalDelay").attr("data-percent")+"%");
    $("#count-advance-month").html($("#totalAdvance").attr("data-total"));
    $("#percent-advance-month").html($("#totalAdvance").attr("data-percent")+"%");

    get_data_andon();
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
            $('.cell-' + i).addClass('bg-danger text-light');
        }

        for (var i = 0; i <= otd_adjust; i++) {
            $('.cell-' + i).removeClass('bg-danger');
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
            beforeSend:function() {
                $("#modal-list-unit").modal("show");
                $("#list-unit").html('<i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>');
                $("#title-list-unit").html("");
            },
            dataType:"JSON",
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(d);
                $("#list-unit").html(d.html);
                if(tipe == "-3"){
                    titleDownload = "Advance >2 hour";
                }else if(tipe == "-2"){
                    titleDownload = "Advance 2 hour";
                }else if(tipe == "-1"){
                    titleDownload = "Advance 1 hour";
                }else if(tipe == "0"){
                    titleDownload = "Ontime";
                }else if(tipe == "9"){
                    titleDownload = "Delay >8 hour";
                }else if (tipe <= 8 && tipe >= 1) {
                    titleDownload = "Delay " + tipe + " hour";
                } else {
                    titleDownload = "Data OTD Unit";
                }
                $("#title-list-unit").html(titleDownload);
                table = $('#datatable').DataTable({
                    searching: false,
                    dom: 'Bfrtip', // Menambahkan elemen untuk tombol
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel mr-2"></i> Excel', // Ganti teks tombol
                            title: 'Data OTD Unit', // Judul file Excel
                            messageTop: 'Laporan Data', // Pesan tambahan di atas tabel
                            className: 'btn btn-success buttons-excel buttons-html5 mr-2 mb-3'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf mr-2"></i> PDF', // Ganti teks tombol
                            title: 'Data OTD Unit',
                            messageTop: 'Laporan Data',
                            className: 'btn btn-danger buttons-pdf buttons-html5 mr-2 mb-3'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print mr-2"></i> Print',
                            title: 'Data OTD Unit',
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
</script>