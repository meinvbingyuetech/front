<?php
include_once(dirname(__FILE__)."/config.php");

//修改库存---单个
if($_GET['action']=='act_up_invent'){
	
	if(!is_numeric($_POST['goods_id']) || !is_numeric($_POST['goods_num'])){
		$arr['error'] = '1010';
		$arr['message'] = '非法参数';
		die(json_encode($arr));
	}
	
	$flag = update_goods_inventory_diy(array('goods_id'=>$_POST['goods_id'],'inventory_num'=>$_POST['goods_num'],'supplier_id'=>$_SESSION['supplier_info']['suppliers_id']));
	if($flag){
		$arr['error'] = '0010';
		$arr['message'] = 'success';
	}
	else{
		$arr['error'] = '1020';
		$arr['message'] = 'fail';
	}
	die(json_encode($arr));
}

//添加产品库存
if($_GET['action']=='act_add_invent'){
	$goods_sn = $_POST['sn'];
	$goods_num = $_POST['num'];
	if(empty($goods_sn) || !is_numeric($goods_num)){
		$arr['error'] = '1010';
		$arr['message'] = '非法参数';
		die(json_encode($arr));
	}

	//查看产品是否存在，如果存在则继续，不存在则退出
	$goods_id = $db->getOne("SELECT `goods_id` FROM ".$ecs->table('goods')." WHERE 1 AND `goods_sn`='{$goods_sn}' ");
	if(empty($goods_id) || !is_numeric($goods_id)){
		$arr['error'] = '1020';
		$arr['message'] = '产品不存在';
		die(json_encode($arr));
	}

	//查看产品是否已经匹配，如果产品已经匹配，则退出
	$goods_supplier = $db->getOne("SELECT `id` FROM ".$ecs->table('goods_supplier')." WHERE 1 AND `supplier_id`='".$_SESSION['supplier_info']['suppliers_id']."' AND `goods_id`='{$goods_id}' AND `inventory_num`>0");
	if(!empty($goods_supplier) && is_numeric($goods_supplier)){
		$arr['error'] = '1030';
		$arr['message'] = '产品已匹配';
		die(json_encode($arr));
	}
	
	//添加产品
	$flag = insert_goods_inventory(array('goods_id'=>$goods_id,'inventory_num'=>$goods_num,'supplier_id'=>$_SESSION['supplier_info']['suppliers_id']));
	if($flag){
		$arr['error'] = '0010';
		$arr['message'] = 'success';
	}
	else{
		$arr['error'] = '1040';
		$arr['message'] = 'fail';
	}
	die(json_encode($arr));
}

//上传XLS文件
if($_GET['action']=='up_xsl'){

	$file_name = $_FILES['upload_file']['name'];
	if(!file_exists($file_name)){

		$temp_arr = explode(".", $file_name);
		$file_ext = array_pop($temp_arr);
		$file_ext = trim($file_ext);
		$file_ext = strtolower($file_ext);
		if (in_array($file_ext, array('xlsx','xls')) === false) {
			$arr['error'] = '1020';
			$arr['msg'] = '文件后缀错误';
			die(json_encode($arr));
		}

		$file = $_FILES['upload_file']['tmp_name'];
		$file_dir = dirname(__FILE__)."/uploads/".date("Ymd",time())."/";
		$file_path = $file_dir.iconv('utf-8','gb2312',$file_name);
		make_dir($file_dir);

		if (move_uploaded_file($file,$file_path) === false) {
			$arr['error'] = '1030';
			$arr['msg'] = $file_name;
		}
		else{
			//上传成功后，处理数据...
			
			require(dirname(dirname(__FILE__)) . '/plugins/phpexcel/Classes/PHPExcel.php');//引入PHP EXCEL类
			$data = format_excel2array($file_path);
			foreach($data as $k=>$v){
				if($k>0){
					$goods_id = $v['A'];
					//$num_now = $v['D'];
					$num_jia = $v['E'];
					$num_jian = $v['F'];

					//加或减库存只能填写一个值
					if( (empty($num_jian) && !empty($num_jia)) || (!empty($num_jian) && empty($num_jia)) ){
					
						//检查商品是否存在
						$num_now = $db->getOne("SELECT `inventory_num` FROM ".$ecs->table("goods_supplier")." WHERE 1 AND `goods_id`='".$goods_id."' AND `supplier_id`='".$_SESSION['supplier_info']['suppliers_id']."' ");
						if(is_numeric($num_now)){
							$flag = false;
							$sql = '';

							//如果是减库存，值不能大于现有库存
							if(!empty($num_jian) && $num_jian<$num_now){
								$sql = "update ".$ecs->table('goods_supplier')." set inventory_num=inventory_num-{$num_jian} where 1 and goods_id={$goods_id} and supplier_id=".$_SESSION['supplier_info']['suppliers_id']." ";
							}
							
							if(!empty($num_jia)){
								$sql = "update ".$ecs->table('goods_supplier')." set inventory_num=inventory_num+{$num_jia} where 1 and goods_id={$goods_id} and supplier_id=".$_SESSION['supplier_info']['suppliers_id']." ";
							}
							
							if(!empty($sql)){
								$flag = $db->query($sql);
							}

							if($flag){
								update_goods_inventory($goods_id);
							}
						}
					}
				}
			}

			$arr['error'] = '0010';
			$arr['msg'] = $file_name;
		}
	}
	else{
		$arr['error'] = '1010';
		$arr['msg'] = 'empty';
	}

	die(json_encode($arr));
}

$page = isset($_GET['page'])?$_GET['page']:1;
$maxsize = 20;
$begin = ($page-1)*$maxsize;
$limit = $begin.','.$maxsize;
$order = " g.`goods_id` DESC ";

