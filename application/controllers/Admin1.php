<?php
date_default_timezone_set("Asia/Jakarta");
class Admin extends MY_Controller {

	function index()
    {
        $this->load->view("admin/index");
    }
	function print_otd()
    {
        if(empty($this->day_sum)){
            $data["day_sum"] = date("d");
        }else{
            $data["day_sum"] = $this->day_sum;
        }
        if(empty($this->month_sum)){
            $data["month_sum"] = date("m");
        }else{
            $data["month_sum"] = $this->month_sum;
        }
        if(empty($this->year_sum)){
            $data["year_sum"] = date("Y");
        }else{
            $data["year_sum"] = $this->year_sum;
        }
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $data["otd_adjust"] = $setup_adjust->otd_adjust;
        $this->load->view("admin/print_otd",$data);
    }

	function set_wh()
    {
        if(!empty($this->input->get("ot-awal"))){
            $update = [
                "nilai" => $this->input->get("ot-awal"),
            ];
            $this->model->update("master_setting","item = 'ot_awal'",$update);
        }
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $data["title"] = "Set WH Overtime";
        $data["body"] = "set_wh";
        $data["jsadd"] = "set_wh";
        $this->load->view("template/index",$data);
    }

	function graph_andon()
    {
        if(empty($this->day_sum)){
            $data["day_sum"] = date("d");
        }else{
            $data["day_sum"] = $this->day_sum;
        }
        if(empty($this->month_sum)){
            $data["month_sum"] = date("m");
        }else{
            $data["month_sum"] = $this->month_sum;
        }
        if(empty($this->year_sum)){
            $data["year_sum"] = date("Y");
        }else{
            $data["year_sum"] = $this->year_sum;
        }
        $data["periodeGraph"] = $data["year_sum"]."-".$data["month_sum"]."-".$data["day_sum"];
        // print_r($data);
        // die();
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $data["otd_adjust"] = $setup_adjust->otd_adjust;
        $data["title"] = "Graph";
        $data["body"] = "graph";
        $data["jsadd"] = "graph";
        $this->load->view("template/index",$data);
    }

	function live_andon()
    {
        if(empty($this->month_sum)){
            $data["month_sum"] = date("m");
        }else{
            $data["month_sum"] = $this->month_sum;
        }
        if(empty($this->year_sum)){
            $data["year_sum"] = date("Y");
        }else{
            $data["year_sum"] = $this->year_sum;
        }
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $data["otd_adjust"] = $setup_adjust->otd_adjust;
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $data["title"] = "Ontime Delivery";
        $data["body"] = "live_andon";
        $data["jsadd"] = "live_andon";
        $this->load->view("template/index",$data);
    }

	function auto_sync()
    {
        $this->load->view("admin/auto_sync");
    }

    function simpan_set_wh()
    {
        header('Content-Type: application/json');
        $this->form_validation->set_rules("onoff[]","On Off Day","trim");
        $this->form_validation->set_rules("start_ds[]","Start DS","trim");
        $this->form_validation->set_rules("end_ds[]","End DS","trim");
        $this->form_validation->set_rules("start_ns[]","Start NS","trim");
        $this->form_validation->set_rules("end_ns[]","End NS","trim");
        if($this->form_validation->run() === FALSE){
            $this->swal("Error",str_replace("\n","<br>",validation_errors()),"error");
            redirect("set_wh");
        }

        $month = $this->input->get("month");
        $start_ds = $this->input->post("start_ds");
        $end_ds = $this->input->post("end_ds");
        $start_ns = $this->input->post("start_ns");
        $end_ns = $this->input->post("end_ns");
        $on_off = $this->input->post("onoff");
        for ($i=1; $i <= date("t",strtotime(date("Y-".$month."-01"))); $i++) {
            if(!empty($on_off[$i])){
                $onoff = "1";
            }else{
                $onoff = "0";
            }
            
            if(!empty($start_ds[$i])){
                $startDS = $start_ds[$i];
            }else{
                $startDS = NULL;
            }
            
            if(!empty($end_ds[$i])){
                $endDS = $end_ds[$i];
            }else{
                $endDS = NULL;
            }
            
            if(!empty($start_ns[$i])){
                $startNS = $start_ns[$i];
            }else{
                $startNS = NULL;
            }
            
            if(!empty($end_ns[$i])){
                $endNS = $end_ns[$i];
            }else{
                $endNS = NULL;
            }
            
            $tanggal = date("Y-".$month."-".sprintf("%02d",$i));
            $day_val = date("D",strtotime($tanggal));
            $update[$tanggal] = [
                "tanggal" => $tanggal,
                "on_off" => $onoff,
                "start_ds" => $startDS,
                "end_ds" => $endDS,
                "start_ns" => $startNS,
                "end_ns" => $endNS,
                "shadow" => "0",
            ];
            if(substr_count("Sat Sun",$day_val) > 0){
                if(empty($on_off[$i])){
                    //CHECK HARI SEBELUM NYA
                    $keyTanggal = date("Y-m-d",strtotime("-1 days",strtotime($tanggal)));
                    if(!empty($update[$keyTanggal]["start_ns"]) && !empty($update[$keyTanggal]["start_ds"])){
                        $update[$tanggal] = [
                            "tanggal" => $tanggal,
                            "on_off" => $onoff,
                            "start_ds" => NULL,
                            "end_ds" => NULL,
                            "start_ns" => "00:00",
                            "end_ns" => $update[$keyTanggal]["end_ns"],
                            "shadow" => "1",
                        ];
                    }
                }
            }

        }

        // print_r($update);
        // die();
        foreach ($update as $key => $value) {
            //CHECK DATA SETUP
            $check = $this->model->gd("set_ot","id","tanggal = '$key'","row");
            if(!empty($check)){
                if($key == "2024-10-31"){
                    $this->model->update("set_ot","tanggal = '$key'",$value);
                }
                $this->model->update("set_ot","tanggal = '$key'",$value);
            }else{
                $this->model->insert("set_ot",$value);
            }
        }
        $this->swal("Sukses","Data OT berhasil disimpan","success");
        redirect("set_wh?month=".$month);
    }

