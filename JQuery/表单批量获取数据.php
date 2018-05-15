<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>serialize demo</title>
  <style>
  body, select {
    font-size: 12px;
  }
  form {
    margin: 5px;
  }
  p {
    color: red;
    margin: 5px;
    font-size: 14px;
  }
  b {
    color: blue;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
 
<form>
  <select name="single">
    <option>Single</option>
    <option>Single2</option>
  </select>
 
  <br>
  <select name="multiple" multiple="multiple">
    <option selected="selected">Multiple</option>
    <option>Multiple2</option>
    <option selected="selected">Multiple3</option>
  </select>
 
  <br>
  <input type="checkbox" name="check" value="check1" id="ch1">
  <label for="ch1">check1</label>
  <input type="checkbox" name="check" value="check2" checked="checked" id="ch2">
  <label for="ch2">check2</label>
 
  <br>
  <input type="radio" name="radio" value="radio1" checked="checked" id="r1">
  <label for="r1">radio1</label>
  <input type="radio" name="radio" value="radio2" id="r2">
  <label for="r2">radio2</label>
  
  <input id='username' name="username" type="text" value="meinvbingyue"/>
      
</form>
 
<p><tt id="results"></tt></p>
 
<script>
  function showValues() {
    var str = $( "form" ).serialize();
    var strArr = $( "form" ).serializeArray();
    $( "#results" ).text( str );
    
    jQuery.each( strArr, function( i, field ) {
      console.log(field.name+' - '+field.value);
    });
  }
  $( "input[type='checkbox'], input[type='radio']" ).on( "click", showValues );
  $( "select" ).on( "change", showValues );
  showValues();

/*
网友写的
$('#submit').click(function(){
	//选取表单
	var form = $('#fm');
	//获取表单数据
	var data = getFormData(form);
	//发送AJAX请求
	$.post('test.php',data,function(data){
		console.log('ok');
	});
 
});
*/
function getFormData(form){
	var data = form.serialize();
	data = decodeURI(data);
	var arr = data.split('&');
	var item,key,value,newData={};
	for(var i=0;i<arr.length;i++){
		item = arr[i].split('=');
		key = item[0];
		value = item[1];
		if(key.indexOf('[]')!=-1){
			key = key.replace('[]','');
			if(!newData[key]){
				newData[key] = [];
			}
			newData[key].push(value);
		}else{
			newData[key] = value;
		}
	}
	return newData;
}



/**
  将form中的值转换为键值对  --- 备注
  
  var data_arr = getFormJson('#form_'+type);
  var category_id = data_arr['category_id'];
*/
function getFormJson(form) {
    var o = {};
    var a = $(form).serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}
</script>
 
</body>
</html>