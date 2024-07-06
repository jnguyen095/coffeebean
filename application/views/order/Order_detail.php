<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 9:33 AM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cập nhật đơn hàng</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/madmin.css')?>">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<!-- Main Header -->
	<?php $this->load->view('/admin/common/admin-header')?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php $this->load->view('/admin/common/left-menu') ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Cập nhật đơn hàng
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url("/order/process-{$order->OrderID}")?>"> Xử lý đơn hàng</a></li>
				<li class="active">Cập nhật đơn hàng</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmOrder");
		echo form_open("order/process", $attributes);
		?>
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Xử lý đơn hàng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<div class="search-filter">
						<div class="row">
							<div class="container-fluid text-center border-bottom">
								<div class="progresses">
									<div class="steps">
										<span><i class="glyphicon glyphicon-ok"></i></span>
									</div>

									<span class="line"><label class="label1">Xem đơn hàng</label></span>

									<div class="steps">
										<span class="font-weight-bold"><i class="glyphicon glyphicon-ok"></i></span>
									</div>

									<span class="line"><label class="label2">Địa chỉ giao hàng</label></span>

									<div class="steps">
										<span >3</span>
									</div>
									<span class="last-line"><label class="label3">Hoàn thành</label></span>

								</div>

							</div>
						</div>
					</div>

					<!-- Right column -->
					<div class="col-lg-9 col-sm-12">
						<div class="col-xs-12">
							<h3><b>Người mua hàng:</b></h3>
							<table class="table table-bordered">
								<thead>
								<tr>
									<td class="text-left">Người mua</td>
									<td class="text-left">Ngày mua</td>
									<td class="text-left">Status</td>
									<td class="text-right">Phí giao hàng</td>
									<td class="text-right">Tổng cộng</td>
									<td class="text-left">Ghi chú</td>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td class="text-left"><?=$order->FullName?><br/><i class="fa fa-phone"></i> <?=$order->Phone?></td>
									<td class="text-left"><?=date('d/m/Y H:i', strtotime($order->CreatedDate))?></td>
									<td class="text-left">
										<?php
										if($order->Status == 'NEW'){
											echo '<lable class="label label-success">Đơn mới</lable>';
										}
										?>
									</td>
									<td class="text-right"><?=number_format($order->ShippingFee)?></td>
									<td class="text-right"><?=number_format($order->TotalPrice)?></td>
									<td class="text-left"><?=$order->Note?></td>
								</tr>
								</tbody>
							</table>
						</div>


						<div class="col-lg-12">
							<div class="row">
								<div class="col-xs-12">
									<h3><b>Người nhận hàng:</b> <a data-toggle="tooltip" id="updateReceiver" title="Sửa thông tin người nhận hàng"><i class="fa fa-edit"></i></a></h3>
								</div>
								<table class="table table-bordered">
									<thead>
									<tr>
										<td class="text-left">Người nhận</td>
										<td class="text-left">Số đt</td>
										<td class="text-left">Địa chỉ</td>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td class="text-left"><?=$shippingAddr->Receiver?></td>
										<td class="text-left"><?=$shippingAddr->Phone?></td>
										<td class="text-left"><?=$shippingAddr->Street?>, <?=$shippingAddr->WardName?>, <?=$shippingAddr->DistrictName?>, <?=$shippingAddr->CityName?></td>
									</tr>
									</tbody>
								</table>

							</div>

						</div>

						<div class="col-lg-12">
							<div class="row">
								<div class="col-xs-12">
									<h3><b>Mặt hàng:</b> <a data-toggle="tooltip" title="Sửa thông tin mặt hàng"><i class="fa fa-edit"></i></a> 	</h3>
								</div>
								<div class="col-xs-12">
									<table class="table table-bordered">
										<thead>
										<tr>
											<td class="text-left">Mặt hàng</td>
											<td class="text-left">Số lượng</td>
											<td class="text-left">Thành tiền</td>
											<td class="text-left">Lựa chọn</td>
										</tr>
										</thead>
										<tbody>
										<?php foreach ($products as $item){
											?>
											<tr>
												<td class="text-left"><a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html" target="_blank"><?=$item->ProductName?></a></td>
												<td class="text-center"><?=$item->Quantity?></td>
												<td class="text-right"><?=number_format($item->Price)?></td>
												<td class="text-left">
													<?php
														$ops = json_decode($item->Options);
														foreach ($ops as $k=>$v){
															foreach ($v as $k1=>$v1){
																if(!empty($v1)){
																	echo "<li>".$k1.": ".$v1."</li>";
																}
															}
														}
													 ?>
												</td>
											</tr>
											<?php
										} ?>
										</tbody>
									</table>
								</div>

							</div>

						</div>

						<div class="row no-margin top-buttons">
							<a class="btn btn-warning" id="addBack" href="<?=base_url("/order/process-{$order->OrderID}.html")?>">Trở lại</a>&nbsp;
							<a class="btn btn-primary" id="addNew" href="<?=base_url("/order/update-{$order->OrderID}.html")?>">Cập nhật đơn hàng</a>
						</div>
					</div>

					<!-- Left column -->
					<div class="col-lg-3 col-sm-12 order-history">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Lịch sử giao dịch</h6>
								<div id="content">
									<ul class="timeline">
										<?php foreach ($trackings as $tracking) {
											?>
											<li class="event">
												<h3><?=date('d/m/Y H:i', strtotime($tracking->CreatedDate))?></h3>
												<p><?=$tracking->Message?></p>
											</li>
											<?php
										}?>
									</ul>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</section>
		<!-- /.content -->
		<input type="hidden" id="crudaction" name="crudaction">
		<input type="hidden" id="productId" name="productId">
		<?php echo form_close(); ?>

		<!-- popups -->
		<!-- Modal -->
		<form id="modalForm" role="form">
			<div class="modal fade" id="modalOrderFormDialog" role="dialog">

			</div>
		</form>
		<!-- end popup -->


	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<?php $this->load->view('/admin/common/admin-footer')?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?=base_url('/theme/admin/js/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('/theme/admin/js/bootstrap.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('/theme/admin/js/adminlte.min.js')?>"></script>
<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/tindatdai_admin.js')?>"></script>

<script type="text/javascript">
	var sendRequest = function(){
		var searchKey = $('#searchKey').val()||"";
		var fromDate = $('#fromDate').val()||"";
		var toDate = $('#toDate').val()||"";
		var code = $('#code').val()||"";
		var hasAuthor = $('input[name=hasAuthor]:checked').val();
		var status = $('input[name=status]:checked').val();
		var phoneNumber = $('#phoneNumber').val()||"";
		window.location.href = '<?=base_url('admin/product/list.html')?>?query='+searchKey + '&phoneNumber=' + phoneNumber + '&fromDate=' + fromDate + '&toDate=' + toDate + '&hasAuthor=' + hasAuthor + '&code=' + code + '&status=' + status + '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
	}

	var curOrderField, curOrderDirection;
	$('[data-action="sort"]').on('click', function(e){
		curOrderField = $(this).data('title');
		curOrderDirection = $(this).data('direction');
		sendRequest();
	});


	$('#searchKey').val(decodeURIComponent(getNamedParameter('query')||""));
	$('#fromDate').val(decodeURIComponent(getNamedParameter('fromDate')||""));
	$('#toDate').val(decodeURIComponent(getNamedParameter('toDate')||""));
	$('#code').val(decodeURIComponent(getNamedParameter('code')||""));
	$('#phoneNumber').val(decodeURIComponent(getNamedParameter('phoneNumber')||""));
	if(decodeURIComponent(getNamedParameter('hasAuthor')) != null){
		$("#chb-" + (parseInt(decodeURIComponent(getNamedParameter('hasAuthor'))) + 1)).prop( "checked", true );
	}else{
		$("#chb-0").prop( "checked", true );
	}

	if(decodeURIComponent(getNamedParameter('status')) != null){
		$("#st-" + (parseInt(decodeURIComponent(getNamedParameter('status'))))).prop( "checked", true );
	}else{
		$("#st_0").prop( "checked", true );
	}

	var curOrderField = getNamedParameter('orderField')||"";
	var curOrderDirection = getNamedParameter('orderDirection')||"";
	var currentSort = $('[data-action="sort"][data-title="'+getNamedParameter('orderField')+'"]');
	if(curOrderDirection=="ASC"){
		currentSort.attr('data-direction', "DESC").find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top active');
	}else{
		currentSort.attr('data-direction', "ASC").find('i.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom active');
	}

	function updateView(productId, val){
		$("#pr-" + productId).addClass("process");
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/Ajax_controller/updateViewForProductIdManual")?>',
			dataType: 'json',
			data: {productId: productId, view: val},
			success: function(res){
				if(res == 'success'){
					/*bootbox.alert("Cập nhật thành công");*/
					$("#pr-" + productId).addClass("success");
				}
			}
		});
	}
	function updateVip(productId, val){
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/Ajax_controller/updateVipPackageForProductId")?>',
			dataType: 'json',
			data: {productId: productId, vip: val},
			success: function(res){
				if(res == 'success'){
					bootbox.alert("Cập nhật thành công");
				}
			}
		});
	}

	function pushPostUp(productId){
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/admin/ProductManagement_controller/pushPostUp")?>',
			dataType: 'json',
			data: {productId: productId},
			success: function(res){
				if(res == 'success'){
					bootbox.alert("Cập nhật thành công");
				}
			}
		});
	}

	function deleteMultiplePostHandler(){
		$("#deleteMulti").click(function(){
			var selectedItems = $("input[name='checkList[]']:checked").length;
			if(selectedItems > 0) {
				bootbox.confirm("Bạn đã chắc chắn xóa những tin rao này chưa?", function (result) {
					if (result) {
						$("#crudaction").val("delete-multiple");
						$("#frmPost").submit();
					}
				});
			}else{
				bootbox.alert("Bạn chưa check chọn tin cần xóa!");
			}
		});
	}

	function deletePostHandler(){
		$('.remove-post').click(function(){
			var prId = $(this).data('post');
			bootbox.confirm("Bạn đã chắc chắn xóa tin rao này chưa?", function(result){
				if(result){
					$("#productId").val(prId);
					$("#crudaction").val("delete");
					$("#frmPost").submit();
				}
			});
		});
	}

	function contactFormHandler(){
		$("#updateReceiver").click(function(){
			$.ajax({
				type:'POST',
				url: '<?=base_url("Order_controller/updateShippingInfo")?>',
				data: {'orderId': <?=$order->OrderID?>},
				success:function(msg) {
					$("#modalOrderFormDialog").html(msg);
					var $modal = $('#modalOrderFormDialog');
					$modal.modal('show');
				}
			});
		});
	}

	$(document).ready(function(){
		contactFormHandler();
		//deletePostHandler();
		//deleteMultiplePostHandler();
	});
</script>
</body>
</html>
