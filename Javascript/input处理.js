/**
* input处理
* handle_input({"selector":"input[type=text]"});
* handle_input({"selector":"#bonus_code"});
*/

function handle_input(param){

	$(param['selector']).focus(function(){
		var _val = $(this).val();
		var _placeholder = $(this).attr("placeholder");
		if(_val==''){
			$(this).attr("_placeholder",_placeholder);
			$(this).attr("placeholder","");
		}
	}).blur(function(){
		var _val = $(this).val();
		var _placeholder = $(this).attr("_placeholder");
		if(_val==''){
			$(this).attr("placeholder",_placeholder);
		}
	});
}


//input只允许输入数字
<input id="priceMin" title="最低价" maxlength="6" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" >

//input按下enter键以后执行
<input id="page_jump_num" value="2" onkeydown="javascript:if(event.keyCode==13){page_jump();return false;}" >
<input type="text" onkeydown="javascript:if(event.keyCode==13) search('key');" autocomplete="off" id="key" accesskey="s">

//input按下一个非系统键被释放的时候执行
<input id="wd-top1" type="text" onkeyup="getContent(this);" />