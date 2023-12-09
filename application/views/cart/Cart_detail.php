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
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Giỏ hàng</span></span></li>
</ul>
<div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered">
			<thead>
			<tr>
				<td class="text-center">Hình ảnh</td>
				<td class="text-left">Tên sản phẩm</td>
				<td class="text-left">Mã hàng</td>
				<td class="text-left">Số lượng</td>
				<td class="text-right">Đơn Giá</td>
				<td class="text-right">Tổng cộng</td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td class="text-center">                  <a href="https://bansidolot.vn/vay-ngu-th-i-950-mau-den"><img src="https://bansidolot.vn/image/cache/catalog/DO LOT THAI LAN/VAY NGU/950/z4907393418390_c0c060463464a2fa033080f04aabd529-80x80.jpg" alt="Váy Ngủ Thái 950 - Màu Đen" title="Váy Ngủ Thái 950 - Màu Đen" class="img-thumbnail"></a>
				</td>
				<td class="text-left"><a href="https://bansidolot.vn/vay-ngu-th-i-950-mau-den">Váy Ngủ Thái 950 - Màu Đen</a>
					<br>
					<small>Size: FreeSize</small>
				</td>
				<td class="text-left">VS9502</td>
				<td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
						<input type="text" name="quantity[YToyOntzOjEwOiJwcm9kdWN0X2lkIjtpOjI0NDk7czo2OiJvcHRpb24iO2E6MTp7aToyNjQ4O3M6NDoiNzYyMSI7fX0=]" value="1" size="1" class="form-control">
						<span class="input-group-btn">
				<button type="submit" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Update"><i class="fa fa-refresh"></i></button>
				<button type="button" data-toggle="tooltip" title="" class="btn btn-danger" onclick="cart.remove('YToyOntzOjEwOiJwcm9kdWN0X2lkIjtpOjI0NDk7czo2OiJvcHRpb24iO2E6MTp7aToyNjQ4O3M6NDoiNzYyMSI7fX0=');" data-original-title="Remove"><i class="fa fa-times-circle"></i></button></span></div></td>
				<td class="text-right">76,000 VNĐ</td>
				<td class="text-right">76,000 VNĐ</td>
			</tr>
			</tbody>
		</table>
	</div>

</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>
<?php $this->load->view('/theme/footer')?>
</div>

<script type="text/javascript">
	$(document).ready(function() {

	});
</script>

</body>

</html>
