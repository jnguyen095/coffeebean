<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<title>Nhà Tìm Chủ | Thông Tin Cá Nhân</title>
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
</head>
<body>

<div class="container-fluid">
	<?php $this->load->view('/theme/header')?>

	<div class="container no-padding">
		<?php $this->load->view('/common/user-menu')?>

		<div class="row no-margin">
			<div class="col-lg-12">
				<div class="col-md-6 well login-panel no-background">
					<div class=" col-xs-12">
						<?php if(!empty($error_response)){
							echo '<div class="alert alert-danger">';
							echo $error_response;
							echo '</div>';
						}?>

						<?php if(!empty($message_response)){
							echo '<div class="alert alert-success">';
							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
							echo $message_response;
							echo '</div>';
						}?>

						<?php
						$attributes = array("class" => "form-horizontal", "id" => "profile", "name" => "profile");
						echo form_open("thong-tin-ca-nhan", $attributes);
						?>
						<fieldset>
							<legend class="text-center">THÔNG TIN CÁ NHÂN</legend>
							<div class="form-group">
								<div class="row colbox no-margin">
									<div class="col-lg-4 col-sm-4">
										<label for="txt_fullname" class="control-label">Số điện thoại</label>
									</div>
									<div class="col-lg-8 col-sm-8"><?=$txt_phone?></div>
								</div>
							</div>

							<div class="form-group">
								<div class="row colbox no-margin">
									<div class="col-lg-4 col-sm-4">
										<label for="txt_fullname" class="control-label">Họ tên <span class="required">*</span> </label>
									</div>
									<div class="col-lg-8 col-sm-8">
										<input class="form-control" id="txt_fullname" name="txt_fullname" placeholder="Fullname" type="text" value="<?=isset($txt_fullname) ? $txt_fullname : '' ?>" />
										<span class="text-danger"><?php echo form_error('txt_fullname'); ?></span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row colbox no-margin">
									<div class="col-lg-4 col-sm-4">
										<label for="txt_email" class="control-label">Email</label>
									</div>
									<div class="col-lg-8 col-sm-8">
										<input class="form-control" id="txt_email" name="txt_email" placeholder="Email" type="text" value="<?=isset($txt_email) ? $txt_email : '' ?>" />
										<span class="text-danger"><?php echo form_error('txt_email'); ?></span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-8 col-sm-8 col-lg-offset-4 text-left">
									<input type="hidden" name="crudaction" value="update"/>
									<input id="btn_login" name="btn_login" type="submit" class="btn btn-info" value="Cập Nhật" />
								</div>
							</div>

						</fieldset>
						<?php echo form_close(); ?>
					</div>
					<div class="clear-both"></div>

				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('/theme/footer')?>
</div>

</body>
</html>
