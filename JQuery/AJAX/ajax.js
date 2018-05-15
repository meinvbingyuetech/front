$.ajax({
	async:'false',
	url:'/api/region_get_province.html',
	type:'POST',
	dataType:'json',
	data:{},
	statusCode: {
		404: function() {
			alert( "找不到页面" );
		},
		200: function(){
			alert("请求成功");
		}
	},
	complete: function(e, xhr, settings){
	   if(e.status === 200){
			alert("200");
	   }else if(e.status === 304){
			alert("304");
	   }else{
			alert("other");
	   }
	},
	success:function(data){
		/*var html = '<option value="0">请选择:</option>';
		for(var i=0;i<data.regions.length;i++){
			html += '<option value="'+data.regions[i]['region_id']+'">'+data.regions[i]['region_name']+'</option>';
		}
		target.html(html);*/
		alert(123);

		if(typeof(data.code)!='undefined')
        {
            alert('修改成功');
        }
	},
	error:function(rs){
	    try{
	        var data = eval('('+rs.responseText+')');
	    }catch(e){
	        alert('系统繁忙，修改失败');
	    }
	    for(var i in data)
	    {
	        alert(data[i].join("\n"));
	        return false;
	    }
	}
});