    function re_calculate()
    {
        $vin = $this->input->post("vin");
        $pdd = $this->input->post("pdd");
        
        //CLEAR CALCULATE
        $data = [
            "otd" => NULL,
            "balance" => NULL,
            "tracking" => NULL,
        ];

        $this->model->update("unit","vin IN(".$vin.")",$data);

        //HITUNG RE-CALCULATE PARTIAL
        $jumlah_vin = substr_count($vin,",");
        if($jumlah_vin <= 0 && !empty($vin)){
            $jumlah_vin = 2;
        }
        //BAGI 100
        $partial = $jumlah_vin / $this->std_limit;
        $partial = ceil($partial);
        for ($i=0; $i < $partial; $i++) {
            // URL endpoint dan parameter
            $url = base_url("calc_lead_time?date=".$pdd);
            // Inisialisasi sesi cURL
            $ch = curl_init();
            // Atur opsi cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Eksekusi cURL dan simpan respons
            $response = curl_exec($ch);
        }

        $fb = ["statusCode" => 200];
        $this->fb($fb);
    }

	function leadtime()
    {
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $data["title"] = "Lead Time Setting";
        $data["body"] = "leadtime";
        $data["jsadd"] = "leadtime";
        $this->load->view("template/index",$data);
    }

    function clear_ot()
    {
        $month = $this->input->get("month");
        $update = [
            "on_off" => "1",
            "start_ds" => "07:25",
            "end_ds" => "16:00",
            "start_ns" => "21:00",
            "end_ns" => "05:45",
            "shadow" => "0",
        ];
        $this->model->update("set_ot","tanggal LIKE '%".date("Y-".$month)."%'",$update);
        $this->swal("Sukses","Clear OT berhasil disimpan","success");
        redirect("set_wh");
    }

    function simpan_leadtime()
    {
        $this->form_validation->set_rules("tt","Tack Time","required|trim");
        $this->form_validation->set_rules("eff","Effeciency","required|trim");
        $this->form_validation->set_rules("wip-weld","WIP Welding","integer|required|trim");
        $this->form_validation->set_rules("wip-paint","WIP Painting","integer|required|trim");
        $this->form_validation->set_rules("wip-pbs","WIP PBS","integer|required|trim");
        $this->form_validation->set_rules("wip-assy","WIP Assy","integer|required|trim");
        $this->form_validation->set_rules("wip-ru","WIP Running Unit","integer|required|trim");
        if($this->form_validation->run() === FALSE){
            $this->swal("Error",str_replace("\n","<br>",validation_errors()),"error");
            redirect("leadtime");
        }

        $tt = $this->input->post("tt");
        $eff = $this->input->post("eff")/100;
        $wip_weld = $this->input->post("wip-weld");
        $wip_paint = $this->input->post("wip-paint");
        $wip_pbs = $this->input->post("wip-pbs");
        $wip_assy = $this->input->post("wip-assy");
        $wip_ru = $this->input->post("wip-ru");

        $data_submit = [
            "eff" => $eff,
            "tt" => $tt,
            "wipw" => $wip_weld,
            "wipt" => $wip_paint,
            "wipp" => $wip_pbs,
            "wipa" => $wip_assy,
            "wipr" => $wip_ru,
        ];
        $array_update = ["eff","tt","wipw","wipt","wipp","wipa","wipr"];
        foreach ($array_update as $key => $value) {
            $data_update = ["nilai" => $data_submit[$value]];
            $this->model->update("master_setting","item = '".$value."'",$data_update);
        }
        $this->swal("Sukses","Data Master berhasil disimpan","success");
        redirect("leadtime");
    }

    function get_data($shop)
    {
        if((date("His")*1) >= 70000){
            $date = date("Y-m-d");
        }else{
            $date = date("Y-m-d",strtotime("-1 days"));
        }
        if(!empty($this->input->get("date"))){
            $date = $this->input->get("date");
        }

        $auto_sync = "No";
        if(!empty($this->input->get("auto_sync"))){
            $auto_sync = $this->input->get("auto_sync");
        }

        $start_date = date("Y-m-d",strtotime($date))." 07:00:00";
        $end_date = date("Y-m-d",strtotime("+1 days",strtotime($date)))." 07:00:00";
        if($shop == "jigin"){
            $shop_val = "3Z01";
            $tpcd = "01010";
        }else if($shop == "delivery"){
            $shop_val = "3Z04";
            $tpcd = "04030";
        }else{
            $fb = ["status" => 500, "res" => "Parameter shop tidak valid"];
            //INSET TO LOG
            $data_log = [
                "waktu" => date("Y-m-d H:i:s"),
                "proses" => "Proses Get Data ".$shop,
                "status" => $fb["status"],
                "problem" => $fb["res"],
                "auto_sync" => $auto_sync,
            ];
            $this->model->insert("log_sync",$data_log);
            $this->fb($fb);
        }
        // URL endpoint dan parameter
        $url = "http://sv-web-kap/pis/searching_unit/byscan_main.php";
        $params = [
            'shop' => $shop_val,
            'tpcd' => $tpcd,
            'scandt_from' => $start_date,
            'scandt_to' => $end_date,
            '_search' => 'false',
            'nd' => '1723946520873',
            'rows' => '10000',
            'page' => '1',
            'sidx' => '',
            'sord' => 'asc',
            '_' => '1723946520873'
        ];

        // Menggabungkan parameter ke dalam URL
        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;

        // Inisialisasi sesi cURL
        $ch = curl_init();

        // Atur opsi cURL
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Eksekusi cURL dan simpan respons
        $response = curl_exec($ch);

        // Cek jika terjadi kesalahan
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            $fb = ["status" => 500, "res" => curl_error($ch)];
            //INSET TO LOG
            $data_log = [
                "waktu" => date("Y-m-d H:i:s"),
                "proses" => "Proses Get Data ".$shop,
                "status" => $fb["status"],
                "problem" => $fb["res"],
                "auto_sync" => $auto_sync,
            ];
            $this->model->insert("log_sync",$data_log);
            $this->fb($fb);
        } else {
            // Tampilkan hasil respons
            $data = json_decode($response,TRUE);
            if(!empty($data["rows"])){
                foreach ($data["rows"] as $key => $value) {
                    if(!empty($value["cell"][2])){
                        $katashiki = $value["cell"][1];
                        $vin = $value["cell"][2];
                        $suffix = $value["cell"][3];
                        $model = $value["cell"][4];
                        $pid = $value["cell"][5];
                        $dest = $value["cell"][6];
                        $color = $value["cell"][7];
                        $color_desc = $value["cell"][8];
                        $shift = $value["cell"][10];
                        //VALIDASI DATA
                        $validasi = $this->model->gd("unit","vin","vin = '$vin'","row");
                        $data_unit = [
                            "katashiki" => $katashiki,
                            "vin" => $vin,
                            "suffix" => $suffix,
                            "model" => $model,
                            "pid" => $pid,
                            "dest" => $dest,
                            "color" => $color,
                            "color_desc" => $color_desc,
                            "shift" => $shift,
                        ];
                        if($shop == "jigin"){
                            $data_unit["jig_in"] = $value["cell"][11];
                        }else{
                            $data_unit["delivery"] = $value["cell"][11];
                        }
                        if(empty($validasi->vin)){
                            $this->model->insert("unit",$data_unit);
                        }else{
                            $this->model->update("unit","vin = '$vin'",$data_unit);
                        }
                    }
                }
                $fb = ["status" => 200, "res" => date("Y-m-d H:i:s")." => Proses update berhasil"];
                //INSET TO LOG
                $data_log = [
                    "waktu" => date("Y-m-d H:i:s"),
                    "proses" => "Proses Get Data ".$shop,
                    "status" => $fb["status"],
                    "problem" => $fb["res"],
                    "auto_sync" => $auto_sync,
                ];
                $this->model->insert("log_sync",$data_log);
                $this->fb($fb);
            }else{
                $fb = ["status" => 500, "res" => date("Y-m-d H:i:s")." => Data kosong"];
                //INSET TO LOG
                $data_log = [
                    "waktu" => date("Y-m-d H:i:s"),
                    "proses" => "Proses Get Data ".$shop,
                    "status" => $fb["status"],
                    "problem" => $fb["res"],
                    "auto_sync" => $auto_sync,
                ];
                $this->model->insert("log_sync",$data_log);
                $this->fb($fb);
            }
        }

