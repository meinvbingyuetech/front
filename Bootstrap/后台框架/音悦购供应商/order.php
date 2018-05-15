<?php
include_once(dirname(__FILE__)."/config.php");

$supplier_id = $_SESSION['supplier_info']['suppliers_id'];
$page = isset($_GET['page'])?$_GET['page']:1;
$maxsize = 20;
$begin = ($page-1)*$maxsize;
$limit = $begin.','.$maxsize;
$order = " `order_id` DESC ";

$where = " and order_status not in (2,3) and (ad_tn='bj_3' or shipping_supplier=".$supplier_id.") ";
if(!empty($_GET['keyword'])){
	$kw = htmlspecialchars($_GET['keyword']);
	$where .= " AND (g.goods_name LIKE '%{$kw}%' OR g.goods_sn LIKE '%{$kw}%') ";
}

$sql = "SELECT * FROM ".$ecs->table('order_info')." WHERE 1 $where ORDER BY $order limit $limit";
$rows = $db->getAll($sql);

$record_count = $db->getOne("SELECT order_id FROM ".$ecs->table('order_info')." WHERE 1 $where");
$page_count = ceil($record_count/$maxsize);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>订单管理</title>
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
								<a href="/order.php">所有订单</a>
							</li>
							<li class="active">
							<?php
							if(!empty($kw)){echo "搜索“{$kw}”";}
							?>
							第<?php echo $page;?>页</li>
						</ul>
						
						<!-- 搜索 -->
						<div class="nav-search" id="nav-search">
							<form name="form1" class="form-search" action="goods.php" method="get">
								<span class="input-icon">
									<input type="text" placeholder="订单号" name="keyword" class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					
					<!-- 内部面包屑 -->
					<div class="page-content">
						<!--<div class="page-header">
							<button class="btn" id="bootbox-regular">匹配产品</button>
						</div> -->

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
														<th>订单号</th>
														<th>下单时间</th>
														<th>收货人</th>
														<th>应付金额</th>
														<th>实际支付</th>
														<th>订单状态</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
													<?php 
													foreach($rows as $k=>$v){
														$v = format_single_order($v);
													?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															<?php echo $v['order_sn'];?>
														</td>
														<td class="hidden-480"><?php echo date("Y-m-d H:i:s",$v['add_time']);?></td>
														<td class="hidden-480"><?php echo $v['consignee'];?></td>
														<td class="hidden-480"><?php echo $v['order_amount'];?></td>
														<td class="hidden-480">
															<?php echo $v['money_paid'];?>
														</td>
														<td>
															<?php
															if($v['order_status_cur']=='已完成'){
																echo '<span class="label label-sm label-success">';
															}
															else if($v['order_status_cur']=='等待付款'){
																echo '<span class="label label-sm label-inverse">';
															}
															else{
																echo '<span class="label label-sm label-warning">';
															}
															?>
															<?php echo $v['order_status_cur'];?>
															</span>
														</td>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																
																<a href="/order_detail.php?id=<?php echo $v['order_id'];?>"><button class="btn btn-xs btn-info" title="修改库存">
																	<i class="icon-edit bigger-120"></i>
																</button></a>

																<!--<button class="btn btn-xs btn-info" title="编辑">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger" title="删除">
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

