<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/17/2017
 * Time: 11:27 AM
 */
class Ward_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findByDistrictId($districtId){
		$this->db->where("DistrictID", $districtId);
		$this->db->order_by("WardName","asc");
		$query = $this->db->get("ward");
		return $query->result();
	}

	public function findById($wardId){
		$this->db->where("WardID", $wardId);
		$query = $this->db->get("ward");
		return $query->row();
	}
}
