<?php
date_default_timezone_set("Asia/Jakarta");
class Admin extends MY_Controller {

	function index()
    {
        $this->load->view("admin/index");
    }
	function print_otd()
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
        $this->load->view("admin/print_otd",$data);
    }

	public function err404()
	{
		$this->load->view("errors/html/error_404_notfound");
	}

	function set_wh()
    {
        $data_std = $this->model->gd("master_setting","*","item != ''","result");
        $data["data_std"] = $data_std;
        $data["title"] = "Set WH Overtime";
        $data["body"] = "set_wh";
        // $data["jsadd"] = "set_wh";
        $this->load->view("template/index",$data);
    }

	function graph_andon()
    {
        if(empty($this->day_sum)){
            $data["day_sum"] = date("m");
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

        $start_ds = $this->input->post("start_ds");
        $end_ds = $this->input->post("end_ds");
        $start_ns = $this->input->post("start_ns");
        $end_ns = $this->input->post("end_ns");
        $on_off = $this->input->post("onoff");
        for ($i=1; $i <= date("t"); $i++) {
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
            
            $tanggal = date("Y-m-".sprintf("%02d",$i));
            $day_val = date("D",strtotime($tanggal));
            if(substr_count("Sat Sun",$day_val) > 0){
                if(empty($on_off[$i])){
                    //CHECK HARI SEBELUM NYA
                    if(!empty($update[($i-1)]["start_ns"]) && !empty($update[($i-1)]["start_ds"])){
                        $update[$i] = [
                            "on_off" => $onoff,
                            "start_ds" => NULL,
                            "end_ds" => NULL,
                            "start_ns" => "00:00",
                            "end_ns" => $update[($i-1)]["end_ns"],
                            "shadow" => "1",
                        ];
                    }
                }
            }else{
                $update[$i] = [
                    "on_off" => $onoff,
                    "start_ds" => $startDS,
                    "end_ds" => $endDS,
                    "start_ns" => $startNS,
                    "end_ns" => $endNS,
                    "shadow" => "0",
                ];
            }

        }
        foreach ($update as $key => $value) {
            $this->model->update("set_ot","tanggal = '$key'",$value);
        }
        $this->swal("Sukses","Data OT berhasil disimpan","success");
        redirect("set_wh");
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
        for ($i=1; $i <= 31; $i++) { 
            $update = [
                "on_off" => "1",
                "post_ot_ds" => NULL,
                "pre_ot_ns" => NULL,
                "post_ot_ns" => NULL,
            ];
            $this->model->update("set_ot","tanggal = '$i'",$update);
        }  
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
        }else{
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

    function calc_lead_time()
    {
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
        $vin_hitung_ulang = "MHKAA1BA1RJ143968"; //MASUKKAN VIN DISINI UNTUK MENGETAHUI PROSES HITUNG NYA
        if(!empty($vin_hitung_ulang)){
            $search_vin_ulang = "AND vin = '$vin_hitung_ulang'";
        }else{
            $search_vin_ulang = "";
        }
        $data = $this->model->gd("unit","*","otd IS NULL AND jig_in IS NOT NULL AND delivery IS NOT NULL AND delivery BETWEEN '".$date." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($date)))." 07:00:00' $search_vin_ulang ORDER BY delivery ASC LIMIT 0,300","result");
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
                $ot_info = $this->model->gd("set_ot","*","tanggal BETWEEN ".date("d",strtotime($data->jig_in))." AND ".date("d",strtotime($data->delivery))."","result");
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

                $balance = $total_otd - $std_otd;
                if($total_otd <= $std_otd){
                    $status_otd = "Ontime";
                }else{
                    $status_otd = "Delay";
                }

                $data_otd[$data->vin] = ["jig_in" => date("D d-m-Y H:i",strtotime($data->jig_in)), "delivery" => date("D d-m-Y H:i",strtotime($data->delivery)), "time_otd" => $total_otd, "status" => $status_otd, "std_otd" => $std_otd, "balance" => $balance];
            }
        }

        if(!empty($vin_hitung_ulang)){
            print_r($data_otd);
            die();
        }

        foreach ($data_otd as $key => $value) {
            if($value["status"] != "NOT VALUABLE"){
                $update_otd = ["otd" => $value["time_otd"], "balance" => $value["balance"]];
                //UPDATE
                $this->model->update("unit","vin = '$key'",$update_otd);
            }
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
        $jig_in = str_replace(":","",$jigin_time);
        $deliv = str_replace(":","",$deliv_time);
        //INISIALISASI JIG IN SHIFT
        $jig_in_shift = "DS";
        if(strtotime($jigin_time) > strtotime("20:29:00") && strtotime($jigin_time) < strtotime("23:59:59")){
            $jig_in_shift = "NS";
        }else if(strtotime($jigin_time) > strtotime("00:00:00") && strtotime($jigin_time) < strtotime("07:00:59")){
            $jig_in_shift = "NS";
        }
        //INISIALISASI DELIV SHIFT
        $deliv_shift = "DS";
        if(strtotime($deliv_time) > strtotime("20:29:00") && strtotime($deliv_time) < strtotime("23:59:59")){
            $deliv_shift = "NS";
        }else if(strtotime($deliv_time) > strtotime("00:00:00") && strtotime($deliv_time) < strtotime("07:00:59")){
            $deliv_shift = "NS";
        }

        $countingDay = (count($ot_info) - 1); //JUMLAH HARI UNIT SELAMA PROSES SAMPAI DELIVERY (KURANG SATU KARENA ARRAY MULAI DAI 0)
        foreach ($ot_info as $key_jam => $val_jam) {
            $day_val = date("D",strtotime($val_jam["tanggal"]));
            if($val_jam["on_off"] <= 0){
                continue;
            }

            if($day_val != "Fri"){
                $search_day_val = "AND day_val != 'Fri'";
            }else{
                $search_day_val = "AND day_val = 'Fri'";
            }

            $otd = 0; //VARIABLE OTD (HITUNGAN LEADTIME)
            if($key_jam <= 0){ // PROSES HITUNG DARI JIG IN SAMPAI AKHIR PROSES (NIGHT SHIFT)
                $jam_awal = $jigin_time;
                if($jig_in_shift == "DS"){// JIKA JIG IN SHIFT ADALAH DAY SHIFT (ATUR JAM AKHIR KE NIGH SHIFT)
                    $jam_akhir = $val_jam["DS"]["end"];

                    //DAPATKAN TIMELINE DAY SHIFT
                    $timelineDayShift = $this->model->gd("timeline","*","
                    (start >= '$jam_awal' AND end <= '$jam_akhir:59' ".$search_day_val." AND shift = 'DS') OR 
                    (start < '$jam_awal' AND end > '$jam_awal' ".$search_day_val." AND shift = 'DS') OR 
                    (start < '$jam_akhir:59' AND end > '$jam_akhir:59' ".$search_day_val." AND shift = 'DS') ORDER BY id ASC","result");

                    //DAPATKAN TIMELINE NIGHT SHIFT
                    $jam_awal = $val_jam["NS"]["start"];
                    $jam_akhir = $val_jam["NS"]["end"];

                    $timelineNightShift = $this->model->gd("timeline","*","
                    (start >= '$jam_awal:59' AND end <= '23:59:59' ".$search_day_val." AND shift = 'NS') OR
                    (start >= '00:00:00' AND end <= '$jam_akhir:59' ".$search_day_val." AND shift = 'NS') ORDER BY id ASC","result");

                    $timelineOTD[$val_jam["tanggal"]] = array_merge($timelineDayShift,$timelineNightShift);
                }else{
                    //DAPATKAN TIMELINE NIGHT SHIFT
                    $jam_akhir = $val_jam["NS"]["end"];
                    
                    if(strtotime($jam_awal) >= strtotime("00:00:00") && strtotime($jam_awal) <= strtotime("07:20:00")){
                        $timelineNightShift = $this->model->gd("timeline","*","
                        (start >= '00:00:00' AND end <= '$jam_akhir:59' ".$search_day_val." AND shift = 'NS') ORDER BY id ASC","result");
                        $end_timeline = end($timelineNightShift);
                        if(strtotime($val_jam["tanggal"]." ".$end_timeline->end) < strtotime($deliv_date)){
                            $timelineNightShift1 = $this->model->gd("timeline","*","
                            (start >= '07:01:00' AND end <= '23:59:59' ".$search_day_val.") ORDER BY id ASC","result");
                            $timelineNightShift = array_merge($timelineNightShift,$timelineNightShift1);
                        }

                        $end_timeline = end($timelineNightShift);
                        if(strtotime(date("Y-m-d",strtotime("+1 days",strtotime($val_jam["tanggal"])))." 00:00:00") < strtotime($deliv_date)){
                            $timelineNightShift1 = $this->model->gd("timeline","*","
                            (start >= '00:00:00' AND end <= '$jam_akhir:59' ".$search_day_val.") ORDER BY id ASC","result");
                            $timelineNightShift = array_merge($timelineNightShift,$timelineNightShift1);
                        }
                        print_r($timelineNightShift);
                    }else{
                        $timelineNightShift = $this->model->gd("timeline","*","
                        (start >= '$jam_awal' AND end <= '23:59:59' ".$search_day_val." AND shift = 'NS') OR
                        (start >= '00:00:00' AND end <= '$jam_akhir:59' ".$search_day_val." AND shift = 'NS') ORDER BY id ASC","result");
                    }

                    $timelineOTD[$val_jam["tanggal"]] = $timelineNightShift;
                }
            }else if($key_jam > 0 && $key_jam < $countingDay){// PROSES UNIT BERADA DI TENGAH HARI (MASIH PROSES BELUM DELIVERY)
                $jam_awal = $val_jam["DS"]["start"];
                $jam_akhir = $val_jam["DS"]["end"];

                //DAPATKAN TIMELINE DAY SHIFT
                $timelineDayShift = $this->model->gd("timeline","*","
                (start >= '$jam_awal' AND end <= '$jam_akhir:59' ".$search_day_val." AND shift = 'DS') OR 
                (start < '$jam_awal' AND end > '$jam_awal' ".$search_day_val." AND shift = 'DS') OR 
                (start < '$jam_akhir:59' AND end > '$jam_akhir:59' ".$search_day_val." AND shift = 'DS') ORDER BY id ASC","result");

                //DAPATKAN TIMELINE NIGHT SHIFT
                $jam_awal = $val_jam["NS"]["start"];
                $jam_akhir = $val_jam["NS"]["end"];

                $timelineNightShift = $this->model->gd("timeline","*","
                (start >= '$jam_awal:59' AND end <= '23:59:59' ".$search_day_val." AND shift = 'NS') OR
                (start >= '00:00:00' AND end <= '$jam_akhir:59' ".$search_day_val." AND shift = 'NS') ORDER BY id ASC","result");

                $timelineOTD[$val_jam["tanggal"]] = array_merge($timelineDayShift,$timelineNightShift);
            }else{// PROSES HARI DIMANA UNIT DELIVERY
                $jam_awal = $val_jam["DS"]["start"];
                if($deliv_shift == "DS"){// JIKA DELIVERY SHIFT ADALAH DAY SHIFT (ATUR JAM AKHIR KE NIGH SHIFT)
                    $jam_akhir = $deliv_time;

                    //DAPATKAN TIMELINE DAY SHIFT
                    $timelineDayShift = $this->model->gd("timeline","*","
                    (start >= '$jam_awal:59' AND end <= '$jam_akhir' ".$search_day_val." AND shift = 'DS') OR 
                    (start < '$jam_awal:59' AND end > '$jam_awal:59' ".$search_day_val." AND shift = 'DS') OR 
                    (start < '$jam_akhir' AND end > '$jam_akhir' ".$search_day_val." AND shift = 'DS') ORDER BY id ASC","result");

                    $timelineOTD[$val_jam["tanggal"]] = $timelineDayShift;
                }else{
                    //JIKA PROSES DELIVERY ADALAH 1 HARI DAN ITU JIG IN DS DAN DELIV NS
                    if($countingDay == 1 && $jig_in_shift == "DS" && $deliv_shift == "NS"){
                        continue; //SKIP PROSES
                    }
                    //DAPATKAN TIMELINE NIGHT SHIFT
                    $jam_awal = $val_jam["DS"]["start"];
                    $jam_akhir = $val_jam["DS"]["end"];

                    //DAPATKAN TIMELINE DAY SHIFT
                    $timelineDayShift = $this->model->gd("timeline","*","
                    (start >= '$jam_awal' AND end <= '$jam_akhir' ".$search_day_val." AND shift = 'DS') OR 
                    (start < '$jam_awal' AND end > '$jam_awal' ".$search_day_val." AND shift = 'DS') OR 
                    (start < '$jam_akhir' AND end > '$jam_akhir' ".$search_day_val." AND shift = 'DS') ORDER BY id ASC","result");

                    //DAPATKAN TIMELINE NIGHT SHIFT
                    $jam_awal = $val_jam["NS"]["start"];
                    $jam_akhir = $deliv_time;
                    
                    if(strtotime($jam_akhir) >= strtotime("20:30:00") && strtotime($jam_akhir) <= strtotime("23:59:59")){
                        $timelineNightShift = $this->model->gd("timeline","*","
                        (start >= '$jam_awal:59' AND start <= '$jam_akhir' ".$search_day_val." AND shift = 'NS') ORDER BY id ASC","result");
                    }else if(strtotime($jam_akhir) >= strtotime("00:00:00") && strtotime($jam_akhir) <= strtotime("07:20:00")){
                        $timelineNightShift = $this->model->gd("timeline","*","
                        (start >= '$jam_awal:59' AND end <= '23:59:59' ".$search_day_val." AND shift = 'NS') OR
                        (start >= '00:00:00' AND end <= '$jam_akhir' ".$search_day_val." AND shift = 'NS') ORDER BY id ASC","result");
                    }
                    $timelineOTD[$val_jam["tanggal"]] = array_merge($timelineDayShift,$timelineNightShift);
                }
            }

        }
        
        print_r($timelineOTD);
        $timelineOTD = json_encode($timelineOTD);
        $timelineOTD = json_decode($timelineOTD,true);

        //OTD FULL SUDAH DI DAPATKAN
        $no = 1;
        $jigin_timeline = "";
        $deliv_timeline = "";
        foreach ($timelineOTD as $keyTL => $valTL) {
            foreach ($valTL as $key => $val) {
                $valueTL = json_encode($val);
                $valueTL = json_decode($valueTL,true);
                $minutes = $valueTL["minutes"];
                $otd += $valueTL["minutes"];
                if($no == 1){
                    $jigin_timeline = $valueTL["start"];
                }else{
                    $deliv_timeline = $valueTL["end"];
                }
                $no++;
            }
        }

        //CARI SELISIH WAKTU JIG IN KE START DS
        $startTime = new DateTime($jigin_timeline);
        $endTime = new DateTime($jigin_time);
        $interval = $startTime->diff($endTime);
        $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);
        $sisaMenitJigIn = round($minutes);
        
        //CARI SELISIH WAKTU JIG IN KE START NS
        $startTime = new DateTime($deliv_timeline);
        $endTime = new DateTime($deliv_time);
        $interval = $startTime->diff($endTime);
        $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);
        $sisaMenitDeliv = round($minutes);

        //FINAL OTD
        $otd_final = $otd - $sisaMenitJigIn - $sisaMenitDeliv;

        echo $otd."-".$sisaMenitJigIn."-".$sisaMenitDeliv;
        // print_r($deliv_timeline);
        return $otd_final;
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

    function set_adjust_otd()
    {
        $adjust = $this->input->post("adjust");
        $day = $this->input->post("day");
        $month = $this->input->post("month");
        $year = $this->input->post("year");
        $this->session->set_userdata(array("day_sum" => $day,"month_sum" => $month, "year_sum" => $year));
        $update = ["otd_adjust" => $adjust];
        $this->model->update("setup_otd_adjust","id = '1'",$update);
        if(!empty($this->input->post("day"))){
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
            case -3:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance <= 121 AND vin != '' ORDER BY balance ASC","result");
                break;
                break;
            case -2:
                $list_unit = $this->model->gd("unit","*","delivery BETWEEN ".$day_search." AND balance BETWEEN -120 AND -60 AND vin != '' ORDER BY balance ASC","result");
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
        
        $load_list_unit = '
        <table class="table table-sm table-bordered table-hover mb-3 mt-1" id="datatable">
        <thead class="thead-light">
            <tr>
                <th style="font-size:9pt;">No</th>
                <th style="font-size:9pt;">VIN</th>
                <th style="font-size:9pt;">Suffix</th>
                <th style="font-size:9pt;">Color</th>
                <th style="font-size:9pt;">Jig In</th>
                <th style="font-size:9pt;">Delivery</th>
                <th style="font-size:9pt;">Actual Lead Time (min)</th>
                <th style="font-size:9pt;">Vs Lead Time Normal</th>
            </tr>
        </thead>
        <tbody>';
        if(!empty($list_unit)){
            $no = 1;
            foreach ($list_unit as $list_unit) {
                $load_list_unit .= '
                <tr>
                    <td style="font-size:9pt;">'.$no++.'</td>
                    <td style="font-size:9pt;">'.$list_unit->vin.'</td>
                    <td style="font-size:9pt;">'.$list_unit->suffix.'</td>
                    <td style="font-size:9pt;">'.$list_unit->color.'</td>
                    <td style="font-size:9pt;">'.date("d-m-Y H:i:s",strtotime($list_unit->jig_in)).'</td>
                    <td style="font-size:9pt;">'.date("d-m-Y H:i:s",strtotime($list_unit->delivery)).'</td>
                    <td style="font-size:9pt;">'.$list_unit->otd.'</td>
                    <td style="font-size:9pt;">'.$list_unit->balance.'</td>
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
        echo $load_list_unit;
        die();
    }

    function getDataAndon()
    {
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
            FROM unit u1 LEFT JOIN unit u2 ON u1.vin = u2.vin WHERE u1.delivery BETWEEN '".$day." 07:00:00' AND '".date("Y-m-d",strtotime("+1 days",strtotime($day)))." 07:00:00';","row");
            
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
}
