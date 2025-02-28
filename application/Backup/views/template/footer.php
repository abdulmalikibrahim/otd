<div class="w-100 text-light text-center" style="height:30px; position:absolute; bottom:0; left:0; background:#0077C3;"><label class="m-0" style="font-family:arial; font-size:10px;">Created By Abdul Malik Ibrahim</label></div>
<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script>
	$("#datatable").DataTable();
</script>
<!-- AUTO SYNC -->
<script>
    var base_url = "<?= base_url(); ?>";
    // function get_data(shop) {
    //     if(shop == "jigin"){
    //         shop_val = "Jig In";
    //     }else{
    //         shop_val = "Delivery";
    //     }
    //     $.ajax({
    //         url:"<?= base_url("get_data"); ?>/"+shop,
    //         dataType:"JSON",
    //         beforeSend:function() {
    //             $("#status_get_data_"+shop).html(shop_val+" : Processing get data...");
    //         },
    //         success:function(r) {
    //             d = JSON.parse(JSON.stringify(r));
    //             console.log(r);
    //             $("#status_get_data_"+shop).html(shop_val+" : "+d.res);
    //             if(shop == "jigin"){
    //                 get_data("delivery");
    //             }else{
    //                 calc_leadtime();
    //             }
    //         },
    //         error:function(a,b,c) {
    //             $("#status_get_data_"+shop).html(shop_val+" : "+a.responseText);
    //         }
    //     });
    // }
    // function calc_leadtime() {
    //     $.ajax({
    //         url:"<?= base_url("calc_lead_time"); ?>",
    //         dataType:"JSON",
    //         beforeSend:function() {
    //             $("#status_calc_lead_time").html("Calc Lead Time : Calculating...");
    //         },
    //         success:function(r) {
    //             d = JSON.parse(JSON.stringify(r));
    //             console.log(r);
    //             $("#status_calc_lead_time").html("Calc Lead Time : "+d.res);
    //         },
    //         error:function(a,b,c) {
    //             $("#status_calc_lead_time").html("Calc Lead Time : "+a.responseText);
    //         }
    //     });
    // }
    // get_data("jigin");
</script>
<?php
if(!empty($this->session->flashdata("swal"))){
    echo $this->session->flashdata("swal");
}
?>