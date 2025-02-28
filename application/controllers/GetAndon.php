<?php
date_default_timezone_set("Asia/Jakarta");
class GetAndon extends MY_Controller {
    
    // function auto_sync_ot()
    // {
    //     $this->load->view("admin/auto_sync_ot");
    // }

    function updateOTFromTracking()
    {
        $check_ot_awal = $this->model->gd("master_setting","nilai","item = 'ot_awal'","row");
        if(!empty($check_ot_awal->nilai)){
            $otAwalSetup = $check_ot_awal->nilai;
        }else{
            $otAwalSetup = 0;
        }
        // URL endpoint dan parameter
        $url = "http://sv-web-kap/pis/tp_operation/query_main.php";
        $params = [
            '_search' => 'false',
            'nd' => time(),
            'rows' => '10000',
            'page' => '1',
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
            echo 'Error:' . curl_error($ch);
            $fb = ["status" => 500, "res" => curl_error($ch)];
            $this->fb($fb);
        } else {
            // Tutup sesi cURL
            curl_close($ch);
            // Tampilkan hasil respons
            $data = json_decode($response,TRUE);
            if(!empty($data["rows"][14]["cell"])){
                $otFinalDev = end($data["rows"][14]["cell"]);
                $currentDate = date("Y-m-d");
                $currentTime = date("H:i:s");
                $shift = "DS";
                if(strtotime($currentTime) >= strtotime("20:30:00") && strtotime($currentTime) <= strtotime("23:59:59")){
                    $shift = "NS";
                }else if(strtotime($currentTime) >= strtotime("00:00:00") && strtotime($currentTime) <= strtotime("07:23:00")){
                    //BACKDATE
                    $shift = "NS";
                    $currentDate = date("Y-m-d",strtotime("-1 days"));
                }

                $currentDay = date("D",strtotime($currentDate));
                if($shift == "DS"){
                    if($currentDay == "Fri"){
                        $lastHourProd = "16:30:00";
                    }else{
                        $lastHourProd = "16:00:00";
                    }
                    $newHourOT = $this->setJam($lastHourProd,$otFinalDev,$currentDay);
                }else{
                    $lastHourProd = "05:45:00";
                    $newHourOT = $this->setJam($lastHourProd,$otFinalDev,$currentDay,$otAwalSetup);
                }


                //UPDATE OT
                if($shift == "DS"){
                    $updateOt = [
                        "start_ds" => "07:25",
                        "end_ds" => $newHourOT,
                    ];
                }else{
                    $updateOt = [
                        "end_ns" => $newHourOT,
                    ];
                }
                //CHECK SET OT
                $validasiSetOT = $this->model->gd("set_ot","on_off","tanggal = '$currentDate'","row");
                if($validasiSetOT->on_off > 0){
                    if($currentDay == "Fri" && $shift == "NS"){
                        $updateOt = [
                            "start_ns" => "00:00",
                            "end_ns" => $newHourOT,
                            "shadow" => "1",
                        ];
                        $this->model->update("set_ot","tanggal = '".date("Y-m-d")."'",$updateOt);
                    }
    
                    $this->model->update("set_ot","tanggal = '$currentDate'",$updateOt);
                    
                    $fb = ["status" => 200, "res" => "Proses update berhasil ".json_encode($updateOt)];
                }else{
                    $fb = ["status" => 200, "res" => "Off Production Day"];
                }
                $this->fb($fb);
            }else{
                $fb = ["status" => 200, "res" => "Proses update berhasil Tidak ada OT"];
                $this->fb($fb);
            }
        }
    }

    private function setJam($lastHourProd,$ot,$currentDay,$otAwal = 0)
    {
        header('Content-Type: application/json');
        $newHourOT = $lastHourProd;
        $minutesOT = 0;
        $oot = 0;
        
        if($otAwal > 0){
            //UPDATE START NS MENJADI 20:30
            $updateStartNS = ["start_ns" => "20:30"];
            $currentDate = date("Y-m-d");
            if(strtotime(date("H:i:s")) >= strtotime("00:00:00") && strtotime(date("H:i:s")) <= strtotime("07:23:00")){
                $currentDate = date("Y-m-d",strtotime("-1 days"));
            }
            $this->model->update("set_ot","tanggal = '$currentDate'",$updateStartNS);
            $ot = $ot - 30;
        }

        if($ot <= 0){
            return $newHourOT;
        }
        
        if($currentDay == "Fri"){
            $minHourOT = "16:31:00";
            $maxHourOT = "16:45:00";
        }else{
            $minHourOT = "16:01:00";
            $maxHourOT = "16:15:00";
        }

        $loopOT = true;
        while ($loopOT) {
            $oot += 15;
            $minutesOT += 15;

            $newHourOT = date("H:i:s",strtotime("+".$minutesOT." minutes",strtotime($lastHourProd)));

            if(strtotime($newHourOT) >= strtotime($minHourOT) && strtotime($newHourOT) <= strtotime($maxHourOT)){
                $minutesOT = $minutesOT + 15;
                $ot = $ot + 15;
            }else if(strtotime($newHourOT) >= strtotime("18:01:00") && strtotime($newHourOT) <= strtotime("18:30:00")){
                $minutesOT = $minutesOT + 30;
                $ot = $ot + 30;
            }
            
            $newHourOT = date("H:i:s",strtotime("+".$minutesOT." minutes",strtotime($lastHourProd)));
            
            // echo $oot." ".$newHourOT."\n";

            if($minutesOT >= $ot){
                $loopOT = false;;
            }
        }

        return date("H:i",strtotime($newHourOT));
    }

