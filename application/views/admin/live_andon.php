<style>
    .highlight-green {
        background-color: #28a745 !important;
        color: white;
    }
    .cell-andon{
        font-size:14pt;
        cursor:pointer;
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
                <div class="card-body bg-primary text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ADV. > 8H</div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-body bg-success text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">ONTIME</div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-body bg-danger text-light p-0 text-center font-weight-bold" style="font-size:3rem; font-family:cooper black;">DELAY > 8H</div>
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
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="11">Advance</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center align-middle highlight-green" rowspan="2">Ontime<br>-1 Hour ~ +1 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="11">Delay</th>
                    </tr>
                    <tr>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">>32 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">32 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">24 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">16 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>

                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">16 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">24 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">32 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">>32 Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = [];
                    $i = date("d");
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

                    $data = [
                        $adv_more_32jam,
                        $adv_32jam,
                        $adv_24jam,
                        $adv_16jam,
                        $adv_8jam,
                        $adv_7jam,
                        $adv_6jam,
                        $adv_5jam,
                        $adv_4jam,
                        $adv_3jam,
                        $adv_2jam,
                        $total_ontime,
                        $delay_2jam,
                        $delay_3jam,
                        $delay_4jam,
                        $delay_5jam,
                        $delay_6jam,
                        $delay_7jam,
                        $delay_8jam,
                        $delay_16jam,
                        $delay_24jam,
                        $delay_32jam,
                        $delay_more_32jam
                    ];
                    ?>
                    <tr>
                        <?php
                        $totalOntime = 0;
                        $totalDelay = 0;
                        foreach ($data as $key => $value) {
                            if($key >= 0 && $key <= 3){
                                $bg_row = "bg-danger";
                            }else if($key >= 19){
                                $bg_row = "bg-danger";
                                $totalDelay += $value;
                            }else if($key >= 4 && $key <= 18){
                                $bg_row = "bg-success";
                                $totalOntime += $value;
                            }
                            echo '<td title="Click for show list unit" class="align-middle '.$bg_row.' text-center p-1 td-row text-light" data-tipe="'.$key.'" data-pdd="'. $day.'" onclick="showListUnit(this)">'.$value.'</td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            <?php
            $percentAdvance = number_format(($totalAdvance / $totalUnit)*100,2,",",".");
            $percentOntime = number_format(($totalOntime / $totalUnit)*100,2,",",".");
            $percentDelay = number_format(($totalDelay / $totalUnit)*100,2,",",".");
            ?>
            <div id="totalUnit-Day" data-total="<?= number_format($totalUnit,0,"","."); ?>" data-percent="0"></div>
            <div id="totalAdvance-Day" data-total="<?= number_format($totalAdvance,0,"","."); ?>" data-percent="<?= $percentAdvance; ?>"></div>
            <div id="totalOntime-Day" data-total="<?= number_format($totalOntime,0,"","."); ?>" data-percent="<?= $percentOntime; ?>"></div>
            <div id="totalDelay-Day" data-total="<?= number_format($totalDelay,0,"","."); ?>" data-percent="<?= $percentDelay; ?>"></div>
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
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="11">Advance</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center align-middle highlight-green" rowspan="2">Ontime<br>-1 Hour ~ +1 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center bg-danger text-light" colspan="11">Delay</th>
                    </tr>
                    <tr>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">>32 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">32 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">24 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">16 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>

                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-2">2 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-3">3 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-4">4 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-5">5 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-6">6 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-7">7 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-8">8 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">16 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">24 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">32 Hour</th>
                        <th style="font-size:10pt;" class="pt-1 pb-1 text-center cell-9">>32 Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data_month = [];
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
                    FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery LIKE '%".date("Y-m-")."%' AND u1.otd IS NOT NULL","row");
                    
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

                    $data_month = [
                        $adv_more_32jam,
                        $adv_32jam,
                        $adv_24jam,
                        $adv_16jam,
                        $adv_8jam,
                        $adv_7jam,
                        $adv_6jam,
                        $adv_5jam,
                        $adv_4jam,
                        $adv_3jam,
                        $adv_2jam,
                        $total_ontime,
                        $delay_2jam,
                        $delay_3jam,
                        $delay_4jam,
                        $delay_5jam,
                        $delay_6jam,
                        $delay_7jam,
                        $delay_8jam,
                        $delay_16jam,
                        $delay_24jam,
                        $delay_32jam,
                        $delay_more_32jam
                    ];
                    ?>
                    <tr>
                        <?php
                        $totalOntime = 0;
                        $totalDelay = 0;
                        foreach ($data_month as $key => $value) {
                            if($key >= 0 && $key <= 3){
                                $bg_row = "bg-danger";
                            }else if($key >= 19){
                                $bg_row = "bg-danger";
                                $totalDelay += $value;
                            }else if($key >= 4 && $key <= 18){
                                $bg_row = "bg-success";
                                $totalOntime += $value;
                            }
                            echo '<td title="Click for show list unit" class="align-middle '.$bg_row.' text-center p-1 td-row text-light" data-tipe="'.$key.'" data-pdd="'. $day.'" onclick="showListUnit(this)">'.$value.'</td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$percentAdvance = number_format(($totalAdvance / $totalUnit)*100,2,",",".");
$percentOntime = number_format(($totalOntime / $totalUnit)*100,2,",",".");
$percentDelay = number_format(($totalDelay / $totalUnit)*100,2,",",".");
?>
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