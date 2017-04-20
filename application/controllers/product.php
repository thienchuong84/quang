<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->category();
	}

	public function category()
	{
		$this->page_data['title'] = "Sản Phẩm";
		$this->page_data['sub_view'] = "product/category_view";

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
	}
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */
?>