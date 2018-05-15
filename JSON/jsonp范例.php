<?php
$arr = array("msg"=>"you name is ".$_GET['name'],"loop"=>array("meminfo"=>array("id"=>"2","name"=>"meinvbingyue")));
echo $_GET['jsoncallback'].'('.json_encode($arr).')';

if(isset($_GET['jsoncallback'])){
	die($_GET['jsoncallback'].'('.json_encode($arr).')');
}
?>

function get_data(){
	$.ajax({
		async:false,
		url:'http://app.imus.cn/async.php',
		type: "GET",
		dataType: 'jsonp',
		data:{name:'meinvbingyue'},
		jsonp: 'jsoncallback',
		success: function (data) {
			alert(data.msg+" - "+data.loop.meminfo.id+" - "+data.loop.meminfo.name);
		}
	});
}