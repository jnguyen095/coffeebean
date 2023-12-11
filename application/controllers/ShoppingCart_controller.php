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
		$this->load->model('District_Model');
		$this->load->model('Ward_Model');
	}

	public function checkOut(){
		$categories = $this->Category_Model->getCategories();
		$data = $categories;
		$this->load->view('cart/Cart_detail', $data);
	}

	public function review(){
		$categories = $this->Category_Model->getCategories();
		$data = $categories;
		$shippingAddr = $this->session->userdata("shippingAddr");
		$crudaction = $this->input->post('crudaction');
		if($crudaction == 'insert'){

		}
		$data['txt_receiver'] = $shippingAddr['txt_receiver'];
		$data['txt_phone'] = $shippingAddr['txt_phone'];
		$data['city'] = $this->City_Model->findById($shippingAddr['txt_city']);
		$data['district'] = $this->District_Model->findById($shippingAddr['txt_district']);
		$data['ward'] = $this->Ward_Model->findById($shippingAddr['txt_ward']);
		$data['street'] = $shippingAddr['street'];
		$this->load->view('cart/Cart_review', $data);
	}

	public function shippingAddress(){
		$categories = $this->Category_Model->getCategories();
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
		$html = '<i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;'.$this->cart->total_items().' sản phẩm - '.number_format($this->cart->total() + ($this->cart->total_items() > 0 ? 12000 : 0)).'đ';
		$html .= ' <span class="caret"></span>';
		return $html;
	}

	public function reloadMiniCart()
	{
		$html = '<li>
					<a>
						<table class="table table-bordered table-responsive">
							<tr>
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
							$html .= '<tr>
										<td colspan="2" class="text-right">Phí giao hàng</td>
										<td class="text-right">'.number_format(12000).'</td>
									</tr>';
							$html .= '<tr>
										<td colspan="2" class="text-right">Tổng:</td>
										<td class="text-right">'.number_format($this->cart->total() + 12000).'</td>
									</tr>';

							$html .= '<tr><td colspan="4" class="text-right"><a href="'.base_url('/check-out.html'). '" class="btn-primary btn-sm">Giỏ Hàng</a> </td></tr>';
					$html .= '</table>';
					$html .= '</a>';
					$html .= '</li>';

		echo $html;
	}

}
