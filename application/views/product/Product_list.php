<!DOCTYPE html>
<html lang = "en">

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
	<meta name="description" content="<?=$category->CatName?>">
	<meta name="keywords" content="<?=keyword_maker($category->CatName)?>">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<title><?php echo $category->CatName?></title>
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container">

<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">
	<?php
		$position = 1;
		if(isset($category->Parent)){
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.base_url().seo_url($category->Parent->CatName).'-c'.$category->Parent->CategoryID.'.html"><span itemprop="name">'.$category->Parent->CatName.'</span></a><meta itemprop="position" content="'.$position++.'" /></li>';
		}
	?>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name"><?php echo $category->CatName?></span></span><meta itemprop="position" content="<?=$position++?>" /></li>
	<?php $this->load->view('/common/quick-search')?>
</ul>
<div class="row no-margin">
	<div class="col-md-12 no-margin no-padding">

		<?php
		 if(isset($sameLevels) && count($sameLevels) > 0){
			 echo '<div class="category-panel col-md-12 affix-top"  data-spy="affix" data-offset-top="90">';
			 echo '<div class="container mcontainer">';
			 foreach ($sameLevels as $level){
				 echo '<div class="col-md-4"><a href="'.base_url().seo_url($level->CatName).'-c'.$level->CategoryID.'.html">'.$level->CatName. ' </a></div>';
			 }
			 echo '<div class="clear-both"></div></div></div>';
		 }
		?>



		<div class="product-panel col-md-12  no-margin no-padding">
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
			<div class="row text-center">
				<?php echo $pagination ?>
			</div>
		</div>

	</div>
</div>

</div>

<?php $this->load->view('/theme/footer')?>

</body>

</html>
