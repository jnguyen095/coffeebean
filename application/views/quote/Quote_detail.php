<!DOCTYPE html>
<html lang = "en">
<meta charset="UTF-8">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Báo giá sản phẩm</title>
</head>
<body>
	<div style="margin-top:10px" >
		<table style="width: 100%;border: solid 1px #dddddd">
			<thead>
			<tr style="background-color: green">
				<td>#</td>
				<td>Mã SP</td>
				<td>Tên sản phẩm</td>
				<td>Giá</td>
				<td>Số lượng</td>
				<td>Thành tiền</td>
				<td>Ghi chú</td>
			</tr>
			</thead>
			<tbody>
			<?php
			$index = 1;
			foreach ($details as $item){
				?>
				<tr>
					<td><?=$index++?></td>
					<td><?=$item->ProductCode?></td>
					<td><?=$item->ProductName?></td>
					<td style="text-align: right"><?=number_format($item->OfferPrice)?></td>
					<td style="text-align: right"><?=$item->Quantity?></td>
					<td style="text-align: right"><?=number_format($item->OfferPrice * $item->Quantity)?></td>
					<td><i><?=$item->Note?></i></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="5" style="text-align: right">Phí giao hàng</td>
				<td style="text-align: right"><?=number_format($quote->ShippingFee)?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right">Giảm giá</td>
				<td style="text-align: right"><?=number_format($quote->Discount)?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right">Tổng cộng</td>
				<td style="text-align: right"><b><?=number_format($quote->TotalPrice)?> VNĐ</b></td>
				<td></td>
			</tr>
			</tbody>

		</table>
	</div>

</body>
</html>
