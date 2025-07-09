<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/19/2017
 * Time: 11:17 AM
 */
?>


<nav class="navbar navbar-default m-navbar navbar-fixed-top">
	<div class="container-fluid">
		<div class="container">
			<a class="navbar-brand brandName ipad-mini-hide hidden-md" href="<?=base_url('/')?>">
				<img src="<?=base_url('/img/vananh.png')?>" atl="Van Anh Shop Logo"/>
			</a>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar4">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="navbar4" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php
					foreach($categories as $r) {
						if(count($child[$r->CategoryID]) > 0){
							echo '<li role="presentation" class="dropdown">
								<a  href="'.base_url().seo_url($r->CatName).'-c'.$r->CategoryID. '.html" role="button" aria-haspopup="true" aria-expanded="false">
											'.$r->CatName.' <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">';
							foreach ($child[$r->CategoryID] as $k){
								echo '<li><a href="'.base_url().seo_url($k->CatName).'-c'.$k->CategoryID. '.html">'.$k->CatName.'</a></li>';
							}

							echo '</ul></li>';
						}else{
							echo ' <li><a href="'.seo_url($r->CatName).'-c'.$r->CategoryID. '.html">'.$r->CatName.'</a></li>';
						}
					}
					?>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li role="presentation" class="dropdown">
						<a id="myHeaderCart" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;<?=$this->cart->total_items();?> sản phẩm <?=number_format($this->cart->total())?>đ
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu mycart">
						</ul>
					</li>

					<?php
					if($this->session->userdata('phone') != null){
						?>
						<li role="presentation" class="dropdown">
							<a href="<?=base_url('/thong-tin-ca-nhan.html')?>" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="glyphicon glyphicon-user"></i>&nbsp;<?=$this->session->userdata('fullname')?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<?php
								if($this->session->userdata('usergroup') != null && $this->session->userdata('usergroup') == 'ADMIN') {
									?>
									<li><a href="<?= base_url('/admin/dashboard.html') ?>">Admin</a></li>
									<?php
								}
								?>
								<li><a href="<?= base_url('/quan-ly-don-hang.html') ?>">Đơn hàng</a></li>
								<li><a href="<?= base_url('/thong-tin-ca-nhan.html') ?>">Thông tin cá nhân</a></li>
								<li><a href="<?=base_url('/dang-xuat.html')?>">Đăng xuất</a></li>
							</ul>
						</li>

						<?php
					}else{
						?>
						<li><a href="<?=base_url('/dang-nhap.html')?>"><i class="glyphicon glyphicon-user"></i>&nbsp;Đăng nhập</a></li>
						<?php
					}
					?>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<!--/.container-fluid -->
</nav>


