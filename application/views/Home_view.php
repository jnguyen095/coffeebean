<!DOCTYPE html>
<html lang = "en">

<head>
	<title>Cà phê rang xay Việt Nam</title>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon.ico')?>">

	<?php $this->load->view('common_header')?>
</head>

<body>

<div class="container">
	<?php $this->load->view('/theme/header')?>

	<div class="row no-margin">
		<div class="search-result col-md-9 no-margin no-padding">

		</div>
		<div class="col-md-9 no-margin no-padding">

		</div>
		<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile">

		</div>
	</div>

	<div class="row">
		<?php
		foreach ($products as $product){?>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="product-thumb transition">
					<div class="image">
						<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><img src="<?=base_url('/img/product/'.$product->Thumb)?>" class="img-responsive" ></a>
					</div>
					<div class="caption">
						<h3><a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><?=$product->Title?></a></h3>
						<h4><?=substr_at_middle($product->Brief, 200)?></h4>
					</div>
					<div class="button-group">
						<div class="button-group">
							<button type="button"><p class="price"><?=number_format($product->Price)?>đ</p></button>
							<a productId="<?=$product->ProductID?>" href="#" class="buyableBtn"><i class="glyphicon glyphicon-shopping-cart"></i> Mua Hàng</a>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>

	<?php $this->load->view('/theme/footer')?>

</div>

<!-- SWIPER -->
<script src="<?php echo base_url()?>theme/site/js/swiper-bundle.min.js"></script>
<!-- Custom JS File Link  -->
<script src="<?php echo base_url()?>theme/site/js/script.js"></script>

</body>

</html>
