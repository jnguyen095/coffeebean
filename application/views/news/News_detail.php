<!DOCTYPE html>
<html lang = "en">

<head>
	<meta charset = "utf-8">
	<meta name="description" content="<?=$newsDetail->Title?>">
	<meta name="keywords" content="Bất động sản, bán nhà, chung cư, mua đất, bán đất, real estate">
	<title><?=$newsDetail->Title?></title>
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body class="news">
<?php $this->load->view('/common/analyticstracking')?>
<div class="container">

<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=base_url().'trang-chu.html'?>"><span itemprop="name">Trang Chủ</span></a><meta itemprop="position" content="1" /></li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=base_url('tin-tuc.html')?>"><span itemprop="name">Tin Tức</span></a><meta itemprop="position" content="2" /></li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name"><?=$newsDetail->Title?></span></span><meta itemprop="position" content="3" /></li>
</ul>

<div class="row no-margin">
	<div class="col-md-9  no-margin no-padding">
		<div class="search-result-panel col-md-12"><?=$newsDetail->Title?></div>
		<div class="news-date"><?=date('d/m/Y h:i', strtotime($newsDetail->CreatedDate))?></div>
		<div class="product-panel col-md-12  no-margin no-padding">
			<?php echo preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $newsDetail->Description);?>
			<div class="news-sources">
				<div class="float-left">
			<?php
				$this->load->view('/SocialShare');
				echo '</div>';
				if(isset($newsDetail->Source)){
					echo '<div class="news-source">'.$newsDetail->Source.'</div>';
				}
			?>
				<div class="clear-both"></div>
			</div>
			<div class="row news-related">
				<?php
				if(isset($topNews) && count($topNews) > 0) {
					echo '<ul class="topNews">';
					foreach ($topNews as $topNew) {
						?>
							<li><a href="<?=base_url(seo_url($topNew->Title.'-n').$topNew->NewsID.'.html')?>"><?=$topNew->Title?> - <?=date('d/m/Y', strtotime($topNew->CreatedDate))?></a></li>
						<?php
					}
					echo '</ul>';
				}
				?>
			</div>
		</div>
	</div>
	<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile">
		<?php $this->load->view('/common/sample_house') ?>
		<?php $this->load->view('/common/Search_filter') ?>
	</div>
</div>

</div>
<?php $this->load->view('/theme/footer')?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>

</html>
