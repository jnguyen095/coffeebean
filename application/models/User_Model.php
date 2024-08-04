<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/15/2017
 * Time: 2:50 PM
 */
class User_Model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

	}

	function getUserById($id)
	{
		$sql = "select * from us3r where Us3rID = ". $id;
		$query = $this->db->query($sql);
		return $query->row();
	}

	function checkExistUserName($userName)
	{
		$this->db->where('UserName', $userName);
		$query = $this->db->get('us3r');
		return $query->num_rows();
	}

	function checkExistUserNameAddGroup($userName, $groupId, $userId){
		$this->db->where('UserName', $userName);
		$this->db->where('UserGroupID', $groupId);
		if($userId != null){
			$this->db->where('Us3rID != ', $userId);
		}
		$query = $this->db->get('us3r');
		return $query->num_rows();
	}

	function addNewUser($data, $groupId)
	{
		$newdata = array(
			'FullName' => $data['fullname'],
			'UserName' => $data['username'],
			'Password' => md5($data['password']),
			'Email' => $data['email'],
			'Phone' => $data['phone'],
			'Address' => $data['address'],
			'CreatedDate' => date('Y-m-d H:i:s'),
			'UpdatedDate' => date('Y-m-d H:i:s'),
			'Status' => $data['status'],
			'UserGroupID' => $groupId,
			'AvailableMoney' => 0,
			'DepositedMoney' => 0,
			'SpentMoney' => 0,
			'StandardPost' => 0,
			'TotalPost' => 0
		);
		$this->db->insert('us3r', $newdata);
	}

	function updateExistingUser($userID, $data)
	{
		$newdata = array(
			'FullName' => $data['fullname'],
			'UserName' => $data['username'],
			'Email' => $data['email'],
			'Phone' => $data['phone'],
			'Address' => $data['address'],
			'UpdatedDate' => date('Y-m-d H:i:s'),
			'UserGroupID' => $data['usergroup'],
			'Status' => $data['status'],
		);
		if(isset($data['password']) && $data['password'] != ""){
			$newdata['Password'] = md5($data['password']);
		}
		$this->db->where('Us3rID', $userID);
		$this->db->update('us3r', $newdata);
	}

	function updateUser($data)
	{
		$userId = $data['UserId'];

		$newdata = array(
			'FullName' => $data['txt_fullname'],
			'Email' => $data['txt_email'],
			'Phone' => $data['txt_phone'],
			'Address' => $data['txt_address'],
			'UpdatedDate' => date('Y-m-d H:i:s')
		);
		$this->db->where('Us3rID', $userId);
		$this->db->update('us3r', $newdata);
	}

	function getAllUsers($offset, $limit, $st, $orderField, $orderDirection){
		//$this->output->enable_profiler(TRUE);
		$query = $this->db->select('u.*')
			->from('us3r u')
			//->join('product p', 'u.Us3rID = p.CreatedByID', 'left')
			->or_like('u.FullName', $st)
			->or_like('u.Email', $st)
			->or_like('u.Phone', $st)
			->limit($limit, $offset)
			->group_by('u.Us3rID')
			->order_by($orderField, $orderDirection)
			->get();

		// $query = $this->db->or_like('FullName', $st)->or_like('Email', $st)->or_like('Phone', $st)->limit($limit, $offset)->order_by($orderField, $orderDirection)->get('us3r');
		$result['items'] = $query->result();
		$query = $this->db->or_like('FullName', $st)->or_like('Email', $st)->or_like('Phone', $st)->get('us3r');
		$result['total'] = $query->num_rows();
		return $result;
	}

	function getAllStaff($offset, $limit, $st, $orderField, $orderDirection){
		// $this->output->enable_profiler(TRUE);
		$query = $this->db->select('u.*, ug.GroupName')
			->from('us3r u')
			->join('usergroup ug', 'u.UserGroupID = ug.UserGroupID', 'left')
			// ->where('UserGroupID', USER_GROUP_STAFF)
			->limit($limit, $offset)
			// ->group_by('u.Us3rID')
			->order_by($orderField, $orderDirection)
			->get();

		// $query = $this->db->or_like('FullName', $st)->or_like('Email', $st)->or_like('Phone', $st)->limit($limit, $offset)->order_by($orderField, $orderDirection)->get('us3r');
		$result['items'] = $query->result();
		$query = $this->db->get('us3r');
		$result['total'] = $query->num_rows();
		// print_r($result);
		return $result;
	}

	function changePassword($userId, $newPw){
		$newdata = array(
			'Password' => md5($newPw),
			'UpdatedDate' => date('Y-m-d H:i:s')
		);
		$this->db->where('Us3rID', $userId);
		$this->db->update('us3r', $newdata);
	}

}
