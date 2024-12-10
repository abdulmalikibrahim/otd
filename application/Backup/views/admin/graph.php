<style>
    .highlight-green {
        background-color: #0077C3;
        color: white;
    }
</style>
<form action="<?= base_url("set_adjust_otd"); ?>" id="form-adjust" method="post">
    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <p class="mb-1 mt-2">Periode</p>
            <input type="date" name="periodeGraph" id="periodeGraph" class="form-control" value="<?= $periodeGraph; ?>">
        </div>
    </div>
</form>
<div class="row mt-3">
    <div class="col-lg-12" hidden>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-hover m-0">
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
                            $get_data_dot = $this->model->gd("set_ot","*","tanggal = '$day_sum'","row");
                            $day = date("Y-m-d",strtotime(date($year_sum."-".$month_sum."-").sprintf("%02d",$day_sum)));
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
                            
                            $total_ontime = $total_unit->total_ontime;

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
                            <td><?= date("D, d M",strtotime($day)); ?></td>
                            <td><?= $total_unit->total_unit; ?></td>
                            
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_more8jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_8jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_7jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_6jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_5jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_4jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_3jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_2jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $adv_1jam; ?></td>

                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_unit->total_ontime; ?></td>

                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_1jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_2jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_3jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_4jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_5jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_6jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_7jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_8jam; ?></td>
                            <td data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_more8jam; ?></td>
                            <td style="font-size:9pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><?= round($otd_value*100,1)."%"; ?></td>
                            <td style="font-size:9pt;" class="align-middle <?=$bg_row;?> text-center p-1 td-row"><a href="javascript:void(0);" id="data-chart" 
                            data-chart1="<?= $adv_more8jam; ?>" 
                            data-chart2="<?= $adv_8jam; ?>" 
                            data-chart3="<?= $adv_7jam; ?>" 
                            data-chart4="<?= $adv_6jam; ?>" 
                            data-chart5="<?= $adv_5jam; ?>" 
                            data-chart6="<?= $adv_4jam; ?>" 
                            data-chart7="<?= $adv_3jam; ?>" 
                            data-chart8="<?= $adv_2jam; ?>"  
                            data-chart9="<?= $adv_1jam; ?>" 
                            data-chart10="<?= $total_ontime; ?>" 
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="chart-container" style="width:100%; height:47rem;">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-lg-12 text-right mt-3">
        <a href="<?= base_url(""); ?>" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-list-unit" tabindex="-1" aria-labelledby="modal-list-unitLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-list-unitLabel">Show List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" id="list-unit">
        <i class="fas fa-spinner fa-spin" style="font-size:30pt;"></i>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>