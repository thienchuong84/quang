<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	/**
	 * data class variable
	 *
	 * @param data to transfer data to view
	 * @var string
	 **/
	var $page_data;

	public function __construct()
	{
		parent::__construct();
	}


}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
?>