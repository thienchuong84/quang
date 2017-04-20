<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// create at 01/12/2016 , sau eucerin va pbx38, vì thế phần name pbx cũng khác. nó lấy từ pbx_model thay vì lấy từ pbx_controller. Ngoài ra property của nó cũng flexible hơn.

require_once APPPATH.'core/Pbx_controller.php';

class Pbx5 extends Pbx_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->name = strtolower(__CLASS__);
	}

	public function gsm()
	{
		// required
		$this->data['title'] = "Report GSM of ".ucfirst($this->name);
		$this->data['subView'] = $this->name.'/gsm';

		// custom variables
		$this->data['project_prefix'] = array("VIB"=>"9192", "Liberty"=>"9288", "VinaWealth"=>"9293");

		if($this->input->post())
		{
			// cpre($this->input->post());

			$this->load->library('form_validation');
			$this->config->load(config_item('report_gsm'));		//lấy từ config/cpbx, vì vậy nếu autoload ko khai báo cpbx thì ở đây sẽ lỗi
			$this->form_validation->set_rules(config_item('reportGsmRules'));
			$this->form_validation->set_error_delimiters('<h4 style="color: red">', '</h4>');

			// nếu OK, thì mới gán các biến lấy từ POST, tiếp tục kiểm tra startDate phải nhỏ hơn endDate
			if($this->form_validation->run() !== FALSE)
			{
				$data = array(
					"arrProjects" => $this->input->post('chkProjects'),
					"gsm" => $this->input->post('selGsm'),					
					"startDate" => $this->input->post('txtStartDate'),
					"endDate" => $this->input->post('txtEndDate')
				);

				if(date('Y-m-d', strtotime($data['startDate'])) > date('Y-m-d', strtotime($data['endDate'])))
					cdie('End Date must greater Start Date. <a href="javascript:history.go(-1)">Back</a>');

				$obj_CI_DB_mysqli_result = $this->pbx_model->getReportTalkTimeGSM($this->name, $this->data['project_prefix'], $data['arrProjects'], $data['gsm'], $data['startDate'], $data['endDate']);

				// -- chú ý: các bước dưới làm nếu ta cần export table, nếu ko cần thì ta ko cần result_array
				// phải ktra empty của obj trước để tránh lỗi phát sinh khi sai datetime
				// if(!empty($obj_CI_DB_mysqli_result))
				// 	$result_array = $obj_CI_DB_mysqli_result->result_array();
				// if(!empty($result_array))
				// {
				// 	$this->data['gsmReportTable'] = $this->_generateTable($obj_CI_DB_mysqli_result);
				// 	$this->data['result_array_talktime'] = serialize($result_array);
				// }
				// else
				// 	$this->data['gsmReportTable'] = FALSE;

				if(!empty($obj_CI_DB_mysqli_result))
					$this->data['gsmReportTable'] = $this->_generateTable($obj_CI_DB_mysqli_result);
				else
					$this->data['gsmReportTable'] = FALSE;

			}
		}

		


		$this->load->view(config_item('frontEnd'), $this->data);
	}





	public function test01()
	{
		echo 'name of pbx : '.ucfirst($this->name);
	}
}

/* End of file pbx5.php */
/* Location: ./application/controllers/pbx5.php */