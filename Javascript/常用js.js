//����1-10000֮��������
var num = Math.floor(Math.random()*10000+1);

//��������
window.open ("my_make_hua.php?first=1&hid="+qstr, 'newwindow2', 'height=500, width=1000, top=300, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');

var posLeft = window.event.clientY-200;
var posTop = window.event.clientX-300;
window.open("file.php", "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);

//�����´��ڣ���������http_referer
function ow(owurl){
	var tmp=window.open("about:blank","")
	tmp.moveTo(0,0)
	tmp.resizeTo(screen.width+20,screen.height)
	tmp.focus()
	tmp.location=owurl
}

//�������ݵ�������
window.clipboardData.setData('text', "��");

//��дcookie����
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
	document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //ʹ���õ���Чʱ����ȷ������toGMTString()
}



//��ȡ��ַ�����ļ���
function GetPageName()
{
var url=window.location.href;//��ȡ����URL
var tmp= new Array();//��ʱ����������ָ��ַ���
tmp=url.split("/");//����"/"�ָ�
var pp = tmp[tmp.length-1];//��ȡ���һ���֣����ļ����Ͳ���
tmp=pp.split("?");//�Ѳ������ļ����ָ
return tmp[0];
//return tmp[0].substring(0,6);
}

//��ȡ��ַ������Ĳ���  e.g://var IP=getURL("ip"); //alert(IP);
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

//ȥ���ַ���ǰ��Ŀո�ͻ��з�
$('#txtcomment').val().replace(/^\s+|\s+$/,"");


var word = encodeURI(encodeURI(word));

//ȥ���ո�
function Trim(str){
return str.replace(/(^\s*)|(\s*$)/g, "");
}


//����ʼ���ַ�ĺϷ���
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

//����ֻ��ĺϷ���
var telReg = !!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
if(isNaN(mobile) || mobile.length!=11 || telReg == false){
	alert('�ֻ����벻�Ϸ�');
	$("#mobile").focus();
	return false;
}