<?php
if($this->uri->segment(1) == "live_andon"){
    ?>
    <div class="w-100 text-light d-flex justify-content-center align-items-center p-0" style="height:70px; background:#0077C3; position: relative;">
        <h3 style="font-family:cooper black; font-size:3rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            ONTIME DELIVERY
        </h3>
    </div>

    <?php
}else{
    ?>
    <div class="w-100 text-light" style="height:90px; background:#0077C3;"><h3 style="font-family:cooper black; font-size:3rem; position:absolute; top:1rem; left:2rem;"><?= $title; ?></h3></div>
    <a href="<?= base_url(""); ?>" title="Home Page" style="position:absolute; top: 1.3rem; right: 1rem;" class="btn btn-sm btn-rounded rounded-circle btn-danger p-2"><i class="fas fa-home m-0" style="font-size:20pt;"></i></a>
    <?php
}
?>