<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/11/2023
 * Time: 12:20 PM
 */

class MyOrder_Model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	public function createOrder($order, $options, $shippingInfo){
		$this->db->insert('myorder', $order);
		$orderId = $this->db->insert_id();
		// order detail
		foreach ($options as $item){
			$item['OrderID'] = $orderId;
			$this->db->insert('orderdetail', $item);
			$this->db->insert_id();
		}

		// shipping info
		$shippingInfo['OrderID'] = $orderId;
		$this->db->insert('ordershipping', $shippingInfo);
		$this->db->insert_id();

		return $orderId;
	}
}
