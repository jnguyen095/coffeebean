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
	<title>Nhà Tìm Chủ | Chỉnh sửa bài đăng</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<script src="<?= base_url('/ckeditor/ckeditor.js') ?>"></script>
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
				Chỉnh sửa sản phẩm</b>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url('/admin/product/list.html')?>">Quản lý sản phẩm</a></li>
				<li class="active">Chỉnh sửa sản phẩm</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-danger">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<?php
					$attributes = array("id" => "frmAddProduct", "enctype" => "multipart/form-data", "class" => "form-horizontal");
					echo form_open("admin/product/edit".((isset($product->ProductID) && $product->ProductID > 0) ? "-".$product->ProductID : ""), $attributes);
					?>
					<div class="form-group">
						<div class="col-md-2">
							<label>Danh mục sản phẩm <span class="required">*</span></label>
						</div>
						<div class="col-md-6">
							<select class="form-control" id="sl_category" name="sl_category">
								<option value="">Chọn danh mục</option>
								<?php

								if($categories != null && count($categories) > 0){
									foreach ($categories as $c){
										?>
										<option value="<?=$c->CategoryID?>" <?=(isset($product->CategoryID) && $product->CategoryID == $c->CategoryID) ? ' selected="selected"' : ''?>><?=$c->CatName?></option>
										<?php
										if(count($child[$c->CategoryID]) > 0){
											foreach ($child[$c->CategoryID] as $k){?>
												<option value="<?=$k->CategoryID?>" <?=((isset($product->CategoryID) && $product->CategoryID == $k->CategoryID) ? ' selected="selected"' : '')?>>&nbsp;&nbsp;&nbsp;&nbsp;<?=$k->CatName?></option>
												<?php
											}
										}
									}
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('sl_category'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Tên sản phẩm <span class="required">*</span></label>
						</div>
						<div class="col-md-6">
							<input type="text" name="Title" placeholder="Tiêu đề" class="form-control" value="<?=isset($product->Title)? $product->Title : ""?>" >
							<span class="text-danger"><?php echo form_error('Title'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Giá bán <span class="required">*</span></label>
						</div>
						<div class="col-md-2">
							<input type="text" name="Price" placeholder="Giá bán" class="form-control" value="<?=isset($product->Price)? $product->Price : ""?>" >
							<span class="text-danger"><?php echo form_error('Price'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label for="txt_active" class="control-label">Có hàng bán</label>
						</div>
						<div class="col-md-2">
							<input type="checkbox" name="Status" value="1" <?=(!isset($product->Status) || $product->Status == 1) ? "checked" : "" ?> class="form-control minimal">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Hình ảnh</label>
						</div>
						<div class="col-md-10">
							<input type="file" id="txt_image" name="txt_image">
							<span class="text-danger"><?php echo form_error('txt_image'); ?></span>
							<?php
							if(isset($product->Thumb) && strlen($product->Thumb) > 0){
								?>
								<img style="width:50px" src="<?=base_url('/img/product/'.$product->Thumb)?>"/>
								<?php
							}
							?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Thông tin sản phẩm</label>
						</div>
						<div class="col-md-6">
							<textarea name="Brief" id="description" rows="50" class="form-control"><?=isset($product->Brief) ? $product->Brief : ''?></textarea>
							<span class="text-danger"><?php echo form_error('brief'); ?></span>
							<script>
								CKEDITOR.replace('description',{
									toolbar: [
										{ name: 'document', items: [ 'Source', '-', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
										[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
										{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
										{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
										{ name: 'styles', items: [ 'Styles', 'Format' ] }
									]
								});
							</script>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-2">
							<button  type="submit" class="btn btn-primary">Lưu</button>
							<a class="btn btn-danger" href="<?=base_url("/admin/product/list.html")?>">Trở lại</a>
						</div>
					</div>

					<input type="hidden" id="crudaction" name="crudaction" value="insert">
					<?php echo form_close(); ?>
				</div>
			</div>

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
<script src="<?=base_url('/theme/admin/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/tindatdai_admin.js')?>"></script>
<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
	});
</script>
</body>
</html>
