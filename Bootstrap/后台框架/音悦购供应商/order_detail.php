<?php
include_once(dirname(__FILE__)."/config.php");


/************** 查操作记录 ********************/
if($_GET['action']=='action_notes'){
	$order_id = $_POST['oid'];
	$order_sn = $_POST['osn'];
	if(!is_numeric($order_id) || !is_numeric($order_sn)){
		die('1');
	}

	/* 取得订单操作记录 */
    $act_list = array();
    $sql = "SELECT * FROM " . $ecs->table('order_action') . " WHERE order_id = '$order_id' ORDER BY log_time DESC,action_id DESC";
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        /*$row['order_status']    = $_LANG['os'][$row['order_status']];
        $row['pay_status']      = $_LANG['ps'][$row['pay_status']];
        $row['shipping_status'] = $_LANG['ss'][$row['shipping_status']];*/
		$row['order_status_cur'] = '-';
		if($row['order_status']==0 && $row['shipping_status']==0 && ($row['pay_status']==0 || $row['pay_status']==1)){
            $row['order_status_cur'] = "等待付款";
        }
        if($row['order_status']==0 && $row['shipping_status']==0 && $row['pay_status']==2){
            $row['order_status_cur'] = "已付款";
        }
        if($row['order_status']==0 && $row['shipping_status']==1 && $row['pay_status']==2){
            $row['order_status_cur'] = "已配货";
        }
        if($row['order_status']==0 && $row['shipping_status']==2 && $row['pay_status']==2){
            $row['order_status_cur'] = "已发货";
        }
        if($row['order_status']==0 && $row['shipping_status']==3 && $row['pay_status']==2){
            $row['order_status_cur'] = "已收货";
        }
        if($row['order_status']==1 && $row['shipping_status']==3 && $row['pay_status']==2){
            $row['order_status_cur'] = "已完成";
        }
        if($row['order_status']==2){
            $row['order_status_cur'] = "退款成功";
        }
		if($row['order_status']==12){
            $row['order_status_cur'] = "退款审核";
        }
        $row['action_time']     = local_date($_CFG['time_format'], $row['log_time']);
        $act_list[] = $row;
    }
	die(json_encode($act_list));
}
/************** 设为已配货 ********************/
if($_GET['action']=='peihuo'){
	$action_note = $_POST['note'];
	$order_id = $_POST['oid'];
	$order_sn = $_POST['osn'];
	if(!is_numeric($order_id) || !is_numeric($order_sn)){
		die('1');
	}

	$arr['shipping_status']     = 1;
	$arr['prepare_time']     = time();
	update_order($order_id, $arr);//更新订单信息
	order_action($order_sn, 0, 1, 2, $action_note,$_SESSION['supplier_info']['suppliers_name']);//记录log
	clear_cache_files();//清除缓存
	die('1');
}
/************** 设为已发货 ********************/
if($_GET['action']=='fahuo'){
	
	$action_note = $_POST['note'];
	$order_id = $_POST['oid'];
	$order_sn = $_POST['osn'];
	$shipping_code = $_POST['shipping_no'];
	$shipping_id = $_POST['shipping_id'];
	if(!is_numeric($order_id) || !is_numeric($order_sn) || empty($shipping_code) || empty($shipping_id)){
		die('1');
	}

	$_arr_shipping = explode("-", $shipping_id);
	$arr['shipping_status']   = 2;
	$arr['shipping_time']     = time();
	$arr['shipping_id']       = $_arr_shipping[0];
	$arr['shipping_name']     = $_arr_shipping[1];
	$arr['shipping_code']     = $shipping_code;
	update_order($order_id, $arr);
	
	/**********************************************************************************/
	
	/* 生成发货单 */
	//获取发货单号
	$delivery['delivery_sn'] = get_delivery_sn();
	//获取当前操作员
	$delivery['action_user'] = $_SESSION['supplier_info']['suppliers_name'];
	$delivery['action_type'] = 2;

	//获取发货单生成时间
	$delivery['add_time'] = time();
	//订单ID
	$delivery['order_id'] = $order_id;
	
	$sql ="select `pay_sn`,`order_sn`,`invoice_no`,`shipping_id`,`shipping_name`,`user_id`,`consignee`,`address`,`country`,`province`,`city`,`district`,`sign_building`,`email`,`zipcode`,`tel`,`mobile`,`best_time`,`postscript`,`how_oos`,`insure_fee`,`shipping_fee`,`supplier_id`,`shipping_status`,`agency_id` from ". $ecs->table('order_info') ." WHERE order_id = '" . $order_id . "'";
	$order_info = $db->GetRow($sql);
	
	$delivery['status'] = $arr['shipping_status'];

	/* 过滤字段项 */
	$filter_fileds = array(
		'order_sn', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee','agency_id',
		'consignee', 'address', 'country', 'province', 'city', 'district', 'sign_building',
		'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
		'supplier_id', 'shipping_name','invoice_no'
	);
	foreach ($filter_fileds as $value)
	{
		$delivery[$value] = $order_info[$value];
	}
	
	/* 发货单入库 */
	$query = $db->autoExecute($ecs->table('delivery_order'), $delivery, 'INSERT', '', 'SILENT');
	$delivery_id = $db->insert_id();
	if ($delivery_id)
	{
		$delivery_goods = array();
		
		//获取订单里的商品
		$goods_list = $db->getAll("SELECT * FROM ".$ecs->table("order_goods")." WHERE 1 AND `order_id`=$order_id");
		//发货单商品入库
		if (!empty($goods_list))
		{
			foreach ($goods_list as $value)
			{
				$delivery_goods = array(
					'delivery_id' => $delivery_id,
					'goods_id' => $value['goods_id'],
					'product_id' => $value['product_id'],
					'goods_name' => addslashes($value['goods_name']),
					'goods_sn' => $value['goods_sn'],
					'send_number' => $value['send_number'],
					'parent_id' => $value['parent_id'],
					'is_real' => $value['is_real'],
					'goods_attr' => addslashes($value['goods_attr'])
				);
				$query = $db->autoExecute($ecs->table('delivery_goods'), $delivery_goods, 'INSERT', '', 'SILENT');
			}
		}
	}
	else
	{
		/* 操作失败 */
		
	}
	
	/**********************************************************************************/
	/* 调用支付宝接口通知买家已经发货 */
    $url = "http://www.musgou.com/plugins/pay/alipayescow/alipayapi_confirm.php";
    $data = array('WIDtrade_no' => $order_info['pay_sn'], 'WIDlogistics_name' => $arr['shipping_name'], 'WIDinvoice_no' => $arr['shipping_code'] );
    curl_post($url,$data);

	order_action($order_sn, 0, 2, 2, $action_note,$_SESSION['supplier_info']['suppliers_name']);//记录log
	clear_cache_files();//清除缓存
	die('1');
}
/************** 设为已收货 ********************/
if($_GET['action']=='shouhuo'){
	
	$action_note = $_POST['note'];
	$order_id = $_POST['oid'];
	$order_sn = $_POST['osn'];
	if(!is_numeric($order_id) || !is_numeric($order_sn)){
		die('1');
	}


	$arr['shipping_status']     = 3;
	$arr['receive_time']		= time();
	update_order($order_id, $arr);

	order_action($order_sn, 0, 3, 2, $action_note,$_SESSION['supplier_info']['suppliers_name']);//记录log
	clear_cache_files();//清除缓存
	die('1');
}
/************** 设为已确认 ********************/
if($_GET['action']=='queren'){
	
	$action_note = $_POST['note'];
	$order_id = $_POST['oid'];
	$order_sn = $_POST['osn'];
	if(!is_numeric($order_id) || !is_numeric($order_sn)){
		die('1');
	}
	order_confirm(array("order_id"=>$order_id,"order_sn"=>$order_sn,"note"=>$action_note,"note"=>$action_note,"action_user"=>$_SESSION['supplier_info']['suppliers_name']));
	die('1');
}
/************** 提交发票号 ********************/
if($_GET['action']=='add_fp'){
	$inv_no = $_POST['fp_no'];
	$order_id = $_POST['oid'];
	$order_sn = $_POST['osn'];
	if(!is_numeric($order_id) || !is_numeric($order_sn)){
		die('1');
	}
	
	$sql = "UPDATE ".$ecs->table('order_info')." SET `invoice_no`='{$inv_no}' WHERE 1 AND `order_id`='".$order_id."' ";
	$db->query($sql);
	die('1');
}


