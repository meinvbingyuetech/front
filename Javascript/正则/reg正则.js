//��ȡ����---���������˼���� ȫ�����滻Ϊ��(*),��������([^\d])
var to_mid = parseInt(p.attr('id').replace(/[^\d]*/ig,"")); 


//�������ؼ��ּӺ�
if(keyword!=''){
	var regExp = new RegExp(keyword, 'gi');//����������ʽ��g��ʾȫ�ֵģ��������g������ҵ���һ���Ͳ���������²����ˣ�i��ʾ�����ִ�Сд
	var html = html.replace(regExp, '<label style="color:red;">'keyword'</label>');//���ҵ��Ĺؼ����滻������highlight���ԣ�
}


var regu = /^[-]|[_]|[.]|[@]|[A-Za-z]*[a-z0-9]*$/;
var regp = /^[A-Za-z]*[a-z0-9_]*$/;

var reu = regu.test(u);
if (reu == false) {
	jQuery('#msg').html("��������ʺŸ�ʽ���󣡣�");
}
var rep = regp.test(p);
if (rep == false) {
	jQuery('#msg').html("������������ʽ���󣡣�");
}