$goods_sql_where = str_replace("`i","g.`i",$goods_sql_where);
$where .= " {$goods_sql_where} ";
$where .= " AND s.inventory_num>0 AND s.supplier_id=".$_SESSION['supplier_info']['suppliers_id'];
if(!empty($_GET['keyword'])){
	$kw = htmlspecialchars($_GET['keyword']);
	$where .= " AND (g.goods_name LIKE '%{$kw}%' OR g.goods_sn LIKE '%{$kw}%') ";
}

$sql = "SELECT g.*,s.inventory_num FROM ".$ecs->table('goods_supplier')." AS s INNER JOIN ".$ecs->table('goods')." AS g WHERE 1 AND s.goods_id=g.goods_id $where ORDER BY $order limit $limit";
$rows = format_all_goods($db->getAll($sql));


$record_count = $db->getOne("SELECT COUNT(g.goods_id) FROM ".$ecs->table('goods_supplier')." AS s INNER JOIN ".$ecs->table('goods')." AS g WHERE 1 AND s.goods_id=g.goods_id $where");
$page_count = ceil($record_count/$maxsize);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>产品管理</title>
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
								<a href="/goods.php">所有产品</a>
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
									<input type="text" placeholder="商品货号/商品名称" name="keyword" class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					
					<!-- 内部面包屑 -->
					<div class="page-content">
						<div class="page-header">
							<button class="btn" id="bootbox-regular">匹配产品</button>
							<button class="btn btn-purple" id="down_xls">下载库存模版</button>
							<button class="btn btn-primary" id="up_xls">上传库存模版</button>
						</div>

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
														<th>商品名称</th>
														<th>商品货号</th>
														<th>商品分类</th>
														<!-- <th>商品场景/应用</th> -->
														<th>商品品牌</th>
														<th>商品库存</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
													<?php 
													foreach($rows as $k=>$v){

														//分类
														$cat_info = get_category_info_by_id_fcache($v['cat_id']);
													?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															<a href="<?php echo $v['goods_link'];?>" target="_blank"><?php echo $v['goods_name'];?></a>
														</td>
														<td class="hidden-480"><?php echo $v['goods_sn'];?></td>
														<td class="hidden-480"><?php echo $cat_info['cat_name'];?></td>
														<!--<td><?php echo $v['scene'];?>/<?php echo $v['application'];?></td>-->
														<td class="hidden-480">
															<?php echo $v['brand_info']['brand_name'];?>
														</td>
														<td><input id="goods_number" type="text" value="<?php echo $v['inventory_num'];?>" style="width:100px;" onkeyup="if(parseInt(value)<=0 || isNaN(value))execCommand('undo')"/></td>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<input id="goods_id" type="hidden" value="<?php echo $v['goods_id'];?>">
																<button class="btn btn-xs btn-success" title="修改库存">
																	<i class="icon-ok bigger-120"></i>
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
				
				//匹配产品
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
													bootbox.hideAll();//关闭窗口
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
				
				//下载模版
				$("#down_xls").on("click",function(){
					window.open("/down_xls.php");
				});
				//上传模板
				$("#up_xls").on(ace.click_event, function() {
					bootbox.dialog({
						title:"上传库存模板",
						message: "<span class='bigger-110'><input type='file' id='imgFile' name='imgFile' /><div style='margin-top:5px;'><ul><li>1、请下载最新的库存模版来修改</li><li>2、加库存和减库存只能二选一</li><li>3、减库存时，数量不能大于或等于现有库存数</li><li>4、加减库存只需填写数字即可</li></ul></div><div id='msg_up_file' style='margin-top:10px;'></div></span>",
						buttons: 			
						{
							"success" :
							 {
								"label" : "<i class='icon-ok'></i> 确定",
								"className" : "btn-sm btn-success",
								"callback": function() {
									var file_num = 0;
									var obj_msg = $("#msg_up_file");
									obj_msg.html("<div style='color:#EE9611;'>文件上传中...</div>").show();

									 //创建FormData对象
									 var data = new FormData();
									 //为FormData对象添加数据
									 $.each($('#imgFile')[0].files, function(i, file) {
										 data.append('upload_file', file);
										 file_num++;
									 });
									 
									 if(file_num==0){
										obj_msg.html("<div style='color:red;'>请选择上传文件！</div>").show();
										setTimeout(function(){
											obj_msg.hide();
										},1500);
										return false;
									 }
									 else{
										$.ajax({
											 url:'goods.php?action=up_xsl',
											 type:'POST',
											 data:data,
											 dataType:'json',
											 cache: false,
											 contentType: false,    //不可缺
											 processData: false,    //不可缺
											 success:function(data){
												if(data.error=='0010'){
													obj_msg.html("<div style='color:green;'>文件上传成功！</div>").show();
													setTimeout(function(){
														//obj_msg.hide();
														bootbox.hideAll();//关闭窗口
													},1500);
												}
												else if(data.error=='1010'){
													obj_msg.html("<div style='color:red;'>请选择上传文件！</div>").show();
													setTimeout(function(){
														obj_msg.hide();
													},1500);
													return false;
												}
												else if(data.error=='1020'){
													obj_msg.html("<div style='color:red;'>请选择Excel文件！</div>").show();
													setTimeout(function(){
														obj_msg.hide();
													},1500);
													return false;
												}
												else{
													obj_msg.html("<div style='color:red;'>文件上传失败！</div>").show();
													setTimeout(function(){
														obj_msg.hide();
													},1500);
													return false;
												}
												
											 }
										 });
									 }
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
