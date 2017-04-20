<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once APPPATH . 'core/MY_Controller.php';

class Pbx_Controller extends MY_Controller
{
	public $name = '';

	public function __construct()
	{
		parent::__construct();
	}

	// public function __get( $key )
	// {
	// 	if( isset($this->$key) )
	// 		return $this->$key;			
	// }

	// public function __set( string $key, $value = null )
	// {
	// 	if( isset($this->$key) )	// ktra key này tồn tại ko? ví dụ $pbx->name = eucerin, Lúc này nó ktra có name và truyền vào value là eucerin
	// 	{
	// 		$this->$key = $value;
	// 	}
	// }


	/**
	 * Get last 10 record from table cdr of asteriskcdrdb db
	 *
	 * @param string 	name of pbx
	 * @return mixed 	either query data as object or FALSE
	 **/
	// create at 9/11/16

	// public function getLast10( $namePbx )
	// {
	// 	// return ['a','b'];
	// 	return $this->pbx_model->getLast10( $namePbx );
	// }

	/* Function trên hơi basic, vì sau khi có chạy local_controller, ta đã có được name và truyền 
	bằng $this->name, vậy ngay tại vị trí này ta truyền thẳng vào luôn, nếu sợ lỗi thì thêm phần test lỗi */
	public function getLast10()
	{
		if( $this->name == '' )
			cdie('Ko có namePbx, at Pbx_Controller');

		return $this->pbx_model->getLast10( $this->name );
	}

	/**
	 * Get extensions from table users of db asterisk
	 *
	 * @return void
	 * @author 
	 **/
	public function getExtens()
	{
		$extens = $this->pbx_model->getExtens( $this->name );

		if( ! $extens )
			return FALSE;

		return $extens;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function reportTalktime()
	{
		// có thể cải thiện bước này bằng cách thay thế 3 biến riêng lẻ thành 1 biến array
		$startDate = $this->input->post('txtStartDate');
		$endDate = $this->input->post('txtEndDate');
		$arrExtens = $this->input->post('chkExtens');

		// kiểm tra định dạng Y-m-d , bằng hàm bên dưới. nhưng đã tích hợp vào form_validation
		// if( !validateDate($startDate) )
		// 	cdie('Sai định dạng StartDate.');

		$this->load->library('form_validation');
		$this->config->load( config_item('report_talktime_validate_file') );		// lấy từ config/cpbx
		$this->form_validation->set_rules( config_item('reportTalktimeRules') );	// config_item này nằm trong file lấy từ config_item('report_talktime_validate_file')
		$this->form_validation->set_error_delimiters('<h4 style="color: red">', '</h4>');
		// eidt at 30/11/16 following ebook CodeIgniter Web Application Blueprints : alert error with bootstrap
		// $this->form_validation->set_error_delimiters('<div class="row"><div class="col-xs-4 col-md-4"><div class="alert alert-danger">', '</div></div></div>');

		if( $this->form_validation->run() !== TRUE )
		{
			// cdie('loi'); 
			return FALSE;
		}

		// startDate ko được lớn hơn endDate
		if( date('Y-m-d', strtotime($startDate)) > date('Y-m-d', strtotime($endDate)) )
			cdie('End Date must greater Start Date. <a href="javascript:history.go(-1)">Back</a>');

		$queryData = $this->pbx_model->getReportTalkTime( $this->name, $arrExtens, $startDate, $endDate );

		if( $queryData === FALSE )
			return FALSE;

		return $queryData;
	}

	/**
	 * generate table from object CI_DB_mysqli_result
	 *
	 * @param object 	not array or 
	 * @return string 
	 **/
	protected function _generateTable($queryData, $id = 'tblGenerate')
	{
		$this->load->library('table');

		$template = array(
		        'table_open'            => '<div class="row"><div class="col-md-12"><div id="'.$id.'" class="table-responsive"><table class="table table-hover">',

		        'thead_open'            => '<thead>',
		        'thead_close'           => '</thead>',

		        'heading_row_start'     => '<tr>',
		        'heading_row_end'       => '</tr>',
		        'heading_cell_start'    => '<th>',
		        'heading_cell_end'      => '</th>',

		        'tbody_open'            => '<tbody>',
		        'tbody_close'           => '</tbody>',

		        'row_start'             => '<tr>',
		        'row_end'               => '</tr>',
		        'cell_start'            => '<td>',
		        'cell_end'              => '</td>',

		        'row_alt_start'         => '<tr>',
		        'row_alt_end'           => '</tr>',
		        'cell_alt_start'        => '<td>',
		        'cell_alt_end'          => '</td>',

		        'table_close'           => '</table></div></div></div>'
		);		

		$this->table->set_template($template);

		return $this->table->generate($queryData);		
	}



}

/* End of file Pbx_Controller.php */
/* Location: ./application/core/Pbx_Controller.php */