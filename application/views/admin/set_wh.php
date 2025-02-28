<div class="row mt-3 ml-3">
    <div class="col-lg-8">
        <h1 style="font-size:3.5rem;" class="m-0">PLANT <?= $this->plant; ?></h1>
    </div>
    <div class="col-lg-4 text-right">
        <div class="row">
            <div class="col-4">
                <form action="<?= base_url("setPlant") ?>" id="formSetPlant" method="post">
                    <div class="text-left"><p class="mb-1">Plant</p></div>
                    <select name="plant" id="plant" class="form-control">
                        <option value="KAP1" <?= $this->plant == "KAP1" ? "selected" : ""; ?>>KAP1</option>
                        <option value="KAP2" <?= $this->plant == "KAP2" ? "selected" : ""; ?>>KAP2</option>
                    </select>
                </form>
            </div>
            <div class="col-4">
                <form action="<?= base_url("set_ot_awal") ?>" method="post" id="formOtAwal">
                    <div class="text-left"><p class="mb-1">OT Awal NS</p></div>
                    <select name="ot-awal" id="ot-awal" class="form-control">
                        <?php
                        $item = $this->plant == "KAP1" ? "ot_awal" : "ot_awal_kap2";
                        $ot_awal = $this->model->gd("master_setting","nilai","item = '$item'","row");
                        for ($i=0; $i <= 1; $i++) { 
                            if(empty($ot_awal->nilai)){
                                $otAwalSetup = 0;
                            }else{
                                $otAwalSetup = $ot_awal->nilai;
                            }

                            if($otAwalSetup == $i){
                                $s = "selected";
                            }else{
                                $s = "";
                            }

                            if($i <= 0){
                                $value = "Tidak";
                            }else{
                                $value = "Ya";
                            }
                            echo '<option value="'.$i.'" '.$s.'>'.$value.'</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="col-4">
                <form action="" method="get" id="form-filter-month">
                    <div class="text-left"><p class="mb-1">Periode</p></div>
                    <div class="input-group">
                        <select name="month" id="month" class="form-control">
                            <?php
                            $monthNow = empty($this->input->get("month")) ? (date("m")*1) : $this->input->get("month");
                            for ($i=1; $i <= 12; $i++) {
                                if($monthNow == $i){
                                    $s = "selected";
                                }else{
                                    $s = "";
                                }
                                echo '<option value="'.sprintf("%02d",$i).'" '.$s.'>'.date("M",strtotime(date("Y-").sprintf("%02d",$i)."-01")).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<form action="<?= base_url("simpan_set_wh?month=".$monthNow); ?>" method="post">
    <div class="row mt-3 ml-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover m-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="pt-1 pb-1 text-center align-middle" rowspan="2">Tanggal</th>
                                <th class="pt-1 pb-1 text-center align-middle" rowspan="2">On/Off<br>Day</th>
                                <th class="pt-1 pb-1 text-center align-middle" colspan="2">Day Shift</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light" rowspan="2">On/Off<br>Night</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light" colspan="2">Night Shift</th>
                            </tr>
                            <tr>
                                <th class="pt-1 pb-1 text-center align-middle">Start</th>
                                <th class="pt-1 pb-1 text-center align-middle">End</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light">Start</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light">End</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $table_ot = $this->plant == "KAP1" ? "set_ot" : "set_ot_kap2";
                            for ($i=1; $i <= 16; $i++) {
                                $day = date("D",strtotime(date("Y-".$monthNow."-").sprintf("%02d",$i)));
                                $tanggal = date("Y-".$monthNow."-").sprintf("%02d",$i);
                                $get_data_dot = $this->model->gd($table_ot,"*","tanggal = '$tanggal'","row");
                                if(substr_count("Sat Sun",$day) > 0){
                                    $bg_day = "bg-secondary text-light";
                                }else{
                                    $bg_day = "";
                                }

                                if(empty($get_data_dot->on_off)){
                                    $checked = "";
                                    $color_text = "text-light";
                                }else{
                                    $checked = "checked";
                                    $color_text = "text-dark";
                                }

                                if(empty($get_data_dot->on_off_night)){
                                    $checkednight = "";
                                    $color_textnight = "text-light";
                                }else{
                                    if($get_data_dot->shadow == 0){
                                        $checkednight = "checked";
                                        $color_textnight = "text-dark";
                                    }else{
                                        $checkednight = "";
                                        $color_textnight = "text-light";
                                    }
                                }
                                ?>
                                <tr>
                                    <td class="<?= $bg_day; ?> pt-1 pb-1">
                                        <?= date("D, d M",strtotime(date("Y-".$monthNow."-".sprintf("%02d",$i)))); ?>
                                    </td>
                                    <td class="<?= $bg_day; ?> pt-1 pb-1 text-center">
                                        <input type="checkbox" name="onoff[<?= $i; ?>]" value="<?= $i; ?>" data-tanggal="<?= $i; ?>" onclick="setuponoff(this)" <?= $checked; ?>>
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="start_ds_<?= $i; ?>" name="start_ds[<?= $i; ?>]" class="<?= $color_text; ?> form-control text-center" value="<?= !empty($get_data_dot->start_ds) ? $get_data_dot->start_ds : ""; ?>">
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="end_ds_<?= $i; ?>" name="end_ds[<?= $i; ?>]" class="<?= $color_text; ?> form-control text-center" value="<?= !empty($get_data_dot->end_ds) ? $get_data_dot->end_ds : ""; ?>">
                                    </td>
                                    <td class="<?= $bg_day; ?> pt-1 pb-1 text-center">
                                        <input type="checkbox" name="onoffnight[<?= $i; ?>]" value="<?= $i; ?>" data-tanggal="<?= $i; ?>" onclick="setuponoffnight(this)" <?= $checkednight; ?>>
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="start_ns_<?= $i; ?>" name="start_ns[<?= $i; ?>]" class="<?= $color_textnight; ?> form-control text-center" value="<?= !empty($get_data_dot->start_ns) ? $get_data_dot->start_ns : ""; ?>">
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="end_ns_<?= $i; ?>" name="end_ns[<?= $i; ?>]" class="<?= $color_textnight; ?> form-control text-center" value="<?= !empty($get_data_dot->end_ns) ? $get_data_dot->end_ns : ""; ?>">
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover m-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="pt-1 pb-1 text-center align-middle" rowspan="2">Tanggal</th>
                                <th class="pt-1 pb-1 text-center align-middle" rowspan="2">On/Off<br>Day</th>
                                <th class="pt-1 pb-1 text-center align-middle" colspan="2">Day Shift</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light" rowspan="2">On/Off<br>Night</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light" colspan="2">Night Shift</th>
                            </tr>
                            <tr>
                                <th class="pt-1 pb-1 text-center align-middle">Start</th>
                                <th class="pt-1 pb-1 text-center align-middle">End</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light">Start</th>
                                <th class="pt-1 pb-1 text-center align-middle bg-secondary text-light">End</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i=17; $i <= date("t",strtotime(date("Y-".$monthNow."-01"))); $i++) { 
                                $day = date("D",strtotime(date("Y-".$monthNow."-").sprintf("%02d",$i)));
                                $tanggal = date("Y-".$monthNow."-").sprintf("%02d",$i);
                                $get_data_dot = $this->model->gd($table_ot,"*","tanggal = '$tanggal'","row");
                                if(substr_count("Sat Sun",$day) > 0){
                                    $bg_day = "bg-secondary text-light";
                                }else{
                                    $bg_day = "";
                                }

                                if(empty($get_data_dot->on_off)){
                                    $checked = "";
                                    $color_text = "text-light";
                                }else{
                                    $checked = "checked";
                                    $color_text = "text-dark";
                                }

                                if(empty($get_data_dot->on_off_night)){
                                    $checkednight = "";
                                    $color_textnight = "text-light";
                                }else{
                                    if($get_data_dot->shadow == 0){
                                        $checkednight = "checked";
                                        $color_textnight = "text-dark";
                                    }else{
                                        $checkednight = "";
                                        $color_textnight = "text-light";
                                    }
                                }
                                ?>
                                <tr>
                                    <td class="<?= $bg_day; ?> pt-1 pb-1">
                                        <?= date("D, d M",strtotime(date("Y-".$monthNow."-".sprintf("%02d",$i)))); ?>
                                    </td>
                                    <td class="<?= $bg_day; ?> pt-1 pb-1 text-center">
                                        <input type="checkbox" name="onoff[<?= $i; ?>]" value="<?= $i; ?>" data-tanggal="<?= $i; ?>" onclick="setuponoff(this)" <?= $checked; ?>>
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="start_ds_<?= $i; ?>" name="start_ds[<?= $i; ?>]" class="<?= $color_text; ?> form-control text-center" value="<?= !empty($get_data_dot->start_ds) ? $get_data_dot->start_ds : ""; ?>">
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="end_ds_<?= $i; ?>" name="end_ds[<?= $i; ?>]" class="<?= $color_text; ?> form-control text-center" value="<?= !empty($get_data_dot->end_ds) ? $get_data_dot->end_ds : ""; ?>">
                                    </td>
                                    <td class="<?= $bg_day; ?> pt-1 pb-1 text-center">
                                        <input type="checkbox" name="onoffnight[<?= $i; ?>]" value="<?= $i; ?>" data-tanggal="<?= $i; ?>" onclick="setuponoffnight(this)" <?= $checkednight; ?>>
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="start_ns_<?= $i; ?>" name="start_ns[<?= $i; ?>]" class="<?= $color_textnight; ?> form-control text-center" value="<?= !empty($get_data_dot->start_ns) ? $get_data_dot->start_ns : ""; ?>">
                                    </td>
                                    <td class="p-0">
                                        <input type="time" id="end_ns_<?= $i; ?>" name="end_ns[<?= $i; ?>]" class="<?= $color_textnight; ?> form-control text-center" value="<?= !empty($get_data_dot->end_ns) ? $get_data_dot->end_ns : ""; ?>">
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-right">
            <button class="btn btn-info btn-sm">Simpan</button>
            <a href="<?= base_url(""); ?>" class="btn btn-sm btn-danger">Kembali</a>
            <a href="<?= base_url("clear_ot?month=".$monthNow); ?>" class="btn btn-sm btn-warning">Clear All</a>
        </div>
    </div>
</form>