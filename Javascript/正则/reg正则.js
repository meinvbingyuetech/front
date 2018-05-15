//获取整数---》正则的意思就是 全部都替换为空(*),除了整数([^\d])
var to_mid = parseInt(p.attr('id').replace(/[^\d]*/ig,"")); 


//给搜索关键字加红
if(keyword!=''){
	var regExp = new RegExp(keyword, 'gi');//创建正则表达式，g表示全局的，如果不用g，则查找到第一个就不会继续向下查找了；i表示不区分大小写
	var html = html.replace(regExp, '<label style="color:red;">'keyword'</label>');//将找到的关键字替换，加上highlight属性；
}


var regu = /^[-]|[_]|[.]|[@]|[A-Za-z]*[a-z0-9]*$/;
var regp = /^[A-Za-z]*[a-z0-9_]*$/;

var reu = regu.test(u);
if (reu == false) {
	jQuery('#msg').html("您输入的帐号格式有误！！");
}
var rep = regp.test(p);
if (rep == false) {
	jQuery('#msg').html("您输入的密码格式有误！！");
}