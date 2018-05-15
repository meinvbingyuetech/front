<?php
define("LOGIN_PAGE", true);

include(dirname(__FILE__)."/config.php");

//退出action
if($_GET['action']=='logout'){
	unset($_SESSION['username']);
	die("<script>location.href='/login.php';</script>");
}
//登录action
if($_GET['action']=='act_login'){
	$username = trim($_POST['username']);
	$password = trim($_POST['pwd']);
	
	if(empty($username) || empty($password)){
		$arr['error'] = '1010';
		$arr['message'] = '非法参数';
		die(json_encode($arr));
	}

	$result = check_supplier_account(array('username'=>$username,'password'=>$password));
	$result = $result['message'];
	if(is_array($result)){
		$arr['error'] = '0010';
		$arr['message'] = 'success';
		
		$_SESSION['supplier_info'] = $result;//获取供应商信息
		$_SESSION['username'] = $username;
	}
	else if($result=='no_account'){
		$arr['error'] = '1030';
		$arr['message'] = 'no_account';
	}
	else{
		$arr['error'] = '1020';
		$arr['message'] = 'fail';
	}
	die(json_encode($arr));
}

//如果已经登录，则跳转至首页
if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
   die("<script>location.href='/';</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>登录页面 - 音悦购体验店后台</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->

		<link rel="stylesheet" href="/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/assets/css/ace-rtl.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/assets/js/html5shiv.js"></script>
		<script src="/assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">音悦购</span>
									<span class="white">体验店后台</span>
								</h1>
								<h4 class="blue">&copy; 龙键传逸</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												请输入您的帐号和密码
											</h4>

											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id="txt_uname" type="text" class="form-control" placeholder="用户名" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id="txt_pwd" type="password" class="form-control" placeholder="密码" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<!--<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> 自动登录 </span>
														</label>-->

														<button id="btn_login" type="button" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															登录
														</button>
													</div>
													<div id='msg_login'></div>
													<div class="space-4"></div>
												</fieldset>
											</form>

											
										</div><!-- /widget-main -->

										<div class="toolbar clearfix" style="display:none;">
											<div>
												<!--<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													忘记密码
												</a>-->
											</div>

											<div>
												<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
													注册账户
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>
															Send Me!
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												Back to login
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="icon-group blue"></i>
												新用户注册
											</h4>

											<div class="space-6"></div>
											<p> 输入您的帐号信息: </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="邮箱" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="用户名"/>
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="密码" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="确认密码" />
															<i class="icon-retweet"></i>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="icon-refresh"></i>
															重置
														</button>

														<button type="button" class="width-65 pull-right btn btn-sm btn-success">
															注册
															<i class="icon-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												<i class="icon-arrow-left"></i>
												登录
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /signup-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script src="/assets/js/jquery-1.10.2.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}

			//登录
			function login(){
				var obj_msg = $("#msg_login");
				var username = $.trim($("#txt_uname").val());
				var pwd = $.trim($("#txt_pwd").val());
				if(username=='' || pwd==''){
					obj_msg.html("<div style='color:red;'>帐号或密码不能为空！</div>").show();
					setTimeout(function(){
						obj_msg.hide();
					},1500);
					return false;
				}

				$.ajax({
					async:"false",
					type:"post",
					url:"?action=act_login",
					data:{username:username,pwd:pwd},
					dataType:'json',
					success:
					function(data){
						if(data.error=='1010'){
							obj_msg.html("<div style='color:red;'>非法参数！</div>").show();
							setTimeout(function(){
								obj_msg.hide();
							},1500);
						}
						else if(data.error=='1020'){
							obj_msg.html("<div style='color:red;'>登录失败！</div>").show();
							setTimeout(function(){
								obj_msg.hide();
							},1500);
						}
						else if(data.error=='1030'){
							obj_msg.html("<div style='color:red;'>该账户不存在！</div>").show();
							setTimeout(function(){
								obj_msg.hide();
							},1500);
						}
						else if(data.error=='0010'){
							obj_msg.html("<div style='color:green;'>登录成功！</div>").show();
							setTimeout(function(){
								location.href='/';
							},1500);
						}
					}
				});
			}

			$(function(){
				$("#txt_uname,#txt_pwd").keydown(function(event){
					if(event.keyCode==13){
						login();
					}
				});

				$("#btn_login").on("click",function(){
					login();
				});
			});
		</script>
	</body>
</html>
