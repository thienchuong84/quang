<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/Pbx_controller.php';

class Local extends Pbx_Controller
{
	public function __construct()
	{
		parent::__construct();

		// $this->setName( strtolower(__CLASS__) );
		// thay thế lệnh trên bằng property, ko cần chạy function setName
		// vì Local này extends nên dùng property, khi nào đứng ở 1 trị trí khác như trong model, ta new object thì mới sửdụng _set _get
		$this->name = strtolower(__CLASS__);
		$this->data['nameProject'] = ucfirst($this->name);
	}

	public function talktime()
	{
		$this->data['title'] = 'Report Talktime of '.ucfirst($this->name);
		$this->data['subView'] = $this->name.'/talktime';


		if ( strtolower($_SERVER['REQUEST_METHOD']) == 'post')
		{
			// cdie('post submit');		// test
			$this->load->library('form_validation');
			// $this->load->library('table');			
			// $this->data['resultData'] = $this->reportTalktime();

			// $queryData return object not array or stdClass
			$obj_CI_DB_mysqli_result = $this->reportTalktime();		// var_dump($queryData->row()); cdie('test gtri $queryData at Local.');
			// var_dump($queryData);
			// cpre($queryData);cdie('test');
			// var_dump($queryData->result_array());		// CHÚ Ý: KHI VAR_DUMP $queryData, muốn lấy bên trong nó phải dùng result_array() , vì nó là method của CI, khi ta thiếu dấu () , luôn luôn nó trả về giá trị null

			// $result_array = $obj_CI_DB_mysqli_result->result_array();	// var_dump(serialize($result_array));cdie('test');
			// nếu chạy lệnh trên, ko ktra !empty() thì sẽ dẩn đến lỗi khi ta nhập sai datetime hay j khác
			if(!empty($obj_CI_DB_mysqli_result)) $result_array = $obj_CI_DB_mysqli_result->result_array();			

			if( empty($result_array) )
				$this->data['talktimeTable'] = FALSE;		// ở vị trí này ko return FALSE được, vì nó ko load đc các hàm bên dưới sẽ làm trắng trang, vì vậy ta set gtrị cho nó để qua bên view ktra
			else
			{
				// echo htmlentities(json_encode($result_array)); cdie('test');
				$this->data['talktimeTable'] = $this->_generateTable($obj_CI_DB_mysqli_result);
				$this->data['result_array_talktime'] = serialize($result_array);
				// $this->data['result_array_talktime'] = json_encode(($result_array));
			}
		}

		$extensions = $this->getExtens();
		if( !$extensions )
			cdie('Lỗi : not extensions at '.__METHOD__);
		else
			$this->data['extensions'] = $extensions;

		$this->load->view(config_item('frontEnd'), $this->data);
	}

	/**
	 * generate table from object CI_DB_mysqli_result
	 *
	 * @param object 	not array or 
	 * @return string 
	 **/
	private function _generateTable($queryData, $id = 'tblGenerate')
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

	/**
	 * get ajax to export excel
	 *
	 * @param string 	string form serialize array
	 * 
	 **/
	public function export_excel()
	{
		if(!$this->input->is_ajax_request())
			show_404();

		// var_dump($_POST);
		$dataExport = $this->input->post('dataExport');
		$dataExport = unserialize($dataExport);
		// $dataExport = ['0'=>'a', '1'=>'b'];
		if(!is_array($dataExport) OR empty($dataExport))
			cdie('test');

		$this->load->library('excel');
		// read data to active sheet
		$this->excel->getActiveSheet()->fromArray($dataExport);		
		$filename = APPPATH."../public/files/cdr_{$this->name}.xls";
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Type: application/force-download');
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

		// $objWriter->save('php://output');	// dùng cái này nếu gọi từ link a hay enter từ web để xuất ra luôn		
		$objWriter->save($filename);	// save thành file ở 1 đường dẩn đâu đó, sau đó trên client gọi đến đường dẩn đó bằng window.open
		
		// echo $filename;					// có thể dùng console.log(response) để in ra đường dẩn bên dưới debug
	}






	public function test01()
	{
		$list = $this->getLast10();
		if($list)
			cpre($list);
		else
			echo 'Lỗi khi lấy danh sách 10 cuộc gọi cuối cùng.';
	}

	public function test02()
	{
		echo 'name of pbx : ', $this->name;
	}

	public function test03()
	{
		$this->data['title'] = 'test03 - for getExten';
		$this->data['subView'] = $this->name.'/test03';

		$list = $this->getExtens();
		if(!$list)
			cdie('Lỗi : ko có extensions at '.__METHOD__);
		else
			$this->data['extensions'] = $list;


		$this->load->view(config_item('frontEnd'), $this->data);
	}

	public function phpexcel()
	{
		$this->load->library('excel');

		$file = APPPATH.'/files/test.xlsx';
		$this->excel->setActiveSheetIndex(0);

		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Users list');

		// get list
		$list = $this->getLast10(TRUE);

		// read data to active sheet
		$this->excel->getActiveSheet()->fromArray($list);

		$filename='get_last_10.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

		$objWriter->save('php://output');

		echo 'local/phpexcel';
	}

}