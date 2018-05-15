
<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->
					<ul class="nav nav-list">
						<li<?php if(strstr($_SERVER['PHP_SELF'],'goods.php')){echo ' class="active open"';}?>>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text"> 产品管理 </span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li<?php if(strstr($_SERVER['PHP_SELF'],'goods.php')){echo ' class="active"';}?>>
									<a href="/goods.php"<?php if(strstr($_SERVER['PHP_SELF'],'goods.php')){echo ' class="active"';}?>>
										<i class="icon-double-angle-right"></i>
										所有产品
									</a>
								</li>
							</ul>
						</li>

						<li<?php if(strstr($_SERVER['PHP_SELF'],'order.php')){echo ' class="active open"';}?>>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 订单管理 </span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li<?php if(strstr($_SERVER['PHP_SELF'],'order.php')){echo ' class="active"';}?>>
									<a href="/order.php"<?php if(strstr($_SERVER['PHP_SELF'],'order.php')){echo ' class="active"';}?>>
										<i class="icon-double-angle-right"></i>
										所有订单
									</a>
								</li>

								
							</ul>
						</li>

						
						<li<?php if(strstr($_SERVER['PHP_SELF'],'member')){echo ' class="active open"';}?>>
							<a href="#" class="dropdown-toggle">
								<i class="icon-edit"></i>
								<span class="menu-text"> 会员管理 </span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li<?php if(strstr($_SERVER['PHP_SELF'],'member.php') || strstr($_SERVER['PHP_SELF'],'member_detail.php')){echo ' class="active"';}?>>
									<a href="member.php"<?php if(strstr($_SERVER['PHP_SELF'],'member.php')){echo ' class="active"';}?>>
										<i class="icon-double-angle-right"></i>
										会员信息
									</a>
								</li>

								<li<?php if(strstr($_SERVER['PHP_SELF'],'membership.php')){echo ' class="active"';}?>>
									<a href="membership.php"<?php if(strstr($_SERVER['PHP_SELF'],'membership.php')){echo ' class="active"';}?>>
										<i class="icon-double-angle-right"></i>
										会员卡
									</a>
								</li>
							</ul>
						</li>
						<li<?php if(strstr($_SERVER['PHP_SELF'],'info.php')){echo ' class="active"';}?>>
							<a href="info.php">
								<i class="icon-list-alt"></i>
								<span class="menu-text"> 资料查询 </span>
							</a>
						</li>

					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>