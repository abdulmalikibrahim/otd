<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTDCS Auto Sync</title>
</head>
<body>
    <div style="width:100%; margin-top:10rem; text-align:center;">
        <h3>OTDCS Auto Sync</h3>
        <div style="margin-bottom:20px;" id="status_get_data_jigin">Jig In : -</div>
        <div style="margin-bottom:20px;" id="status_get_data_delivery">Delivery : -</div>
        <div style="margin-bottom:20px;" id="status_calc_lead_time">Calc Lead Time : -</div>
    </div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script>
    function get_data(shop) {
        if(shop == "jigin"){
            shop_val = "Jig In";
        }else{
            shop_val = "Delivery";
        }
        $.ajax({
            url:"<?= base_url("get_data"); ?>/"+shop+"?auto_sync=Yes",
            dataType:"JSON",
            beforeSend:function() {
                $("#status_get_data_"+shop).html(shop_val+" : Processing get data...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
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
            url:"<?= base_url("calc_lead_time"); ?>?auto_sync=Yes",
            dataType:"JSON",
            beforeSend:function() {
                $("#status_calc_lead_time").html("Calc Lead Time : Calculating...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                $("#status_calc_lead_time").html("Calc Lead Time : "+d.res);
            },
            error:function(a,b,c) {
                $("#status_calc_lead_time").html("Calc Lead Time : "+a.responseText);
            }
        });
    }
    
    get_data("jigin");

    setInterval(() => {
        get_data("jigin");
    }, 900000);
</script>