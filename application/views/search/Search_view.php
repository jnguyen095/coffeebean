<!DOCTYPE html>
<html lang = "en">
<?php
	$searchBy = "";
	if(isset($category) && !isset($cat_city) && !isset($cat_city_dic)){
		$searchBy = $category->CatName;
	} else if(isset($city)){
		if(isset($district)){
			$searchBy = 'Nhà đất tại quận '.$district->DistrictName.', '. $city->CityName;
		}else{
			$searchBy = 'Nhà đất tại '.$city->CityName;
		}
	}else if(isset($cat_city)){
		$searchBy = $cat_city;
	}else if(isset($cat_city_dic)){
		$searchBy = $cat_city_dic;
	}else if(isset($branch)){
		$searchBy = $branch->BrandName;
	}else if(isset($userAuthor)){
		$searchBy = "Bất động sản của ".$userAuthor->FullName;
	}else{
		$searchBy = "Tìm kiếm";
	}
	?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="audience" content="general" />
	<meta name="resource-type" content="document" />
	<meta name="abstract" content="Thông tin nhà đất Việt Nam" />
	<meta name="classification" content="Bất động sản Việt Nam" />
	<meta name="area" content="Nhà đất và bất động sản" />
	<meta name="placename" content="Việt Nam" />
	<meta name="author" content="nhatimchu.com" />
	<meta name="copyright" content="©2017 nhatimchu.com" />
	<meta name="owner" content="nhatimchu.com" />
	<meta name="distribution" content="Global" />
	<meta name="description" content="<?=$searchBy?>">
	<meta name="keywords" content="<?=keyword_maker($searchBy)?>">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<title><?=$searchBy?></title>
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container">

<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=base_url().'trang-chu.html'?>"><span itemprop="name">Trang Chủ</span></a><meta itemprop="position" content="1" /></li>
	<?php
	if(isset($district)){
		if(isset($city)){
			?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Tìm theo quận <?php echo $district->DistrictName ?>, <?php echo $city->CityName ?></span></span><meta itemprop="position" content="2" /></li>
			<?php
		}else{
			?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Tìm theo quận <?php echo $district->DistrictName ?></span></span><meta itemprop="position" content="2" /></li>
			<?php
		}
	}else if(isset($city)) {
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Tìm theo thành phố <?php echo $city->CityName ?></span></span><meta itemprop="position" content="2" /></li>
		<?php
	}else if(isset($branch)){
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Tìm theo dự án <?php echo $branch->BrandName ?></span></span><meta itemprop="position" content="2" /></li>
		<?php
	}else if(isset($cat_city)){
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name"><?php echo $cat_city ?></span></span><meta itemprop="position" content="2" /></li>
		<?php
	}else if(isset($userAuthor)){
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name"><?php echo "Bất động sản của ".$userAuthor->FullName ?></span></span><meta itemprop="position" content="2" /></li>
		<?php
	}else{
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Tìm kiếm</span></span><meta itemprop="position" content="2" /></li>
		<?php
	}
	?>
</ul>
<div class="row no-margin">
	<div class="search-result col-md-9 no-margin no-padding">

	</div>
	<div class="col-md-9 no-margin no-padding">
		<div class="search-result-panel col-md-12">
			<?=number_format($total)?> kết quả<span class="search-total-result">
			<?php
			 $str = '';
			 if(isset($keyword) && strlen($keyword) > 0){
				 $str .= ' "'.$keyword.'"';
			 }
			 if(isset($category)){
				 if(isset($keyword)){
					 $str .= ', '.$category->CatName;
				 }else {
					 $str .= $category->CatName;
				 }
			 }

			 echo $str;
			?>
			</span>
		</div>
		<div class="product-panel col-md-12 no-margin no-padding">
			<div class="row">
				<?php
				foreach ($products as $product){?>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
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
			<?php
			if(isset($products) && count($products) > 0) {
				?>
				<div class="row text-center">
					<?php if (isset($pagination)) echo $pagination ?>
				</div>
				<?php
			}else{
				?>
				<div class="alert alert-warning">Không tìm thấy dữ liệu phù hợp, vui lòng chọn danh mục khác.</div>
				<?php
			}
			?>
		</div>
	</div>
	<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile">
		<?php $this->load->view('/common/user_author') ?>
		<?php $this->load->view('/common/branch-left') ?>
		<?php $this->load->view('/common/district-left-link')?>
		<?php $this->load->view('/common/branch-left-link')?>
		<?php $this->load->view('/common/Search_filter') ?>
	</div>
</div>


<?php $this->load->view('/theme/footer')?>
</div>
</body>

</html>
