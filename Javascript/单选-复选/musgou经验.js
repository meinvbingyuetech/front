<script type="text/javascript">
<!--
	/* 点击不可叠加 radio */
	$("input[name='cannot_over']").click(function(){

		var bonus_id = '';
		var bonus_money = 0;
		$('input:radio[name=cannot_over]').each(function(key,item){
			if($(this).get(0).checked){
				bonus_id = $(this).val();
				bonus_money = parseFloat($(this).attr("money"));
			}
		});

		$("input[name='can_over']").each(function(key,item){//取消所有checkbox选项
			$(this).removeAttr("checked");
		});

		//alert(bonus_id+' --> '+bonus_money);
		assign_bonus(bonus_money,bonus_id);
	});

	/* 点击可叠加 checkbox //注意、HTML代码里的name不用中括号[] */
	$("input[name='can_over']").click(function(){
		
		var bonus_id = '';
		var bonus_money = 0;
		$("input[name='can_over']").each(function(key,item){
			if($(this).get(0).checked){
				bonus_id += $(this).val()+',';
				bonus_money = bonus_money + parseFloat($(this).attr("money"));
			}
		});
		bonus_id = bonus_id.substr(0,parseInt(bonus_id.length)-1);

		$('input:radio[name=cannot_over]').each(function(key,item){//取消所有radio选项
			$(this).removeAttr("checked");
		});

		//alert(bonus_id+' --> '+bonus_money);
		assign_bonus(bonus_money,bonus_id);
	});

//-->
</script>