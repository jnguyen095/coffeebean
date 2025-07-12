<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/18/2017
 * Time: 6:16 PM
 */
?>
<?php
$attributes = array("id" => "frmUpdateOrder");
echo form_open("admin/OrderManagement_controller/update", $attributes);
?>
<!-- Modal -->
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<!-- Modal Header -->
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only">Đóng</span>
			</button>
			<h4 class="modal-title h4" id="myModalLabel">Thay đổi đơn hàng</h4>
		</div>
		<!-- Modal Body -->
		<div class="modal-body">
			<p class="statusMsg"></p>

		</div>

		<!-- Modal Footer -->
		<div class="modal-footer">
			<input type="hidden" name="crudaction" value="insert"/>
			<input type="hidden" name="orderId" value="<?=$order->OrderID?>"/>
			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			<button id="btnUpdateShipping" type="button" class="btn btn-primary submitBtn" onclick="submitUpdateShipping()">Cập nhật</button>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
	function submitUpdateShipping(){
		var dataString = $("#frmShipping").serialize();
		console.log(dataString);
		$.ajax({
			type:'POST',
			url: '<?=base_url('admin/OrderManagement_controller/updateShippingInfo')?>',
			data: dataString,
			beforeSend: function () {
				$('.submitBtn').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			success:function(msg){
				if(msg == "success"){
					bootbox.alert("Cập nhật thành công", function(){
						window.location.href = '<?=base_url("admin/order/process-{$shipping->OrderID}.html")?>';
					});

				}else{
					$('.statusMsg').html('<span style="color:red;">'+msg+'</span>');
				}
				$('.submitBtn').removeAttr("disabled");
				$('.modal-body').css('opacity', '');
			}
		});
	}

	function loadWardByDistrictId(){
		$("#txtDistrict").change(function(){
			var districtId = $(this).val();
			$(".overlay").show();
			jQuery.ajax({
				type: "POST",
				url: '<?=base_url('/ajax_controller/findWardByDistrictId')?>',
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
				url: '<?=base_url('/ajax_controller/findDistrictByCityId')?>',
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

	$(document).ready(function() {
		loadDistrictByCityId();
		loadWardByDistrictId();
	});
</script>
