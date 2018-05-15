<?php
include_once(dirname(__FILE__)."/config.php");

$supplier_id = $_SESSION['supplier_info']['suppliers_id'];
$page = isset($_GET['page'])?$_GET['page']:1;
$maxsize = 20;
$begin = ($page-1)*$maxsize;
$limit = $begin.','.$maxsize;
$order = " `user_id` DESC ";
$where = " AND user_id>0 ";

if(!empty($_GET['keyword'])){
	$kw = htmlspecialchars($_GET['keyword']);
	$where .= " AND (user_name LIKE '%{$kw}%' OR mobile_phone LIKE '%{$kw}%') ";
}

$sql = "select * from ".$ecs->table('users')." where 1 and ad_tn='bj_3' $where ORDER BY $order limit $limit ";
$rows = $db->getAll($sql);

$record_count = $db->getOne("select count(user_id) from ".$ecs->table('users')." where 1 and ad_tn='bj_3' $where");
$page_count = ceil($record_count/$maxsize);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>会员管理</title>
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
							<li class="active">
							<?php
							if(!empty($kw)){echo "搜索“{$kw}”";}
							?>
							第<?php echo $page;?>页</li>
						</ul>
						
						<!-- 搜索 -->
						<div class="nav-search" id="nav-search">
							<form name="form1" class="form-search" action="member.php" method="get">
								<span class="input-icon">
									<input type="text" placeholder="用户名/手机号码" name="keyword" class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					
					<!-- 内部面包屑 -->
					<div class="page-content">
						<!--<div class="page-header">
							<button class="btn" id="bootbox-regular">匹配产品</button>
						</div>-->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th>用户名</th>
														<th>会员卡</th>
														<th>邮件</th>
														<th>手机号码</th>
														<th>注册时间</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
													<?php 
													foreach($rows as $k=>$v){
														//查询用户的会员卡
														$membership_info = $db->getRow("select * from ".$ecs->table('membership')." where 1 and user_id=".$v['user_id']." and supplier_id=$supplier_id ");
														if(empty($membership_info['card_no'])){
															$membership_info['card_no'] = '-';
														}
													?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															<?php echo $v['user_name'];?>
														</td>
														<td class="hidden-480"><?php echo $membership_info['card_no'];?></td>
														<td class="hidden-480"><?php echo $v['email'];?></td>
														<td class="hidden-480">
															<?php echo $v['mobile_phone'];?>
														</td>
														<td class="hidden-480">
															<?php echo date("Y-m-d H:i:s",$v['reg_time']);?>
														</td>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<input id="user_id" type="hidden" value="<?php echo $v['user_id'];?>">
																<!--<button class="btn btn-xs btn-success" title="修改库存">
																	<i class="icon-ok bigger-120"></i>
																</button>-->

																<a href="/member_detail.php?id=<?php echo $v['user_id'];?>"><button class="btn btn-xs btn-info" title="查看">
																	<i class="icon-edit bigger-120"></i>
																</button></a>

																<!--<button class="btn btn-xs btn-danger" title="删除">
																	<i class="icon-trash bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning" title="标记">
																	<i class="icon-flag bigger-120"></i>
																</button>-->
															</div>

														</td>
													</tr>
													<?php
													}

													if(count($rows)==0){
														echo '<tr><td colspan=7 align=center>暂无数据</td></tr>';
													}
													?>
													
												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
								</div><!-- /row -->
								
								<ul class="pager">
									<?php
									if($page>1){
										$prev_page = $page - 1;
										echo '<li class="previous"><a href="?page='.$prev_page.'">&larr; 上一页</a></li>';
									}
									?>
									
									<?php
									if($page<$page_count){
										$next_page = $page + 1;
										echo '<li class="next"><a href="?page='.$next_page.'">下一页 &rarr;</a></li>';
									}
									?>
									
								</ul>
								<p></p>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

				<?php include_once(dirname(__FILE__)."/temp/setting.php");?>
			</div><!-- /.main-container-inner -->
			
			<?php include_once(dirname(__FILE__)."/temp/top.php");?>

		</div><!-- /.main-container -->

		<?php include_once(dirname(__FILE__)."/temp/js.php");?>
		<script type="text/javascript">
		<!--
			$(function(){
				
				//修改库存--单个
				$("table button").on("click",function(){
					var _this = $(this);
					var goods_num = _this.parent().parent().siblings().children("input").val();
					var goods_id = _this.siblings("#goods_id").val();
					$.ajax({
						async:"false",
						type:"post",
						url:"?action=act_up_invent",
						data:{goods_num:goods_num,goods_id:goods_id},
						dataType:'json',
						success:
						function(data){
							if(data.error=='1010'){
								$("body").showTopbarMessage({ width: "600px",background: "#FF3366", close: 1500, content: "非法参数"});
							}
							else if(data.error=='1020'){
								$("body").showTopbarMessage({ width: "600px",background: "#FF3366", close: 1500, content: "修改失败"});
							}
							else if(data.error=='0010'){
								$("body").showTopbarMessage({width: "600px",background: "#95c51b", close: 1500, content: "修改成功"});
							}
						}
					});
				});

				$("#bootbox-regular").on(ace.click_event, function() {
					bootbox.dialog({
						title:"添加匹配产品",
						message: "<span class='bigger-110'>产品SN码：<input type='text' id='goods_sn' /><br><br>产品库存&nbsp;：<input type='text' id='goods_num' /><div id='msg_add_goods' style='margin-top:10px;'></div></span>",
						buttons: 			
						{
							"success" :
							 {
								"label" : "<i class='icon-ok'></i> 确定",
								"className" : "btn-sm btn-success",
								"callback": function() {
									var obj_msg = $("#msg_add_goods");
									var goods_sn = $.trim($("#goods_sn").val());
									var goods_num = $.trim($("#goods_num").val());
									if(goods_sn==''){
										$("#goods_sn").focus();
										obj_msg.html("<div style='color:red;'>请输入相关产品的SN码！</div>").show();
										setTimeout(function(){
											obj_msg.hide();
										},1500);
										return false;
									}
									if(goods_num==''){
										$("#goods_num").focus();
										obj_msg.html("<div style='color:red;'>请输入产品的库存！</div>").show();
										setTimeout(function(){
											obj_msg.hide();
										},1500);
										return false;
									}

									if(parseInt(goods_num)<=0 || isNaN(goods_num)){
										$("#goods_num").focus();
										obj_msg.html("<div style='color:red;'>请输入正确的产品库存！</div>").show();
										setTimeout(function(){
											obj_msg.hide();
										},1500);
										return false;
									}

									$.ajax({
										async:"false",
										type:"post",
										url:"?action=act_add_invent",
										data:{sn:goods_sn,num:goods_num},
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
												$("#goods_sn").val("").focus();
												obj_msg.html("<div style='color:red;'>该产品不存在，请输入正确的产品SN码！</div>").show();
												setTimeout(function(){
													obj_msg.hide();
												},3000);
											}
											else if(data.error=='1030'){
												obj_msg.html("<div style='color:red;'>该产品已匹配，请勿重复添加！</div>").show();
												setTimeout(function(){
													bootbox.hideAll();
												},3000);
											}
											else if(data.error=='1040'){
												obj_msg.html("<div style='color:green;'>产品匹配失败！</div>").show();
												setTimeout(function(){
													bootbox.hideAll();
												},1500);
											}
											else if(data.error=='0010'){
												obj_msg.html("<div style='color:green;'>产品匹配成功！</div>").show();
												setTimeout(function(){
													location.href="/goods.php";
												},1500);
											}
										}
									});

									return false;
								}
							},
							"button" :
							{
								"label" : "取消",
								"className" : "btn-sm"
							}
						}
					});

				});

			});
		//-->
		</script>
	</body>
</html>
