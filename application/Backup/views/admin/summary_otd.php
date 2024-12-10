<style>
    .highlight-green {
        background-color: #0077C3;
        color: white;
    }
</style>
    <div class="row">
        <div class="col-lg-4 text-right">
            <div class="input-group">
                </div>
        </div>
        <div class="col-lg-4 d-flex justify-content-end align-items-end">
            <form action="<?= base_url("print_otd"); ?>" target="_blank" method="get">
                <div class="card mt-2 border-0">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="mb-1">From :</p>
                                <input type="date" class="form-control" name="print-from" value="<?= $year_sum."-".$month_sum."-01"; ?>">
                            </div>
                            <div class="col-lg-6">
                                <p class="mb-1">To :</p>
                                <input type="date" class="form-control" name="print-to" value="<?= date("Y-m-t",strtotime($year_sum."-".$month_sum."-01")); ?>">
                            </div>
                            <div class="col-lg-12 mt-1 text-right">
                                <button class="btn btn-sm btn-info"><i class="fas fa-print pr-2"></i>Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <form action="<?= base_url("set_adjust_otd"); ?>" id="form-adjust" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="mb-1 mt-2">Periode</p>
                        <div class="input-group">
                            <select name="month" id="month" class="form-control">
                                <?php
                                for ($i=1; $i <= 12; $i++) {
                                    if($month_sum == $i){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    echo '<option value="'.$i.'" '.$selected.'>'.date("M",strtotime(date("Y-".sprintf("%02d",$i)."-01"))).'</option>';
                                }
                                ?>
                            </select>
                            <select name="year" id="year" class="form-control">
                                <?php
                                for ($i=2024; $i <= date("Y"); $i++) {
                                    if($year_sum == $i){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <p class="mb-1 mt-2">Allowance Adjust</p>
                        <select name="adjust" id="adjust" class="form-control">
                            <option value="0">OnTime</option>
                            <?php
                            for ($i=1; $i <= 8; $i++) {
                                if($otd_adjust == $i){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.' Jam</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
<div class="row mt-0">
    <div class="col-lg-12 text-right mb-2">
        <a href="<?= base_url("summary_otd_excel"); ?>" target="_blank" class="btn btn-success" id="btn-convert-excel"><i class="fas fa-file-excel mr-2"></i>Download Table</a>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-hover m-0" id="datatable-summary">
                    <thead>
                        <tr>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle" rowspan="3">Delivery</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle" rowspan="3">Total Unit</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green" colspan="9">Advance (hour)</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle highlight-green" rowspan="3">Ontime</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center" colspan="9">Delay (hour)</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle" rowspan="3">OTD</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle" rowspan="3">Chart</th>
                        </tr>
                        <tr>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">>8</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">8</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">7</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">6</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">5</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">4</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">3</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">2</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">1</th>

                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-1">1</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-2">2</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-3">3</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-4">4</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-5">5</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-6">6</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-7">7</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-8">8</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-9">>8</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $date = $year_sum."-".$month_sum."-01";
                        for ($i=1; $i <= date("t",strtotime($date)); $i++) {
                            $get_data_dot = $this->model->gd("set_ot","*","tanggal = '$i'","row");
                            $day = date("Y-m-d",strtotime(date($year_sum."-".$month_sum."-").sprintf("%02d",$i)));
                            $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
                            SUM(CASE WHEN u2.balance BETWEEN -60 AND -1 THEN 1 ELSE 0 END) AS adv_1jam,
                            SUM(CASE WHEN u2.balance BETWEEN -120 AND -61 THEN 1 ELSE 0 END) AS adv_2jam,
                            SUM(CASE WHEN u2.balance BETWEEN -180 AND -121 THEN 1 ELSE 0 END) AS adv_3jam,
                            SUM(CASE WHEN u2.balance BETWEEN -240 AND -181 THEN 1 ELSE 0 END) AS adv_4jam,
                            SUM(CASE WHEN u2.balance BETWEEN -300 AND -241 THEN 1 ELSE 0 END) AS adv_5jam,
                            SUM(CASE WHEN u2.balance BETWEEN -360 AND -301 THEN 1 ELSE 0 END) AS adv_6jam,
                            SUM(CASE WHEN u2.balance BETWEEN -420 AND -361 THEN 1 ELSE 0 END) AS adv_7jam,
                            SUM(CASE WHEN u2.balance BETWEEN -480 AND -421 THEN 1 ELSE 0 END) AS adv_8jam,
                            SUM(CASE WHEN u2.balance <= -481 THEN 1 ELSE 0 END) AS adv_more8jam,
                            COUNT(CASE WHEN u2.balance = 0 THEN 1 END) AS total_ontime,
                            SUM(CASE WHEN u2.balance BETWEEN 1 AND 60 THEN 1 ELSE 0 END) AS total_1jam,
                            SUM(CASE WHEN u2.balance BETWEEN 61 AND 120 THEN 1 ELSE 0 END) AS total_2jam,
                            SUM(CASE WHEN u2.balance BETWEEN 121 AND 180 THEN 1 ELSE 0 END) AS total_3jam,
                            SUM(CASE WHEN u2.balance BETWEEN 181 AND 240 THEN 1 ELSE 0 END) AS total_4jam,
                            SUM(CASE WHEN u2.balance BETWEEN 241 AND 300 THEN 1 ELSE 0 END) AS total_5jam,
                            SUM(CASE WHEN u2.balance BETWEEN 301 AND 360 THEN 1 ELSE 0 END) AS total_6jam,
                            SUM(CASE WHEN u2.balance BETWEEN 361 AND 420 THEN 1 ELSE 0 END) AS total_7jam,
                            SUM(CASE WHEN u2.balance BETWEEN 421 AND 480 THEN 1 ELSE 0 END) AS total_8jam,
                            SUM(CASE WHEN u2.balance >= 481 THEN 1 ELSE 0 END) AS total_more8jam
                            FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$day." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($day)))." 07:00:00';","row");
                            
                            // Assign results to variables
                            $totalUnit = $total_unit->total_unit;
                            $adv_1jam = $total_unit->adv_1jam;
                            $adv_2jam = $total_unit->adv_2jam;
                            $adv_3jam = $total_unit->adv_3jam;
                            $adv_4jam = $total_unit->adv_4jam;
                            $adv_5jam = $total_unit->adv_5jam;
                            $adv_6jam = $total_unit->adv_6jam;
                            $adv_7jam = $total_unit->adv_7jam;
                            $adv_8jam = $total_unit->adv_8jam;
                            $adv_more8jam = $total_unit->adv_more8jam;
                            
                            $total_ontime = $adv_1jam + $adv_2jam + $adv_3jam + $adv_4jam + $adv_5jam + $adv_6jam + $adv_7jam + $adv_8jam + $adv_more8jam + $total_unit->total_ontime;
                            $ontime = $total_unit->total_ontime;

                            $total_1jam = $total_unit->total_1jam;
                            $total_2jam = $total_unit->total_2jam;
                            $total_3jam = $total_unit->total_3jam;
                            $total_4jam = $total_unit->total_4jam;
                            $total_5jam = $total_unit->total_5jam;
                            $total_6jam = $total_unit->total_6jam;
                            $total_7jam = $total_unit->total_7jam;
                            $total_8jam = $total_unit->total_8jam;
                            $total_more8jam = $total_unit->total_more8jam;
                            
                            $otd_value = 0;
                            if($totalUnit > 0){
                                switch ($otd_adjust) {
                                    case 0:
                                        $otd_value = $total_ontime / $totalUnit;
                                        break;
                                    case 1:
                                        $otd_value = ($total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 2:
                                        $otd_value = ($total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 3:
                                        $otd_value = ($total_3jam + $total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 4:
                                        $otd_value = ($total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 5:
                                        $otd_value = ($total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 6:
                                        $otd_value = ($total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 7:
                                        $otd_value = ($total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    case 8:
                                        $otd_value = ($total_8jam + $total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime) / $totalUnit;
                                        break;
                                    default:
                                        // Handle case where $otd_adjust is outside the expected range
                                        $otd_value = $total_ontime / $totalUnit;
                                        break;
                                }
                            }

                            if(substr_count("Sat Sun",date("D",strtotime($day))) > 0){
                                $bg_row = "bg-secondary";
                            }else{
                                $bg_row = "";
                            }
                            ?>
                            <tr>
                                <td style="font-size:9pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= date("D, d M",strtotime($day)); ?></td>
                                <td style="font-size:9pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= $total_unit->total_unit; ?></td>
                                
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-9" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_more8jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-8" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_8jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-7" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_7jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-6" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_6jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-5" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_5jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-4" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_4jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-3" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_3jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-2" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_2jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="-1" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_1jam; ?></td>

                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="0" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_unit->total_ontime; ?></td>

                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-1" data-tipe="1" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_1jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-2" data-tipe="2" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_2jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-3" data-tipe="3" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_3jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-4" data-tipe="4" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_4jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-5" data-tipe="5" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_5jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-6" data-tipe="6" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_6jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-7" data-tipe="7" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_7jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-8" data-tipe="8" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_8jam; ?></td>
                                <td style="font-size:9pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-9" data-tipe="9" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_more8jam; ?></td>
                                <td style="font-size:9pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= round($otd_value*100,1)."%"; ?></td>
                                <td style="font-size:9pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><a href="javascript:void(0);" onclick="open_chart(this)" 
                                data-chart1="<?= $adv_more8jam; ?>" 
                                data-chart2="<?= $adv_8jam; ?>" 
                                data-chart3="<?= $adv_7jam; ?>" 
                                data-chart4="<?= $adv_6jam; ?>" 
                                data-chart5="<?= $adv_5jam; ?>" 
                                data-chart6="<?= $adv_4jam; ?>" 
                                data-chart7="<?= $adv_3jam; ?>" 
                                data-chart8="<?= $adv_2jam; ?>"  
                                data-chart9="<?= $adv_1jam; ?>" 
                                data-chart10="<?= $ontime; ?>" 
                                data-chart11="<?= $total_1jam; ?>" 
                                data-chart12="<?= $total_2jam; ?>" 
                                data-chart13="<?= $total_3jam; ?>" 
                                data-chart14="<?= $total_4jam; ?>" 
                                data-chart15="<?= $total_5jam; ?>" 
                                data-chart16="<?= $total_6jam; ?>" 
                                data-chart17="<?= $total_7jam; ?>" 
                                data-chart18="<?= $total_8jam; ?>" 
                                data-chart19="<?= $total_more8jam; ?>" 
                                data-tanggal="<?= date("l, d M Y",strtotime($day)); ?>" title="Show Chart" class="btn btn-sm btn-success"><i class="fas fa-chart-line"></i></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12 text-right mt-3">
        <a href="<?= base_url(""); ?>" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-list-unit" tabindex="-1" aria-labelledby="modal-list-unitLabel" aria-hidden="true" style="overflow-y:auto;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-list-unitLabel">Show List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <h4 id="title-list-unit" style="position: absolute;top: 5rem;right: 2rem;"></h4>
      <button class="btn btn-sm btn-info" style="position: absolute;top: 8rem;right: 1rem; z-index:1000;" id="btn-re-calculate" data-vin="" data-pdd="" onclick="re_calculate(this)">Calculate Ulang</button>
      <div class="modal-body text-center" id="list-unit">
        <i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-tracking" tabindex="-1" aria-labelledby="modal-trackingLabel" aria-hidden="true" style="overflow-y:auto;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-trackingLabel">Tracking Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" id="tracking">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-tracking-unit" tabindex="-1" aria-labelledby="modal-tracking-unitLabel" aria-hidden="true" style="overflow-y:auto;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-tracking-unitLabel">Tracking Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" id="tracking-unit">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-chart" tabindex="-1" aria-labelledby="modal-list-unitLabel" aria-hidden="true" style="overflow-y:auto;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-chart">Chart OTD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <canvas id="myChart"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>