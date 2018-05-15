<?php
include_once(dirname(__FILE__)."/config.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>首页</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php include_once(dirname(__FILE__)."/temp/head.php");?>
	</head>

	<body>
		<?php include_once(dirname(__FILE__)."/temp/header.php");?>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				
				<?php include_once(dirname(__FILE__)."/temp/left.php");?>

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>
						
						<!-- 面包屑 -->
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="/">首页</a>
							</li>

							<li>
								<a href="#">列表</a>
							</li>
							<li class="active">详情</li>
						</ul>
						
						<!-- 搜索 -->
						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="搜索 ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					
					首页
				</div><!-- /.main-content -->

				<?php include_once(dirname(__FILE__)."/temp/setting.php");?>
			</div><!-- /.main-container-inner -->
			
			<?php include_once(dirname(__FILE__)."/temp/top.php");?>

		</div><!-- /.main-container -->

		<?php include_once(dirname(__FILE__)."/temp/js.php");?>
	</body>
</html>
