<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// echo 'Homepage of obaju';
		$this->trangchu();
	}

	public function home_obaju()
	{
		$this->page_data['title'] = "Home";
		$this->page_data['sub_view'] = 'home/home_obaju_view';

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
	}

	public function trangchu()
	{
		$this->page_data['title'] = "Trang Chủ";
		$this->page_data['sub_view'] = 'home/trangchu_view';

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
	}

	public function vechungtoi()
	{
		$this->page_data = array('title' => 'Về Chúng Tôi', 'sub_view' => 'home/vechungtoi_view');

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
		// echo 've chung toi';
	}

	public function timdailyphanphoi()
	{
		$this->page_data = array('title' => 'Tìm Đại Lý Phân Phối', 'sub_view' => 'home/timdailyphanphoi_view');

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
	}

	public function hethongphanphoi()
	{
		$this->page_data = array('title' => 'Hệ Thống Phân Phối', 'sub_view' => 'home/hethongphanphoi_view');

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
	}

	public function lienhe()
	{
		$this->page_data = array('title' => 'Liên Hệ', "sub_view" => 'home/lienhe_view');

		$this->load->view(config_item('obaju_path_view'), $this->page_data);
	}

	public function test01()
	{
		echo obaju_url();
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */