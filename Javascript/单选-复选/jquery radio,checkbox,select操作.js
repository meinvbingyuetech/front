radio单选组的第二个元素为当前选中：$('input[@name=sex]').get(1).checked = true;

if($(this).get(0).checked){}  //貌似这种判断比较正确

单选组radio获取选中值：var item = $("input[name='items']:checked").val();


--------------------------------------------------------------------------------------------------------------------------------------------------------


多选框checkbox：	//注意、HTML代码里的name不用中括号[]

判断是否选中：
<input id="gritter-light" checked="" type="checkbox">
!$('#gritter-light').get(0).checked ? ' gritter-light' : ''

$("input[name='can_over']").each(function(key,item){//不行的话，省去单引号试试
	//if($(this).get(0).checked){		   //------------>这样也可以
	if($(this).attr("checked")=='checked'){//------------>这样判断貌似有时候也有用（静态的时候，动态就不行了）  
		alert(key+':选中');
	}else{
		alert(key+':没选中');
	}
});

$("input[name=chk_partner]").each(function(key,item){
	if($(this).get(0).checked){
		check_num++;
	}
});

if($("#is_default").get(0).checked){
	// true
}

/******案例******/
var str = '';
$("input[name='notice_id']").each(function(key,item){
		if($(this).get(0).checked){
				str += $(item).val()+',';
		}
		str = str.substring(0,str.length-1);
});

/****************/
var f='';
$("input[name='chk_list']").each(function(){
	if($(this).get(0).checked){if(f){f+=",";}f+=$(this).attr("data");}
});

if(f==''){
	alert('请至少选中一件商品！');
}
else{
	location.href='/checkout.html?goods_id='+f;
}

--------------------------------------------------------------------------------------------------------------------------------------------------------


获取Select ：

获取select 选中的 text:
   $("#sel").find("option:selected").text();
获取select选中的 value:

   $("#sel").val();
获取select选中的索引:
     $("#sel").get(0).selectedIndex;

获取select中option的个数:
var nums = $('#SongList option').size();

设置select: 

设置select 选中的索引：
     $("#sel").get(0).selectedIndex=index;//index为索引值
	 $("#province").get(0).value=value;
  设置select 选中的value：
    $("#sel").attr("value","Normal");
    $("#sel").val("Normal");
    $("#sel").get(0).value = value;
  设置select 选中的text:
var count=$("#sel").size();
  for(var i=0;i<count;i++)  
     {           if($("#sel").get(0).options.text == text)  
        {  
            $("#sel").get(0).options.selected = true;  
            break;  
        }  
    }

//添加下拉框的option
$("<option value='1'>1111</option>").appendTo("#sel");

//清空 Select:
$("#sel").empty();


------------------------------------------------------------------------------------------------------

JQuery对Select的操作
一、获取选择的值
$("#select_id").find("option:selected").text()
$("#select_id").val()
二、选中
1. $("#select_id ").get(0).selectedIndex=1;  //设置Select索引值为1的项选中
2. $("#select_id ").val(4);   //设置Select的Value值为4的项选中
3. $("#select_id option[text='jQuery']").attr("selected", true);   //设置Select的Text值为jQuery的项选中
 
三、添加、删除项
1. $("#select_id").append("<option value='Value'>Text</option>");  //为Select追加一个Option(下拉项)
2. $("#select_id").prepend("<option value='0'>请选择</option>");  //为Select插入一个Option(第一个位置)
3. $("#select_id option:last").remove();  //删除Select中索引值最大Option(最后一个)
4. $("#select_id option[index='0']").remove();  //删除Select中索引值为0的Option(第一个)
5. $("#select_id option[value='3']").remove();  //删除Select中Value='3'的Option
5. $("#select_id option[text='4']").remove();  //删除Select中Text='4'的Option
四、触发选择项事件
$("#select_id").change(function(){//code...});   //为Select添加事件，当选择其中一项时触发