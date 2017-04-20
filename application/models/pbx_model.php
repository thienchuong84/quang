<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pbx_model extends MY_Model
{
	public $dataTest = ['test01'=>'chuong', 'test02'=>'binh'];

	private $data = array();

	public function __construct()
	{
		parent::__construct();
	}

	// public function __set($name, $value)
	// {
	// 	$this->data[$name] = $value;
	// }

	// public function __get($name)
	// {
	// 	if(array_key_exists($name, $this->data))
	// 		return $this->data[$name];

	// 	// 1 cach debug cực kì pro
 //        $trace = debug_backtrace();
 //        trigger_error(
 //            'Undefined property via __get(): ' . $name .
 //            ' in ' . $trace[0]['file'] .
 //            ' on line ' . $trace[0]['line'],
 //            E_USER_NOTICE);

 //        return null;		
	// }

	// public function __isset($name)
	// {
	// 	return isset($this->data[$name]);
	// }

	// public function __unset($name)
	// {
	// 	unset($this->data[$name]);
	// }

	public function getLast10_tmp()
	{
		$this->load->database();

		$this->db->select('calldate, src, dst,duration, billsec');
		$this->db->from('cdr');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(10);		

		// $sql = "SELECT * FROM asteriskcdrdb ORDER BY id DESC LIMIT 10";

		$query = $this->db->get();

		$this->db->close();

		if($query)
			return $query->result();

		return FALSE;
	}

	public function getLast10( $namePbx, $tableName = 'cdr' )
	{	
		// kiểm lỗi
		if($namePbx == '')
			cdie('ko biết tên pbx');
		$db = $this->load->database($namePbx, TRUE);

		$db->select( 'calldate, src, dst,duration, billsec' );
		$db->from( $tableName );
		$db->order_by( 'id', 'DESC' );
		$db->limit( 10 );

		// $sql = "SELECT * FROM asteriskcdrdb ORDER BY id DESC LIMIT 10"; $query = $db->query($sql); $query->result();

		$query = $db->get();

		$db->close();

		if($query)
			return $query->result();

		return FALSE;
	}	

	/**
	 * Get extension of pbx from table users of db asterisk
	 *
	 * @param string 	name of pbx to load config mysql
	 * @return mixed 	either query data as object or FALSE
	 **/
	public function getExtens( $namePbx, $dbName = 'asterisk', $tableName = 'users' )
	{
		if( $namePbx == '' )
			cdie('Lỗi : ko biết tên pbx at '.__METHOD__);
		$db = $this->load->database($namePbx, TRUE);

		$db->db_select( $dbName );
		$db->select( 'name, extension' );
		$db->from( $tableName );
		$db->limit( 100 );

		$query = $db->get();
		$db->close();

		if( ! $query )
		{
			cdie('Lỗi query at '.__METHOD__);
			return FALSE;
		}

		// cpre($query->result_array()); cdie(); 	// return [0] => Array
		// cpre($query->result()); cdie();			// return [0] => stdClass Object

		return $query->result();
	}

	/**
	 * undocumented function
	 *
	 * @return object not return array or stdClass. Use to generate table
	 **/
	public function getReportTalkTime( $namePbx, $arrExtens, $startDate, $endDate )
	{
		// vì bên controller đã ktra kỉ rồi, nên bên đây ko cần ktra lại nữa
		$startDate .= ' 00:00:00';
		$endDate .= ' 23:59:59';

		/* Bởi vì đưa lệnh vào query builder thành ra ko cần chuyển nó thành chuỗi  */
		$extens = "";
		if( is_array($arrExtens) )
		{
			foreach ($arrExtens as $value)
				$extens .= $value . ',';

			$extens = substr($extens, 0, strlen($extens)-1);
		}		

		$db = $this->load->database($namePbx, TRUE);



		$sql = "SELECT  obsum.Exten, 
						obsum.Total_Dial_Call, 
						obsum.Total_Time, 
						(obsum.Total_Time DIV obsum.Total_Dial_Call) AS Avg_Time_Call, 
						obsum.Total_Connect_Call, 
						obsum.Total_Wait_Time, 
						obsum.Total_Talk_Time, 
						(obsum.Total_Talk_Time DIV obsum.Total_Connect_Call) AS Avg_ConnectTime_Call 
						FROM ";
		$sql .= "	(SELECT src AS Exten, 
						COUNT(id) AS Total_Dial_Call, 
						SUM(duration) AS Total_Time, 
						SUM(duration-billsec) AS Total_Wait_Time, 
						SUM(billsec) AS Total_Talk_Time, 
						SUM(CASE WHEN disposition = 'ANSWERED' THEN 1 ELSE 0 END) AS Total_Connect_Call 
					FROM cdr 
					WHERE src IN ({$extens}) 
						AND LENGTH(dst) > 7
						AND calldate >= '{$startDate}' 
						AND calldate <= '{$endDate}' GROUP BY src) obsum";						
		
		// cdie($sql);
		// cdie($db->get_compiled_select());	// Debug : show mysql command with query builder

		$query = $db->query($sql);
		// $query = $db->get();		// bới simple $db->query($sql) ở trên thì ko được dùng $db->get ở đây
		$db->close();

		// var_dump($query->row()); cdie('test gtri $query');	// khi ko có row nào nó trả về NULL, vì vậy ta có thể dùng isset hoặc === FALSE
		if($query->row() === FALSE)
			return FALSE;


		// return $query->result();
		return $query;		// vì cần sử dụng table library của ci nên ta ko cần return $query->result() như trên
		// return $this->dataTest;
	}

	/**
	 * Get talktime follow GSM, first use in pbx5/gsm. Create at 7/12/16
	 *
	 * @param string 	namePbx to load config db
	 * @param array 	$arrAllProjects will get All porject for case when
	 * @param array 	$arrProjects will get prefix dial of project
	 * @param string 	startDate, andDate follow Y-m-d
	 * @return object not arrat or stdClass. Used to generate table
	 **/
	public function getReportTalkTimeGSM($namePbx, $arrAllProjects, $arrProjects, $gsm, $startDate, $endDate, $table = 'cdr')
	{
		$startDate .= ' 00:00:00';
		$endDate .= ' 23:59:59';

		$case_when = "CASE LEFT(dst,4)";
		foreach ($arrAllProjects as $key => $value) 
			$case_when .= " WHEN '{$value}' THEN '".$key."'";
		$case_when .= " ELSE 'Other' END AS Project";

		$where_projects = "";
		if($gsm == "vinaMobi")
		{
			foreach ($arrProjects as $value) 
				$where_projects .= " dst REGEXP '{$value}(088|089|012|090|091|093|094)\d*' OR";
				// $where_projects .= " dst REGEXP '".$value."(088|089|012|09[0134])\d*' OR";
		}
		else
		{
			foreach ($arrProjects as $value) 
				$where_projects .= " dst REGEXP '{$value}(086|016|09[678])\d*' OR";			
		}
		$where_projects = trim(substr($where_projects, 0, strlen($where_projects)-2));

		$sql = "SELECT {$case_when}, ROUND((SUM(billsec)/60),0) AS Talktime
				FROM {$table}
				WHERE ( calldate >= '".$startDate."' && calldate <= '".$endDate."') AND ({$where_projects}) GROUP BY Project";

		$db = $this->load->database($namePbx, TRUE);
		$query = $db->query($sql);
		$db->close();

		if($query->row() === FALSE)
			return FALSE;

		return $query;
	}



}




/*
		// $db->select('src AS Exten, COUNT(id) AS Total_Dial_Call, SUM(duration) AS Total_Time, SUM(duration-billsec) AS Total_Wait_Time, SUM(billsec) AS Total_Talk_Time, SUM(CASE WHEN disposition = "ANSWERED" THEN 1 ELSE 0 END) AS Total_Connect_Call');
		// $db->from('cdr');
		// $db->where_in('src', $arrExtens);
		// $db->where('calldate >', $startDate);
		// $db->where('calldate <', $endDate);
		// $db->group_by('src');	
*/


?>