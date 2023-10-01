<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/24/2017
 * Time: 9:18 AM
 */
class Direction_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findAll(){
		$this->db->order_by("DirectionName","asc");
		$query = $this->db->get("direction");
		return $query->result();
	}

	public function findById($directionId){
		$this->db->where("DirectionID", $directionId);
		$query = $this->db->get("direction");
		return $query->row();
	}
}
