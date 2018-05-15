<?php
define('IN_ECS', true);
require(dirname(dirname(__FILE__)) . '/includes/init.php');
require(dirname(__FILE__) . '/function.php');

if (!defined('LOGIN_PAGE'))
{
   //判断是否登录
   if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	   die("<script>location.href='/login.php';</script>");
   }
}
?>