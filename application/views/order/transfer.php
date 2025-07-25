<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/9/2017
 * Time: 2:19 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset = "utf-8">
		<title>Làm Nông Vui | Quản Lý Giao Dịch</title>
		<?php $this->load->view('common_header')?>
		<script src="<?= base_url('/js/createpost.min_v1.2.js') ?>"></script>
		<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid">
	<?php $this->load->view('/theme/header')?>

	<?php $this->load->view('/common/user-menu')?>

	<div class="row no-margin">
		<div class="col-lg-12 col-sm-12">
			<div>
				<div class="float-left h2title">Quản lý giao dịch</div>
				<div class="float-right">

				</div>
				<div class="clear-both"></div>
			</div>
			<hr/>

			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>

			<?php if(!empty($error_message)){
				echo '<div class="alert alert-danger">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $error_message;
				echo '</div>';
			}?>

			<?php
			$attributes = array("id" => "frmProcessPost");
			echo form_open("quan-ly-giao-dich", $attributes);
			?>
			<!-- content -->
			<div class="col-md-12 no-margin no-padding text-center table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr class="bg-success">
						<th>STT</th>
						<th>Ngày giao dịch <i class="glyphicon glyphicon-triangle-bottom"></i></th>
						<th>Ghi nợ</th>
						<th>Ghi có</th>
						<th>Nội dung</th>
						<th>Tình trạng</th>
						<th>Thực hiện</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(isset($histories) && count($histories) > 0) {
						$counter = 1;
						$sumDeposited = 0;
						$sumSpent = 0;
						foreach ($histories as $history) {
							?>
							<tr>
								<td><?=$counter++?></td>
								<td class="text-left"><?=date('d/m/Y H:i', strtotime($history->TransferTime))?></td>
								<td class="text-right"><?php
									if($history->Type == -1 && $history->Status == ACTIVE){
										$sumSpent += $history->Money;
										echo number_format($history->Money);
									}
									?>
								</td>
								<td class="text-right"><?php
									if($history->Type == 1 && $history->Status == ACTIVE){
										$sumDeposited += $history->Money;
										echo number_format($history->Money);
									}
									?>
								</td>
								<td class="text-left"><?=$history->Reason?></td>
								<td><?=$history->Status == ACTIVE ? '<span class="active">Thành Công</span>' : '<span class="paymentDelay">Treo</span>&nbsp;|&nbsp;<a data-toggle="tooltip" title="Số tiền: '.number_format($history->Money).'" data-transferid='.$history->PurchaseHistoryID.' class="btn btn-xs btn-primary payment">Thanh Toán</a>'?></td>
								<td><?=$history->FullName?></td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td colspan="2"></td>
							<td class="text-right"><strong><?=number_format($sumSpent)?></strong></td>
							<td class="text-right"><strong><?=number_format($sumDeposited)?></strong></td>
							<td colspan="3"></td>
						</tr>
						<tr>
							<td colspan="3" class="text-right">Số dư khả dụng:</td>
							<td class="text-right"><strong class="label label-success table-icons"><?=number_format($sumDeposited - $sumSpent)?></strong></td>
							<td colspan="4"></td>
						</tr>
						<?php
					}else{
						?>
							<tr>
								<td colspan="7">
									<span>Chưa có giao dịch nào, xem cách nạp thêm tiền <a href="<?=base_url('bao-gia-dich-vu.html')?>">tại đây</a></span>
								</td>
							</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<!-- end content -->
			<input type="hidden" id="crudaction" name="crudaction">
			<input type="hidden" id="processId" name="processId">
			<?php echo form_close(); ?>

			<div class="clear-both"></div>
		</div>
	</div>

	<?php $this->load->view('/theme/footer')?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".payment").click(function(){
			$this = $(this);
			var id = $this.data('transferid');
			if(id != null && id != undefined){
				bootbox.confirm("Tiến hành thanh toán cho tin này?", function (result) {
					if (result) {
						$("#crudaction").val('update');
						$("#processId").val(id);
						$("#frmProcessPost").submit();
					}
				});
			}
		});
	});
</script>
</body>
</html>
