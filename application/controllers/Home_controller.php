<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 11:17 AM
 */
class Home_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->model('City_Model');
		$this->load->model('Brand_Model');
		$this->load->helper("seo_url");
		$this->load->helper('text');
		$this->load->helper("my_date");
		$this->load->model('News_Model');
		$this->load->model('Cooperate_Model');
		$this->load->model('SampleHouse_Model');
		$this->load->model('Banner_Model');
		$this->load->helper('form');

	}

	public function index() {
		$categories = $this->Category_Model->getCategories();
		$data = $categories;
		$newProducts = $this->Product_Model->topNewProducts(20);

		$data['products'] = $newProducts;
		$this->load->helper('url');
		$this->load->view('Home_view', $data);
	}

}
