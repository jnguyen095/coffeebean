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
	<div class="col-lg-12 mobile-hide ">
		<div class="container-fluid text-center border-bottom">
			<div class="progresses">
				<div class="steps">
					<span><i class="glyphicon glyphicon-ok"></i></span>
				</div>

				<span class="line"><label class="label1">Xem đơn hàng</label></span>

				<div class="steps">
					<span class="font-weight-bold">2</span>
				</div>

				<span class="line"><label class="label2">Địa chỉ giao hàng</label></span>

				<div class="steps">
					<span >3</span>
				</div>
				<span class="last-line"><label class="label3">Hoàn thành</label></span>

			</div>

		</div>
	</div>

	<div class="col-lg-12">
		<div class="col-lg-7">
			<form class="form-horizontal">
				<div class="form-group">
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Người nhận hàng <span class="required">*</span></label>
						<input type="text" class="form-control" name="txt_receiver">
						<span class="text-danger"><?php echo form_error('txt_receiver'); ?></span>
					</div>
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Số điện thoại <span class="required">*</span></label>
						<input type="text" class="form-control" name="txt_phone">
						<span class="text-danger"><?php echo form_error('txt_phone'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="form-group">
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Thành phố <span class="required">*</span></label>
						<select id="txtCity" class="form-control" name="txt_city">
							<option>Chọn tỉnh/thành phố</option>
							<?php
							if($cities != null && count($cities) > 0){
								$str = '';
								foreach ($cities as $ct){
									?>
									<option value="<?=$ct->CityID?>" <?=(isset($city) && $city == $ct->CityID) ? ' selected' : ''?> ><?=$ct->CityName?></option>
									<?php
								}
							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('txt_city'); ?></span>
					</div>
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Quận/huyện <span class="required">*</span></label>
						<select id="txtDistrict" class="form-control" name="txt_district">
							<option>Chọn quận/huyện</option>
							<?php
							if(isset($districts) && count($districts) > 0) {
								foreach ($districts as $dt) {
									?>
									<option
										value="<?= $dt->DistrictID ?>" <?= (isset($district) && $district == $dt->DistrictID) ? ' selected' : '' ?> ><?= $dt->DistrictName ?></option>
									<?php
								}
							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('txt_district'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="form-group">
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Phường/xã</label>
						<select id="txtWard" class="form-control" name="txt_ward">
							<option value="-1">Chọn phường/xã</option>
							<?php
							if(isset($wards) && count($wards) > 0) {
								foreach ($wards as $wd) {
									?>
									<option
										value="<?= $wd->WardID ?>" <?= (isset($ward) && $ward == $wd->WardID) ? ' selected' : '' ?> ><?= $wd->WardName ?></option>
									<?php
								}
							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('txt_ward'); ?></span>
					</div>
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Đường <span class="required">*</span></label>
						<input type="text" id="txt_street" name="txt_street" class="form-control typeahead" value="<?=isset($street) ? $street : ''?>">
						<span class="text-danger"><?php echo form_error('txt_street'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>
			</form>
		</div>

		<div class="col-lg-5">
			<table class="table table-bordered">
				<thead>
				<tr>
					<td class="text-left">Sản phẩm</td>
					<td class="text-left">Số lượng</td>
					<td class="text-right">Tổng cộng</td>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->cart->contents() as $item){?>
					<tr>
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
						<td class="text-center">
							<?=$item['qty']?>
						</td>
						<td class="text-right" colspan="2"><?=number_format($item['price'] * $item['qty'])?></td>

					</tr>
				<?php } ?>
				<tr>
					<td colspan="2">Phí giao hàng</td>
					<td class="text-right">12,000</td>
				</tr>
				<tr>
					<td colspan="2">Tổng cộng</td>
					<td class="text-right"><?=number_format($this->cart->total() + 12000)?> VNĐ</td>
				</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div class="col-lg-12 text-right">
		<a class="btn btn-info" href="<?=base_url('/check-out.html')?>"><i class="glyphicon glyphicon-menu-left"></i> Trở Lại  </a>
		<a class="btn btn-primary" type="submit">Tiếp Theo <i class="glyphicon glyphicon-menu-right"></i> </a>
	</div>
</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>
<?php $this->load->view('/theme/footer')?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		loadDistrictByCityId();
		loadWardByDistrictId();
	});
	function loadWardByDistrictId(){
		$("#txtDistrict").change(function(){
			var districtId = $(this).val();
			$(".overlay").show();
			jQuery.ajax({
				type: "POST",
				url: urls.loadWardByDistrictId,
				dataType: 'json',
				data: {districtId: districtId},
				success: function(res){
					document.getElementById("txtWard").options.length = 1;
					for(key in res){
						$("#txtWard").append("<option value='"+res[key].WardID+"'>"+res[key].WardName+"</option>");
					}
					$(".overlay").hide();
				}
			});
		});
	}

	function loadDistrictByCityId(){
		$("#txtCity").change(function(){
			$(".overlay").show();
			var cityId = $(this).val();
			document.getElementById("txtWard").options.length = 1;
			jQuery.ajax({
				type: "POST",
				url: urls.loadDistrictByCityId,
				dataType: 'json',
				data: {cityId: cityId},
				success: function(res){
					document.getElementById("txtDistrict").options.length = 1;
					for(key in res){
						$("#txtDistrict").append("<option value='"+res[key].DistrictID+"'>"+res[key].DistrictName+"</option>");
					}
					$(".overlay").hide();
				}
			});
		});
	}
</script>

</body>

</html>
