<script>
    function setuponoff(data) {
        tanggal = data.dataset.tanggal;
        if(data.checked){
            $("#start_ds_"+tanggal).val("07:25");
            $("#end_ds_"+tanggal).val("16:00");

            $("#start_ds_"+tanggal).removeClass("text-light");
            $("#end_ds_"+tanggal).removeClass("text-light");

            $("#start_ds_"+tanggal).addClass("text-dark");
            $("#end_ds_"+tanggal).addClass("text-dark");
        }else{
            $("#start_ds_"+tanggal).val("");
            $("#end_ds_"+tanggal).val("");
            
            $("#start_ds_"+tanggal).removeClass("text-dark");
            $("#end_ds_"+tanggal).removeClass("text-dark");

            $("#start_ds_"+tanggal).addClass("text-light");
            $("#end_ds_"+tanggal).addClass("text-light");
            
        }
    }
    function setuponoffnight(data) {
        tanggal = data.dataset.tanggal;
        if(data.checked){
            $("#start_ns_"+tanggal).val("21:00");
            $("#end_ns_"+tanggal).val("05:45");

            $("#start_ns_"+tanggal).removeClass("text-light");
            $("#end_ns_"+tanggal).removeClass("text-light");

            $("#start_ns_"+tanggal).addClass("text-dark");
            $("#end_ns_"+tanggal).addClass("text-dark");
        }else{
            $("#start_ns_"+tanggal).val("");
            $("#end_ns_"+tanggal).val("");
            
            $("#start_ns_"+tanggal).removeClass("text-dark");
            $("#end_ns_"+tanggal).removeClass("text-dark");

            $("#start_ns_"+tanggal).addClass("text-light");
            $("#end_ns_"+tanggal).addClass("text-light");
            
        }
    }

    $("#month, #ot-awal").change(function() {
        $("#form-filter-month").submit();
    });
</script>