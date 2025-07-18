<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class Quotation_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function save($data){
		$quote = array(
			"Code" => $this->getNewQuotationCode(),
			"Name" => $data['name'],
			"Phone" => $data['phone'],
			"Email" => $data['email'],
			"Address" => $data['address'],
			"Note" => $data['note'],
			"Status" => ACTIVE,
			"RequestedDate" => date('Y-m-d H:i:s'),
			"ShippingFee" => 0,
			"Discount" => 0,
			"TotalPrice" => 0
		);
		$this->db->insert('quotation', $quote);
		$quotation_id = $this->db->insert_id();
		// insert quotation detail
		$quoteDetail = $data['products'];
		foreach ($quoteDetail as $item){
			$detail = array(
				"QuotationID" => $quotation_id,
				"ProductID" => $item['ProductID'],
				"Quantity" => $item['Quantity'],
				"Price" => 0,
				"OfferPrice" => 0,
			);
			$this->db->insert('quotationdetail', $detail);
		}

		return $quotation_id;
	}

	private function getNewQuotationCode(){
		$sql = 'select q.Code from quotation q';
		$sql .= ' order by q.RequestedDate desc';
		$sql .= ' limit 1';
		$productCodes = $this->db->query($sql);
		$code = $productCodes->row();
		if($code != null){
			$newCode = (int)str_replace('Q-', '', $code->Code) + 1;
			if($newCode < 10){
				return "Q-0000".$newCode;
			} else if($newCode < 100){
				return "Q-000".$newCode;
			} else if($newCode < 1000){
				return "Q-0".$newCode;
			} else if($newCode < 10000){
				return "Q-".$newCode;
			}
		}else {
			return "Q-00001";
		}
	}

}
