<!DOCTYPE html>
<html lang = "en">

<head>
	<meta charset = "utf-8">
	<title>POS</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/theme/pos/css/pos.css')?>">
</head>

<body class="news">
<div class="container-fluid no-padding">

<?php $this->load->view('/pos/header')?>

<div class="row no-margin pos">
	<div class="col-md-9 no-margin no-padding " style="background-color: #cccccc">
		<?php
		foreach ($products as $product) {?>
		<div class="col-sm-2">
			<div class="productItem">
				<div class="col-sm-6 no-padding productImg">
					<img src="<?=base_url('/img/product/').$product->Thumb?>" width="100%"/>
				</div>
				<div class="col-sm-6 no-padding">
					<div class="productName"><?=$product->Title?></div>
					<div class="productPrice"><?=number_format($product->Price)?></div>
				</div>
			</div>
		</div>
		<?php }
		?>
	</div>
	<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile" style="background-color: #ECE8DC">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#home">Home</a></li>
			<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
			<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
		</ul>

		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<h3>HOME</h3>
				<p>Some content.</p>
			</div>
			<div id="menu1" class="tab-pane fade">
				<h3>Menu 1</h3>
				<p>Some content in menu 1.</p>
			</div>
			<div id="menu2" class="tab-pane fade">
				<h3>Menu 2</h3>
				<p>Some content in menu 2.</p>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('/pos/footer')?>
</div>

</body>

</html>
