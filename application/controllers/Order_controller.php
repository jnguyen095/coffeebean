<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/25/2023
 * Time: 1:39 PM
 */

class Order_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid')){
			redirect('dang-nhap');
		}
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->helper("seo_url");
		$this->load->model('Category_Model');
		$this->load->model('MyOrder_Model');
		$this->load->model('Product_Model');
		$this->load->model('Direction_Model');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
	}

	public function index()
	{
		$searchOrders = $this->MyOrder_Model->searchByItems();
		$orders = $searchOrders['items'];
		$total = $searchOrders['total'];
		$data['orders'] = $orders;
		$config['total_rows'] = $total;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('order/Order_list', $data);
	}

	public function process($orderId)
	{
		$order = $this->MyOrder_Model->findByOrderId($orderId);
		$this->load->view('order/Order_detail', $order);
	}

	public function update($orderId)
	{
		$crudaction = $this->input->post("crudaction");
		if($crudaction == "insert-update"){

		}
		$order = $this->MyOrder_Model->findByOrderId($orderId);
		$this->load->view('order/Order_update', $order);
	}
}
