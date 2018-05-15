//删除当前选项
function delIterm(obj)
{
	$(obj).parent().parent().remove();
}


$("#rdshop").find("li").mouseover(
	function(){
		$("#rdshop").find("li").removeClass("a"); 
		$(this).addClass("a");
});


//绑定enter事件
$("body").bind('keyup',function(event) {   
	if(event.keyCode==13){
		$('#note-submit').click();
	}
});


//name属性选择器
$("input[name='myname']").val();


/**
* 导航条通用代码
*/
$(function(){

  var j = 0;
  var link =window.location.href;
  $(".menu ul li").each(function(i){
   var url = $(this).find("a").attr("href");
   if(link.indexOf(url)>-1){
		$(this).attr("class","this");
		j++;

   }
   });

	if(j==2){
		$(".menu ul li").each(function(i){
			if(i==0){
				$(this).removeAttr("class");
				return false;
			}
	   });
	}
});


/**
* jquery.cookie 的使用
*/
$.cookie('the_cookie'); // 读取 cookie
$.cookie('the_cookie', 'the_value'); // 存储 cookie
$.cookie('the_cookie', 'the_value', { expires: 7,path:'/' }); // 存储一个带7天期限的cookie
$.cookie('the_cookie','', { expires: -1 ,path:'/'}); // 删除 cookie


/**
* 下拉框操作
*/
$("#sel").find("option:selected").val();  //获取值
$("#sel").find("option:selected").text(); //获取文本
$("#sel").empty();  //清空下拉框

var city = "广州市";
$('#city option').each(
	function(i){
		if(this.value==pindao_db){
			$(this).attr("selected","selected");
		}
	}
);


/**
* radio操作
*/
var item = $("input[name='items']:checked").val(); //获取选中值
$('input[@name=sex]').get(1).checked = true;  //单选组的第二个元素为当前选中
$("input[name='isrw']").attr("checked");


/**
* 动画 animate
*/
$(function(){
	$("button").click(function(){
		$("#block").animate({
			opacity: "0.5",
			width: "80%",
			height: "100px",
			borderWidth: "5px",
			fontSize: "30px",
			marginTop: "40px",
			marginLeft: "20px"
		},2000);
	});
});


/**
* 循环
*/
$('#lianjie li').each(function(){
	var mname = $(this).find('#mname').val();
	var murl = $(this).find('#murl').val();
});

/**
* AJAX强制获取新内容
*/
$.ajax({
    type: "get",
    url: "action_common.php",
    data:{id:val},	
    cache: false,
    ifModified: true,
    success: function(data) {
        alert(data);
    }
});

/**
* 绑定Enter事件
*/
$(function() {
    $("#txtname").bind('keyup',
    function(event) {
        if (event.keyCode == 13) {
            login();
        }
    });
});