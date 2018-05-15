/**
* input¥¶¿Ì
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