$order_id = intval(trim($_GET['id']));
$order_info = format_single_order($db->getRow("SELECT * FROM ".$ecs->table('order_info')." WHERE 1 AND order_id='{$order_id}'"));
//print_r($order_info);exit;
if(!is_numeric($order_info['order_id'])){
	header("Location:/");exit;
}

//订单来源
if(empty($order_info['referer'])){
	$order_info['referer'] = '本站';
}
//下单时间
$order_info['add_date'] = date("Y-m-d H:i:s",$order_info['add_time']);
//配货时间
if($order_info['prepare_time']==0 || empty($order_info['prepare_time'])){
	$order_info['prepare_time'] = '-';
}
else{
	$order_info['prepare_time'] = date("Y-m-d H:i:s",$order_info['prepare_time']);
}
//发货时间
if($order_info['shipping_time']==0 || empty($order_info['shipping_time'])){
	$order_info['shipping_time'] = '-';
}
else{
	$order_info['shipping_time'] = date("Y-m-d H:i:s",$order_info['shipping_time']);
}
//快递跟踪信息
$html_shipping = '';
if(!empty($order_info['shipping_code'])){
	$arr = get_ship_follow_info(array('sort'=>'asc','ship_id'=>$order_info['shipping_id'],'ship_num'=>$order_info['shipping_code'],'order_sn'=>$order_info['order_sn']));
	/*if($arr['errCode']==0){
		foreach($arr['data'] as $v){
			$html_shipping .= $v['time'].' --- '.$v['context'].PHP_EOL;
		}
	}*/
	foreach($arr as $v){
		$html_shipping .= $v['date'].' --- '.$v['content'].PHP_EOL;
	}
	//print_r($html_shipping);exit;
	if(empty($html_shipping)){$html_shipping='暂无数据';}
}
else{
	$html_shipping = '-';
}
//快递费用
if($order_info['shipping_fee']>0){
	$order_info['shipping_fee'] = $order_info['shipping_fee'];
}
else{
	$order_info['shipping_fee'] = '-';
}
//付款时间
if($order_info['pay_time']==0 || empty($order_info['pay_time'])){
	$order_info['pay_time'] = '-';
}
else{
	$order_info['pay_time'] = date("Y-m-d H:i:s",$order_info['pay_time']);
}
//付款金额
if($order_info['pay_status']==2){
	$pay_info = $db->getRow("SELECT * FROM ".$ecs->table('pay_log')." WHERE 1 AND order_id={$order_id} AND is_paid=1");
}
//商品列表
$goods_list = format_all_goods($db->getAll("SELECT *,goods_price*goods_number as total_price FROM " . $ecs->table('order_goods') . " WHERE 1 AND `order_id`=".$order_id));
//print_r($goods_list);exit;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>订单详细信息</title>
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
							<li class="active">订单详情</li>
						</ul>
						
						
					</div>
					
					<div class="page-content">
						<div class="page-header">
							<h1>
								<button class="btn" id="bootbox-regular" onclick="history.go(-1)"><i class="icon-arrow-left"></i>返回</button>
								<?php
								if(in_array($order_info['order_status'],array(0,1)) && in_array($order_info['shipping_status'],array(0,1,2,3)) && in_array($order_info['pay_status'],array(1,2))){
								?>
								<button class="btn btn-purple" id="action_notes">操作记录</button>
								<?php } ?>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php
								if($order_info['order_status']==0 && in_array($order_info['shipping_status'],array(0,1,2,3)) && in_array($order_info['pay_status'],array(1,2))){
								?>
								<h2>操作信息</h2>
								<form class="form-horizontal" role="form" name="form_action">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 备注 </label>

										<div class="col-sm-9">
											<textarea id="note" style="width:90%;height:100px;"></textarea>
										</div>
									</div>

									<?php
									if($order_info['order_status']==0 && $order_info['pay_status']==2 && $order_info['shipping_status']==1){
									?>
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 选择快递 </label>

											<div class="col-sm-9">
												<select id="shipping_id">
												<option value='0'>-请选择-</option>
												<?php
												$ship_list = shipping_list();
												foreach($ship_list as $k=>$v){
													echo "<option value='".$v['shipping_id']."-".$v['shipping_name']."'>".$v['shipping_name']."</option>";
												}
												?>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="txt_shipping_no"> 快递单号 </label>

											<div class="col-sm-9">
												<input type="text" id="txt_shipping_no" class="col-xs-10 col-sm-5" value=""/>
											</div>
										</div>
									<?php
									}
									?>	
									

									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<?php
											if($order_info['order_status']==0 && $order_info['pay_status']==2 && $order_info['shipping_status']==0){
											?>
											<button id="btn_peihuo" class="btn btn-info" type="button">
												<i class="icon-ok bigger-110"></i>
												配货
											</button>
											<?php
											}
											?>

											<?php
											if($order_info['order_status']==0 && $order_info['pay_status']==2 && $order_info['shipping_status']==1){
											?>
											<button id="btn_fahuo" class="btn btn-info" type="button">
												<i class="icon-ok bigger-110"></i>
												发货
											</button>
											<?php
											}
											?>

											<?php
											if($order_info['order_status']==0 && $order_info['pay_status']==2 && $order_info['shipping_status']==2){
											?>
											<button id="btn_shouhuo" class="btn btn-info" type="button">
												<i class="icon-ok bigger-110"></i>
												收货
											</button>
											<?php
											}
											?>

											<?php
											if($order_info['order_status']==0 && $order_info['pay_status']==2 && $order_info['shipping_status']==3){
											?>
											<button id="btn_queren" class="btn btn-info" type="button">
												<i class="icon-ok bigger-110"></i>
												确认
											</button>
											<?php
											}
											?>

											<!--&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="icon-undo bigger-110"></i>
												Reset
											</button>-->
										</div>
									</div>
								</form>
								<?php
								}
								?>
								

								<h2>订单信息</h2>
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 订单号 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['order_sn'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 下单时间 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['add_date'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 订单状态 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['order_status_cur'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 订单来源 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['referer'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

								</form>

								<h2>费用信息</h2>
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 商品金额 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['goods_amount'];?>"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 配送费用 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['shipping_fee']=='-'?'':'+';echo $order_info['shipping_fee'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 优惠券 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="-<?php echo $order_info['bonus'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 订单金额 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['order_amount'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

								</form>
								
								<h2>付款信息</h2>
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 付款方式 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['pay_name'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 付款时间 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['pay_time'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 实付金额 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $pay_info['order_amount'];?>"/>
										</div>
									</div>
									<div class="space-4"></div>

								</form>

								<h2>收货人信息</h2>
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 收货人 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['consignee'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 手机 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['mobile'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 收货地址 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['address_all'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 电话 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['tel'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 电子邮件 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['email'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 邮编 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['zipcode'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 留言 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['postscript'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

								</form>

								<h2>配送信息</h2>
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 配货时间 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['prepare_time'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 发货时间 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['shipping_time'];?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 发货单号 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['shipping_code']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 发货快递 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['shipping_name']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 发货费用 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['shipping_fee']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 送货详情 </label>

										<div class="col-sm-9">
											<textarea readonly style="width:90%;height:400px;"><?php echo $html_shipping;?></textarea>
										</div>
									</div>

									<div class="space-4"></div>

								</form>
			
								<?php
								if(!empty($order_info['inv_payee']))
								{
								?>
									<h2>发票信息</h2>
									<form class="form-horizontal" role="form">
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 发票号 </label>

											<div class="col-sm-9">
												<input type="text" id="txt_fp_no" class="col-xs-10 col-sm-5" value="<?php echo $order_info['invoice_no'];?>"/>
												&nbsp;&nbsp;
												<button id="btn_fp_no" class="btn btn-sm btn-primary">提交</button>
												<!-- 提示 start -->
												<div id="msg_fp_no" style="width:150px;display:none;" class="alert alert-danger">
													请输入发票号！
												</div>
												<!-- 提示 end -->
											</div>
										</div>

										<div class="space-4"></div>

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 发票类型 </label>

											<div class="col-sm-9">
												<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['inv_type'];?>"/>
											</div>
										</div>

										<div class="space-4"></div>

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 发票抬头 </label>

											<div class="col-sm-9">
												<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['inv_payee'];?>"/>
											</div>
										</div>

										<div class="space-4"></div>

					
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 发票内容 </label>

											<div class="col-sm-9">
												<input type="text" id="form-field-1" class="col-xs-10 col-sm-5" value="<?php echo $order_info['inv_content'];?>"/>
											</div>
										</div>

										<div class="space-4"></div>

									</form>
								<?php
								}
								?>
								
								<h2>商品信息</h2>
								<form class="form-horizontal" role="form">
									<?php
									foreach($goods_list as $k=>$v){
									?>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品<?php echo $k+1;?> </label>

										<div class="col-sm-9">
											<span><a href="<?php echo $v['goods_link'];?>" target="_blank"><img src="<?php echo $v['goods_thumb_link'];?>" /><?php echo $v['goods_name'];?></a></span>
										</div>
									</div>

									<div class="space-4"></div>
		
									<?php
									}
									?>

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
		<script type="text/javascript">
		<!--
			var oid = <?php echo $order_info['order_id'];?>;
			var osn = <?php echo $order_info['order_sn'];?>;

			//配货
			$("#btn_peihuo").on("click",function(){
				var note = $.trim($("#note").val());
				$.ajax({
					async:'false',
					url:'?action=peihuo',
					type:'post',
					data:{note:note,oid:oid,osn:osn},
					dataType:'json',
					success:
					function(data){
						location.reload(true);
					}
				});
			});
			
			//发货
			$("#btn_fahuo").on("click",function(){
				var note = $.trim($("#note").val());
				var shipping_id = $.trim($("#shipping_id").val());
				var shipping_no = $.trim($("#txt_shipping_no").val());
				
				if(shipping_id==0){
					$("body").showTopbarMessage({ width: "600px",background: "#FF3366", close: 1500, content: "请选择快递公司"});
					return false;
				}
				if(shipping_no==''){
					$("body").showTopbarMessage({ width: "600px",background: "#FF3366", close: 1500, content: "请输入快递单号"});
					return false;
				}
				$.ajax({
					async:'false',
					url:'?action=fahuo',
					type:'post',
					data:{note:note,shipping_id:shipping_id,shipping_no:shipping_no,oid:oid,osn:osn},
					dataType:'json',
					success:
					function(data){
						location.reload(true);
					}
				});
			});

			//发货
			$("#btn_shouhuo").on("click",function(){
				var note = $.trim($("#note").val());
				$.ajax({
					async:'false',
					url:'?action=shouhuo',
					type:'post',
					data:{note:note,oid:oid,osn:osn},
					dataType:'json',
					success:
					function(data){
						location.reload(true);
					}
				});
			});
			//确认
			$("#btn_queren").on("click",function(){
				var note = $.trim($("#note").val());
				$.ajax({
					async:'false',
					url:'?action=queren',
					type:'post',
					data:{note:note,oid:oid,osn:osn},
					dataType:'json',
					success:
					function(data){
						location.reload(true);
					}
				});
			});

			//操作记录
			$("#action_notes").on("click", function() {
				
				$.ajax({
					async:'false',
					url:'?action=action_notes',
					type:'post',
					data:{oid:oid,osn:osn},
					dataType:'json',
					success:
					function(data){
						if(data.length>0){
							
							var html = '<table class="table table-striped table-bordered table-hover"><thead class="thin-border-bottom"><tr><th class="col-md-4"><i class="icon-user"></i>操作者</th><th class="col-md-3">操作时间</th><th class="col-md-2">状态</th><th class="col-md-6">备注</th></tr></thead><tbody>';
							for(var i=0;i<data.length;i++){
								html += '<tr><td>'+data[i]['action_user']+'</td><td>'+data[i]['action_time']+'</td><td>'+data[i]['order_status_cur']+'</td><td>'+data[i]['action_note']+'</td></tr>';
							}
							html += '</tbody></table>';
							bootbox.dialog({
								title:"操作记录",
								message: "<span >"+html+"</span>",
								buttons: 			
								{
									"success" :
									 {
										"label" : "<i class='icon-ok'></i> 确定",
										"className" : "btn-sm btn-success",
										"callback": function() {
											//bootbox.hideAll();
										}
									}
								}
							});
						}
					}
				});

			});

			//提交发票号
			$("#btn_fp_no").on("click", function(){
				var fp_no = $.trim($("#txt_fp_no").val());
				if(fp_no==''){
					$("#msg_fp_no").show();
					setTimeout(function(){
						$("#msg_fp_no").hide();
					},3000);
					return false;
				}
				
				if(fp_no!=''){
					bootbox.dialog({
						title:"消息提示",
						message: "<span class='bigger-110'>发票号已经填写，确定重新提交吗？</span>",
						buttons: 			
						{
							"success" :
							 {
								"label" : "<i class='icon-ok'></i> 确定",
								"className" : "btn-sm btn-success",
								"callback": function() {
									add_fp({'fp_no':fp_no,'oid':oid,'osn':osn});
								}
							},
							"button" :
							{
								"label" : "取消",
								"className" : "btn-sm"
							}
						}
					});
				}
				else{
					add_fp({'fp_no':fp_no,'oid':oid,'osn':osn});
				}
				
				return false;
			});
			function add_fp(param){
				var fp_no = param.fp_no;
				var oid = param.oid;
				var osn = param.osn;
				$.ajax({
					async:'false',
					url:'?action=add_fp',
					type:'post',
					data:{fp_no:fp_no,oid:oid,osn:osn},
					dataType:'json',
					success:
					function(data){
						location.reload(true);
					}
				});
			}
									        
		//-->
		</script>
	</body>
</html>
