<script>

/*
 AJAX分页
 */
function RJ_Pagebar(opt){
    if(!opt.id){ return false};
    if(!opt.PageCount){return false};
    var _obj = document.getElementById(opt.id);
    var _cp = parseInt(opt.CurrentPage)>parseInt(opt.PageCount)?1:parseInt(opt.CurrentPage)||1;
    //var _sc = parseInt(opt.SingleCount)>parseInt(opt.PageCount)?7:parseInt(opt.SingleCount)||7;
    var _sc = parseInt(opt.SingleCount)>parseInt(opt.PageCount)?parseInt(opt.PageCount):parseInt(opt.SingleCount);
    var _pc = parseInt(opt.PageCount);
    if(_sc%2==0){_sc=_sc-1};

    var callback = opt.callback || function(){};

    if(_cp!=1)
    {
        var oA=document.createElement('a');
        oA.href="#1";
        //oA.innerHTML=lang_pagesy;
        oA.innerHTML="01";
        _obj.appendChild(oA);

        var oA=document.createElement('a');
        oA.href="#"+(_cp-1);
        oA.innerHTML="上一页";
        _obj.appendChild(oA);
    }
    else
    {
        var oS=document.createElement('span');
        oS.className="RU-pagedisabled";
        //oS.innerHTML=lang_pagesy;
        oS.innerHTML="01";
        //_obj.appendChild(oS);

        var oS=document.createElement('span');
        oS.className="RU-pagedisabled";
        oS.innerHTML="上一页";
        //_obj.appendChild(oS);
    }

    if(_cp<=(_sc-1)/2)
    {
        for(i=1;i<=_sc;i++)
        {
            if(i==_cp)
            {
                var oS=document.createElement('span');
                oS.className='RU-pagenow';
                oS.innerHTML=i.toString().length==1?"0"+i:i;
                _obj.appendChild(oS);
            }
            else
            {
                var oA=document.createElement('a');
                oA.href="#"+i;
                oA.innerHTML=i.toString().length==1?"0"+i:i;
                _obj.appendChild(oA);
            }
        }
        var oS=document.createElement('span');
        oS.innerHTML="…";
        //_obj.appendChild(oS);
    }
    else if(_cp<=_pc&&_cp>=_pc-(_sc-1)/2)
    {
        var oS=document.createElement('span');
        oS.innerHTML="…";
        //_obj.appendChild(oS);
        for(i=_pc-_sc+1;i<=_pc;i++)
        {
            if(i==_cp)
            {
                var oS=document.createElement('span');
                oS.className='RU-pagenow';
                oS.innerHTML=i.toString().length==1?"0"+i:i;
                _obj.appendChild(oS);
            }
            else
            {
                var oA=document.createElement('a');
                oA.href="#"+i;
                oA.innerHTML=i.toString().length==1?"0"+i:i;
                _obj.appendChild(oA);
            }
        }
    }
    else
    {
        var oS=document.createElement('span');
        oS.innerHTML="…";
        //_obj.appendChild(oS);

        for(i=_cp-(_sc-1)/2;i<(parseInt(_cp)+parseInt(_sc)-(_sc-1)/2);i++)
        {
            if(i==_cp)
            {
                var oS=document.createElement('span');
                oS.className='RU-pagenow';
                oS.innerHTML=i.toString().length==1?"0"+i:i;
                _obj.appendChild(oS);
            }
            else
            {
                var oA=document.createElement('a');
                oA.href="#"+i;
                oA.innerHTML=i.toString().length==1?"0"+i:i;
                _obj.appendChild(oA);
            }
        }
        var oS=document.createElement('span');
        oS.innerHTML="…";
        //_obj.appendChild(oS);
    }

    if(_cp!=_pc)
    {
        var oA=document.createElement('a');
        oA.href="#"+(_cp+1);
        oA.innerHTML="下一页";
        _obj.appendChild(oA);

        var oA=document.createElement('a');
        oA.href="#"+(opt.PageCount);
        //oA.innerHTML=lang_pagemy;
        oA.innerHTML=opt.PageCount.toString().length==1?"0"+opt.PageCount:opt.PageCount;
        _obj.appendChild(oA);
    }
    else
    {
        var oS=document.createElement('span');
        oS.className="RU-pagedisabled";
        oS.innerHTML="下一页";
        //_obj.appendChild(oS);

        var oS=document.createElement('span');
        oS.className="RU-pagedisabled";
        //oS.innerHTML=lang_pagemy;
        oS.innerHTML=opt.PageCount.toString().length==1?"0"+opt.PageCount:opt.PageCount;
        //_obj.appendChild(oS);
    }

    callback(_cp,_pc);

    var cA=_obj.getElementsByTagName('a');
    for (var i=0;i<cA.length;i++)
    {
        cA[i].onclick=function(){
            var pagenum=parseInt(this.getAttribute('href').substring(1));
            _obj.innerHTML="";
            RJ_Pagebar({
                id:opt.id, //容器ID : 必选参数
                CurrentPage:pagenum,   //当前页 ： 可选参数，默认值为1
                SingleCount:opt.SingleCount,   //显示数目： 可选参数，只能为奇数，默认值为7，
                PageCount:opt.PageCount,   //必选参数
                callback:callback
            })
            return false;
        }
    }
}

