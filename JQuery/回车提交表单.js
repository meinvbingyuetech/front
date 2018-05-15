//  $("#comment_space").on("click","#btn_reply",function(){    -->comment_space可以是已加载到页面的某个容器

//绑定显示回复节点事件
$("#comment_space").on("click",".replay-button",function(){
	
	//清空所有的节点
	$(".post-comt").each(function(){
		$(this).html("");
	});
	
	//插入回复节点
	var html = '<textarea style="width:90%,height:100px"></textarea><br><a id="emot_reply">表情</a><input id="btn_reply" type="button" value="回复" />';
	$(this).parents(".comment-con").siblings('.post-comt').html(html);

});

//绑定提交回复事件
$("#comment_space").on("click","#btn_reply",function(){
	var fid = $(this).parent().attr("comt-id");
	var tfid = $(this).parent().attr("top-comt-id");
	var tuid = $(this).parent().attr("to-uid");
	var cont = $(this).siblings("textarea").val();

	$.ajax({
		url:"/api/saveComt/",
		type:"post",
		data:{"fid":fid,"tfid":tfid,"aid":aid,"comt":cont,"touid":tuid,"class":_class},
		success:function(data){
			if(data==0){
				alert('回复失败！');
			}else if(data==-1){
				showid('div_dialog_login');
			}else if(data==-2){
				alert('休息一下吧！');
			}
			else if(data==-3){
				alert('不能自己回复自己！');
			}else{
				var arr = data.split("&&");
				var username = $('#cur_username').val();
				$('#reply_space_'+tfid).append('<div class="havereply" id="reply_1"><img src="http://www.imus.cn/images/reply-sf.png" class="infon"><div class="reply-all"><div class="uer-img fl"><img src="'+getUserFace(arr[0])+'"></div><div class="others fl"><div class="conversation"><i>'+username+'</i> 对 <i>'+arr[1]+'</i> 说：<span class="fr">'+getDate()+'</span></div><div class="comment-content">'+arr[2]+'</div></div><div style="clear:both;"></div></div></div>');
			}
		}
	});
});