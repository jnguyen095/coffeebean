<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/24/2017
 * Time: 1:19 PM
 */
class Order_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid')){
			redirect('dang-nhap');
		}
		$this->load->model('Product_Model');
		$this->load->model('Category_Model');
		$this->load->model('City_Model');
		$this->load->model('Transfer_Model');
		$this->load->model('CallMeBack_Model');
		$this->load->helper("seo_url");
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper("bootstrap_pagination");
		$this->load->library('pagination');
		$this->load->model('User_Model');
		$this->load->model('MyOrder_Model');
		$this->load->library('cart');
	}

	public function index($page = 0)
	{
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');

		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data = $categories;

		// end file cached

		$userId = $this->session->userdata('loginid');

		$crudaction = $this->input->post("crudaction");
		if($crudaction == DELETE){
			$productId = $this->input->post("productId");
			if($productId != null && $productId > 0) {
				$product = $this->Product_Model->findById($productId);
				$folder = $product->code;
				$upath = 'attachments' . DIRECTORY_SEPARATOR .'u'. $userId . DIRECTORY_SEPARATOR. $folder;
				// delete db first
				$this->Product_Model->deleteById($productId);
				if (file_exists($upath)){
					$this->delete_directory($upath);
				}
				$data['message_response'] = 'Xóa tin rao thành công.';
			}
		}else if($crudaction == REFRESH){
			$productId = $this->input->post("productId");
			if($productId != null && $productId > 0) {
				$this->Product_Model->pushPostUp($productId);
				$data['message_response'] = 'Làm mới tin rao thành công.';
			}
		}else if($crudaction == INACTIVE_POST){
			$productId = $this->input->post("productId");
			if($productId != null && $productId > 0) {
				$this->Product_Model->changeStatusPost($productId, INACTIVE);
				$data['message_response'] = 'Đã tạm khóa tin rao.';
			}
		}else if($crudaction == ACTIVE_POST){
			$productId = $this->input->post("productId");
			if($productId != null && $productId > 0) {
				$this->Product_Model->changeStatusPost($productId, ACTIVE);
				$data['message_response'] = 'Tin rao đã mở trạng thái hoạt động.';
			}
		}

		$orders = $this->MyOrder_Model->findByUserId($userId, $page, 10);

		$data['orders'] = $orders['items'];

		$config = pagination();
		$config['base_url'] = base_url('quan-ly-don-hang.html');
		$config['total_rows'] = $orders['total'];
		$config['per_page'] = 10;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('order/list', $data);
	}

	public function transfer(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data = $categories;
		// end file cached

		$userId = $this->session->userdata('loginid');

		$crudaction = $this->input->post("crudaction");
		if($crudaction == UPDATE){
			$processId = $this->input->post("processId");
			if($processId != null && $processId > 0){
				$process = $this->Transfer_Model->findById($processId);
				$loginUser = $this->User_Model->getUserById($userId);
				if($loginUser->AvailableMoney >= $process->Money){
					$this->Product_Model->changeStatusPost($process->ProductID, ACTIVE);
					$this->Transfer_Model->changeStatusProcess($processId, ACTIVE);
					$this->Transfer_Model->updateMeny4User($userId, PAYMENT_WITHDRAW, $process->Money);

					$data['message_response'] = 'Thanh toán thành công, tin rao đang hiển thị.';
				}else{
					$data['error_message'] = 'Số tiền không đủ thanh toán, vui lòng nạp thêm tiền, <a href="'.base_url('/bao-gia-dich-vu.html').'">hướng dẫn nạp tiền</a>.';
				}
			}
		}

		$userId = $this->session->userdata('loginid');
		$data['histories'] = $this->Transfer_Model->findByUserId($userId);
		$this->load->view('post/transfer', $data);
	}

	public function callMeBack($page = 0){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('category');
		$footerMenus = $this->cache->file->get('footer');
		if(!$categories){
			$categories = $this->Category_Model->getCategories();
			$this->cache->file->save('category', $categories, 1440);
		}
		if(!$footerMenus) {
			$footerMenus = $this->City_Model->findByTopProductOfCategoryGroupByCity();
			$this->cache->file->save('footer', $footerMenus, 1440);
		}
		$data = $categories;
		$data['footerMenus'] = $footerMenus;
		// end file cached

		$userId = $this->session->userdata('loginid');
		$crudaction = $this->input->post("crudaction");
		if($crudaction == UPDATE) {
			$callMeBackID = $this->input->post("callMeBackID");
			if ($callMeBackID != null && $callMeBackID > 0) {
				$resolved = 'RESOLVED';
				$this->CallMeBack_Model->updateMessage($callMeBackID, $resolved);
				$data['message_response'] = 'Cập nhật thành công.';
			}
		} else if($crudaction == 'update-all'){
			$resolved = 'RESOLVED';
			$this->CallMeBack_Model->updateAllMessage($userId, $resolved);
			$data['message_response'] = 'Cập nhật thành công.';
		}

		$callmebacks = $this->CallMeBack_Model->findByUserId($userId, $page);
		$data['callmebacks'] = $callmebacks['callmebacks'];

		$config = pagination();
		$config['base_url'] = base_url('yeu-cau-goi-lai.html');
		$config['total_rows'] = $callmebacks['total'];
		$config['per_page'] = 10;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('post/callmeback', $data);
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
}