/**
 *晒单列表+ajax分页
 *comment_list({"goods_id":1})
 */
function comment_list(param)
{
    $("#comment_paper").html("").hide();
    $.ajax({
	  async:false,
	  dataType:"jsonp",
	  jsonp: 'jsoncallback',
	  url:"http://www.musgou.com/api/item-get-comt.html",
	  data:{"id":param.goods_id,"page":1},
	  type:"post",
	  success:
	  function(data){
		show_comment(data);
		RJ_Pagebar({
			id:'comment_paper',
			CurrentPage:1,					//当前页
			SingleCount:7,					//分页个数(只能为奇数)
			PageCount:data.total_page,		//必选参数
			callback : function(pagenow,pagecount){
				$.ajax({
				  async:false,
			      dataType:"jsonp",
				  jsonp: 'jsoncallback',
				  url:"http://www.musgou.com/api/item-get-comt.html",
				  data:{"id":param.goods_id,"page":pagenow},
				  type:"post",
				  success:
				  function(data){
					  show_comment(data);
				  }
				});
			}
		})
	  }
	});
}

/*
 显示晒单HTML
 */
function show_comment(data){
	if(data.total_page>1){
		$("#comment_paper").show();
	}

	var html = '<ul>';
	var html_right = '';
	if(data.total_num==0){
		html += '<div style="text-align:center;height:100px; line-height:100px;">「暂无晒单」</div>';
	}
	else{
		$(".really").hide();
		$("#comment_num").html("（"+data.total_num+"）");
		for(var i=0;i<data.list.length;i++){
			
			//晒图
			var litpic = data.list[i].litpic;
			var arr_litpic = litpic.split(",");
			var html_litpic = ' <div class="show-play" ><span class="close">×</span><span id="keepup"><i></i>收起</span> | <span id="keepupfl"><i></i>向左旋转</span> | <span id="keepupfr"><i></i> 向右旋转</span>    <ul class="bigImg">';
			for(var y=0;y<arr_litpic.length;y++){
				if(arr_litpic[y]!=''){
					html_litpic += '<li><img src="'+arr_litpic[y]+'"></li>';
				}			
			}
			html_litpic += '</ul><div class="smallScroll"><a class="sPrev prevStop" > < </a><div class="smallImg">    <div class="tempWrap" >	<ul>';
			for(var z=0;z<arr_litpic.length;z++){
				var _class = '';
				if(arr_litpic[z]!=''){
					if(z==0){
						_class = ' class="on"'; 
					}
					if(z==(arr_litpic.length-1)){
						_class = ' style="margin-right:0;"';
					}
					html_litpic += '<li'+_class+'><img src="'+arr_litpic[z]+'" width="48" height="48"></li>';
				}			
			}
			html_litpic += '</ul></div></div><a class="sNext"> > </a></div></div>';
			
			var html_litpic2 = '';
			for(var z=0;z<arr_litpic.length;z++){
				var _class = '';
				if(arr_litpic[z]!=''){
					if(z==0){
						_class = ' class="on"'; 
					}
					html_litpic2 += '<li'+_class+'><img src="'+arr_litpic[z]+'" width="120" height="120"></li>';
				}			
			}
                            
			html += '<li><div class="cont-list clearfix"><div class="show-user fl"><img src="/'+data.list[i].user_info.face_link+'" height="60" width="60"></div><div class="show-cont fl"><span class="star xin'+data.list[i].rank+'"></span><div class="show-text">'+data.list[i].cont+'</div><div class="show-img  clearfix"><ul class="img-list clearfix" >'+html_litpic2+'</ul></div><div class="musgou-answer" style="display:none;"><p><span>官方回复：</span>内容...</p></div></div></div><div class="show-time clearfix"><span class="fl">来自于<i>'+data.list[i].uname+' '+data.list[i].date+'</i></span><span class="fr" style="display:none;"><em></em>有帮助(3)</span></div></li>';
			
			html_right += '<li><p>'+data.list[i].cont+'</p><div class="time clearfix"><span class="fl">发表：'+data.list[i].uname+'</span><span class="fr">'+data.list[i].date2+'</span></div></li>';

		}
		$(".really ul").html(html_right);
		$(".really").show();
	}
	html += '</ul><div id="markimg">'+html_litpic+'</div>';
	$("#blueprint_list").html(html);
	
	$("#comment_num_2").html(data.total_num);
	$("#like_persent").html(data.like_persent);
	$(".eval1").html(data.rank_1+'人');
	$(".eval2").html(data.rank_2+'人');
	$(".eval3").html(data.rank_3+'人');
	$(".eval4").html(data.rank_4+'人');
	$(".eval5").html(data.rank_5+'人');
}
</script>

