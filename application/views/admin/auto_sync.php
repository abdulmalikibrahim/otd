<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTDCS Auto Sync</title>
</head>
<body>
    <div style="width:100%; margin-top:10rem; text-align:center;">
        <h3>OTDCS Auto Sync KAP1</h3>
        <div style="margin-bottom:20px;" id="status_get_data_jigin_1">Jig In : -</div>
        <div style="margin-bottom:20px;" id="status_get_data_delivery_1">Delivery : -</div>
        <div style="margin-bottom:20px;" id="status_calc_lead_time_1">Calc Lead Time : -</div>
        <div style="margin-bottom:20px;" id="status_ot_1">Overtime : -</div>
    </div>
    <div style="width:100%; margin-top:5rem; text-align:center;">
        <h3>OTDCS Auto Sync KAP2</h3>
        <div style="margin-bottom:20px;" id="status_get_data_jigin_2">Jig In : -</div>
        <div style="margin-bottom:20px;" id="status_get_data_delivery_2">Delivery : -</div>
        <div style="margin-bottom:20px;" id="status_calc_lead_time_2">Calc Lead Time : -</div>
        <div style="margin-bottom:20px;" id="status_ot_2">Overtime : -</div>
    </div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script>
    function get_data_ot(kap) {
        const url = kap === 1 ? "<?= base_url("updateOTFromTracking"); ?>" : "<?= base_url("updateOTFromTrackingKAP2"); ?>";
        $.ajax({
            url:url,
            dataType:"JSON",
            beforeSend:function() {
                $("#status_ot_"+kap).html("Processing get data...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                $("#status_ot_"+kap).html(d.res);
            },
            error:function(a,b,c) {
                $("#status_ot_"+kap).html(a.responseText);
            }
        });
    }

    function get_data(shop,kap) {
        if(shop == "jigin"){
            shop_val = "Jig In";
        }else if(shop == "delivery"){
            shop_val = "Delivery";
        }

        $.ajax({
            url:"<?= base_url("get_data"); ?>/"+shop+"?auto_sync=Yes&kap="+kap,
            dataType:"JSON",
            beforeSend:function() {
                $("#status_get_data_"+shop+"_"+kap).html(shop_val+" : Processing get data...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                $("#status_get_data_"+shop+"_"+kap).html(shop_val+" : "+d.res);
                if(shop == "jigin"){
                    get_data("delivery",1);
                    get_data("delivery",2);
                }else{
                    calc_leadtime(1); //KAP1
                    calc_leadtime(2); //KAP2
                    get_data_ot(1);
                    get_data_ot(2);
                }
            },
            error:function(a,b,c) {
                $("#status_get_data_"+shop+"_"+kap).html(shop_val+" : "+a.responseText);
            }
        });
    }
    function calc_leadtime(kap) {
        const url = "<?= base_url("calc_lead_time"); ?>?auto_sync=Yes&KAP="+kap
        $.ajax({
            url:url,
            dataType:"JSON",
            beforeSend:function() {
                $("#status_calc_lead_time_"+kap).html("Calc Lead Time : Calculating...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                $("#status_calc_lead_time_"+kap).html("Calc Lead Time : "+d.res);
            },
            error:function(a,b,c) {
                $("#status_calc_lead_time_"+kap).html("Calc Lead Time : "+a.responseText);
            }
        });
    }
    
    get_data("jigin",1);
    get_data("jigin",2);

    setInterval(() => {
        get_data("jigin",1);
        get_data("jigin",2);
    }, 900000);
</script>