<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 10/3/2023
 * Time: 8:51 PM
 */

class Category_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid') && $this->session->userdata('usergroup') != 'ADMIN'){
			redirect('dang-nhap');
		}

		$this->load->library('session');
		$this->load->model('Category_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = $this->Category_Model->getCategories();
		$this->load->view("admin/category/list", $data);
	}

	public function add($categoryId = null)
	{
		$data = $this->Category_Model->getCategories();
		$data['CategoryID'] = $categoryId;
		if ($this->input->post('crudaction') == "insert") {
			$parentID = $this->input->post("txt_parent");
			$data['txt_parent'] = isset($parentID) ? $parentID : null;
			$data['txt_catname'] = $this->input->post("txt_catname");
			$data['ch_status'] = $this->input->post("ch_status") == null ? INACTIVE : ACTIVE;
			$data['index'] = 0;

			//set validations
			$this->form_validation->set_rules("txt_catname", "Tên danh mục", "trim|required");
			$validateResult = $this->form_validation->run();
			if ($validateResult == TRUE) {
				if($this->Category_Model->findByCatName($data['txt_catname'], $data['CategoryID']) == null){
					$dbid = $this->Category_Model->saveOrUpdate($data);
					$data['categoryID'] = $dbid;
					redirect('admin/category/list');
				}else{
					$data['error_message'] = "The Code field must contain a unique value.";
				}
			}
		}
		if($categoryId != null){
			$category = $this->Category_Model->findById($categoryId);
			$data['txt_catname'] = $category->CatName;
			$data['txt_parent'] = $category->ParentID;
			$data['ch_status'] = $category->Active;
		}

		$this->load->view("admin/category/edit", $data);
	}
}