<?php

/*------------------------------------------------------ */
//-- 显示评论内容
/*------------------------------------------------------ */
if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'get_comt'){
	$id   = !empty($_REQUEST['id'])   ? intval($_REQUEST['id'])   : 0;
	$type = !empty($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
	
	/*$keywords_original = trim($_REQUEST['keyword']);//原始搜索词
	$keywords_show = urldecode($keywords_original);//页面显示用的
	$keywords_db = htmlspecialchars(addslashes($keywords_show));//数据库操作用的*/

	$page   = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$maxsize = 10;
	$begin = ($page-1)*$maxsize;
	
	$where = " AND comment_type={$type} AND id_value={$id} AND status=1";

	//数据
	$sql = "SELECT comment_id AS id,user_id AS uid,add_time AS time,comment_rank AS rank,content AS cont,user_name AS uname,litpic,order_sn FROM " . $ecs->table('comment') . " WHERE 1 $where ORDER BY `comment_id` DESC LIMIT {$begin},{$maxsize}";
	$rows = $db->getAll($sql);
	
	$arr = array();
	foreach($rows as $v){
		$v['date'] = date("Y年m月d日 H:i",$v['time']);
		$v['date2'] = date("Y-m-d",$v['time']);
		if($v['uname']==''){
			$v['uname'] = '匿名用户';
		}
		else{
			$v['user_info'] = get_user_info($v['uid']);
		}
		$arr[] = $v;
	}
	$res['list'] = $arr;
	//print_r($arr);exit;
	
	//统计
	$sql_record = "SELECT COUNT(`comment_id`) FROM " . $ecs->table('comment') . " WHERE 1 $where";
	$record = $db->getOne($sql_record);
	$total_page = ceil($record/$maxsize);
	$res['total_page'] = $total_page;
	$res['total_num'] = $record;
	
	//星级
	$sql_rank_5 = "SELECT COUNT(`comment_id`) FROM " . $ecs->table('comment') . " WHERE 1 $where AND `comment_rank`=5";
	$rank_5 = $db->getOne($sql_rank_5);
	$res['rank_5'] = $rank_5;

	$sql_rank_4 = "SELECT COUNT(`comment_id`) FROM " . $ecs->table('comment') . " WHERE 1 $where AND `comment_rank`=4";
	$rank_4 = $db->getOne($sql_rank_4);
	$res['rank_4'] = $rank_4;

	$sql_rank_3 = "SELECT COUNT(`comment_id`) FROM " . $ecs->table('comment') . " WHERE 1 $where AND `comment_rank`=3";
	$rank_3 = $db->getOne($sql_rank_3);
	$res['rank_3'] = $rank_3;

	$sql_rank_2 = "SELECT COUNT(`comment_id`) FROM " . $ecs->table('comment') . " WHERE 1 $where AND `comment_rank`=2";
	$rank_2 = $db->getOne($sql_rank_2);
	$res['rank_2'] = $rank_2;

	$sql_rank_1 = "SELECT COUNT(`comment_id`) FROM " . $ecs->table('comment') . " WHERE 1 $where AND `comment_rank`=1";
	$rank_1 = $db->getOne($sql_rank_1);
	$res['rank_1'] = $rank_1;
	
	//满意率
	$like_persent = round(($rank_5/$record)*100,1);
	if($like_persent==0){$like_persent='100';}
	$res['like_persent'] = $like_persent;
	
	jsonp_json_callback($res);
}


/**
* jsonp或者json返回数据，优先jsonp
*/
function jsonp_json_callback($arr){
	if(isset($_REQUEST['jsoncallback'])){
		die($_REQUEST['jsoncallback'].'('.json_encode($arr).')');
	}

	die(json_encode($arr));
}
?>