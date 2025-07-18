<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/5/2017
 * Time: 12:58 PM
 */
class Quotation_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('StaticPage_Model');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->model('City_Model');
		$this->load->model('Quotation_Model');
		$this->load->helper("seo_url");
		$this->load->helper('form');
		$this->load->library('cart');
		$this->load->library('form_validation');
		$this->load->helper('my_email');
	}

	// Bao gia quang cao
	public function quote(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;
		// end file cached
		$crudaction = $this->input->post('crudaction');
		if($crudaction == 'request-quotation'){

			$this->form_validation->set_rules("name", "Họ tên", "trim|required");
			$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required|regex_match[/^[0-9]{10,11}$/]'); //{10} for 10 or 11 digits number

			$name = $this->input->post('name');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			$note = $this->input->post('note');
			$data['name'] = $name;
			$data['phone'] = $phone;
			$data['email'] = $email;
			$data['address'] = $address;
			$data['note'] = $note;
			$data['totalProducts'] = 0;
			$data['totalItems'] = 0;
			$products = $this->input->post('products');
			//print_r($products);
			$productMap = [];
			if($products != null && count($products) > 0) {
				$index = 0;
				$totalItems = 0;
				$data['totalProducts'] = count($products);
				foreach ($products as $productID => $qty) {
					$item = array("ProductID" => $productID, "Quantity" => $qty);
					$productIDs[$index++] = $productID;
					$totalItems += $qty;
					array_push($productMap, $item);
				}
				$data['totalItems'] = $totalItems;

			}
			if ($this->form_validation->run()) {
				if($productMap != null && count($productMap) > 0){
					$data['products'] = $productMap;
					$this->Quotation_Model->save($data);
					$data = array();
					$data['name'] = '';
					$data['phone'] = '';
					$data['email'] = '';
					$data['address'] = '';
					$data['note'] = '';
					$data['categories'] = $categories;
					$data['message_response'] = "Đã gửi báo giá thành công, bạn vui lòng đợi chúng tôi sẻ phản hồi qua Đt/Zalo hoặc email";
				} else {
					$data['error_response'] = "Chưa có sản phẩm nào, bạn vui lòng sản phẩm";
				}
			} else if($productMap != null && count($productMap) > 0) {
				$data['products'] = $this->Product_Model->findMoreProductByMapID($productMap);
			}
		}

		$this->load->view("/static/Quote_view", $data);
	}
}
