<style>
    .highlight-green {
      background-color: #51c46e;
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
                            for ($i=1; $i <= 7; $i++) {
                                if($otd_adjust == $i){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.($i+1).' Jam</option>';
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
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="11">Advance (hour)</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle highlight-green" rowspan="3">Ontime<br>-1 ~ +1 Hour</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="11">Delay (hour)</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle" rowspan="3">OTD</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center align-middle" rowspan="3">Chart</th>
                        </tr>
                        <tr>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">>32</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">32</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">24</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">16</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">8</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">7</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">6</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">5</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">4</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">3</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center highlight-green">2</th>

                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-1">2</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-2">3</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-3">4</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-4">5</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-5">6</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-6">7</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center cell-7">8</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">16</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">24</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">32</th>
                            <th style="font-size:9pt;" class="pt-1 pb-1 text-center bg-danger text-light">>32</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $date = $year_sum."-".$month_sum."-01";
                        for ($i=1; $i <= date("t",strtotime($date)); $i++) {
                            $get_data_dot = $this->model->gd("set_ot","*","tanggal = '$i'","row");
                            $day = date("Y-m-d",strtotime(date($year_sum."-".$month_sum."-").sprintf("%02d",$i)));
                            $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
                            SUM(CASE WHEN u2.balance <= -1921 THEN 1 ELSE 0 END) AS adv_more_32jam,
                            SUM(CASE WHEN u2.balance BETWEEN -1920 AND -1441 THEN 1 ELSE 0 END) AS adv_32jam,
                            SUM(CASE WHEN u2.balance BETWEEN -1440 AND -961 THEN 1 ELSE 0 END) AS adv_24jam,
                            SUM(CASE WHEN u2.balance BETWEEN -960 AND -481 THEN 1 ELSE 0 END) AS adv_16jam,
                            SUM(CASE WHEN u2.balance BETWEEN -480 AND -421 THEN 1 ELSE 0 END) AS adv_8jam,
                            SUM(CASE WHEN u2.balance BETWEEN -420 AND -361 THEN 1 ELSE 0 END) AS adv_7jam,
                            SUM(CASE WHEN u2.balance BETWEEN -360 AND -301 THEN 1 ELSE 0 END) AS adv_6jam,
                            SUM(CASE WHEN u2.balance BETWEEN -300 AND -241 THEN 1 ELSE 0 END) AS adv_5jam,
                            SUM(CASE WHEN u2.balance BETWEEN -240 AND -181 THEN 1 ELSE 0 END) AS adv_4jam,
                            SUM(CASE WHEN u2.balance BETWEEN -180 AND -121 THEN 1 ELSE 0 END) AS adv_3jam,
                            SUM(CASE WHEN u2.balance BETWEEN -120 AND -61 THEN 1 ELSE 0 END) AS adv_2jam,

                            SUM(CASE WHEN u2.balance BETWEEN -60 AND 60 THEN 1 ELSE 0 END) AS total_ontime,

                            SUM(CASE WHEN u2.balance BETWEEN 61 AND 120 THEN 1 ELSE 0 END) AS delay_2jam,
                            SUM(CASE WHEN u2.balance BETWEEN 121 AND 180 THEN 1 ELSE 0 END) AS delay_3jam,
                            SUM(CASE WHEN u2.balance BETWEEN 181 AND 240 THEN 1 ELSE 0 END) AS delay_4jam,
                            SUM(CASE WHEN u2.balance BETWEEN 241 AND 300 THEN 1 ELSE 0 END) AS delay_5jam,
                            SUM(CASE WHEN u2.balance BETWEEN 301 AND 360 THEN 1 ELSE 0 END) AS delay_6jam,
                            SUM(CASE WHEN u2.balance BETWEEN 361 AND 420 THEN 1 ELSE 0 END) AS delay_7jam,
                            SUM(CASE WHEN u2.balance BETWEEN 421 AND 480 THEN 1 ELSE 0 END) AS delay_8jam,
                            SUM(CASE WHEN u2.balance BETWEEN 481 AND 960 THEN 1 ELSE 0 END) AS delay_16jam,
                            SUM(CASE WHEN u2.balance BETWEEN 961 AND 1440 THEN 1 ELSE 0 END) AS delay_24jam,
                            SUM(CASE WHEN u2.balance BETWEEN 1441 AND 1920 THEN 1 ELSE 0 END) AS delay_32jam,
                            SUM(CASE WHEN u2.balance >= 1921 THEN 1 ELSE 0 END) AS delay_more_32jam
                            FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$day." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($day)))." 07:00:00' AND u1.otd IS NOT NULL","row");
                            
                            // Assign results to variables
                            $totalUnit = $total_unit->total_unit;
                            
                            $adv_2jam = $total_unit->adv_2jam;
                            $adv_3jam = $total_unit->adv_3jam;
                            $adv_4jam = $total_unit->adv_4jam;
                            $adv_5jam = $total_unit->adv_5jam;
                            $adv_6jam = $total_unit->adv_6jam;
                            $adv_7jam = $total_unit->adv_7jam;
                            $adv_8jam = $total_unit->adv_8jam;
                            $adv_16jam = $total_unit->adv_16jam;
                            $adv_24jam = $total_unit->adv_24jam;
                            $adv_32jam = $total_unit->adv_32jam;
                            $adv_more_32jam = $total_unit->adv_more_32jam;
                            $totalAdvance = $adv_16jam + $adv_24jam + $adv_32jam + $adv_more_32jam;
                            
                            $total_ontime = $total_unit->total_ontime;

                            $delay_2jam = $total_unit->delay_2jam;
                            $delay_3jam = $total_unit->delay_3jam;
                            $delay_4jam = $total_unit->delay_4jam;
                            $delay_5jam = $total_unit->delay_5jam;
                            $delay_6jam = $total_unit->delay_6jam;
                            $delay_7jam = $total_unit->delay_7jam;
                            $delay_8jam = $total_unit->delay_8jam;
                            $delay_16jam = $total_unit->delay_16jam;
                            $delay_24jam = $total_unit->delay_24jam;
                            $delay_32jam = $total_unit->delay_32jam;
                            $delay_more_32jam = $total_unit->delay_more_32jam;

                            $dataDay = [
                                intval($adv_more_32jam),
                                intval($adv_32jam),
                                intval($adv_24jam),
                                intval($adv_16jam),
                                intval($adv_8jam),
                                intval($adv_7jam),
                                intval($adv_6jam),
                                intval($adv_5jam),
                                intval($adv_4jam),
                                intval($adv_3jam),
                                intval($adv_2jam),
                                intval($total_ontime),
                                intval($delay_2jam),
                                intval($delay_3jam),
                                intval($delay_4jam),
                                intval($delay_5jam),
                                intval($delay_6jam),
                                intval($delay_7jam),
                                intval($delay_8jam),
                                intval($delay_16jam),
                                intval($delay_24jam),
                                intval($delay_32jam),
                                intval($delay_more_32jam)
                            ];

                            $maxVal = max($dataDay)+15;

                            $arrayOTDValues = array_slice($dataDay,4,(intval($otd_adjust)+8));
                            // print_r($arrayOTDValues);
                            // echo "<br>";
                            
                            $otd_value = 0;
                            if($totalUnit > 0){
                                $otd_value = array_sum($arrayOTDValues) / $totalUnit;
                            }

                            if(substr_count("Sat Sun",date("D",strtotime($day))) > 0){
                                $bg_row = "bg-secondary text-light";
                            }else{
                                $bg_row = "";
                            }
                            ?>
                            <tr>
                                <td style="font-size:12pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= date("D, d M",strtotime($day)); ?></td>
                                <td style="font-size:12pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= $total_unit->total_unit; ?></td>
                                
                                <?php
                                $tipe = -11;
                                $tipeClass = 0;
                                $tipeClassVal = "";
                                foreach ($dataDay as $key => $value) {
                                    if(!empty($bg_row)){
                                      $dataDay = "SatSun";
                                    }else{
                                      $dataDay = "";
                                    }
                                    if($key >= 0 && $key <= 3){
                                      if(empty($bg_row)){
                                        $tipeClassVal = "bg-danger text-light";
                                      }
                                    }else if($key >= 4 && $key <= 10){
                                      $tipeClassVal = "cell-".$tipeClass;
                                    }else if($key > 11 && $key <= 18){
                                      $tipeClass++;
                                      $tipeClassVal = "cell-".$tipeClass;
                                    }else if($key > 18){
                                      if(empty($bg_row)){
                                        $tipeClassVal = "bg-danger text-light";
                                      }
                                    }
                                    echo '<td style="font-size:12pt; cursor:pointer;" title="Click for show list unit" class="align-middle '.$bg_row.' text-center p-1 td-row '.$tipeClassVal.'" data-day="'.$dataDay.'" data-tipe="'.$tipe.'" data-pdd="'.$day.'" onclick="showListUnit(this)">'.$value.'</td>';
                                    $tipe++;
                                }
                                ?>
                                
                                <td style="font-size:12pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= round($otd_value*100,1)."%"; ?></td>
                                <td style="font-size:12pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><a href="javascript:void(0);" onclick="open_chart(this)" data-chart="<?= json_encode($dataDay); ?>" data-max="<?= $maxVal; ?>" data-tanggal="<?= date("l, d M Y",strtotime($day)); ?>" title="Show Chart" class="btn btn-sm btn-success"><i class="fas fa-chart-line"></i></a></td>
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
      <h5 id="title-list-unit" style="position: absolute;top: 5rem;right: 2rem;"></h5>
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