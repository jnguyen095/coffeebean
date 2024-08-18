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

	<div class="col-md-12 no-margin no-padding">
		<ul id="tabId" class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" id="tab-1" href="#order1">Order 1</a>
				<a onclick="removeTab('tab-1')" class="glyphicon glyphicon-remove removeTab no-padding no-margin"></a>
			</li>
			<a id="addTab" title="Thêm đơn" data-toggle="tooltip" href="#" style="display: block;margin-top: 8px; color: #008000"><i class="glyphicon glyphicon-plus"></i></a>
		</ul>


		<div id="tabContent" class="tab-content">
			<div id="tab-1-content" class="tab-pane fade in active">
				
			</div>
			
		</div>
	</div>
</div>


<?php $this->load->view('/pos/footer')?>
</div>

<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		initialTabsEvent();
		loadTabContent('tab-1');
		initialAddNewTab();
	});

	function addProduct2Cart(productId, tabID){

	}

	function initialAddNewTab(){
		$("#addTab").click(function(){
			addNewTab();
		});
	}

	function initialCatCollapseExpend(tabID){
		$("#cat-" + tabID).unbind('click');
		$("#cat-" + tabID).click(function(e){
			$this = $(e);
			$elm = $('#cat-' + tabID + ' i');
			if($(".pos-navbar-nav").is(":visible")){
				$elm.removeClass("glyphicon-menu-up");
				$elm.addClass("glyphicon-menu-down");
				$("#navbar-" + tabID).hide();
			}else{
				$elm.removeClass("glyphicon-menu-down");
				$elm.addClass("glyphicon-menu-up");
				$("#navbar-" + tabID).show();
				
			}
		});
	}

	function initialTabsEvent(){
		$("#tabId > li > a").unbind('click');
		$("#tabId > li > a").click(function(){
			$id = $(this).attr("id");
			selectedTab($id);
		});
		$("#tabId > li > a:after").click(function(){
			console.log(this);
		});
		
	}	

	function addNewTab(){	
		$tabs = $("#tabId li");
		var newID = $tabs.length + 1;
		for(var i = 1; i < newID; i++){
			if($("#tab-"+i).length == 0){
				// missing tab
				newID = i;
				break;
			}
		}
		$('<li><a data-toggle="tab" id="tab-'+ newID +'" href="#menu'+ newID +'">Order '+ newID +'</a><a onclick="removeTab(tab-' + newID + ')" class="glyphicon glyphicon-remove removeTab no-padding no-margin"></a></li>').insertBefore($("#addTab"));
		$("#tabContent").append('<div id="tab-'+ newID +'-content" class="tab-pane fade"><h3>Menu '+newID+'</h3><p>Some content in menu '+newID+'.</p></div>');
		loadTabContent('tab-'+newID);
		initialTabsEvent();
	}

	function loadTabContent(tabID){
		$.ajax({
			type:'POST',
			url: '<?=base_url()?>POS_controller/loadTabContent',
			data: {'tabID': tabID},
			success:function(msg) {
				$("#" + tabID + '-content').html(msg);
				initialCatCollapseExpend(tabID);
				initialSearchCustomer(tabID);
			}
		});
	}

	function initialSearchCustomer(tabID){
		$("#addcustomer-" + tabID).click(function(){
			var $modal = $('#modalCustomerDialog-' + tabID);
			$.ajax({
				type: "POST",
				url: '<?=base_url()?>POS_controller/getCustomerList',
				data: {'tabID': tabID, 'keyword': ''},
			}).done(function (data) {
				$modal.html(data);
				$modal.modal('show');
			});
		});
	}

	function selectCustomer(customerId, tabID){
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>POS_controller/getCustomerById',
			data: {'tabID': tabID, 'userId': customerId},
		}).done(function (data) {
			$("#customer-" + tabID).html(data);
			updateTabName(customerId, tabID);
			$('#modalCustomerDialog-' + tabID).modal('hide');
		});
	}

	function updateTabName(customerId, tabID){
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>POS_controller/getCustomerNameById',
			data: {'tabID': tabID, 'userId': customerId},
		}).done(function (data) {
			$("#" + tabID).html(data);
		});
	}

	function loadProduct(catId, tabID){
		$.ajax({
			type:'POST',
			url: '<?=base_url()?>POS_controller/loadProductByCatId',
			data: {'catId': catId},
			success:function(msg) {
				$("#product-" + tabID).html(msg);
			}
		});
	}

	function removeTab(tabID){
		
		bootbox.confirm("Bạn có chắc chắn xóa đơn hàng: <b>" + $("#" + tabID).text() + "</b>?", function(r){
			if(r){
				// Remove Tab content
				$("#"+ tabID + "-content").remove();
				// Remove Tab header
				$("#" + tabID).parent().remove();
			}
		});
	}

	function selectedTab(tabId){
		$(".nav-tabs li").removeClass("active");
		$(this).parent().addClass("active");
		$(".tab-content .tab-pane").removeClass("active");
		$(".tab-content .tab-pane").removeClass("in");
		$("#" + tabId + "-content").addClass("active");
		$("#" + tabId + "-content").addClass("in");
	}
</script>
</html>
