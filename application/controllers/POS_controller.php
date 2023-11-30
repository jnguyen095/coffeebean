<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 11/24/2023
 * Time: 7:13 PM
 */

class POS_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid')){
			// redirect('dang-nhap');
			$this->session->set_userdata('loginid', 0);
		}
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->model('Direction_Model');
	}

	public function index()
	{
		$data = $this->Product_Model->loadAvailableProducts(0, 10, null, null, null, null);
		$this->load->view('pos/index', $data);
	}
}
