<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTD CALCULLATION SYSTEM</title>
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
	<link href="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('css/sb-admin.css'); ?>" rel="stylesheet">
    <style>
        .result-scan {
            -webkit-text-stroke-width: 3px;
            -webkit-text-stroke-color: black;
        }
        
        .btn-lightgreen {
            color: #D2E4F5;
            background-color: #0077C3;
            border-color: #0077C3;
        }

        .btn-lightgreen:hover {
            color: #D2E4F5 !important;
            background-color: #0169A3;
            border-color: #0169A3;
        }

        .btn-lightgreen:focus, .btn-lightgreen.focus {
            -webkit-box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
            box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
        }

        .btn-lightgreen.disabled, .btn-lightgreen:disabled {
            color: #D2E4F5;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-lightgreen:not(:disabled):not(.disabled):active, .btn-lightgreen:not(:disabled):not(.disabled).active,
        .show > .btn-lightgreen.dropdown-toggle {
            color: #D2E4F5;
            background-color: #0169A3;
            border-color: #1c7430;
        }

        .btn-lightgreen:not(:disabled):not(.disabled):active:focus, .btn-lightgreen:not(:disabled):not(.disabled).active:focus,
        .show > .btn-lightgreen.dropdown-toggle:focus {
            -webkit-box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
            box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
        }
    </style>
</head>
<body style="background-image:url('<?= base_url("assets/img/background.png"); ?>'); background-size:100%; background-repeat:no-repeat; background-position:center center;">
    <h3 style="font-family:cooper black; font-size:3.5rem; position:absolute; top:2rem; left:2rem; color:#0077C3;">OTD Calculation System</h3>
    <div style="position:absolute; top: 10rem; left:2rem;">
        <div class="mt-3" style="min-width:400px;">
            <a href="<?= base_url("set_wh"); ?>" class="btn btn-lightgreen w-100 text-left pt-2 pb-2" style="border-radius:30px; padding-left:25px; padding-right:25px;"><h4>1. Set WH & OT Master</h4></a>
        </div>
        <div class="mt-3" style="min-width:400px;">
            <a href="<?= base_url("leadtime"); ?>" class="btn btn-lightgreen w-100 text-left pt-2 pb-2" style="border-radius:30px; padding-left:25px; padding-right:25px;"><h4>2. Set Std Leadtime</h4></a>
        </div>
        <div class="mt-3" style="min-width:400px;">
            <a href="<?= base_url("summary_otd"); ?>" class="btn btn-lightgreen w-100 text-left pt-2 pb-2" style="border-radius:30px; padding-left:25px; padding-right:25px;"><h4>3. Achievement OTD</h4></a>
        </div>
        <div class="mt-3" style="min-width:400px;">
            <a href="<?= base_url("live_andon"); ?>" class="btn btn-lightgreen w-100 text-left pt-2 pb-2" style="border-radius:30px; padding-left:25px; padding-right:25px;"><h4>4. Live Andon</h4></a>
        </div>
        <div class="mt-3" style="min-width:400px;">
            <a href="<?= base_url("graph_andon"); ?>" class="btn btn-lightgreen w-100 text-left pt-2 pb-2" style="border-radius:30px; padding-left:25px; padding-right:25px;"><h4>5. Graph</h4></a>
        </div>
    </div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script src="https://cdn.datatables.net/v/bs4/dt-2.1.0/datatables.min.js"></script>
<script>
	$("#datatable").DataTable();
</script>
<!-- AUTO SYNC -->
<script>
    function get_data(shop) {
        if(shop == "jigin"){
            shop_val = "Jig In";
        }else{
            shop_val = "Delivery";
        }
        $.ajax({
            url:"<?= base_url("get_data"); ?>/"+shop,
            dataType:"JSON",
            beforeSend:function() {
                $("#status_get_data_"+shop).html(shop_val+" : Processing get data...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(r);
                $("#status_get_data_"+shop).html(shop_val+" : "+d.res);
                if(shop == "jigin"){
                    get_data("delivery");
                }else{
                    calc_leadtime();
                }
            },
            error:function(a,b,c) {
                $("#status_get_data_"+shop).html(shop_val+" : "+a.responseText);
            }
        });
    }
    function calc_leadtime() {
        $.ajax({
            url:"<?= base_url("calc_lead_time"); ?>",
            dataType:"JSON",
            beforeSend:function() {
                $("#status_calc_lead_time").html("Calc Lead Time : Calculating...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                console.log(r);
                $("#status_calc_lead_time").html("Calc Lead Time : "+d.res);
            },
            error:function(a,b,c) {
                $("#status_calc_lead_time").html("Calc Lead Time : "+a.responseText);
            }
        });
    }
    get_data("jigin");
</script>