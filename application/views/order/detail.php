<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/9/2017
 * Time: 2:19 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset = "utf-8">
		<title>Nhà Tìm Chủ | Quản Lý Đơn Hàng</title>
		<?php $this->load->view('common_header')?>
		<script src="<?= base_url('/js/createpost.js') ?>"></script>
		<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
		<?php $this->load->view('/common/googleadsense')?>
</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid">
	<?php $this->load->view('/theme/header')?>

	<?php $this->load->view('/common/user-menu')?>

	<div class="container no-padding">
		<div class="row no-margin">
			<div class="col-lg-12 col-sm-12">
				<div>
					<div class="float-left h2title">Quản lý đơn hàng > chi tiết đơn hàng <?=$order->Code?></div>
					<div class="clear-both"></div>
				</div>
				<hr/>

				<?php if(!empty($message_response)){
					echo '<div class="alert alert-success">';
					echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
					echo $message_response;
					echo '</div>';
				}?>

				<!-- content -->
				<div class="col-md-8 no-margin no-padding text-center table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead class="thead-table">
							<tr class="bg-success">
								<th class="text-center">#</th>
								<th>Sản phẩm</th>
								<th class="text-center">SL</th>
								<th class="text-center">Giá</th>
								<th class="text-center">Tiền</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$counter = 1;
							foreach ($products as $item) {
								?>
								<tr>
									<th scope="row"><?=$counter++?>.</th>
									<td class="text-left">
										<a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html" target="_blank"><?=$item->ProductName?></a>
										<?php
										$ops = json_decode($item->Options);
										foreach ($ops as $k=>$v){
											foreach ($v as $k1=>$v1){
												if(!empty($v1)){
													echo "<li>".$k1.": ".$v1."</li>";
												}
											}
										}
										?>
									</td>
									<td><?=number_format($item->Quantity)?></td>
									<td><?=number_format($item->Price)?></td>
									<td><?=number_format(($item->Price) * ($item->Quantity))?></td>
								</tr>
								<?php
							}
						?>
						</tbody>
					</table>



				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-5">Tình trạng:</div>
						<div class="col-md-7"><span class="badge badge-pill alert-success"><?=$order->Status == 'NEW' ? 'Chờ xác nhận' : $order->Status?></span> </div>
					</div>
					<div class="row">
						<div class="col-md-5">Ngày mua hàng:</div>
						<div class="col-md-7"><?=date('d/m/Y H:i', strtotime($order->CreatedDate))?></div>
					</div>
					<div class="row">
						<div class="col-md-5">Phí giao hàng:</div>
						<div class="col-md-7"><?=number_format($order->ShippingFee)?></div>
					</div>
					<div class="row">
						<div class="col-md-5">Tổng:</div>
						<div class="col-md-7"><?=number_format($order->TotalPrice)?> (VNĐ)</div>
					</div>
					<div class="row">
						<div class="col-md-5">Thanh toán:</div>
						<div class="col-md-7"><?=$order->Payment?></div>
					</div>
					<div class="row">
						<div class="col-md-5">Người nhận hàng:</div>
						<div class="col-md-7"><?=$shippingAddr->Receiver?></div>
					</div>
					<div class="row">
						<div class="col-md-5">Số ĐT:</div>
						<div class="col-md-7"><?=$shippingAddr->Phone?></div>
					</div>
					<div class="row">
						<div class="col-md-5">Địa chỉ:</div>
						<div class="col-md-7"><?=$shippingAddr->Street?>, <?=$shippingAddr->WardName?>, <?=$shippingAddr->DistrictName?>, <?=$shippingAddr->CityName?></div>
					</div>
					<div class="row">
						<div class="col-md-5">Ghi chú:</div>
						<div class="col-md-7"><?=empty($order->Note) ? '-' : $order->Note?></div>
					</div>

				</div>
				<!-- end content -->
				<div class="clear-both"></div>
			</div>
		</div>
	</div>

	<?php $this->load->view('/theme/footer')?>
</div>

</body>
</html>
