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

	public function searchByItems($offset=null, $limit=null)
	{
		$sql = 'select m.*,u.FullName from myorder m inner join us3r u on m.CreatedBy = u.Us3rID';
		$sql .= ' order by date(m.CreatedDate) desc';
		if($offset != null && $limit != null){
			$sql .= ' limit '.$offset.','.$limit;
		}
		$orders = $this->db->query($sql);
		$total = $this->db->count_all_results('myorder');

		$data['items'] = $orders->result();
		$data['total'] = $total;
		return $data;
	}

	public function findByOrderId($orderId)
	{
		$data = [];
		$sql = 'select m.*,u.FullName, u.Phone from myorder m inner join us3r u on m.CreatedBy = u.Us3rID';
		$sql .= ' where m.OrderID = '. $orderId;
		$query = $this->db->query($sql);
		$order = $query->row();

		// order detail
		$query = $this->db->select('od.*, p.Title as ProductName')
			->from('orderdetail od')
			->join('myorder o', 'od.OrderID = o.OrderID')
			->join('product p', 'p.ProductID = od.ProductID')
			->where('od.OrderID', $order->OrderID)
			->get();

		$products = $query->result();

		// order shipping
		$query = $this->db->select('sh.*, c.CityName, d.DistrictName, w.WardName')
			->from('ordershipping sh')
			->join('myorder o', 'o.OrderID = sh.OrderID')
			->join('city c', 'c.CityID = sh.CityID', 'inner')
			->join('district d', 'd.DistrictID = sh.DistrictID', 'inner')
			->join('ward w', 'w.WardID = sh.WardID', 'inner')
			->where('sh.OrderID', $order->OrderID)
			->get();
		$shipping = $query->row();


		$data['order'] = $order;
		$data['products'] = $products;
		$data['shippingAddr'] = $shipping;

		return $data;
	}
}
