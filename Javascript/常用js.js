//生成1-10000之间的随机数
var num = Math.floor(Math.random()*10000+1);

//弹出窗口
window.open ("my_make_hua.php?first=1&hid="+qstr, 'newwindow2', 'height=500, width=1000, top=300, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');

var posLeft = window.event.clientY-200;
var posTop = window.event.clientX-300;
window.open("file.php", "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);

//弹出新窗口，而不产生http_referer
function ow(owurl){
	var tmp=window.open("about:blank","")
	tmp.moveTo(0,0)
	tmp.resizeTo(screen.width+20,screen.height)
	tmp.focus()
	tmp.location=owurl
}

//复制内容到剪贴板
window.clipboardData.setData('text', "第");

//读写cookie函数
function getCookie(c_name)
{
	if (document.cookie.length > 0)
	{
		c_start = document.cookie.indexOf(c_name + "=")
		if (c_start != -1)
		{
			c_start = c_start + c_name.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1)
			{
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null
}
function setCookie(c_name,value,expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //使设置的有效时间正确。增加toGMTString()
}



//获取地址栏的文件名
function GetPageName()
{
var url=window.location.href;//获取完整URL
var tmp= new Array();//临时变量，保存分割字符串
tmp=url.split("/");//按照"/"分割
var pp = tmp[tmp.length-1];//获取最后一部分，即文件名和参数
tmp=pp.split("?");//把参数和文件名分割开
return tmp[0];
//return tmp[0].substring(0,6);
}

//获取地址栏后面的参数  e.g://var IP=getURL("ip"); //alert(IP);
function getURL() {
    var Url = top.window.location.href;
    var u, g, StrBack = '';
    if (arguments[arguments.length - 1] == "#") u = Url.split("#");
    else u = Url.split("?");
    if (u.length == 1) g = '';
    else g = u[1];
    if (g != '') {
        gg = g.split("&");
        var MaxI = gg.length;
        str = arguments[0] + "=";
        for (i = 0; i < MaxI; i++) {
            if (gg[i].indexOf(str) == 0) {
                StrBack = gg[i].replace(str, "");
                break;
            }
        }
    }
    return StrBack;
}

var str=(($('#txtcomment').val().replace(/<(.+?)>/gi,"&lt;&gt;")).replace(/%20/gi,"&nbsp;")).replace(/\n/gi,"<br/>");

//去掉字符串前后的空格和换行符
$('#txtcomment').val().replace(/^\s+|\s+$/,"");


var word = encodeURI(encodeURI(word));

//去除空格
function Trim(str){
return str.replace(/(^\s*)|(\s*$)/g, "");
}


//检查邮件地址的合法性
function checkMail(str)
 {
    var mailArray;
    var patterns = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
    mailArray = str.split(",");
    for (i = 0; i < mailArray.length; i++)
    {
        if (patterns.test(mailArray[i]))
        {
            return true;

        }
        else
        {
            return false;

        }

    }

}

//检查手机的合法性
var telReg = !!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
if(isNaN(mobile) || mobile.length!=11 || telReg == false){
	alert('手机号码不合法');
	$("#mobile").focus();
	return false;
}