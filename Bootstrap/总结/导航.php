<?php
$class_index = ' class="active"';

if(strstr($_SERVER['PHP_SELF'],"notice")){
	$class_notice = ' class="active"';
	$class_index = '';
}
?>
<ul class="nav nav-pills">
  <li<?php echo $class_index;?>><a href="index.php">主页</a></li>
  <li<?php echo $class_notice;?>><a href="notice.php">公告管理</a></li>
  <li><a href="cash.php">提现申请</a></li>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">代理帐号<span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="agent.php">列表数据</a></li>
      <li><a href="agent_add.php">增加帐号</a></li>
      <!--<li class="divider"></li>
      <li>
        <a href="#">分离的链接</a>
	  </li>-->
    </ul>
  </li>
</ul>