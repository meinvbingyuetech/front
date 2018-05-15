<?php
include_once(dirname(__FILE__)."/config.php");
$user_id = intval(trim($_GET['id']));

$user_info = $db->getRow("SELECT * FROM ".$ecs->table('users')." WHERE 1 AND user_id='{$user_id}'");
if(!is_numeric($user_info['user_id'])){
	header("Location:/");exit;
}

if($user_info['sex']==0){
	$user_info['sex'] = '女生';
}
else if($user_info['sex']==1){
	$user_info['sex'] = '男生';
}
else if($user_info['sex']==2){
	$user_info['sex'] = '保密';
}

$user_info['last_login'] = date("Y-m-d H:i:s",$user_info['last_login']);

$_json_tbip = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$user_info['last_ip']);
$_arr_tbip = json_decode($_json_tbip,true);
if($_arr_tbip['code']!=0){
	$user_info['last_area'] = '-';
}
else{
	$user_info['last_area'] = $_arr_tbip['data']['region'].$_arr_tbip['data']['city'].$_arr_tbip['data']['county'].$_arr_tbip['data']['isp'];
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>会员详细信息</title>
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
								<a href="/member.php">所有会员</a>
							</li>
							<li class="active">会员详情</li>
						</ul>
						
						
					</div>
					
					<div class="page-content">
						<div class="page-header">
							<h1>
								<button class="btn" id="bootbox-regular" onclick="history.go(-1)"><i class="icon-arrow-left"></i>返回</button>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户名 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['user_name'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 邮箱 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['email'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 性别 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['sex'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 生日 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['birthday'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 最近一次登录时间 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['last_login'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 最近一次登录IP </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['last_ip'].' - '.$user_info['last_area'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> QQ </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['qq'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 手机 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $user_info['mobile_phone'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>
								</form>
								<!-- PAGE CONTENT END -->
							</div>
						</div>
					</div>

				</div><!-- /.main-content -->

				<?php include_once(dirname(__FILE__)."/temp/setting.php");?>
			</div><!-- /.main-container-inner -->
			
			<?php include_once(dirname(__FILE__)."/temp/top.php");?>

		</div><!-- /.main-container -->

		<?php include_once(dirname(__FILE__)."/temp/js.php");?>
	</body>
</html>
