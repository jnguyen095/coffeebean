<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 10:25 AM
 */
class ProductManagement_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid') && $this->session->userdata('usergroup') != 'ADMIN'){
			redirect('dang-nhap');
		}

		$this->load->library('session');
		$this->load->model('Product_Model');
		$this->load->model('Category_Model');
		$this->load->model('User_Model');
		$this->load->model('Unit_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$crudaction = $this->input->post("crudaction");
		if($crudaction == DELETE){
			$productId = $this->input->post("productId");
			$this->deleteProductById($productId);
			$data['message_response'] = 'Xóa tin rao thành công.';
		}else if($crudaction == "delete-multiple"){
			$productIds = $this->input->post("checkList");
			foreach ($productIds as $productId){
				$this->deleteProductById($productId);
			}
			$data['message_response'] = 'Xóa tin rao thành công.';
		}
		$config = pagination($this);
		$config['base_url'] = base_url('admin/product/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "ModifiedDate";
			$config['orderDirection'] = "DESC";
		}
		$postFromDate = $this->input->get('fromDate');
		$postToDate = $this->input->get('toDate');
		$phoneNumber = $this->input->get('phoneNumber');
		$createdById = $this->input->get('createdById');
		$hasAuthor = $this->input->get('hasAuthor');
		$status = $this->input->get('status');
		$code = $this->input->get('code');
		if($phoneNumber != null && count($phoneNumber) > 0){
			$results = $this->Product_Model->findByPhoneNumber($config['page'], $config['per_page'], $phoneNumber);
			$data['products'] = $results['items'];
			$config['total_rows'] = $results['total'];
		}else {
			$results = $this->Product_Model->findAndFilter($config['page'], $config['per_page'], $config['searchFor'], $postFromDate, $postToDate, $createdById, $hasAuthor, $code, $status, $config['orderField'], $config['orderDirection']);
			$data['products'] = $results['items'];
			$config['total_rows'] = $results['total'];
		}
		if($createdById != null){
			$user = $this->User_Model->getUserById($createdById);
			$data['user'] = $user;
		}

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/product/list", $data);
	}

	public function edit($productId = null){
		$categories = $this->Category_Model->getCategories();
		if($productId == null){
			$productId = $this->input->post('ProductID');
		}
		$data = $categories;
		if($this->input->post('crudaction') == "insert"){
			$this->form_validation->set_rules("sl_category", "Danh mục", "trim|required");
			$this->form_validation->set_rules("Title", "Tên sản phẩm", "trim|required");
			$this->form_validation->set_rules("Price", "Gián bán", "trim|required");
			if($this->input->post('Price') != null) {
				$this->form_validation->set_rules('Price', 'Giá bán', 'regex_match[/^\d+(\.\d{2})?$/]'); //{10} for 10 or 11 digits number
			}
			if ($this->form_validation->run() == FALSE)
			{
				$data['message_response'] = "Dữ liệu chưa đúng, kiểm tra lại";
				$this->load->view('admin/product/edit', $data);
			}else{
				$data['sl_category'] = $this->input->post('sl_category');
				$data['Title'] = $this->input->post('Title');
				$data['Price'] = $this->input->post('Price');
				$data['Brief'] = $this->input->post('Brief');
				$data['Status'] = $this->input->post('Status');
				$data['CreatedByID'] = $this->session->userdata('loginid');
				$data['ProductID'] = $productId;
				$count = $this->Product_Model->checkNewProductIsValid($data['sl_category'], $data['Title'], $productId);
				if($count < 1){
					$preImg = $this->input->post("txt_image");
					$img = $this->uploadImage();
					if($img == null && $preImg != null){
						$img = $preImg;
					}
					$data['txt_image'] = $img;

					$this->Product_Model->addOrUpdateProduct($data);
					$data['message_response'] = "Thêm mới sản phẩm thành công";
					redirect('admin/product/list');
				}else{
					$data['message_response'] = "Sản phẩm này đã tồn tại, vui lòng chọn tên sản phẩm hoặc danh mục khác";
				}


			}
		}else if($productId != null){
			$product = $this->Product_Model->findById($productId);
			$data['product'] = $product;
		}
		$this->load->view("admin/product/edit", $data);
	}

	private function deleteProductById($productId){
		if($productId != null && $productId > 0) {
			//$product = $this->Product_Model->findById($productId);
			//$folder = $product->code;
			//$upath = 'attachments' . DIRECTORY_SEPARATOR .'u'. $product->CreatedByID . DIRECTORY_SEPARATOR. $folder;
			// delete db first
			$this->Product_Model->deleteById($productId);
			//if (file_exists($upath)){
				//$this->delete_directory($upath);
			//}
		}
	}

	public function pushPostUp(){
		$productId = $this->input->post('productId');
		$this->Product_Model->pushPostUp($productId);
		echo json_encode('success');
	}

	private function delete_directory($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				else
					delete_directory($dirname.'/'.$file);
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

	private function uploadImage(){
		if(!empty($this->input->post("txt_image"))){
			return $this->input->post("txt_image");
		}else{
			$this->allowed_img_types = $this->config->item('allowed_img_types');
			$upath = 'img' . DIRECTORY_SEPARATOR .'product'. DIRECTORY_SEPARATOR;

			if (!file_exists($upath)) {
				mkdir($upath, 0777, true);
			}

			$config['upload_path'] = $upath;
			$config['allowed_types'] = $this->allowed_img_types;
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('txt_image')) {
				log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
			}
			$img = $this->upload->data();
			return $img['file_name'];
		}
	}
}
