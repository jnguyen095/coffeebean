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
	<title>Làm Nông Vui | Dashboard</title>
	<?php $this->load->view('/admin/common/header-js') ?>
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
				Dashboard
				<small>Tổng quan Làm Nông Vui</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">



		</section>
		<!-- /.content -->
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
<script src="<?=base_url('/theme/admin/js/jquery.flot.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/jquery.flot.categories.js')?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#updateVip").click(function(){
			if($(this).data('vip') > 0){
				bootbox.confirm("Chuyển crawler VIP những ngày trước sang Standard?", function(r){
				if(r){
					jQuery.ajax({
						type: "POST",
						url: '<?=base_url("/admin/admin_controller/updateStandardForPreviousPost")?>',
						dataType: 'json',
						data: {},
						success: function(res){
							if(res == 'success'){
								bootbox.alert("Cập nhật thành công");
							}
						}
					});
				}
			});
			}
			
		});

		$("#deleteCaptchaImgs").click(function(){
			if($(this).data('captcha') > 0){
				bootbox.confirm("Xóa hết hình captcha trong thư mục?", function(r){
					if(r){
						jQuery.ajax({
							type: "POST",
							url: '<?=base_url("/admin/admin_controller/deleteAllCaptcha")?>',
							dataType: 'json',
							data: {},
							success: function(res){
								if(res == 'success'){
									$("#captchaImgs").removeClass('bg-red').addClass('bg-green').html('0');
									// bootbox.alert("Xóa thành công");
								}
							}
						});
					}
				});
			}

		});

		$("#replaceThumbnails").click(function(){
			if($(this).data('thumb') > 0){
				bootbox.confirm("Thay hêt thumbnail?", function(r){
					if(r){
						jQuery.ajax({
							type: "POST",
							url: '<?=base_url("/admin/admin_controller/replaceThumbs")?>',
							dataType: 'json',
							data: {},
							success: function(res){
								if(res == 'success'){
									$("#thumbImgs").removeClass('bg-red').addClass('bg-green').html('0');
									// bootbox.alert("Thay hình thành công");
								}
							}
						});
					}
				});
			}
		});

		$("#retainCrawlerVip").click(function(){
			if($(this).data('vip') > 0){
				bootbox.confirm("Giữ lại tin Crawler Vip ngày trước?", function(r){
					if(r){
						jQuery.ajax({
							type: "POST",
							url: '<?=base_url("/admin/admin_controller/retainCrawlerVip")?>',
							dataType: 'json',
							data: {},
							success: function(res){
								if(res == 'success'){
									$("#previousCrawlerVipPost").removeClass('bg-red').addClass('bg-green').html('0');
									// bootbox.alert("Update thành công");
								}
							}
						});
					}
				});
			}
		});

		$("#retainAuthorVip").click(function(){
			if($(this).data('vip') > 0){
				bootbox.confirm("Giữ lại tin Vip chính chủ ngày trước?", function(r){
					if(r){
						jQuery.ajax({
							type: "POST",
							url: '<?=base_url("/admin/admin_controller/retainOwnerVip")?>',
							dataType: 'json',
							data: {},
							success: function(res){
								if(res == 'success'){
									$("#previousCrawlerVipPost").removeClass('bg-red').addClass('bg-green').html('0');
									// bootbox.alert("Update thành công");
								}
							}
						});
					}
				});
			}
		});

		$("#increasePostView").click(function(){
			bootbox.prompt({
				title: "Tăng View thêm trong khoảng bao nhiêu? Random từ 1 đến:",
				inputType: 'number',
				callback: function (result) {
					jQuery.ajax({
						type: "POST",
						url: '<?=base_url("/admin/admin_controller/addRandomNumber2PostView")?>',
						dataType: 'json',
						data: {'range': result},
						success: function(res){
							if(res == 'success'){
								bootbox.alert("Cập nhật thành công");
							}
						}
					});
				}
			});
		});

		var userdata = [];
		<?php
		foreach ($userRegistByDate as $userDate){
			?>
				var child = ["<?=date('d/m', strtotime($userDate->ForDate))?>", <?=$userDate->Total?>];
				userdata.push(child);
			<?php
		}
		?>

		// User registed
		userdata.reverse();
		$.plot("#placeholder", [ userdata ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			},grid: {
				hoverable: true,
				borderWidth: 1,
				backgroundColor: { colors: ["#ffffff", "#ebebeb"] }
			}

		});


		// Post registed
		var postdata = [];
		<?php
		foreach ($postRegistByDate as $postDate){
		?>
			var childPost = ["<?=date('d/m', strtotime($postDate->ForDate))?>", <?=$postDate->Total?>];
			postdata.push(childPost);
		<?php
		}
		?>

		postdata.reverse();
		$.plot("#postholder", [ postdata ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			},grid: {
				hoverable: true,
				borderWidth: 1,
				backgroundColor: { colors: ["#ffffff", "#EDF5FF"] }
			}
		});
	});
</script>
</body>
</html>
