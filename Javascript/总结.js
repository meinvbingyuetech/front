/**
* �ַ���
*/
split('#')	   //��һ���ַ����ָ���ַ�������
str.substring  //�ָ��ַ���
str.length	   //��ȡ�ַ�������

/**
* JS����
*/

encodeURI()
encodeURIComponent()//URL����������ʱҪת����

decodeURI()
decodeURIComponent()

/**
* ����
*/
new Date().toLocaleString();        //��ǰ����+ʱ��
new Date().toLocaleTimeString();    //��ǰʱ��
new Date().toLocaleDateString();    //��ǰ����

getYear()           //��
getMonth()          //��
getDate()           //��
getDay()            //����
getHours()          //Сʱ
getMinutes()        //����
getSeconds()        //��


/**
* ��ʱ��
*/
setInterval(fnSetTime,1000);   //��ʱ��(������,ʱ��)
setTimeout(fn,2000);


/**
* �жϡ�ת������
*/
parseInt(obj)
parseFloat(obj)
Number(obj)    //�Ѷ����ֵת��Ϊ����
isNaN(obj)     //���������Ƿ��Ƿ�����ֵ

/**
* ����
*/
typeof()

typeof��������δ����,���صľ��� "undefined".
������Ϊ���� typeof(x) = "number"
�ַ��� typeof(x) = "string"
����ֵ typeof(x) = "boolean"
����,�����null typeof(x) = "object"
���� typeof(x) = "function"


/**
* �ַ�����ת
* split("")��ÿһ���ַ�תΪһ������Ԫ��
* reverse()���������ÿ��Ԫ��
* join("")��������������ӷ���תΪ�ַ���
*/
var sMyString = "abcdefg";
alert(sMyString.split("").reverse().join(""));



/**
* ����
*/
sort()         //�������Ԫ�ؽ�������

<script type="text/javascript">
function sortNumber(a,b)
{
return a - b
}

var arr = new Array(6)
arr[0] = "10"
arr[1] = "5"
arr[2] = "40"
arr[3] = "25"
arr[4] = "1000"
arr[5] = "1"

document.write(arr + "<br />")
document.write(arr.sort(sortNumber)) //Ҫ������ֵ�Ĵ�С�����ֽ������򣬾ͱ���ʹ��һ����������sortNumber
</script>


/**
* �����ַ���
*/
join()    //�޲�������ͬ��toString()
join("")  //�������ӷ�
join("*") //��*�������ַ�

<script type="text/javascript">

var arr = new Array(3)
arr[0] = "George"
arr[1] = "John"
arr[2] = "Thomas"

document.write(arr.join())
</script>


/**
* ����ȥ���ո񡢻���
*/
var val = $('#txt').val().replace(/^\s+|\s+$/,"");
alert(val.length);


/**
* ����
*/
var number = document.getElementById('number').value;  //�Ƿ�Ϊ����
var regular=/^\d+\.?\d*$/;
if(!regular.test(number)){
	alert('����������Ч�����֣�');
	return false;
}
function checknumber(data) {
    var re = /^[\-\+]?([0-9]\d*|0|[1-9]\d{0,2}(,\d{3})*)(\.\d+)?$/;
    if (re.test(data)) {
        return true; //������
    }else{
		return false; //��������
	}
}

<input type="text" onkeyup="if(isNaN(value))execCommand('undo')">  //ֻ����������

var num = prompt("����һ��5��100֮�������", "");

var arr = new Array(2)
arr[0] = "George"
arr[1] = "John"

var randNum = Math.floor(Math.random()*10000);  //��ȡ�����

onclick="this.src=this.src+'?123'"  //��������֤����ı���

/**
* JS ��
*/
// item1
<form onkeydown="if(event.ctrlKey && event.keyCode==13) this.submit()">

// item2
<form name="form1" action="" method="get">
<input type="text" name="url" value="" class="searchText" onkeydown="enter();" />
<input type="button" name="submit1" onclick="subform1();" value="�������Ӽ��"/>
</form>

function enter(){
if(document.addEventListener){
document.addEventListener("keypress",fireFoxHandler, true);
}else{
document.attachEvent("onkeypress",ieHandler);
}
}

function fireFoxHandler(evt){
if(evt.keyCode==13){
subform1();
}
}

function ieHandler(evt){
if(evt.keyCode==13){
subform1();
}
}

function subform1()
{
document.form1.submit1.value='�����...';
document.form1.submit1.disabled=true;
form1.submit();
}