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
		$this->load->helper("my_date");
		$this->load->helper('form');
	}

	public function checkOut(){
		$categories = $this->Category_Model->getCategories();
		$data = $categories;
		foreach ($this->cart->contents() as $item){

		}
		$this->load->view('cart/Cart_detail', $data);
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
		$html = '<i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;'.$this->cart->total_items().' sản phẩm - '.number_format($this->cart->total()).'đ';
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
										<td colspan="2" class="text-right">Tổng:</td>
										<td class="text-right">'.number_format($this->cart->total()).'</td>
									</tr>';

							$html .= '<tr><td colspan="4" class="text-right"><a href="'.base_url('/check-out.html'). '" class="btn-primary btn-sm">Giỏ Hàng</a> </td></tr>';
					$html .= '</table>';
					$html .= '</a>';
					$html .= '</li>';

		echo $html;
	}

}
