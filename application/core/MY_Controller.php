<?php
class MY_Controller extends CI_Controller {

	public function __construct()
    {
        parent::__construct(); // Memastikan perpustakaan yang di-autoload dapat diakses
        $this->day_sum = $this->session->userdata("day_sum");
        $this->month_sum = $this->session->userdata("month_sum");
        $this->year_sum = $this->session->userdata("year_sum");
        $this->std_limit = 250;
    }
    function fb($array)
    {
        echo json_encode($array);
        die();   
    }
    function std_otd($kap)
    {
        if($kap == "1"){
            $wip = $this->model->gd("master_setting","SUM(nilai) as total_wip","item LIKE '%wip%' AND item NOT LIKE '%kap2%'","row");
            $tt = $this->model->gd("master_setting","nilai","item = 'tt'","row");
            $eff = $this->model->gd("master_setting","nilai","item = 'eff'","row");
        }else{
            $wip = $this->model->gd("master_setting","SUM(nilai) as total_wip","item LIKE '%wip%' AND item LIKE '%kap2%'","row");
            $tt = $this->model->gd("master_setting","nilai","item = 'tt_kap2'","row");
            $eff = $this->model->gd("master_setting","nilai","item = 'eff_kap2'","row");
        }
        $total_wip = $wip->total_wip;
        $std_otd = ($total_wip*$tt->nilai)/$eff->nilai;
        return round($std_otd);   
    }
	public function swal($title, $text, $icon)
	{
		$this->session->set_flashdata("swal", '
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			var text = "' . $text . '";
			swal.fire({title:"' . $title . '",html:text,icon:"' . $icon . '"});
		</script>');
	}
}
?>