        // Tutup sesi cURL
        curl_close($ch);
    }

    private function roundTime($time)
    {
        $cariTime = $this->model->gd("timeline","end","'$time' BETWEEN `start` AND `end`","row");
        $roundedTime = date("H:i:s",strtotime("+1 seconds",strtotime($cariTime->end)));
        // Tampilkan hasil
        return $roundedTime;
    }

    private function checkShift($date)
    {
        $shift = "DS";
        $date = strtotime(date("H:i:s",strtotime($date)));
        if($date >= strtotime("00:00:00") && $date <= strtotime("07:25:00")){
            $shift = "NS";
        }else if($date >= strtotime("20:40:00") && $date <= strtotime("23:59:59")){
            $shift = "NS";
        }

        $ot_info = $this->model->gd("set_ot","start_ds,end_ds,start_ns,end_ns","tanggal = '".date("Y-m-d",strtotime($date))."'","row");
        $ot_info = json_encode($ot_info);
        $return = [
            "ot_info" => json_decode($ot_info,true),
            "shift" => $shift,
        ];
        return $return;
    }

    function calc_lead_time()
    {
        // error_reporting(0);
        header('Content-Type: application/json');
        $std_otd = $this->std_otd();
        if((date("His")*1) >= 70000){
            $date = date("Y-m-d");
        }else{
            $date = date("Y-m-d",strtotime("-1 days"));
        }
        if(!empty($this->input->get("date"))){
            $date = $this->input->get("date");
        }

        $auto_sync = "No";
        if(!empty($this->input->get("auto_sync"))){
            $auto_sync = $this->input->get("auto_sync");
        }
        
        //GET ALL DATA BY DATE
        $vin_hitung_ulang = ""; //MASUKKAN VIN DISINI UNTUK MENGETAHUI PROSES HITUNG NYA
        if(!empty($vin_hitung_ulang)){
            $search_vin_ulang = "AND vin = '$vin_hitung_ulang'";
        }else{
            $search_vin_ulang = "";
        }
        $data = $this->model->gd("unit","vin,jig_in,delivery","otd IS NULL AND jig_in IS NOT NULL AND delivery IS NOT NULL AND delivery BETWEEN '".$date." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($date)))." 07:00:00' $search_vin_ulang ORDER BY delivery ASC LIMIT 0,".$this->std_limit,"result");
        if(empty($data)){
            $fb = ["status" => 500, "res" => "Tidak ada data delivery"];
            //INSET TO LOG
            $data_log = [
                "waktu" => date("Y-m-d H:i:s"),
                "proses" => "Calculation Lead Time",
                "status" => $fb["status"],
                "problem" => $fb["res"],
                "auto_sync" => $auto_sync,
            ];
            $this->model->insert("log_sync",$data_log);
            $this->fb($fb);
        }

        $timeline = $this->model->gd("timeline","*","id !=","result");
        if(empty($timeline)){
            $fb = ["status" => 500, "res" => "Data timeline kosong"];
            //INSET TO LOG
            $data_log = [
                "waktu" => date("Y-m-d H:i:s"),
                "proses" => "Calculation Lead Time",
                "status" => $fb["status"],
                "problem" => $fb["res"],
                "auto_sync" => $auto_sync,
            ];
            $this->model->insert("log_sync",$data_log);
            $this->fb($fb);
        }

        $data_otd = [];
        $data_time = [];
        foreach ($data as $data) {
            if(!empty($data->jig_in)){
                $jigin_date = date("D",strtotime($data->jig_in));
                $jigin_time = date("H:i:s",strtotime($data->jig_in));
                $jigin_time_exp = explode(":",$jigin_time);

                $deliv_date = date("D",strtotime($data->delivery));
                $deliv_time = date("H:i:s",strtotime($data->delivery));
                $deliv_time_exp = explode(":",$deliv_time);

                //GET INFO OT
                $ot_info = $this->model->gd("set_ot","*","tanggal BETWEEN '".date("Y-m-d",strtotime($data->jig_in))."' AND '".date("Y-m-d",strtotime($data->delivery))."'","result");
                $no = 1;
                $data_jam = [];
                foreach ($ot_info as $ot_info) {
                    if($no == 1){
                        $tanggal_awal = date("Y-m-".sprintf("%02d",$ot_info->tanggal));
                    }else{
                        $tanggal_awal = date("Y-m-d",strtotime("+1 days",strtotime($tanggal_awal)));
                    }
                    $data_jam[] = [
                        "tanggal" => $tanggal_awal,
                        "on_off" => $ot_info->on_off,
                        "DS" => ["start" => $ot_info->start_ds, "end" => $ot_info->end_ds],
                        "NS" => ["start" => $ot_info->start_ns, "end" => $ot_info->end_ns],
                    ];
                    $no++;
                }


                //HITUNG OTD
                $total_otd = $this->hitung_otd($data_jam,$jigin_time,$deliv_time,$data->vin,$data->jig_in,$data->delivery);

                $balance = $total_otd["otd_final"] - $std_otd;
                if($total_otd["otd_final"] <= $std_otd){
                    $status_otd = "Ontime";
                }else{
                    $status_otd = "Delay";
                }

                $data_otd[$data->vin] = ["jig_in" => date("D d-m-Y H:i",strtotime($data->jig_in)), "delivery" => date("D d-m-Y H:i",strtotime($data->delivery)), "time_otd" => $total_otd["otd_final"], "status" => $status_otd, "std_otd" => $std_otd, "balance" => $balance, "tracking" => $total_otd["tracking"]];

                // die();
                if($status_otd != "NOT VALUABLE"){
                    $update_otd = ["otd" => $total_otd["otd_final"], "balance" => $balance, "tracking" => $total_otd["tracking"]];
                    //UPDATE
                    $this->model->update("unit","vin = '$data->vin'",$update_otd);
                }
            }
        }

        // print_r($data_otd);
        // die();
        
        if(!empty($vin_hitung_ulang)){
            print_r($data_otd);
            die();
        }

        $fb = ["status" => 200, "res" => date("Y-m-d H:i:s")." => Proses calculation berhasil"];
        //INSET TO LOG
        $data_log = [
            "waktu" => date("Y-m-d H:i:s"),
            "proses" => "Calculation Lead Time",
            "status" => $fb["status"],
            "problem" => $fb["res"],
            "auto_sync" => $auto_sync,
        ];
        $this->model->insert("log_sync",$data_log);
        $this->fb($fb);
    } 

    private function hitung_otd($ot_info,$jigin_time,$deliv_time,$vin,$jigin_date,$deliv_date)
    {
        set_time_limit(20);
        $currentTime = $jigin_date;
        $dataOT = $this->checkShift($jigin_date);
        $roundTime = $this->roundTime($currentTime);
        $loopTime = true;
        $timelineLoop = [];
        $jigin_checkpoint = $jigin_time;
        $finish_end = "no";

        $i = 0;
        $already_ns = "no"; //HANYA UNTUK HARI SENIN
        while ($loopTime) {
            $skip_collect = "no";
            $day_val = date("D",strtotime($currentTime));
            $start = date("H:i:s",strtotime($currentTime));
            if($jigin_checkpoint == "Backdate"){
                $n = 1;
                $statusValidate = true;
                while ($statusValidate) {
                    $validateTanggal = $this->model->gd("set_ot","*","tanggal = '".date("Y-m-d",strtotime("-".$n." days",strtotime($currentTime)))."'","row");
                    $currTimeBackDate = strtotime(date("H:i:s",strtotime($currentTime)));
                    // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
                    if($validateTanggal->on_off > 0){
                        $statusValidate = false;
                        if($currTimeBackDate >= strtotime("20:40:00") && $currTimeBackDate <= strtotime("23:59:59")){
                            $jigin_checkpoint = "Backdate";
                        }else if($currTimeBackDate >= strtotime("00:00:00") && $currTimeBackDate <= strtotime("07:00:00")){
                            $jigin_checkpoint = "Backdate";
                        }else{
                            $jigin_checkpoint = "BackdateFinish";
                        }
                    }else{
                        if($n > 3){
                            $statusValidate = false;
                            if($currTimeBackDate >= strtotime("20:40:00") && $currTimeBackDate <= strtotime("23:59:59")){
                                $jigin_checkpoint = "Backdate";
                            }else if($currTimeBackDate >= strtotime("00:00:00") && $currTimeBackDate <= strtotime("07:00:00")){
                                $jigin_checkpoint = "Backdate";
                            }else{
                                $jigin_checkpoint = "BackdateFinish";
                            }
                        }
                    }
                    $n++;
                }
            }else{
                $validateTanggal = $this->model->gd("set_ot","*","tanggal = '".date("Y-m-d",strtotime($currentTime))."'","row");
            }
            // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
            if($validateTanggal->on_off <= 0){
                if($validateTanggal->shadow <= 0){
                    $skip_collect = "yes";
                }else{
                    if(strtotime($start) >= strtotime("07:00:00") && strtotime($start) <= strtotime("23:59:59")){
                        $currentTime = date("Y-m-d",strtotime("+1 days",strtotime($currentTime)))." 07:00:00";
                    }
                }
            }


            if(strtotime($currentTime) >= strtotime($deliv_date)){
                $loopTime = false;
                $loopOneHours = date("H:i:s",strtotime($deliv_date));
                if($loopTime === false){
                    //CARI SELISIH MENIT SETIAP WAKTU
                    if(!empty($timelineLoop[$tanggalKey][$i-1])){
                        $startDiff = new DateTime($timelineLoop[$tanggalKey][$i-1]["start"]);
                    }else{
                        $check_start = $this->model->gd("timeline","start","'".date("H:i:s",strtotime($deliv_date))."' BETWEEN `start` AND `end`","row");
                        $startDiff = new DateTime($check_start->start);
                        $timelineLoop[$tanggalKey][$i-1]["start"] = $check_start->start;
                    }

                    $endDiff = new DateTime(date("H:i:s",strtotime($deliv_date)));
                    $diffMinutes = ($startDiff->diff($endDiff)->i) + ($startDiff->diff($endDiff)->h*60);

                    $timelineLoop[$tanggalKey][$i-1]["end"] = date("H:i:s",strtotime($deliv_date));
                    $timelineLoop[$tanggalKey][$i-1]["minutes"] = $diffMinutes;
                }
                $skip_collect = "yes";
            }else{
                if($jigin_date == $currentTime){
                    $loopOneHours = $roundTime;
                    $tipeLoop = "PROD";
                    $shift = $dataOT["shift"];
                }else{
                    $loopOneHours = $this->model->gd("timeline","minutes,tipe,shift","'".date("H:i:s",strtotime($currentTime))."' BETWEEN `start` AND `end` AND day_val LIKE '%".$day_val."%'","row");
                    // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
                    if(date("D",strtotime($currentTime)) == "Mon"){
                        $currTime = strtotime(date("H:i:s",strtotime($currentTime)));
                        if($currTime >= strtotime("07:23:00") && $currTime <= strtotime("23:59:59")){
                            $tipeLoop = $loopOneHours->tipe;
                        }else{
                            //CHECK APAKAH HARI SEBELUMNYA ON
                            $before_mon = $this->model->gd("set_ot","on_off","tanggal = '".date("Y-m-d",strtotime("-1 days",strtotime($currentTime)))."'","row");
                            // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
                            if($before_mon->on_off <= 0 && $loopOneHours->shift == "NS" && $already_ns == "no"){ //HARI MINGGU NYA OFF
                                $tipeLoop = "OFF";
                            }else{
                                $already_ns = "yes";
                                $tipeLoop = $loopOneHours->tipe;
                            }
                        }
                    }else{
                        $tipeLoop = $loopOneHours->tipe;
                    }
                    $shift = $loopOneHours->shift;
                    $loopOneHours = date("H:i:s",strtotime("+".$loopOneHours->minutes." minutes",strtotime($currentTime)));
                }
            }

            if($shift == "NS"){
                $endTimeShift = $validateTanggal->end_ns.":00";
                $startTimeShift = $validateTanggal->start_ns.":00";
                if($tipeLoop == "OT"){
                    if(strtotime($start) >= strtotime("05:00:00") && strtotime($start) <= strtotime("07:23:00")){
                        if(strtotime($start) >= strtotime($endTimeShift)){
                            $tipeLoop = "OFF";
                        }
                    }
                }
            }else{
                $endTimeShift = $validateTanggal->end_ds.":00";
                $startTimeShift = $validateTanggal->start_ds.":00";

            }


            //CARI MINUTES
            $tanggalKey = date("Y-m-d",strtotime($currentTime));
            $end = date("H:i:s",strtotime("-1 seconds",strtotime($loopOneHours)));
            $end_exp = explode(":",$end);
            if(end($end_exp) == "59"){
                $end = date("H:i:s",strtotime($loopOneHours));
            }

            if($end == "00:00:00"){
                $end = "23:59:59";
            }

            //CARI SELISIH MENIT SETIAP WAKTU
            $startDiff = new DateTime($start);
            $endDiff = new DateTime($end);
            $diffMinutes = ($startDiff->diff($endDiff)->i) + 1;

            if(substr_count($tipeLoop,"OFF") <= 0){
                if($tipeLoop == "OT"){
                    if(strtotime($start) > strtotime($endTimeShift)){
                        if($shift == "NS"){
                            if($startTimeShift != "21:00:00"){
                                if(strtotime($start) > strtotime($endTimeShift)){
                                    if($startTimeShift == "20:30:00"){
                                        $skip_collect = "no";
                                    }else{
                                        $skip_collect = "yes";
                                    }
                                }else{
                                    $skip_collect = "no";
                                }
                            }else{
                                $skip_collect = "yes";
                            }
                        }else{
                            $skip_collect = "yes";
                        }
                    }else{
                        $skip_collect = "no";
                        if(strtotime($end) >= strtotime($endTimeShift)){
                            $end = $endTimeShift;
                            $endDiff = new DateTime($end);
                            $diffMinutes = ($startDiff->diff($endDiff)->i)+1;
                        }
                    }
                }

                if($skip_collect == "no"){
                    if(strtotime($currentTime) < strtotime($deliv_date)){
                        $timelineLoop[$tanggalKey][$i] = [
                            "date" => date("Y-m-d H:i:s",strtotime($tanggalKey." ".$start)),
                            "day" => date("D",strtotime($tanggalKey)),
                            "start" => $start,
                            "end" => $end,
                            "minutes" => $diffMinutes,
                            "tipe" => $tipeLoop,
                            "shift" => $shift,
                        ];
                    }
                }
            }

            if($loopOneHours == $roundTime){
                $currentTime = date("Y-m-d",strtotime($currentTime))." ".$roundTime;
                if($roundTime == "00:00:00"){
                    if($i <= 0){
                        if(strtotime($timelineLoop[$tanggalKey][$i]["date"]) > strtotime($currentTime)){
                            $currentTime = date("Y-m-d",strtotime("+1 days",strtotime($currentTime)))." 00:00:01";
                        }
                    }else if($i > 0){
                        if(strtotime($timelineLoop[$tanggalKey][$i-1]["date"]) > strtotime($currentTime)){
                            $currentTime = date("Y-m-d",strtotime("+1 days",strtotime($currentTime)))."  00:00:01";
                        }
                    }
                }
            }else{
                $loopOneHours = $this->model->gd("timeline","minutes","'".date("H:i:s",strtotime($currentTime))."' BETWEEN `start` AND `end` AND day_val LIKE '%".$day_val."%'","row");
                // log_message('debug', 'Executed query: ' . str_replace("\n"," ",$this->db->last_query()));
                $currentTime = date("Y-m-d H:i:s",strtotime("+".$loopOneHours->minutes." minutes",strtotime($currentTime)));
                $currentTime_exp = explode(":",$currentTime);
                if(end($currentTime_exp) == "00"){
                    $currentTime = date("Y-m-d H:i:s",strtotime("+".$loopOneHours->minutes." minutes 1 seconds",strtotime($currentTime)));
                }
                // echo $vin."=>".$end."=>".$shift."=>".$jigin_checkpoint."\n";
                if($shift == "NS" && $jigin_checkpoint != "Backdate"){
                    if($jigin_checkpoint != "BackdateFinish"){
                        $jigin_checkpoint = "Backdate";
                    }
                }
            }

            $i++;
        }

        // print_r($timelineLoop);
        // die();

        //FINAL OTD
        $otd_final = 0;
        if(!empty($timelineLoop)){
            foreach ($timelineLoop as $keyLoop => $loopVal) {
                foreach ($loopVal as $key => $value) {
                    $otd_final += $value["minutes"];
                }
            }
        }

        $return = [
            "otd_final" => $otd_final,
            "tracking" => json_encode($timelineLoop)
        ];

        return $return;
    }

	function summary_otd()
    {
        if(empty($this->month_sum)){
            $data["month_sum"] = date("m");
        }else{
            $data["month_sum"] = $this->month_sum;
        }
        if(empty($this->year_sum)){
            $data["year_sum"] = date("Y");
        }else{
            $data["year_sum"] = $this->year_sum;
        }
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $data["otd_adjust"] = $setup_adjust->otd_adjust;
        $data["title"] = "Summary OTD";
        $data["body"] = "summary_otd";
        $data["jsadd"] = "summary_otd";
        $this->load->view("template/index",$data);
    }

	function summary_otd_excel()
    {
        if(empty($this->month_sum)){
            $data["month_sum"] = date("m");
        }else{
            $data["month_sum"] = $this->month_sum;
        }
        if(empty($this->year_sum)){
            $data["year_sum"] = date("Y");
        }else{
            $data["year_sum"] = $this->year_sum;
        }
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $data["otd_adjust"] = $setup_adjust->otd_adjust;
        $this->load->view("admin/summary_otd_excel",$data);
    }

    function set_adjust_otd()
    {
        $adjust = $this->input->post("adjust");
        $periodeGraph = $this->input->post("periodeGraph");
        if(empty($periodeGraph)){
            $day = $this->input->post("day");
            $month = $this->input->post("month");
            $year = $this->input->post("year");
        }else{
            $periodeGraph_exp = explode("-",$periodeGraph);
            $day = $periodeGraph_exp[2];
            $month = $periodeGraph_exp[1];
            $year = $periodeGraph_exp[0];
        }
        $session = array("day_sum" => $day,"month_sum" => $month, "year_sum" => $year);
        $this->session->set_userdata($session);
        $update = ["otd_adjust" => $adjust];
        $this->model->update("setup_otd_adjust","id = '1'",$update);
        if(!empty($this->input->post("periodeGraph"))){
            redirect('graph_andon');
        }else{
            redirect('summary_otd');
        }
    }

    function list_unit($tipe,$day)
    {
        if($day == "allday"){
            $day_search = "'".date("Y-m-01")." 07:00:00' AND '".date("Y-m-t")." 07:00:00'";
        }else{
            $day_search = "'".$day." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($day)))." 07:00:00'";
        }
        switch ($tipe) {
            case -9:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance <= -481 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -8:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -480 AND -421 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -7:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -420 AND -361 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -6:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -360 AND -301 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -5:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -300 AND -241 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -4:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -240 AND -181 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -3:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -180 AND -121 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -2:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -120 AND -61 AND vin != '' ORDER BY balance ASC","result");
                break;
            case -1:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -60 AND -1 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 0:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance = 0 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 1:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 1 AND 60 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 2:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 61 AND 120 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 3:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 121 AND 180 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 4:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 181 AND 240 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 5:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 241 AND 300 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 6:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 301 AND 360 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 7:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 361 AND 420 AND vin != '' ORDER BY balance ASC","result");
                break;
            case 8:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN 421 AND 480 AND vin != '' ORDER BY balance ASC","result");
                break;
            default:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance >= 481 AND vin != '' ORDER BY balance ASC","result");
                break;
        }

        $result = [];
        
        $load_list_unit = '
        <table class="table table-sm table-bordered table-hover mb-3 mt-1" id="datatable">
        <thead class="thead-light">
            <tr>
                <th style="font-size:9pt;" class="align-middle text-center">No</th>
                <th style="font-size:9pt;" class="align-middle text-center">VIN</th>
                <th style="font-size:9pt;" class="align-middle text-center">Suffix</th>
                <th style="font-size:9pt;" class="align-middle text-center">Color</th>
                <th style="font-size:9pt;" class="align-middle text-center">Jig In</th>
                <th style="font-size:9pt;" class="align-middle text-center">Delivery</th>
                <th style="font-size:9pt;" class="align-middle text-center">Actual Lead Time (min)</th>
                <th style="font-size:9pt;" class="align-middle text-center">Vs Lead Time Normal</th>
                <th style="font-size:9pt;" class="align-middle text-center">Action</th>
            </tr>
        </thead>
        <tbody>';
        $vin_unit = [];
        if(!empty($list_unit)){
            $no = 1;
            foreach ($list_unit as $list_unit) {
                $vin_unit[] = $list_unit->vin;
                $load_list_unit .= '
                <tr>
                    <td style="font-size:9pt;" class="align-middle text-center">'.$no++.'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.$list_unit->vin.'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.$list_unit->suffix.'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.$list_unit->color.'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.date("d-m-Y H:i:s",strtotime($list_unit->jig_in)).'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.date("d-m-Y H:i:s",strtotime($list_unit->delivery)).'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.$list_unit->otd.'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">'.$list_unit->balance.'</td>
                    <td style="font-size:9pt;" class="align-middle text-center">
                        <button data-vin="'.$list_unit->vin.'" onclick="tracking_time(this)" class="w-100 btn btn-info p-1" title="Tracking Time" style="font-size:8pt;">Tracking Time</button>
                        <button data-vin="'.$list_unit->vin.'" onclick="tracking_unit(this)" class="w-100 mt-2 btn btn-success p-1" title="Tracking Unit" style="font-size:8pt;">Tracking Unit</button>
                    </td>
                </tr>';
            }
        }else{
            $load_list_unit .= '
            <tr>
                <td style="font-size:9pt;" colspan="10" class="text-center">Tidak ada data</td>
            </tr>';
        }
        $load_list_unit .= '</tbody></table>';
        sleep(1.5);
        $result = [
            "html" => $load_list_unit,
            "vin" => "'".implode("','",$vin_unit)."'",
        ];
        echo json_encode($result);
        die();
    }

    function getDataAndon()
    {
        $print_from = $this->input->get("print_from");
        $print_to = $this->input->get("print_to");
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $otd_adjust = $setup_adjust->otd_adjust;
        
        $data_std = $this->model->gd("master_setting","*","item != ''","result");

        $grandTotalUnitDay = 0;
        $grandTotalOntimeDay = 0;
        $grandTotalDelayDay = 0;
        $grandTotalAdvanceDay = 0;

        $grandPercentOntimeDay = 0;
        $grandPercentDelayDay = 0;
        $grandPercentAdvanceDay = 0;
        
        $grandTotalUnitMonth = 0;
        $grandTotalOntimeMonth = 0;
        $grandTotalDelayMonth = 0;
        $grandTotalAdvanceMonth = 0;

        $grandPercentOntimeMonth = 0;
        $grandPercentDelayMonth = 0;
        $grandPercentAdvanceMonth = 0;

        for ($i=1; $i <= date("d"); $i++) {
            $get_data_dot = $this->model->gd("set_ot","*","tanggal = '$i'","row");
            $day = date("Y-m-d",strtotime(date("Y-m-").sprintf("%02d",$i)));
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
            $total_advance = $advance;
            
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
            
            $unitOntime = 0;
            if($totalUnit > 0){
                switch ($otd_adjust) {
                    case 1:
                        $unitOntime = ($total_1jam + $total_ontime);
                        break;
                    case 2:
                        $unitOntime = ($total_2jam + $total_1jam + $total_ontime);
                        break;
                    case 3:
                        $unitOntime = ($total_3jam + $total_2jam + $total_1jam + $total_ontime);
                        break;
                    case 4:
                        $unitOntime = ($total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                        break;
                    case 5:
                        $unitOntime = ($total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                        break;
                    case 6:
                        $unitOntime = ($total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                        break;
                    case 7:
                        $unitOntime = ($total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                        break;
                    case 8:
                        $unitOntime = ($total_8jam + $total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                        break;
                    default:
                        // Handle case where $otd_adjust is outside the expected range
                        $unitOntime = $total_ontime;
                        break;
                }
            }

            if($i == date("d")){
                $grandTotalUnitDay = $totalUnit;
                $grandTotalOntimeDay = $unitOntime;
                $grandTotalAdvanceDay = $total_advance;
                $grandTotalDelayDay = ($totalUnit - ($unitOntime + $total_advance));

                if(!empty($unitOntime)){
                    $grandPercentOntimeDay = round($unitOntime / $totalUnit * 100,1);
                    $grandPercentAdvanceDay = round($total_advance / $totalUnit * 100,1);
                    $grandPercentDelayDay = round(100 - ($grandPercentOntimeDay + $grandPercentAdvanceDay),1);
                }
            }

            $grandTotalUnitMonth += $totalUnit;
            $grandTotalOntimeMonth += $unitOntime;
            $grandTotalAdvanceMonth += $total_advance;
            $grandTotalDelayMonth += ($totalUnit - ($unitOntime + $total_advance));

            if(!empty($unitOntime)){
                $grandPercentOntimeMonth = round($unitOntime / $totalUnit * 100,1);
                $grandPercentAdvanceMonth = round($total_advance / $totalUnit * 100,1);
                $grandPercentDelayMonth = round(100 - ($grandPercentOntimeMonth + $grandPercentAdvanceMonth),1);
            }
        }

        $fb = [
            "statusCode" => 200,
            "data" => [
                "Day" => [
                    "TotalUnit" => number_format($grandTotalUnitDay,0,"","."),
                    "TotalOntime" => number_format($grandTotalOntimeDay,0,"","."),
                    "TotalDelay" => number_format($grandTotalDelayDay,0,"","."),
                    "TotalAdvance" => number_format($grandTotalAdvanceDay,0,"","."),
                    "PercentOntime" => $grandPercentOntimeDay,
                    "PercentDelay" => $grandPercentDelayDay,
                    "PercentAdvance" => $grandPercentAdvanceDay,
                ],
                "Month" => [
                    "TotalUnit" => number_format($grandTotalUnitMonth,0,"","."),
                    "TotalOntime" => number_format($grandTotalOntimeMonth,0,"","."),
                    "TotalDelay" => number_format($grandTotalDelayMonth,0,"","."),
                    "TotalAdvance" => number_format($grandTotalAdvanceMonth,0,"","."),
                    "PercentOntime" => $grandPercentOntimeMonth,
                    "PercentDelay" => $grandPercentDelayMonth,
                    "PercentAdvance" => $grandPercentAdvanceMonth,
                ]
            ]
        ];
        $this->fb($fb);
    }

    function printDataAndon()
    {
        $print_from = $this->input->get("print_from");
        $print_to = $this->input->get("print_to");
        $setup_adjust = $this->model->gd("setup_otd_adjust","*","id = '1'","row");
        $otd_adjust = $setup_adjust->otd_adjust;
        
        $data_std = $this->model->gd("master_setting","*","item != ''","result");

        $grandTotalUnitDay = 0;
        $grandTotalOntimeDay = 0;
        $grandTotalDelayDay = 0;
        $grandTotalAdvanceDay = 0;

        $grandPercentOntimeDay = 0;
        $grandPercentDelayDay = 0;
        $grandPercentAdvanceDay = 0;
        
        $grandTotalUnitMonth = 0;
        $grandTotalOntimeMonth = 0;
        $grandTotalDelayMonth = 0;
        $grandTotalAdvanceMonth = 0;

        $grandPercentOntimeMonth = 0;
        $grandPercentDelayMonth = 0;
        $grandPercentAdvanceMonth = 0;

        
        $total_unit = $this->model->query_exec("SELECT COUNT(u1.vin) AS total_unit,
        SUM(CASE WHEN u2.balance BETWEEN -60 AND -1 THEN 1 ELSE 0 END) AS adv_1jam,
        SUM(CASE WHEN u2.balance BETWEEN -120 AND -61 THEN 1 ELSE 0 END) AS adv_2jam,
        SUM(CASE WHEN u2.balance <= -121 THEN 1 ELSE 0 END) AS adv_more3jam,
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
        FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$print_from." 07:00:00' AND '".$print_to." 07:00:00';","row");
        
        // Assign results to variables
        $totalUnit = $total_unit->total_unit;

        $adv_1jam = $total_unit->adv_1jam;
        $adv_2jam = $total_unit->adv_2jam;
        $adv_more3jam = $total_unit->adv_more3jam;

        $total_advance = $adv_1jam + $adv_2jam + $adv_more3jam;
        
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
        
        $unitOntime = 0;
        if($totalUnit > 0){
            switch ($otd_adjust) {
                case 1:
                    $unitOntime = ($total_1jam + $total_ontime);
                    break;
                case 2:
                    $unitOntime = ($total_2jam + $total_1jam + $total_ontime);
                    break;
                case 3:
                    $unitOntime = ($total_3jam + $total_2jam + $total_1jam + $total_ontime);
                    break;
                case 4:
                    $unitOntime = ($total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                    break;
                case 5:
                    $unitOntime = ($total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                    break;
                case 6:
                    $unitOntime = ($total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                    break;
                case 7:
                    $unitOntime = ($total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                    break;
                case 8:
                    $unitOntime = ($total_8jam + $total_7jam + $total_6jam + $total_5jam + $total_4jam + $total_3jam + $total_2jam + $total_1jam + $total_ontime);
                    break;
                default:
                    // Handle case where $otd_adjust is outside the expected range
                    $unitOntime = $total_ontime;
                    break;
            }
        }

        if($i == date("d")){
            $grandTotalUnitDay = $totalUnit;
            $grandTotalOntimeDay = $unitOntime;
            $grandTotalAdvanceDay = $total_advance;
            $grandTotalDelayDay = ($totalUnit - ($unitOntime + $total_advance));

            if(!empty($unitOntime)){
                $grandPercentOntimeDay = round($unitOntime / $totalUnit * 100,1);
                $grandPercentAdvanceDay = round($total_advance / $totalUnit * 100,1);
                $grandPercentDelayDay = round(100 - ($grandPercentOntimeDay + $grandPercentAdvanceDay),1);
            }
        }

        $grandTotalUnitMonth += $totalUnit;
        $grandTotalOntimeMonth += $unitOntime;
        $grandTotalAdvanceMonth += $total_advance;
        $grandTotalDelayMonth += ($totalUnit - ($unitOntime + $total_advance));

        if(!empty($unitOntime)){
            $grandPercentOntimeMonth = round($unitOntime / $totalUnit * 100,1);
            $grandPercentAdvanceMonth = round($total_advance / $totalUnit * 100,1);
            $grandPercentDelayMonth = round(100 - ($grandPercentOntimeMonth + $grandPercentAdvanceMonth),1);
        }

        $fb = [
            "statusCode" => 200,
            "data" => [
                "Day" => [
                    "TotalUnit" => number_format($grandTotalUnitDay,0,"","."),
                    "TotalOntime" => number_format($grandTotalOntimeDay,0,"","."),
                    "TotalDelay" => number_format($grandTotalDelayDay,0,"","."),
                    "TotalAdvance" => number_format($grandTotalAdvanceDay,0,"","."),
                    "PercentOntime" => $grandPercentOntimeDay,
                    "PercentDelay" => $grandPercentDelayDay,
                    "PercentAdvance" => $grandPercentAdvanceDay,
                ],
                "Month" => [
                    "TotalUnit" => number_format($grandTotalUnitMonth,0,"","."),
                    "TotalOntime" => number_format($grandTotalOntimeMonth,0,"","."),
                    "TotalDelay" => number_format($grandTotalDelayMonth,0,"","."),
                    "TotalAdvance" => number_format($grandTotalAdvanceMonth,0,"","."),
                    "PercentOntime" => $grandPercentOntimeMonth,
                    "PercentDelay" => $grandPercentDelayMonth,
                    "PercentAdvance" => $grandPercentAdvanceMonth,
                ]
            ]
        ];
        $this->fb($fb);
    }

    function tracking_time()
    {
        $this->form_validation->set_rules("vin","VIN","required|trim");
        if($this->form_validation->run() === FALSE){
            $fb = ["statusCode" => 500, "data" => ["message" => validation_errors()]];
            $this->fb($fb);
        }

        $vin = $this->input->post("vin",true);
        $tracking = $this->model->gd("unit","tracking,otd","vin = '$vin'","row");
        if(empty($tracking->tracking)){
            $fb = ["statusCode" => 500, "data" => ["message" => "Data Tracking Kosong"]];
            $this->fb($fb);
        }

        $otd = $tracking->otd;
        $tracking = json_decode($tracking->tracking,true);
        $html_track = '<table border="1" class="table table-bordered table-hover">';
        foreach ($tracking as $tanggal => $timeline) {
            $html_track .= '<tr><td colspan="3" align="center" class="font-weight-bold bg-secondary p-1 text-light">'.date("D, d-M-Y",strtotime($tanggal)).'</td></tr>';
            foreach ($timeline as $key => $value) {
                if($value["end"] == "23:59:59"){
                    $end_time = "00:00";
                }else{
                    $end_time = date("H:i",strtotime($value["end"]));
                }
                $html_track .= '<tr>';
                $html_track .= '
                <td class="p-1" align="center">'.date("H:i",strtotime($value["start"])).'</td>
                <td class="p-1" align="center">'.$end_time.'</td>
                <td class="p-1" align="center">'.$value["minutes"].'</td>';
                $html_track .= '</tr>';
            }
        }
        $html_track .= '<tr>
            <td class="p-1 bg-secondary font-weight-bold text-light" colspan="2" align="center">Total</td>
            <td class="p-1 bg-secondary font-weight-bold text-light" align="center">'.$otd.'</td>
        </tr>';
        $html_track .= '</table>';
        
        $fb = ["statusCode" => 200, "data" => ["tracking" => $html_track]];
        $this->fb($fb);
    }

    function tracking_unit()
    {
        $this->form_validation->set_rules("vin","VIN","required|trim");
        if($this->form_validation->run() === FALSE){
            $fb = ["statusCode" => 500, "data" => ["message" => validation_errors()]];
            $this->fb($fb);
        }

        $vin = $this->input->post("vin",true);
        $url = "http://sv-web-kap/pis/searching_unit/byvin_main.php";
        $params = [
            'vin' => $vin,
            '_search' => false,
            'nd' => time(),
            'rows' => 1000,
            'page' => 1,
            'sidx' => '',
            'sord' => 'asc',
            '_' => time()
        ];

        // Menggabungkan parameter ke dalam URL
        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;

        // Inisialisasi sesi cURL
        $ch = curl_init();

        // Atur opsi cURL
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Eksekusi cURL dan simpan respons
        $response = curl_exec($ch);

        // Cek jika terjadi kesalahan
        if (curl_errno($ch)) {
            $fb = ["statusCode" => 500, "data" => ["message" => '<div>'.curl_error($ch).'</div>']];
        } else {
            // Tampilkan hasil respons
            $data = json_decode($response,TRUE);
            if(!empty($data["rows"])){
                $html_track = '<table border="1" class="table table-bordered table-hover">';
                $html_track .= '
                <thead class="thead thead-light">
                    </tr>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">No</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">VIN</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Sfx</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Model</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Dest</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Color</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Shift</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Last Scan</th>
                        <th class="p-2 align-middle text-center" style="font-size:9pt;">Scan Date</th>
                    </tr>
                </thead>';
                $no = 1;
                foreach ($data["rows"] as $key => $value) {
                    if(!empty($value["cell"][2])){
                        $katashiki = $value["cell"][1];
                        $vin = $value["cell"][2];
                        $suffix = $value["cell"][3];
                        $model = str_replace(" ","",$value["cell"][4]);
                        $dest = str_replace(" ","",$value["cell"][6]);
                        $color = str_replace(" ","",$value["cell"][7]);
                        $pos_scan = $value["cell"][9];
                        $shift = $value["cell"][10];
                        $scan_date = $value["cell"][11];
                        $html_track .= '
                        </tr>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$no.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$vin.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$suffix.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$model.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$dest.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$color.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$shift.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$pos_scan.'</td>
                            <td class="p-2 align-middle text-center" style="font-size:9pt;">'.$scan_date.'</td>
                        </tr>';
                        $no++;
                    }
                }
                $html_track .= '</table>';
                $fb = ["statusCode" => 200, "data" => ["tracking" => $html_track]];
            }else{
                $fb = ["statusCode" => 500, "data" => ["message" => '<div>Data Tracking Unit Tidak Ditemukan.</div>']];
            }
        }
        // Tutup sesi cURL
        curl_close($ch);
        $this->fb($fb);
    }
}
