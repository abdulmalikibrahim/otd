

// private function checkShift($date)
    // {
    //     $shift = "DS";
    //     $time = strtotime(date("H:i:s",strtotime($date)));
    //     if($time >= strtotime("00:00:00") && $time <= strtotime("07:25:00")){
    //         $shift = "NS";
    //     }else if($time >= strtotime("20:40:00") && $time <= strtotime("23:59:59")){
    //         $shift = "NS";
    //     }

    //     $ot_info = $this->model->gd("set_ot","start_ds,end_ds,start_ns,end_ns","tanggal = '".date("Y-m-d",strtotime($date))."'","row");
    //     $ot_info = json_encode($ot_info);
    //     $return = [
    //         "ot_info" => json_decode($ot_info,true),
    //         "shift" => $shift,
    //     ];
    //     return $return;
    // }

    // private function hitung_otd1($ot_info,$jigin_time,$deliv_time,$vin,$jigin_date,$deliv_date)
    // {
    //     set_time_limit(20);
    //     $currentTime = $jigin_date;
    //     $dataOT = $this->checkShift($jigin_date);
    //     $roundTime = $this->roundTime($currentTime);
    //     $loopTime = true;
    //     $timelineLoop = [];
    //     $jigin_checkpoint = $jigin_time;
    //     $finish_end = "no";

    //     $rangeHolidayStart = "";
    //     $rangeHolidayMiddle = "";
    //     $rangeHolidayEnd = "";
    //     $i = 0;
    //     $already_ns = "no"; //HANYA UNTUK HARI SENIN
    //     while ($loopTime) {
    //         $skip_collect = "no";
    //         $day_val = date("D",strtotime($currentTime));
    //         $start = date("H:i:s",strtotime($currentTime));
    //         if($jigin_checkpoint == "Backdate"){
    //             $n = 1;
    //             $statusValidate = true;
    //             while ($statusValidate) {
    //                 $validateTanggal = $this->model->gd("set_ot","*","tanggal = '".date("Y-m-d",strtotime("-".$n." days",strtotime($currentTime)))."'","row");
    //                 $currTimeBackDate = strtotime(date("H:i:s",strtotime($currentTime)));
    //                 // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
    //                 if($validateTanggal->on_off_night > 0){
    //                     $statusValidate = false;
    //                     if($currTimeBackDate >= strtotime("20:40:00") && $currTimeBackDate <= strtotime("23:59:59")){
    //                         $jigin_checkpoint = "Backdate";
    //                     }else if($currTimeBackDate >= strtotime("00:00:00") && $currTimeBackDate <= strtotime("07:00:00")){
    //                         $jigin_checkpoint = "Backdate";
    //                     }else{
    //                         $jigin_checkpoint = "BackdateFinish";
    //                     }
    //                 }else{
    //                     if($n > 3){
    //                         $statusValidate = false;
    //                         if($currTimeBackDate >= strtotime("20:40:00") && $currTimeBackDate <= strtotime("23:59:59")){
    //                             $jigin_checkpoint = "Backdate";
    //                         }else if($currTimeBackDate >= strtotime("00:00:00") && $currTimeBackDate <= strtotime("07:00:00")){
    //                             $jigin_checkpoint = "Backdate";
    //                         }else{
    //                             $jigin_checkpoint = "BackdateFinish";
    //                         }
    //                     }
    //                 }
    //                 $n++;
    //             }
    //         }else{
    //             $validateTanggal = $this->model->gd("set_ot","*","tanggal = '".date("Y-m-d",strtotime($currentTime))."'","row");
    //         }
    //         // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
    //         if($validateTanggal->on_off <= 0){
    //             if($validateTanggal->shadow <= 0){
    //                 $skip_collect = "yes";
    //                 $rangeHolidayStart = $validateTanggal->tanggal." 07:25:00";
    //                 $rangeHolidayMiddle = date("Y-m-d",strtotime("+1 days",strtotime($validateTanggal->tanggal)))." 00:00:00";
    //                 $rangeHolidayEnd = date("Y-m-d",strtotime("+1 days",strtotime($validateTanggal->tanggal)))." 07:24:00";
    //             }else{
    //                 if(strtotime($start) >= strtotime("07:00:00") && strtotime($start) <= strtotime("23:59:59")){
    //                     $currentTime = date("Y-m-d",strtotime("+1 days",strtotime($currentTime)))." 07:00:00";
    //                 }
    //             }
    //         }


    //         if(strtotime($currentTime) >= strtotime($deliv_date)){
    //             $loopTime = false;
    //             $loopOneHours = date("H:i:s",strtotime($deliv_date));
    //             if($loopTime === false){
    //                 //CARI SELISIH MENIT SETIAP WAKTU
    //                 if(!empty($timelineLoop[$tanggalKey][$i-1])){
    //                     $startDiff = new DateTime($timelineLoop[$tanggalKey][$i-1]["start"]);
    //                 }else{
    //                     $check_start = $this->model->gd("timeline","start","'".date("H:i:s",strtotime($deliv_date))."' BETWEEN `start` AND `end`","row");
    //                     $startDiff = new DateTime($check_start->start);
    //                     $timelineLoop[$tanggalKey][$i-1]["start"] = $check_start->start;
    //                 }

    //                 $endDiff = new DateTime(date("H:i:s",strtotime($deliv_date)));
    //                 $diffMinutes = ($startDiff->diff($endDiff)->i) + ($startDiff->diff($endDiff)->h*60);

    //                 $timelineLoop[$tanggalKey][$i-1]["end"] = date("H:i:s",strtotime($deliv_date));
    //                 $timelineLoop[$tanggalKey][$i-1]["minutes"] = $diffMinutes;
    //             }
    //             $skip_collect = "yes";
    //         }else{
    //             if($jigin_date == $currentTime){
    //                 $loopOneHours = $roundTime;
    //                 $tipeLoop = "PROD";
    //                 $shift = $dataOT["shift"];
    //             }else{
    //                 $loopOneHours = $this->model->gd("timeline","minutes,tipe,shift","'".date("H:i:s",strtotime($currentTime))."' BETWEEN `start` AND `end` AND day_val LIKE '%".$day_val."%'","row");
    //                 // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
    //                 if(date("D",strtotime($currentTime)) == "Mon"){
    //                     $currTime = strtotime(date("H:i:s",strtotime($currentTime)));
    //                     if($currTime >= strtotime("07:23:00") && $currTime <= strtotime("23:59:59")){
    //                         $tipeLoop = $loopOneHours->tipe;
    //                     }else{
    //                         //CHECK APAKAH HARI SEBELUMNYA ON
    //                         $before_mon = $this->model->gd("set_ot","on_off,on_off_night","tanggal = '".date("Y-m-d",strtotime("-1 days",strtotime($currentTime)))."'","row");
    //                         // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
    //                         if($before_mon->on_off_night <= 0 && $loopOneHours->shift == "NS" && $already_ns == "no"){ //HARI MINGGU NYA OFF
    //                             $tipeLoop = "OFF";
    //                         }else{
    //                             $already_ns = "yes";
    //                             $tipeLoop = $loopOneHours->tipe;
    //                         }
    //                     }
    //                 }else{
    //                     $tipeLoop = $loopOneHours->tipe;
    //                 }
    //                 $shift = $loopOneHours->shift;
    //                 $loopOneHours = date("H:i:s",strtotime("+".$loopOneHours->minutes." minutes",strtotime($currentTime)));
    //             }
    //         }

    //         if($shift == "NS"){
    //             $endTimeShift = $validateTanggal->end_ns.":00";
    //             $startTimeShift = $validateTanggal->start_ns.":00";
    //             if($tipeLoop == "OT"){
    //                 if(strtotime($start) >= strtotime("05:00:00") && strtotime($start) <= strtotime("07:23:00")){
    //                     if(strtotime($start) >= strtotime($endTimeShift)){
    //                         $tipeLoop = "OFF";
    //                     }
    //                 }
    //             }
    //         }else{
    //             $endTimeShift = $validateTanggal->end_ds.":00";
    //             $startTimeShift = $validateTanggal->start_ds.":00";

    //         }


    //         //CARI MINUTES
    //         $tanggalKey = date("Y-m-d",strtotime($currentTime));
    //         $end = date("H:i:s",strtotime("-1 seconds",strtotime($loopOneHours)));
    //         $end_exp = explode(":",$end);
    //         if(end($end_exp) == "59"){
    //             $end = date("H:i:s",strtotime($loopOneHours));
    //         }

    //         if($end == "00:00:00"){
    //             $end = "23:59:59";
    //         }

    //         //CARI SELISIH MENIT SETIAP WAKTU
    //         $startDiff = new DateTime($start);
    //         $endDiff = new DateTime($end);
    //         $diffMinutes = ($startDiff->diff($endDiff)->i) + 1;

    //         if(substr_count($tipeLoop,"OFF") <= 0){
    //             if($tipeLoop == "OT"){
    //                 if(strtotime($start) > strtotime($endTimeShift)){
    //                     if($shift == "NS"){
    //                         if($startTimeShift != "21:00:00"){
    //                             if(strtotime($start) > strtotime($endTimeShift)){
    //                                 if($startTimeShift == "20:30:00"){
    //                                     $skip_collect = "no";
    //                                 }else{
    //                                     $skip_collect = "yes";
    //                                 }
    //                             }else{
    //                                 $skip_collect = "no";
    //                             }
    //                         }else{
    //                             $skip_collect = "yes";
    //                         }
    //                     }else{
    //                         $skip_collect = "yes";
    //                     }
    //                 }else{
    //                     $skip_collect = "no";
    //                     if(strtotime($end) >= strtotime($endTimeShift)){
    //                         $end = $endTimeShift;
    //                         $endDiff = new DateTime($end);
    //                         $diffMinutes = ($startDiff->diff($endDiff)->i)+1;
    //                     }
    //                 }
    //             }

    //             if(substr_count("Sat Sun",$day_val) <= 0){
    //                 if(!empty($rangeHolidayStart) && !empty($rangeHolidayEnd) && !empty($rangeHolidayMiddle)){
    //                     $totimeHolidayStart = strtotime($rangeHolidayStart);
    //                     $totimeHolidayMiddle = strtotime($rangeHolidayMiddle);
    //                     $totimeHolidayEnd = strtotime($rangeHolidayEnd);
    //                     if(strtotime($currentTime) > $totimeHolidayStart && strtotime($currentTime) < $totimeHolidayEnd){
    //                         $skip_collect = "yes";
    //                     }else if(strtotime($currentTime) > $totimeHolidayMiddle && strtotime($currentTime) < $totimeHolidayEnd){
    //                         $skip_collect = "yes";
    //                     }
    //                 }
    //             }

    //             if($skip_collect == "no"){
    //                 if(strtotime($currentTime) < strtotime($deliv_date)){
    //                     $timelineLoop[$tanggalKey][$i] = [
    //                         "date" => date("Y-m-d H:i:s",strtotime($tanggalKey." ".$start)),
    //                         "day" => date("D",strtotime($tanggalKey)),
    //                         "start" => $start,
    //                         "end" => $end,
    //                         "minutes" => $diffMinutes,
    //                         "tipe" => $tipeLoop,
    //                         "shift" => $shift,
    //                     ];
    //                 }
    //             }
    //         }

    //         if($loopOneHours == $roundTime){
    //             $currentTime = date("Y-m-d",strtotime($currentTime))." ".$roundTime;
    //             if($roundTime == "00:00:00"){
    //                 if($i <= 0){
    //                     if(strtotime($timelineLoop[$tanggalKey][$i]["date"]) > strtotime($currentTime)){
    //                         $currentTime = date("Y-m-d",strtotime("+1 days",strtotime($currentTime)))." 00:00:01";
    //                     }
    //                 }else if($i > 0){
    //                     if(strtotime($timelineLoop[$tanggalKey][$i-1]["date"]) > strtotime($currentTime)){
    //                         $currentTime = date("Y-m-d",strtotime("+1 days",strtotime($currentTime)))."  00:00:01";
    //                     }
    //                 }
    //             }
    //         }else{
    //             $loopOneHours = $this->model->gd("timeline","minutes","'".date("H:i:s",strtotime($currentTime))."' BETWEEN `start` AND `end` AND day_val LIKE '%".$day_val."%'","row");
    //             // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
    //             $currentTime = date("Y-m-d H:i:s",strtotime("+".$loopOneHours->minutes." minutes",strtotime($currentTime)));
    //             $currentTime_exp = explode(":",$currentTime);
    //             if(end($currentTime_exp) == "00"){
    //                 $currentTime = date("Y-m-d H:i:s",strtotime("+".$loopOneHours->minutes." minutes 1 seconds",strtotime($currentTime)));
    //             }
    //             // echo $vin."=>".$end."=>".$shift."=>".$jigin_checkpoint."\n";
    //             if($shift == "NS" && $jigin_checkpoint != "Backdate"){
    //                 if($jigin_checkpoint != "BackdateFinish"){
    //                     $jigin_checkpoint = "Backdate";
    //                 }
    //             }
    //         }

    //         $i++;
    //     }

    //     print_r($timelineLoop);
    //     die();

    //     //FINAL OTD
    //     $otd_final = 0;
    //     if(!empty($timelineLoop)){
    //         foreach ($timelineLoop as $keyLoop => $loopVal) {
    //             foreach ($loopVal as $key => $value) {
    //                 $otd_final += $value["minutes"];
    //             }
    //         }
    //     }

    //     $return = [
    //         "otd_final" => $otd_final,
    //         "tracking" => json_encode($timelineLoop)
    //     ];

    //     return $return;
    // }

    // private function roundTime($time,$kap)
    // {
    //     $cariTime = $this->model->gd("timeline","end","'$time' BETWEEN `start` AND `end` AND plant = '$kap'","row");
    //     $roundedTime = date("H:i:s",strtotime("+1 seconds",strtotime($cariTime->end)));
    //     // Tampilkan hasil
    //     return $roundedTime;
    // }