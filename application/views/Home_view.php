<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="audience" content="general" />
	<meta name="resource-type" content="document" />
	<meta name="abstract" content="Cà phê rang xay, cà phê hạt, coffee, coffee bean" />
	<meta name="classification" content="Cà phê rang xay" />
	<meta name="area" content="Cà phê rang xay" />
	<meta name="placename" content="Việt Nam" />
	<meta name="author" content="capheranghat.com" />
	<meta name="copyright" content="©2023 capheranghat.com" />
	<meta name="owner" content="capheranghat.com" />
	<meta name="distribution" content="Global" />
	<meta name="description" content="Cà phê rang xay Việt Nam, cung cấp cà phê rang xay, thiết bị chuyên dụng cà phê">
	<meta name="keywords" content="cà, phê, rang, xay,Việt, Nam, coffee, cafe">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Cà phê rang xay Việt Nam</title>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon.ico')?>">

	<!-- SWIPER -->
	<link rel="stylesheet" href="<?php echo base_url()?>theme/site/css/swiper-bundle.min.css" />
	<!-- Font Awesome CDN Link  -->
	<link rel="stylesheet" href="<?php echo base_url()?>theme/site/css/com_ajax_libs_font-awesome_5.15.4_css_all.min.css">

	<!-- Custom CSS File Link  -->
	<link rel="stylesheet" href="<?php echo base_url()?>theme/site/css/style.css">
</head>

<body>

<!-- HEADER -->
<?php $this->load->view('/common/header')?>

<!-- HOME -->
<section class="home" id="home">
	<div class="row">
		<div class="content">
			<h3>fresh coffee in the morning</h3>
			<a href="#" class="btn">buy one now</a>
		</div>

		<div class="image">
			<img src="<?php echo base_url()?>theme/site/image/home-img-1.png" class="main-home-image" alt="">
		</div>
	</div>

	<div class="image-slider">
		<img src="<?php echo base_url()?>theme/site/image/home-img-1.png" alt="">
		<img src="<?php echo base_url()?>theme/site/image/home-img-2.png" alt="">
		<img src="<?php echo base_url()?>theme/site/image/home-img-3.png" alt="">
	</div>
</section>

<!-- ABOUT -->
<section class="about" id="about">
	<h1 class="heading">about us <span>why choose us</span></h1>

	<div class="row">
		<div class="image">
			<img src="<?php echo base_url()?>theme/site/image/about-img.png" alt="">
		</div>

		<div class="content">
			<h3 class="title">what's make our coffee special!</h3>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel rerum laboriosam reprehenderit ipsa id
				repellat odio illum, voluptas, necessitatibus assumenda adipisci. Hic, maiores iste? Excepturi illo
				dolore mollitia qui quia.</p>
			<a href="#" class="btn">read more</a>
			<div class="icons-container">
				<div class="icons">
					<img src="<?php echo base_url()?>theme/site/image/about-icon-1.png" alt="">
					<h3>quality coffee</h3>
				</div>
				<div class="icons">
					<img src="<?php echo base_url()?>theme/site/image/about-icon-2.png" alt="">
					<h3>our branches</h3>
				</div>
				<div class="icons">
					<img src="<?php echo base_url()?>theme/site/image/about-icon-3.png" alt="">
					<h3>free delivery</h3>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- MENU -->
<section class="menu" id="menu">
	<h1 class="heading">our menu <span>popular menu</span></h1>

	<div class="box-container">
		<a href="#" class="box">
			<img src="<?php echo base_url()?>theme/site/image/menu-1.png" alt="">
			<div class="content">
				<h3>our special coffee</h3>
				<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur, sed.</p>
				<span>$8.99</span>
			</div>
		</a>

		<a href="#" class="box">
			<img src="<?php echo base_url()?>theme/site/image/menu-2.png" alt="">
			<div class="content">
				<h3>our special coffee</h3>
				<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vel, fugit.</p>
				<span>$8.99</span>
			</div>
		</a>

		<a href="#" class="box">
			<img src="<?php echo base_url()?>theme/site/image/menu-3.png" alt="">
			<div class="content">
				<h3>our special coffee</h3>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, recusandae.</p>
				<span>$8.99</span>
			</div>
		</a>

		<a href="#" class="box">
			<img src="<?php echo base_url()?>theme/site/image/menu-4.png" alt="">
			<div class="content">
				<h3>our special coffee</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse, quas.</p>
				<span>$8.99</span>
			</div>
		</a>

		<a href="#" class="box">
			<img src="<?php echo base_url()?>theme/site/image/menu-5.png" alt="">
			<div class="content">
				<h3>our special coffee</h3>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, vitae.</p>
				<span>$8.99</span>
			</div>
		</a>

		<a href="#" class="box">
			<img src="<?php echo base_url()?>theme/site/image/menu-6.png" alt="">
			<div class="content">
				<h3>our special coffee</h3>
				<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde, expedita!</p>
				<span>$8.99</span>
			</div>
		</a>
	</div>
</section>

<!-- REVIEW -->
<section class="review" id="review">
	<h1 class="heading">reviews <span>what people says</span></h1>

	<div class="swiper review-slider">
		<div class="swiper-wrapper">
			<div class="swiper-slide box">
				<i class="fas fa-quote-left"></i>
				<i class="fas fa-quote-right"></i>
				<img src="<?php echo base_url()?>theme/site/image/pic-1.png" alt="">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, earum quis dolorem quaerat tenetur
					illum.</p>
				<h3>john deo</h3>
				<span>satisfied client</span>
			</div>

			<div class="swiper-slide box">
				<i class="fas fa-quote-left"></i>
				<i class="fas fa-quote-right"></i>
				<img src="<?php echo base_url()?>theme/site/image/pic-2.png" alt="">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum optio quasi ut, illo ipsam
					assumenda.</p>
				<h3>john deo</h3>
				<span>satisfied client</span>
			</div>

			<div class="swiper-slide box">
				<i class="fas fa-quote-left"></i>
				<i class="fas fa-quote-right"></i>
				<img src="<?php echo base_url()?>theme/site/image/pic-3.png" alt="">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius asperiores aliquam hic quis!
					Eligendi, aliquam.</p>
				<h3>john deo</h3>
				<span>satisfied client</span>
			</div>

			<div class="swiper-slide box">
				<i class="fas fa-quote-left"></i>
				<i class="fas fa-quote-right"></i>
				<img src="<?php echo base_url()?>theme/site/image/pic-4.png" alt="">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi modi perspiciatis distinctio
					velit aliquid a.</p>
				<h3>john deo</h3>
				<span>satisfied client</span>
			</div>
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>

<!-- BOOK -->
<section class="book" id="book">
	<h1 class="heading">booking <span>reserve a table</span></h1>

	<form action="">
		<input type="text" placeholder="Name" class="box">
		<input type="email" placeholder="Email" class="box">
		<input type="number" placeholder="Number" class="box">
		<textarea name="" placeholder="Message" class="box" id="" cols="30" rows="10"></textarea>
		<input type="submit" value="send message" class="btn">
	</form>
</section>

<!-- FOOTER -->
<?php $this->load->view('/common/footer')?>


<!-- SWIPER -->
<script src="<?php echo base_url()?>theme/site/js/swiper-bundle.min.js"></script>
<!-- Custom JS File Link  -->
<script src="<?php echo base_url()?>theme/site/js/script.js"></script>

</body>

</html>
