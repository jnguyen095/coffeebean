<!DOCTYPE html>
<html lang = "en">

<head>
	<title>Vân Anh Shop - Đồ Lót Giá Tốt</title>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon.ico')?>">

	<?php $this->load->view('common_header')?>
</head>

<body>

<div class="container-fluid no-padding-left no-padding-right">
	<?php $this->load->view('/theme/header')?>

	<div class="container-fluid no-padding-left no-padding-right">
		<div class="row no-margin">
			<div id='carousel-custom' class='carousel slide hot-product fix-height-standard' data-interval="7000" data-ride='carousel'>
				<div class='carousel-outer'>
					<!-- Wrapper for slides -->
					<div class='carousel-inner'>
						<?php
						$counter = 0;
						foreach ($topBanners as $banner) {
							?>
							<div class="item <?=$counter++ == 0 ? 'active' : ''?>">
								<div>
									<a href="<?=base_url('/redirect-adv-' . $banner->BannerID .'.html')?>">
										<img style="height: 400px; width: 100%" src="<?=base_url('/img/banner/'.$banner->Image)?>" />
									</a>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<?php
			foreach ($products as $product){?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="product-thumb transition">
						<div class="image">
							<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><img src="<?=base_url($product->Thumb)?>" class="img-responsive" ></a>
						</div>
						<div class="caption">
							<h3><a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><?=$product->Title?></a></h3>
							<h4><?=substr_at_middle($product->Brief, 200)?></h4>
						</div>
						<div class="button-group">
							<div class="button-group">
								<button type="button"><p class="price"><?=number_format($product->Price)?>đ</p></button>
								<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><i class="glyphicon glyphicon-shopping-cart"></i> Mua Hàng</a>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>

</div>

<?php $this->load->view('/theme/footer')?>

<!-- SWIPER -->
<script src="<?php echo base_url()?>theme/site/js/swiper-bundle.min.js"></script>
<!-- Custom JS File Link  -->
<!--<script src="--><?php //echo base_url()?><!--theme/site/js/script.js"></script>-->

</body>

</html>
