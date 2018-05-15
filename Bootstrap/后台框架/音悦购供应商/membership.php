<?php
include_once(dirname(__FILE__)."/config.php");


/*
批量添加会员卡
*/
if($_GET['act']=='batch_add_membership'){
	exit;
	//生成BJ000004到BJ999999
	for($i=918327;$i<1000000;$i++){
		if($i<10){
			$card_no = "BJ00000".$i;
		}
		else if($i<100){
			$card_no = "BJ0000".$i;
		}
		else if($i<1000){
			$card_no = "BJ000".$i;
		}
		else if($i<10000){
			$card_no = "BJ00".$i;
		}
		else if($i<100000){
			$card_no = "BJ0".$i;
		}
		else if($i<1000000){
			$card_no = "BJ".$i;
		}
		$sql = "INSERT INTO ".$ecs->table('membership')."(`card_no`,`supplier_id`,`user_id`,`ctime`) VALUES('{$card_no}','3','0','".time()."')";
		$db->query($sql);
	}

	exit;
}

$page = isset($_GET['page'])?$_GET['page']:1;
$maxsize = 20;
$begin = ($page-1)*$maxsize;
$limit = $begin.','.$maxsize;
$order = " `id` ASC ";


if(!empty($_GET['keyword'])){
	$kw = htmlspecialchars($_GET['keyword']);
	//查询是否有该会员
	$user_id = $db->getOne("SELECT user_id FROM ".$ecs->table('users')." WHERE 1 AND `user_name`='{$kw}' ");
	if(is_numeric($user_id)){
		$where .= " AND `user_id` = $user_id ";
	}
	else{
		$where .= " AND `card_no` LIKE '%".$kw."%' ";
	}
}

$sql = "SELECT * FROM ".$ecs->table('membership')." WHERE 1 AND `supplier_id`='".$_SESSION['supplier_info']['suppliers_id']."' $where ORDER BY $order limit $limit";
$rows = $db->getAll($sql);

$record_count = $db->getOne("SELECT COUNT(id) FROM ".$ecs->table('membership')." WHERE 1 AND `supplier_id`='".$_SESSION['supplier_info']['suppliers_id']."' $where");
$page_count = ceil($record_count/$maxsize);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>会员卡管理</title>
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
								<a href="/membership.php">所有会员卡</a>
							</li>
							<li class="active">
							第<?php echo $page;?>页</li>
						</ul>
						
						<!-- 搜索 -->
						<div class="nav-search" id="nav-search">
							<form name="form1" class="form-search" action="membership.php" method="get">
								<span class="input-icon">
									<input type="text" placeholder="会员卡号或会员名 ..." name="keyword" class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					
					<!-- 内部面包屑 -->
					<div class="page-content">
						<!--<div class="page-header">
							<button class="btn btn-purple" id="add_card">添加会员卡</button>
							<button class="btn btn-primary" id="import_card">导入会员卡</button>
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
														<th>ID</th>
														<th>会员卡号</th>
														<th>生成时间</th>
														<th>是否启用</th>
														<th>关联用户</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
													<?php 
													foreach($rows as $k=>$v){
														$user = $db->getRow("SELECT user_name FROM ".$ecs->table('users')." WHERE 1 AND `user_id`='".$v['user_id']."'");
													?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															<?php echo $v['id'];?>
														</td>
														<td class="hidden-480"><?php echo $v['card_no'];?></td>
														<td class="hidden-480"><?php echo date("Y-m-d H:i:s",$v['ctime']);?></td>
														<td class="hidden-480">
															<?php echo $v['user_id']==0?'<span class="label label-sm label-warning">未关联</span>':"<span class='label label-sm label-success'>已关联</span>";?>
														</td>
														<td><?php echo $user['user_name'];?></td>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<input id="id" type="hidden" value="<?php echo $v['id'];?>">

																<button class="btn btn-xs btn-warning" title="关联会员">
																	<i class="icon-flag bigger-120"></i>
																</button>


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
					return false;
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

			

			});
		//-->
		</script>
	</body>
</html>
