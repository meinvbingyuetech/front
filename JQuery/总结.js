//ɾ����ǰѡ��
function delIterm(obj)
{
	$(obj).parent().parent().remove();
}


$("#rdshop").find("li").mouseover(
	function(){
		$("#rdshop").find("li").removeClass("a"); 
		$(this).addClass("a");
});


//��enter�¼�
$("body").bind('keyup',function(event) {   
	if(event.keyCode==13){
		$('#note-submit').click();
	}
});


//name����ѡ����
$("input[name='myname']").val();


/**
* ������ͨ�ô���
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
* jquery.cookie ��ʹ��
*/
$.cookie('the_cookie'); // ��ȡ cookie
$.cookie('the_cookie', 'the_value'); // �洢 cookie
$.cookie('the_cookie', 'the_value', { expires: 7,path:'/' }); // �洢һ����7�����޵�cookie
$.cookie('the_cookie','', { expires: -1 ,path:'/'}); // ɾ�� cookie


/**
* ���������
*/
$("#sel").find("option:selected").val();  //��ȡֵ
$("#sel").find("option:selected").text(); //��ȡ�ı�
$("#sel").empty();  //���������

var city = "������";
$('#city option').each(
	function(i){
		if(this.value==pindao_db){
			$(this).attr("selected","selected");
		}
	}
);


/**
* radio����
*/
var item = $("input[name='items']:checked").val(); //��ȡѡ��ֵ
$('input[@name=sex]').get(1).checked = true;  //��ѡ��ĵڶ���Ԫ��Ϊ��ǰѡ��
$("input[name='isrw']").attr("checked");


/**
* ���� animate
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
* ѭ��
*/
$('#lianjie li').each(function(){
	var mname = $(this).find('#mname').val();
	var murl = $(this).find('#murl').val();
});

/**
* AJAXǿ�ƻ�ȡ������
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
* ��Enter�¼�
*/
$(function() {
    $("#txtname").bind('keyup',
    function(event) {
        if (event.keyCode == 13) {
            login();
        }
    });
});