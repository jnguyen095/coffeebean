<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 10/3/2023
 * Time: 8:51 PM
 */

class QuotationManagement_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid') && $this->session->userdata('usergroup') != 'ADMIN'){
			redirect('dang-nhap');
		}

		$this->load->library('session');
		$this->load->model('Quotation_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/quote/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "RequestedDate";
			$config['orderDirection'] = "DESC";
		}

		$status = $this->input->get('status');
		$results = $this->Quotation_Model->findAndFilter($config['page'], $config['per_page'], $status, $config['orderField'], $config['orderDirection']);
		$data['quotes'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view("admin/quote/list", $data);
	}

	public function view($quoteId)
	{
		$results = $this->Quotation_Model->findById($quoteId);
		// print_r($results['quote']->Code);
		$this->load->view("admin/quote/view", $results);
	}
}
