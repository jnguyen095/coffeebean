<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/19/2017
 * Time: 11:17 AM
 */
?>


<nav class="navbar navbar-default m-navbar navbar-fixed-top"/>
	<div class="container">
		<a class="navbar-brand brandName ipad-mini-hide hidden-md" href="<?=base_url('/')?>">
			<img src="<?=base_url('/img/logo2.png')?>" atl="Nha Tim Chu Logo"/>
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
						<i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;<?=$this->cart->total_items();?> sản phẩm - <?=number_format($this->cart->total())?>đ
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu mycart">
						<li>
							<a>
								<table class="table table-bordered table-responsive">
									<tr>
										<td>Sản phẩm</td>
										<td>SL</td>
										<td>Thành tiền</td>
										<td>Xóa</td>
									</tr>
									<?php foreach ($this->cart->contents() as $item): ?>
									<tr>
										<td>
											<?php echo substr_at_middle($item['name'], 120)?>
											<br/>
											<?php if ($this->cart->has_options($item['rowid']) == TRUE): ?>
												<?php foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value): ?>
													<?php $i = 1; ?>
													<?php foreach ($option_value as $k => $v): ?>
														<i><?=$v?></i><?=($i==1 ? ':' : '')?>
														<?php $i++; ?>
													<?php endforeach; ?>
													<br/>
												<?php endforeach; ?>
											<?php endif;?>
										</td>
										<td class="text-center"><?php echo $item['qty']; ?></td>
										<td class="text-right"><?=number_format($item['price']) ?></td>
										<td><a class="remove-cart-item glyphicon glyphicon-remove-circle text-red" rowid="<?php echo $item['rowid']?>" style="color: #ff0000"></a></td>
									</tr>
									<?php endforeach;?>
									<tr>
										<td colspan="4" class="text-right"><a href="<?=base_url('/check-out.html')?>" class="btn-primary btn-sm">Checkout</a> </td>
									</tr>
								</table>
							</a>
						</li>
					</ul>
				</li>

				<?php
				if($this->session->userdata('username') != null){
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
							<li><a href="<?= base_url('/quan-ly-tin-rao.html') ?>">Quản lý tin rao</a></li>
							<li><a href="<?= base_url('/quan-ly-giao-dich.html') ?>">Giao dịch</a></li>
							<li><a href="<?= base_url('/thong-tin-ca-nhan.html') ?>">Thông tin cá nhân</a></li>
							<li><a href="<?=base_url('/dang-xuat.html')?>">Đăng xuất</a></li>
						</ul>
					</li>

					<?php
				}else{
					?>
					<li><a href="<?=base_url('/dang-nhap.html')?>">Đăng nhập</a></li>
					<?php
				}
				?>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
	<!--/.container-fluid -->
</nav>


