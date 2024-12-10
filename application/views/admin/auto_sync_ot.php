<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTDCS Auto Sync OT</title>
</head>
<body>
    <div style="width:100%; margin-top:10rem; text-align:center;">
        <h3>OTDCS Auto Sync OT</h3>
        <div style="margin-bottom:20px;" id="status"></div>
    </div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script>
    function get_data() {
        $.ajax({
            url:"<?= base_url("updateOTFromTracking"); ?>",
            dataType:"JSON",
            beforeSend:function() {
                $("#status").html("Processing get data...");
            },
            success:function(r) {
                d = JSON.parse(JSON.stringify(r));
                $("#status").html(d.res);
            },
            error:function(a,b,c) {
                $("#status").html(a.responseText);
            }
        });
    }
    
    get_data();

    setInterval(() => {
        get_data();
    }, 60000);
</script>