    function updateOTFromTrackingKAP2()
    {
        header('Content-Type: application/json');
        $check_ot_awal = $this->model->gd("master_setting","nilai","item = 'ot_awal_kap2'","row");
        if(!empty($check_ot_awal->nilai)){
            $otAwalSetup = $check_ot_awal->nilai;
        }else{
            $otAwalSetup = 0;
        }
        $url = "http://10.59.225.35/Web_Common/AndonTPOperation/GetList/";
        $params[] = [
            'Action' => "0",
            'Section_Name' => "",
            'UserID' => "userANDON"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Cookie: UserLogin=userANDON; webbase_AndonPCD=%2FWeb_AndonPCD; webbase_PCD=%2FWeb_PCD; webbase_Welding=%2FWeb_Welding; webbase_Hrgm=%2FWeb_Harigami; webbase_Toso=%2FWeb_Toso; webbase_Common=%2FWeb_Common; jwtCookie=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1laWQiOiJ1c2VyQU5ET04iLCJuYW1lIjoiNjE1ODQwRmIgRmU4MCA0MDNGIEE3ZTUgRWNmNzNhZWYxMGQwIiwianRpIjoiYmEwYTM1MmUtZDI1ZC00ZjczLWFkMWYtZTc4ODk2MGE5NzVhIiwibmJmIjoxNzM5ODQwOTQ4LCJleHAiOjE3NzEzNzY5NDgsImlzcyI6IkpXVEF1dGhlbnRpY2F0aW9uU2VydmVyIiwiYXVkIjoiSldUU2VydmljZVBvc3RtYW5DbGllbnQifQ.sqgCqQ5Li5RIoPWKPQI7Mt-iUyCebnrfm4zr4kZvwDM; UserName=615840Fb%20Fe80%20403F%20A7e5%20Ecf73aef10d0; UserGroupID=f4e35e38X59d3X4dfdX9dbcX7a75ff5da40a"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $response = curl_exec($ch);

        // Cek jika terjadi kesalahan
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            $fb = ["status" => 500, "res" => curl_error($ch)];
            $this->fb($fb);
        } else {
            // Tutup sesi cURL
            curl_close($ch);
            // Tampilkan hasil respons
            $data = json_decode($response,TRUE);
            $dataLast = end($data["Contents"]);
            $dataOvertime = end($dataLast);
            
            $otFinalDev = $dataOvertime;
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");
            $shift = "DS";
            if(strtotime($currentTime) >= strtotime("20:30:00") && strtotime($currentTime) <= strtotime("23:59:59")){
                $shift = "NS";
            }else if(strtotime($currentTime) >= strtotime("00:00:00") && strtotime($currentTime) <= strtotime("07:23:00")){
                //BACKDATE
                $shift = "NS";
                $currentDate = date("Y-m-d",strtotime("-1 days"));
            }

            $currentDay = date("D",strtotime($currentDate));
            if($shift == "DS"){
                if($currentDay == "Fri"){
                    $lastHourProd = "16:30:00";
                }else{
                    $lastHourProd = "16:00:00";
                }
                $newHourOT = $this->setJam($lastHourProd,$otFinalDev,$currentDay);
            }else{
                $lastHourProd = "05:45:00";
                $newHourOT = $this->setJam($lastHourProd,$otFinalDev,$currentDay,$otAwalSetup);
            }


            //UPDATE OT
            if($shift == "DS"){
                $updateOt = [
                    "start_ds" => "07:25",
                    "end_ds" => $newHourOT,
                ];
            }else{
                $updateOt = [
                    "end_ns" => $newHourOT,
                ];
            }
            //CHECK SET OT
            $validasiSetOT = $this->model->gd("set_ot_kap2","on_off","tanggal = '$currentDate'","row");
            if($validasiSetOT->on_off > 0){
                if($currentDay == "Fri" && $shift == "NS"){
                    $updateOt = [
                        "start_ns" => "00:00",
                        "end_ns" => $newHourOT,
                        "shadow" => "1",
                    ];
                    $this->model->update("set_ot_kap2","tanggal = '".date("Y-m-d")."'",$updateOt);
                }

                $this->model->update("set_ot_kap2","tanggal = '$currentDate'",$updateOt);
                
                $fb = ["status" => 200, "res" => "Proses update berhasil ".json_encode($updateOt)];
            }else{
                $fb = ["status" => 200, "res" => "Off Production Day"];
            }
            $this->fb($fb);
        }
    }

    function setPlant()
    {
        $plant = $this->input->post("plant");
        $dataSess = ["plant" => $plant];
        $this->session->set_userdata($dataSess);
        redirect("set_wh");    
    }
}
