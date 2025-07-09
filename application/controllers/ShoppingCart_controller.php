<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/7/2023
 * Time: 3:19 PM
 */

class ShoppingCart_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->helper("seo_url");
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->helper("my_date");
		$this->load->helper('form');
		$this->load->model('City_Model');
		$this->load->model('User_Model');
		$this->load->model('District_Model');
		$this->load->model('Ward_Model');
		$this->load->model('MyOrder_Model');
		$this->load->model('OrderShipping_Model');
		$this->load->helper('my_email');
	}

	public function checkOut(){
		$categories = $this->Category_Model->getActiveCategories();
		$data = $categories;
		$this->load->view('cart/Cart_detail', $data);
	}

	public function review(){
		$shippingAddr = $this->session->userdata("shippingAddr");
		$crudaction = $this->input->post('crudaction');
		if($crudaction == 'insert'){
			$note = $this->input->post("note");
			$payment = $this->input->post("payment");
			// order
			$loginID = $this->session->userdata('loginid');
			$newOrder = [];
			$newOrder['UserID'] = $loginID;
			$newOrder['Status'] = ORDER_STATUS_NEW;
			// $newOrder['ShippingFee'] = 12000;
			$newOrder['TotalPrice'] = $this->cart->total();
			$newOrder['TotalItems'] = $this->cart->total_items();
			$newOrder['Note'] = $note;
			$newOrder['Payment'] = $payment;
			$newOrder['CreatedDate'] = date('Y-m-d H:i:s');
			$newOrder['UpdatedDate'] = date('Y-m-d H:i:s');
			$newOrder['CreatedBy'] = $loginID;
			$newOrder['UpdatedBy'] = $loginID;
			$newOrder['Code'] = $this->MyOrder_Model->getNewOrderCode();

			// order items
			$orderItems = [];
			foreach ($this->cart->contents() as $item){
				$options = [];
				// property
				if($this->cart->has_options($item['rowid']) == TRUE) {
					foreach ($this->cart->product_options($item['rowid']) as $option_attr => $option_val) {
						$option = [];
						$option[$option_val['key']] = $option_val['attr'];
						array_push($options, $option);
					}
				}

				$orderItem = array(
					'ProductID' => $item['id'],
					'Price' => $item['price'],
					'Quantity' => $item['qty'],
					'Options' => $options
				);
				array_push($orderItems, $orderItem);
			}

			// shipping
			$shippingInfo = array(
				'Receiver' => $shippingAddr['txt_receiver'],
				'Phone' => $shippingAddr['txt_phone'],
				'CityID' => $shippingAddr['txt_city'],
				'DistrictID' => $shippingAddr['txt_district'],
				'WardID' => $shippingAddr['txt_ward'],
				'Street' => $shippingAddr['street']
			);

			// tracking
			$user = $this->User_Model->getUserById($loginID);
			//print_r($user);
			$orderTracking = array(
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => $user->FullName. ' tạo đơn hàng' . (isset($note) && strlen($note) > 0 ? ' với ghi chú: <b>'. $note .'</b>' : '')
			);

			$data['orderId'] = $this->MyOrder_Model->createOrder($newOrder, $orderItems, $shippingInfo, $orderTracking);

			// send email to inform customer
			$customerEmail = $user->Email;
			if($customerEmail != null && strlen($customerEmail) > 0){
				my_send_email($customerEmail,APP_DOMAIN . " - Đặt hàng thành công", "<p>Bạn vừa đặt hàng thành công tại: " . APP_DOMAIN . ", mã đơn hàng: <b>" . $newOrder['Code'] . "</b></p><p>Theo dõi đơn hàng tại đây: " . APP_DOMAIN . "/don-hang-". $data['orderId']."html</p>" );
			}

			//return;
			redirect('/check-out/success?orderId=' . $data['orderId']);
		}
		$categories = $this->Category_Model->getActiveCategories();
		$data = $categories;
		$data['txt_receiver'] = $shippingAddr['txt_receiver'];
		$data['txt_phone'] = $shippingAddr['txt_phone'];
		$data['city'] = $this->City_Model->findById($shippingAddr['txt_city']);
		$data['district'] = $this->District_Model->findById($shippingAddr['txt_district']);
		$data['ward'] = $this->Ward_Model->findById($shippingAddr['txt_ward']);
		$data['street'] = $shippingAddr['street'];
		$this->load->view('cart/Cart_review', $data);
	}

	public function success(){
		$this->cart->destroy();
		$this->session->set_userdata("shippingAddr", []);
		$categories = $this->Category_Model->getActiveCategories();
		$data = $categories;
		$this->load->view('cart/Cart_success', $data);
	}

	public function shippingAddress(){
		$categories = $this->Category_Model->getActiveCategories();
		$data = $categories;
		$crudaction = $this->input->post('crudaction');
		if($crudaction == 'insert'){
			$data['txt_receiver'] = $this->input->post("txt_receiver");
			$data['txt_phone'] = $this->input->post("txt_phone");
			$data['txt_city'] = $this->input->post("txt_city");
			$data['txt_district'] = $this->input->post("txt_district");
			$data['txt_ward'] = $this->input->post("txt_ward");
			$data['street'] = $this->input->post("txt_street");
			$this->form_validation->set_rules("txt_receiver", "Người nhận hàng", "trim|required");
			$this->form_validation->set_rules("txt_phone", "Số điện thoại", "trim|required");
			$this->form_validation->set_rules("txt_city", "Thành phố", "numeric|required");
			$this->form_validation->set_rules("txt_district", "Quận", "numeric|required");
			$this->form_validation->set_rules("txt_ward", "Phường", "numeric|required");
			$this->form_validation->set_rules("txt_street", "Đường", "required");
			$validateResult = $this->form_validation->run();
			if($validateResult == TRUE){
				$shippingAddr = array(
					'txt_receiver' => $data['txt_receiver'],
					'txt_phone' => $data['txt_phone'],
					'txt_city' => $data['txt_city'],
					'txt_district' => $data['txt_district'],
					'txt_ward' => $data['txt_ward'],
					'street' => $data['street'],
				);
				$this->session->set_userdata("shippingAddr", $shippingAddr);
				redirect('check-out/review');
			}
		} else{
			$shippingAddr = $this->session->userdata("shippingAddr");
			if($shippingAddr != null){
				$data['txt_receiver'] = $shippingAddr['txt_receiver'];
				$data['txt_phone'] = $shippingAddr['txt_phone'];
				$data['txt_city'] = $shippingAddr['txt_city'];
				$data['txt_district'] = $shippingAddr['txt_district'];
				$data['txt_ward'] = $shippingAddr['txt_ward'];
				$data['street'] = $shippingAddr['street'];
			} else {
				//get latest shipping address from last order
				$loginID = $this->session->userdata('loginid');
				if($loginID != null){
					$shippingAddr = $this->OrderShipping_Model->getLatestShippingAddr($loginID);
					if($shippingAddr != null){
						$data['txt_receiver'] = $shippingAddr->Receiver;
						$data['txt_phone'] = $shippingAddr->Phone;
						$data['txt_city'] = $shippingAddr->CityID;
						$data['txt_district'] = $shippingAddr->DistrictID;
						$data['txt_ward'] = $shippingAddr->WardID;
						$data['street'] = $shippingAddr->Street;
					}
				}
			}

		}

		$cities = $this->City_Model->getAllActive();
		$data['cities'] = $cities;
		if(isset($data['txt_city']) && $data['txt_city'] != null){
			$districts = $this->District_Model->findByCityId($data['txt_city']);
			$data['districts'] = $districts;
		}
		if(isset($data['txt_district']) && $data['txt_district'] != null){
			$wards = $this->Ward_Model->findByDistrictId($data['txt_district']);
			$data['wards'] = $wards;
		}
		$this->load->view('cart/Cart_address', $data);
	}

	public function addItemToCart(){
		$productId = $_POST['productId'];
		$qty = $_POST['qty'];
		$options = isset($_POST['options']) ? $_POST['options'] : [];
		$product = $this->Product_Model->findById($productId);
		$price = $product->Price;
		$data = array(
			'id' => $productId,
			'qty' => $qty,
			'price' => $price,
			'image' => $product->Thumb,
			'options' => $options,
			'name' => $product->Title
		);
		$this->cart->insert($data);
		echo $this->reloadHeadCart();
	}

	public function removeItemToCart()
	{
		$rowid = $_POST['rowid'];
		$this->cart->update(array('rowid' => $rowid, 'qty' => 0));
		echo $this->reloadHeadCart();
	}

	public function reloadHeadCart()
	{
		$html = '<i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;'.$this->cart->total_items().' sản phẩm '.number_format($this->cart->total()).'đ';
		$html .= ' <span class="caret"></span>';
		return $html;
	}

	public function reloadMiniCart()
	{
		$html = '<li>
					<a>
						<table class="table table-bordered table-responsive">
							<tr class="bg-success">
								<td>Sản phẩm</td>
								<td>SL</td>
								<td>Thành tiền</td>
								<td>Xóa</td>
							</tr>';
							foreach ($this->cart->contents() as $item){
								$html .= '<tr>';
								$html .= '<td>' . substr_at_middle($item['name'], 120);
								// property
								if($this->cart->has_options($item['rowid']) == TRUE){
									$html .= '<br/>';
									foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
										$i = 1;
										foreach ($option_value as $k => $v){
											$html .= '<i>'.$v . '</i>';
											$html .= $i == 1 ? ':' : '';
											$i++;
										}
										$html .= '<br/>';
									}
								}
								//
								$html .= '</td>';
								$html .= '<td class="text-center">' . $item['qty'] .'</td>';
								$html .= '<td class="text-right">'. number_format($item['price']) .  '</td>';
								$html .= '<td><a class="remove-cart-item glyphicon glyphicon-remove-circle text-red" rowid="'. $item['rowid'] .'" style="color: #ff0000"></a></td>';
								$html .= '</tr>';
							}
							$html .= '<tr>';
							if(count($this->cart->contents()) > 0){
								$html .='<td colspan="4" class="text-right"><a href="'.base_url('/check-out.html'). '" class="btn-primary btn-sm">Đặt Hàng</a></td>';
							} else {
								$html .='<td colspan="4" class="text-center"><i>Chưa có sản phẩm!</i></td>';
							}
							$html .= '</tr>';
					$html .= '</table>';
					$html .= '</a>';
					$html .= '</li>';

		echo $html;
	}

}
