<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 10:25 AM
 */
class UserManagement_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid') && $this->session->userdata('usergroup') != 'ADMIN'){
			redirect('dang-nhap');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('User_Model');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/user/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "CreatedDate";
			$config['orderDirection'] = "DESC";
		}
		$results = $this->User_Model->getAllUsers($config['page'], $config['per_page'], $config['searchFor'], $config['orderField'], $config['orderDirection']);
		$data['users'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/user/list", $data);
	}

	public function staff()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/staff/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "CreatedDate";
			$config['orderDirection'] = "DESC";
		}
		$results = $this->User_Model->getAllStaff($config['page'], $config['per_page'], $config['searchFor'], $config['orderField'], $config['orderDirection']);
		$data['staffs'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/staff/list", $data);
	}

	public function addStaff($staffId = null){
		$data = [];
		if($staffId != null){
			$staff = $this->User_Model->getUserById($staffId);
			$data['staffID'] = $staff->Us3rID;
			$data['txt_fullname'] = $staff->FullName;
			$data['txt_username'] = $staff->UserName;
			$data['txt_password'] = $staff->Password;
			$data['txt_email'] = $staff->Email;
			$data['txt_phone'] = $staff->Phone;
			$data['txt_address'] = $staff->Address;
		}
		if($this->input->post('crudaction') == "insert"){
			$this->form_validation->set_message('txt_fullname', 'Họ tên không được để trống');

			$this->form_validation->set_rules("txt_fullname", "Họ tên", "trim|required");
			$this->form_validation->set_rules("txt_username", "Tên đăng nhập", "trim|required");
			$this->form_validation->set_rules("txt_password", "Mật khẩu", "trim|required");
			$this->form_validation->set_rules("txt_email", "Email", "valid_email");
			$this->form_validation->set_rules('txt_phone', 'Số điện thoại', 'regex_match[/^[0-9]{10,11}$/]'); //{10} for 10 or 11 digits number

			if ($this->form_validation->run() == FALSE)
			{
				//validation fails
				$this->load->view('admin/staff/add', $data);
			}else{
				$fullname = $this->input->post('txt_fullname');
				$username = $this->input->post('txt_username');
				$password = $this->input->post('txt_password');
				$email = $this->input->post('txt_email');
				$phone = $this->input->post('txt_phone');
				$address = $this->input->post('txt_address');

				$count = $this->User_Model->checkExistUserNameAddGroup($username, USER_GROUP_STAFF);
				if($count > 0){
					$data['error_response'] = 'Tên đăng nhập đã tồn tại.';
					$this->load->view('admin/staff/add', $data);
				}else{
					$newdata['fullname'] = $fullname;
					$newdata['username'] = $username;
					$newdata['password'] = $password;
					$newdata['email'] = $email;
					$newdata['phone'] = $phone;
					$newdata['address'] = $address;

					$this->User_Model->addNewUser($newdata, USER_GROUP_STAFF);
					$data['message_response'] = 'Đăng ký thành công';
					redirect('admin/staff/list');
				}
			}
		}

		$this->load->view("admin/staff/add", $data);
	}
}
