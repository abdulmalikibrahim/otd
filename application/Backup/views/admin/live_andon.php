<style>
    .highlight-green {
        background-color: #28a745 !important;
        color: white;
    }
</style>
<div style="position:relative;">
    <div class="row mt-4">
        <div class="col-lg-4" style="font-family:bernard mt condensed; font-weight:bold; font-size:3rem;">Daily</div>
        <div class="col-lg-4 text-center" style="font-family:bernard mt condensed; font-weight:bold; font-size:3rem;" id="date-now"></div>
        <div class="col-lg-4 text-right" style="font-family:bernard mt condensed; font-weight:bold; font-size:3rem;" id="time-now"></div>
    </div>
    <div class="row mt-3">
        <div class="col-lg">
            <div class="card">
                <div class="card-body text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black; background-color: #000;">DELIVERY</div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-body bg-primary text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ADVANCE</div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-body bg-success text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ONTIME</div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-body bg-danger text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">DELAY</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg mt-2">
            <div class="card" style="height:15rem;">
                <div class="counting card-body d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:90pt; font-family:calibri; background-color:#000;" id="count-delivery">0</div>
            </div>
        </div>
        <div class="col-lg mt-2">
            <div class="card" style="height:15rem;">
                <div class="counting card-body bg-primary d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:55pt; font-family:calibri;" id="count-advance">0</div>
                <div class="counting mt-2 card-body bg-primary d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:45pt; font-family:calibri;" id="percent-advance">0</div>
            </div>
        </div>
        <div class="col-lg mt-2">
            <div class="card" style="height:15rem;">
                <div class="counting card-body bg-success d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:55pt; font-family:calibri;" id="count-ontime">0</div>
                <div class="counting mt-2 card-body bg-success d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:45pt; font-family:calibri;" id="percent-ontime">0</div>
            </div>
        </div>
        <div class="col-lg mt-2">
            <div class="card" style="height:15rem;">
                <div class="counting card-body bg-danger d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:55pt; font-family:calibri;" id="count-delay">0</div>
                <div class="counting mt-2 card-body bg-danger d-flex align-items-center justify-content-center text-light p-2 text-center font-weight-bold" style="font-size:45pt; font-family:calibri;" id="percent-delay">0</div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <table class="table table-bordered table-hover m-0">
                <thead>
                    <tr>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center bg-primary text-light" rowspan="2">Advance</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center align-middle highlight-green" rowspan="2">Ontime</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="9">Delay</th>
                    </tr>
                    <tr>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-1">1 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-9">>8 Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = date("d");
                    $get_data_dot = $this->model->gd("set_ot","*","tanggal = '$i'","row");
                    $day = date("Y-m-d",strtotime(date($year_sum."-".$month_sum."-").sprintf("%02d",$i)));
                    $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
                    SUM(CASE WHEN u2.balance <= -481 THEN 1 ELSE 0 END) AS advance,
                    SUM(CASE WHEN u2.balance BETWEEN -480 AND 0 THEN 1 ELSE 0 END) AS total_ontime,
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
                    $advance = $total_unit->advance;
                    
                    $total_ontime = $advance + $total_unit->total_ontime;

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
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row bg-primary text-light" data-tipe="-3" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $advance; ?></td>

                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-0" data-tipe="0" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_unit->total_ontime; ?></td>

                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-1" data-tipe="1" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_1jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-2" data-tipe="2" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_2jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-3" data-tipe="3" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_3jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-4" data-tipe="4" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_4jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-5" data-tipe="5" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_5jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-6" data-tipe="6" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_6jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-7" data-tipe="7" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_7jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-8" data-tipe="8" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_8jam; ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle <?=$bg_row;?> text-center p-1 td-row cell-9" data-tipe="9" data-pdd="<?= $day; ?>" onclick="showListUnit(this)"><?= $total_more8jam; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12" style="font-family:bernard mt condensed; font-weight:bold; font-size:3rem;">Monthly</div>
    </div>
    <div class="row">
        <div class="col-lg mt-2">
            <div class="card" style="height:150px;">
                <div class="card-body d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:70pt; font-family:calibri; background-color:#000;" id="count-delivery-month">0</div>
            </div>
        </div>
        <div class="col-lg mt-2">
            <div class="card" style="height:150px;">
                <div class="card-body bg-primary d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:40pt; font-family:calibri;" id="count-advance-month">0</div>
                <div class="mt-2 card-body bg-primary d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:30pt; font-family:calibri;" id="percent-advance-month">0</div>
            </div>
        </div>
        <div class="col-lg mt-2">
            <div class="card" style="height:150px;">
                <div class="card-body bg-success d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:40pt; font-family:calibri;" id="count-ontime-month">0</div>
                <div class="mt-2 card-body bg-success d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:30pt; font-family:calibri;" id="percent-ontime-month">0</div>
            </div>
        </div>
        <div class="col-lg mt-2">
            <div class="card" style="height:150px;">
                <div class="card-body bg-danger d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:40pt; font-family:calibri;" id="count-delay-month">0</div>
                <div class="mt-2 card-body bg-danger d-flex align-items-center justify-content-center text-light p-0 text-center font-weight-bold" style="font-size:30pt; font-family:calibri;" id="percent-delay-month">0</div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <table class="table table-bordered table-hover m-0">
                <thead>
                    <tr>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center align-middle bg-primary text-light" rowspan="2">Advance</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center align-middle highlight-green" rowspan="2">Ontime</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="9">Delay</th>
                    </tr>
                    <tr>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-1">1 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:14pt;" class="pt-1 pb-1 text-center cell-9">>8 Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
                    SUM(CASE WHEN u2.balance <= -481 THEN 1 ELSE 0 END) AS advance,
                    SUM(CASE WHEN u2.balance BETWEEN -480 AND 0 THEN 1 ELSE 0 END) AS total_ontime,
                    SUM(CASE WHEN u2.balance BETWEEN 1 AND 60 THEN 1 ELSE 0 END) AS total_1jam,
                    SUM(CASE WHEN u2.balance BETWEEN 61 AND 120 THEN 1 ELSE 0 END) AS total_2jam,
                    SUM(CASE WHEN u2.balance BETWEEN 121 AND 180 THEN 1 ELSE 0 END) AS total_3jam,
                    SUM(CASE WHEN u2.balance BETWEEN 181 AND 240 THEN 1 ELSE 0 END) AS total_4jam,
                    SUM(CASE WHEN u2.balance BETWEEN 241 AND 300 THEN 1 ELSE 0 END) AS total_5jam,
                    SUM(CASE WHEN u2.balance BETWEEN 301 AND 360 THEN 1 ELSE 0 END) AS total_6jam,
                    SUM(CASE WHEN u2.balance BETWEEN 361 AND 420 THEN 1 ELSE 0 END) AS total_7jam,
                    SUM(CASE WHEN u2.balance BETWEEN 421 AND 480 THEN 1 ELSE 0 END) AS total_8jam,
                    SUM(CASE WHEN u2.balance >= 481 THEN 1 ELSE 0 END) AS total_more8jam
                    FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery LIKE '%".date("Y-m-")."%'","row");
                    
                    // Assign results to variables
                    $totalAdvance = $total_unit->advance;
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
                    
                    $totalOntime = 0;
                    if($totalUnit > 0){
                        switch ($otd_adjust) {
                            case 1:
                                $totalOntime = ($total_1jam + $total_ontime);
                                break;
                            case 2:
                                $totalOntime = ($total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 3:
                                $totalOntime = ($total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 4:
                                $totalOntime = ($total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 5:
                                $totalOntime = ($total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 6:
                                $totalOntime = ($total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 7:
                                $totalOntime = ($total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            case 8:
                                $totalOntime = ($total_8jam + $total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                                break;
                            default:
                                // Handle case where $otd_adjust is outside the expected range
                                $totalOntime = $total_ontime;
                                break;
                        }
                    }

                    $totalUnit = $totalAdvance + $total_ontime + $total_1jam + $total_2jam + $total_3jam + $total_4jam + $total_5jam + $total_6jam + $total_7jam + $total_8jam + $total_more8jam;
                    $totalDelay = $totalUnit - ($totalAdvance + $totalOntime);
                    $percentAdvance = round($totalAdvance/$totalUnit*100,2);
                    $percentOntime = round($totalOntime/$totalUnit*100,2);
                    $percentDelay = round($totalDelay/$totalUnit*100,2);
                    ?>
                    <tr>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row bg-primary text-light" data-tipe="-3" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($totalAdvance,0,"","."); ?></td>

                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-0" data-tipe="0" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_ontime,0,"","."); ?></td>

                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-1" data-tipe="1" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_1jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-2" data-tipe="2" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_2jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-3" data-tipe="3" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_3jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-4" data-tipe="4" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_4jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-5" data-tipe="5" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_5jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-6" data-tipe="6" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_6jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-7" data-tipe="7" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_7jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-8" data-tipe="8" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_8jam,0,"","."); ?></td>
                        <td style="font-size:14pt; cursor:pointer;" title="Click for show list unit" class="align-middle text-center p-1 td-row cell-9" data-tipe="9" data-pdd="allday" onclick="showListUnit(this)"><?= number_format($total_more8jam,0,"","."); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="totalUnit" data-total="<?= number_format($totalUnit,0,"","."); ?>" data-percent="0"></div>
<div id="totalAdvance" data-total="<?= number_format($totalAdvance,0,"","."); ?>" data-percent="<?= $percentAdvance; ?>"></div>
<div id="totalOntime" data-total="<?= number_format($totalOntime,0,"","."); ?>" data-percent="<?= $percentOntime; ?>"></div>
<div id="totalDelay" data-total="<?= number_format($totalDelay,0,"","."); ?>" data-percent="<?= $percentDelay; ?>"></div>
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
      <h4 id="title-list-unit" style="position: absolute;top: 5rem;right: 2rem;"></h4>
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
<div class="modal fade" id="modal-chart" tabindex="-1" aria-labelledby="modal-list-unitLabel" aria-hidden="true">
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