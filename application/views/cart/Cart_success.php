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
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="mobile-hide"><span itemprop="item"><span itemprop="name"><a itemprop="item" href="<?=base_url('/check-out.html')?>">Giỏ hàng</a></span></span></li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Địa chỉ giao hàng</span></span></li>
</ul>
<div class="row">
	Thành công order

	<div class="col-lg-12 text-right">
		<a class="btn btn-info" href="<?=base_url('/check-out/address.html')?>"><i class="glyphicon glyphicon-menu-left"></i> Trở Lại  </a>
		<button class="btn btn-primary" type="submit">Hoàn Thành <i class="glyphicon glyphicon-menu-right"></i> </button>
	</div>


</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>
<?php $this->load->view('/theme/footer')?>
</div>


</body>

</html>
