/**
* 字符串
*/
split('#')	   //把一个字符串分割成字符串数组
str.substring  //分割字符串
str.length	   //获取字符串长度

/**
* JS编码
*/

encodeURI()
encodeURIComponent()//URL链接有中文时要转下码

decodeURI()
decodeURIComponent()

/**
* 日期
*/
new Date().toLocaleString();        //当前日期+时间
new Date().toLocaleTimeString();    //当前时间
new Date().toLocaleDateString();    //当前日期

getYear()           //年
getMonth()          //月
getDate()           //日
getDay()            //星期
getHours()          //小时
getMinutes()        //分钟
getSeconds()        //秒


/**
* 定时器
*/
setInterval(fnSetTime,1000);   //定时器(函数名,时间)
setTimeout(fn,2000);


/**
* 判断、转换类型
*/
parseInt(obj)
parseFloat(obj)
Number(obj)    //把对象的值转换为数字
isNaN(obj)     //检查其参数是否是非数字值

/**
* 类型
*/
typeof()

typeof的运算数未定义,返回的就是 "undefined".
运算数为数字 typeof(x) = "number"
字符串 typeof(x) = "string"
布尔值 typeof(x) = "boolean"
对象,数组和null typeof(x) = "object"
函数 typeof(x) = "function"


/**
* 字符串反转
* split("")将每一个字符转为一个数组元素
* reverse()反序数组的每个元素
* join("")再最后将数组无连接符的转为字符串
*/
var sMyString = "abcdefg";
alert(sMyString.split("").reverse().join(""));



/**
* 排序
*/
sort()         //对数组的元素进行排序

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
document.write(arr.sort(sortNumber)) //要按照数值的大小对数字进行排序，就必须使用一个排序函数：sortNumber
</script>


/**
* 连接字符串
*/
join()    //无参数，等同于toString()
join("")  //不用连接符
join("*") //用*号连接字符

<script type="text/javascript">

var arr = new Array(3)
arr[0] = "George"
arr[1] = "John"
arr[2] = "Thomas"

document.write(arr.join())
</script>


/**
* 正则去除空格、换行
*/
var val = $('#txt').val().replace(/^\s+|\s+$/,"");
alert(val.length);


/**
* 其他
*/
var number = document.getElementById('number').value;  //是否为数字
var regular=/^\d+\.?\d*$/;
if(!regular.test(number)){
	alert('请您输入有效的数字！');
	return false;
}
function checknumber(data) {
    var re = /^[\-\+]?([0-9]\d*|0|[1-9]\d{0,2}(,\d{3})*)(\.\d+)?$/;
    if (re.test(data)) {
        return true; //是数字
    }else{
		return false; //不是数字
	}
}

<input type="text" onkeyup="if(isNaN(value))execCommand('undo')">  //只能输入数字

var num = prompt("输入一个5到100之间的数字", "");

var arr = new Array(2)
arr[0] = "George"
arr[1] = "John"

var randNum = Math.floor(Math.random()*10000);  //获取随机数

onclick="this.src=this.src+'?123'"  //可用于验证码的文本框

/**
* JS 表单
*/
// item1
<form onkeydown="if(event.ctrlKey && event.keyCode==13) this.submit()">

// item2
<form name="form1" action="" method="get">
<input type="text" name="url" value="" class="searchText" onkeydown="enter();" />
<input type="button" name="submit1" onclick="subform1();" value="友情链接检查"/>
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
document.form1.submit1.value='检查中...';
document.form1.submit1.disabled=true;
form1.submit();
}