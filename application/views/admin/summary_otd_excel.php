<?php
// Set headers to indicate that the content is an Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Summary OTD.xls");
header("Cache-Control: max-age=0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUMMARY OTD EXCEL</title>
</head>
<body>
    <table class="table table-bordered table-hover m-0" border="1" id="datatable-summary">
        <thead>
            <tr>
                <th rowspan="2">Delivery</th>
                <th rowspan="2">Total Unit</th>
                <th colspan="9">Advance (hour)</th>
                <th rowspan="2">Ontime</th>
                <th colspan="9">Delay (hour)</th>
                <th rowspan="2">OTD</th>
            </tr>
            <tr>
                <th>>8</th>
                <th>8</th>
                <th>7</th>
                <th>6</th>
                <th>5</th>
                <th>4</th>
                <th>3</th>
                <th>2</th>
                <th>1</th>

                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>>8</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $date = $year_sum."-".$month_sum."-01";
            $kap = !empty($this->input->get("kap")) ? $this->input->get("kap") : "1";
            $tableUnit = $kap == "1" ? "unit" : "unitkap2";
            $tableSetOt = $kap == "1" ? "set_ot" : "set_ot_kap2";
            for ($i=1; $i <= date("t",strtotime($date)); $i++) {
                $get_data_dot = $this->model->gd($tableSetOt,"*","tanggal = '$i'","row");
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
                FROM $tableUnit u1 LEFT JOIN $tableUnit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$day." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($day)))." 07:00:00';","row");
                
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
                    
                    <td><?= $adv_more8jam; ?></td>
                    <td><?= $adv_8jam; ?></td>
                    <td><?= $adv_7jam; ?></td>
                    <td><?= $adv_6jam; ?></td>
                    <td><?= $adv_5jam; ?></td>
                    <td><?= $adv_4jam; ?></td>
                    <td><?= $adv_3jam; ?></td>
                    <td><?= $adv_2jam; ?></td>
                    <td><?= $adv_1jam; ?></td>

                    <td><?= $total_unit->total_ontime; ?></td>

                    <td><?= $total_1jam; ?></td>
                    <td><?= $total_2jam; ?></td>
                    <td><?= $total_3jam; ?></td>
                    <td><?= $total_4jam; ?></td>
                    <td><?= $total_5jam; ?></td>
                    <td><?= $total_6jam; ?></td>
                    <td><?= $total_7jam; ?></td>
                    <td><?= $total_8jam; ?></td>
                    <td><?= $total_more8jam; ?></td>
                    <td><?= round($otd_value*100,1)."%"; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>