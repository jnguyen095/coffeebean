<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Giỏ Hàng</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/carousel-custom.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/magnific-popup.css')?>" />
	<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>

</head>

<body>
<div class="container">
<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/')?>"><span itemprop="name">Trang chủ</span></a></li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="mobile-hide"><span itemprop="item"><span itemprop="name">Giỏ hàng</span></span></li>
</ul>
<div class="row">
	<div class="col-lg-12 mobile-hide ">
		<div class="container-fluid text-center border-bottom">
			<div class="progresses">
				<div class="steps step in-progress">
					<span class="font-weight-bold">1</span>
				</div>

				<span class="line"><label class="label1">Xem đơn hàng</label></span>

				<div class="steps">
					<span>2</span>
				</div>

				<span class="line"><label class="label2">Địa chỉ giao hàng</label></span>

				<div class="steps">
					<span>3</span>
				</div>
				<span class="last-line"><label class="label3">Hoàn thành</label></span>

			</div>

		</div>
	</div>

	<div class="col-lg-12">
		<table class="table table-bordered">
			<thead>
			<tr>
				<td class="text-center">Hình ảnh</td>
				<td class="text-left">Tên sản phẩm</td>
				<td class="text-left">Số lượng</td>
				<td class="text-right">Đơn Giá</td>
				<td class="text-right">Tổng cộng</td>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($this->cart->contents() as $item){?>
				<tr>
					<td class="text-center">
						<a href="<?=base_url().seo_url($item['name']).'-p'.$item['id']?>.html">
							<img src="<?=base_url($item['image'])?>" alt="<?=$item['name']?>" title="<?=$item['name']?>" class="img-thumbnail">
						</a>
					</td>
					<td class="text-left">
						<a href="<?=base_url().seo_url($item['name']).'-p'.$item['id']?>.html"><?=$item['name']?></a>
						<?php if($this->cart->has_options($item['rowid']) == TRUE){
							echo "<br>";
							foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
								$i = 1;
								foreach ($option_value as $k => $v){ ?>
									<i><small><?=$v?></small></i>
									<?=$i == 1 ? ':' : ''?>
									<?php
									$i++;
								}
								echo "</br>";
							}
						}?>

					</td>
					<td class="text-left">
						<input type="text" name="quantity[<?=$item['rowid']?>]" value="<?=$item['qty']?>" size="1" class="form-control">
					</td>
					<td class="text-right"><?=number_format($item['price'])?></td>
					<td class="text-right"><?=number_format($item['price'] * $item['qty'])?></td>
				</tr>
			<?php } ?>
			<tr>
				<td class="text-right" colspan="4">Phí giao hàng</td>
				<td class="text-right">-</td>
			</tr>
			<tr>
				<td class="text-right" colspan="4">Tổng cộng</td>
				<td class="text-right"><?=number_format($this->cart->total())?>(VNĐ)</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="col-lg-12 text-right margin-bottom-20">
		<a class="btn btn-primary" href="<?=base_url('/check-out/address.html')?>">Tiếp Theo <i class="glyphicon glyphicon-menu-right"></i> </a>
	</div>
</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>

</div>

<?php $this->load->view('/theme/footer')?>

<script type="text/javascript">
	$(document).ready(function() {

	});
</script>

</body>

</html>
