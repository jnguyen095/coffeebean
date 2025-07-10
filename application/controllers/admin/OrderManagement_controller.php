<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/25/2023
 * Time: 1:39 PM
 */

class OrderManagement_controller extends CI_Controller
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
		$this->load->model('City_Model');
		$this->load->model('User_Model');
		$this->load->model('District_Model');
		$this->load->model('Ward_Model');
		$this->load->model('OrderShipping_Model');
		$this->load->model('OrderTracking_Model');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/order/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "ModifiedDate";
			$config['orderDirection'] = "DESC";
		}

		$code = $this->input->get('code');
		$phoneNumber = $this->input->get('phoneNumber');
		$searchOrders = $this->MyOrder_Model->searchByItems($code, $phoneNumber, $config['page'], $config['per_page']);
		$orders = $searchOrders['items'];
		$total = $searchOrders['total'];
		$data['orders'] = $orders;

		$config['total_rows'] = $total;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('admin/order/Order_list', $data);
	}

	public function process($orderId)
	{
		$order = $this->MyOrder_Model->findByOrderId($orderId);
		$this->load->view('admin/order/Order_detail', $order);
	}

	public function update($orderId)
	{
		$crudaction = $this->input->post("crudaction");
		if($crudaction == "insert-update"){
			echo 'success';
		}
		$order = $this->MyOrder_Model->findByOrderId($orderId);
		$this->load->view('admin/order/Order_update', $order);
	}

	public function updateShippingInfo(){
		$crudaction = $this->input->post('crudaction');

		if($crudaction == 'insert'){
			$orderId = $this->input->post("orderId");
			$receiver = $this->input->post("txt_receiver");
			$phone = $this->input->post("txt_phone");
			$city = $this->input->post("txt_city");
			$district = $this->input->post("txt_district");
			$ward = $this->input->post("txt_ward");
			$street = $this->input->post("txt_street");

			$shippingInfo = array(
				'Receiver' => $receiver,
				'Phone' => $phone,
				'CityID' => $city,
				'DistrictID' => $district,
				'WardID' => $ward,
				'Street' => $street
			);
			$this->OrderShipping_Model->update($orderId, $shippingInfo);

			// tracking
			$loginID = $this->session->userdata('loginid');
			$user = $this->User_Model->getUserById($loginID);
			$orderTracking = array(
				'OrderID' => $orderId,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => $user->FullName. ' cập nhật thông tin giao hàng'
			);
			$this->OrderTracking_Model->insert($orderTracking);


			echo "success";
		}else{
			$orderId = $this->input->post('orderId');
			$shipping = $this->OrderShipping_Model->findByOrderId($orderId);
			$cities = $this->City_Model->getAllActive();
			$districts = $this->District_Model->findByCityId($shipping->CityID);
			$wards = $this->Ward_Model->findByDistrictId($shipping->DistrictID);

			$data = [];
			$data['shipping'] = $shipping;
			$data['cities'] = $cities;
			$data['wards'] = $wards;
			$data['districts'] = $districts;

			return $this->load->view('admin/order/shipping_update', $data);
		}

	}
}
