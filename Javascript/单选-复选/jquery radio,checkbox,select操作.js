radio��ѡ��ĵڶ���Ԫ��Ϊ��ǰѡ�У�$('input[@name=sex]').get(1).checked = true;

if($(this).get(0).checked){}  //ò�������жϱȽ���ȷ

��ѡ��radio��ȡѡ��ֵ��var item = $("input[name='items']:checked").val();


--------------------------------------------------------------------------------------------------------------------------------------------------------


��ѡ��checkbox��	//ע�⡢HTML�������name����������[]

�ж��Ƿ�ѡ�У�
<input id="gritter-light" checked="" type="checkbox">
!$('#gritter-light').get(0).checked ? ' gritter-light' : ''

$("input[name='can_over']").each(function(key,item){//���еĻ���ʡȥ����������
	//if($(this).get(0).checked){		   //------------>����Ҳ����
	if($(this).attr("checked")=='checked'){//------------>�����ж�ò����ʱ��Ҳ���ã���̬��ʱ�򣬶�̬�Ͳ����ˣ�  
		alert(key+':ѡ��');
	}else{
		alert(key+':ûѡ��');
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

/******����******/
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
	alert('������ѡ��һ����Ʒ��');
}
else{
	location.href='/checkout.html?goods_id='+f;
}

--------------------------------------------------------------------------------------------------------------------------------------------------------


��ȡSelect ��

��ȡselect ѡ�е� text:
   $("#sel").find("option:selected").text();
��ȡselectѡ�е� value:

   $("#sel").val();
��ȡselectѡ�е�����:
     $("#sel").get(0).selectedIndex;

��ȡselect��option�ĸ���:
var nums = $('#SongList option').size();

����select: 

����select ѡ�е�������
     $("#sel").get(0).selectedIndex=index;//indexΪ����ֵ
	 $("#province").get(0).value=value;
  ����select ѡ�е�value��
    $("#sel").attr("value","Normal");
    $("#sel").val("Normal");
    $("#sel").get(0).value = value;
  ����select ѡ�е�text:
var count=$("#sel").size();
  for(var i=0;i<count;i++)  
     {           if($("#sel").get(0).options.text == text)  
        {  
            $("#sel").get(0).options.selected = true;  
            break;  
        }  
    }

//����������option
$("<option value='1'>1111</option>").appendTo("#sel");

//��� Select:
$("#sel").empty();


------------------------------------------------------------------------------------------------------

JQuery��Select�Ĳ���
һ����ȡѡ���ֵ
$("#select_id").find("option:selected").text()
$("#select_id").val()
����ѡ��
1. $("#select_id ").get(0).selectedIndex=1;  //����Select����ֵΪ1����ѡ��
2. $("#select_id ").val(4);   //����Select��ValueֵΪ4����ѡ��
3. $("#select_id option[text='jQuery']").attr("selected", true);   //����Select��TextֵΪjQuery����ѡ��
 
������ӡ�ɾ����
1. $("#select_id").append("<option value='Value'>Text</option>");  //ΪSelect׷��һ��Option(������)
2. $("#select_id").prepend("<option value='0'>��ѡ��</option>");  //ΪSelect����һ��Option(��һ��λ��)
3. $("#select_id option:last").remove();  //ɾ��Select������ֵ���Option(���һ��)
4. $("#select_id option[index='0']").remove();  //ɾ��Select������ֵΪ0��Option(��һ��)
5. $("#select_id option[value='3']").remove();  //ɾ��Select��Value='3'��Option
5. $("#select_id option[text='4']").remove();  //ɾ��Select��Text='4'��Option
�ġ�����ѡ�����¼�
$("#select_id").change(function(){//code...});   //ΪSelect����¼�����ѡ������һ��ʱ����