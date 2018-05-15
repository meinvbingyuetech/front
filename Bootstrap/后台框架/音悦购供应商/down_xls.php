<?php
define('IN_ECS', true);
require_once(dirname(dirname(__FILE__))."/includes/init.php");
require_once dirname(dirname(__FILE__)).'/plugins/phpexcel/Classes/PHPExcel.php';

/*if(!is_numeric($pid)){
	die("非法请求");
}*/

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("音悦购");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '商品ID')
			->setCellValue('B1', '商品SN')
            ->setCellValue('C1', '商品名')
            ->setCellValue('D1', '现库存')
            ->setCellValue('E1', '加库存')
			->setCellValue('F1', '减库存');

$excel_num = 2;
$num = 1;

$sql = "SELECT g.goods_id,g.goods_sn,g.goods_name,s.inventory_num FROM ".$ecs->table('goods_supplier')." AS s INNER JOIN ".$ecs->table('goods')." AS g WHERE 1 AND s.goods_id=g.goods_id AND s.supplier_id =3 AND s.inventory_num >0";
$rows = $db->getAll($sql);

foreach($rows as $k=>$v){

	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$excel_num, $v['goods_id'])
			->setCellValue('B'.$excel_num, $v['goods_sn'])
			->setCellValue('C'.$excel_num, $v['goods_name'])
			->setCellValue('D'.$excel_num, $v['inventory_num'])
			->setCellValue('E'.$excel_num, '')
			->setCellValue('F'.$excel_num, '');
	$num++;
	$excel_num++;
}

////////////////////////////////////////// 下载 ////////////////////////////////////////////////////////

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="inventory_'.date("Ymd",time()).'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;




?>
<!DOCTYPE html>
<html>
<head>
   <title>下载库存模版</title>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

<h1>下载库存模版</h1>

</body>
</html>
