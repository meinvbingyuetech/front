/**
* jquery tips 提示插件 jquery.tips.js v0.1beta
*
* 使用方法
* $(selector).tips({   //selector 为jquery选择器
*  msg:'your messages!',    //你的提示消息  必填
*  side:1,  //提示窗显示位置  1，2，3，4 分别代表 上右下左 默认为1（上） 可选
*  color:'#FFF', //提示文字色 默认为白色 可选
*  bg:'#F00',//提示窗背景色 默认为红色 可选
*  time:2,//自动关闭时间 默认2秒 设置0则不自动关闭 可选
*  x:0,//横向偏移  正数向右偏移 负数向左偏移 默认为0 可选
*  y:0,//纵向偏移  正数向下偏移 负数向上偏移 默认为0 可选
* })
*

$("#name").tips({
	side:1,
	msg:'修改成功',
	bg:'green',
	time:2,
});

<!DOCTYPE html>
<html>
    <head>
        <title>demo</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.tips.js"></script>
        <style>
        #myinput{position:relative;top:200px;left:200px;}
        </style>
        <script type="text/javascript">
            $(function (){
                $('#myinput').click(function(){
                    $(this).tips({
                        side:1,  //1,2,3,4 分别代表 上右下左
                        msg:'上方弹出消息，3秒后自动消失，鼠标悬浮时，自动延时',//tips的文本内容
                        color:'#FFF',//文字颜色，默认为白色
                        bg:'#FD9720',//背景色，默认为红色
                        time:3,//默认为2 自动关闭时间 单位为秒 0为不关闭 （点击提示也可以关闭）
                        x:0,// 默认为0 横向偏移 正数向右偏移 负数向左偏移
                        y:0 // 默认为0 纵向偏移 正数向下偏移 负数向上偏移
                    }).tips({
                        side:2,
                        msg:'右方弹出消息，5秒后自动消失，鼠标悬浮时，自动延时',
                        bg:'#AE81FF',
                        time:5
                    }).tips({
                        side:3,
                        msg:'下方弹出消息，7秒后自动消失，鼠标悬浮时，自动延时',
                        bg:'#307FC1',
                        time:7
                    }).tips({
                        side:4,
                        msg:'左方弹出消息，不自动消失，鼠标点击才会消失',
                        time:0
                    });
                });
            });
 
        </script>
    </head>
    <body>
        <input id="myinput"/>
    </body>
</html>
*/
(function ($) {
    $.fn.tips = function(options){
        var defaults = {
            side:1,
            msg:'',
            color:'#FFF',
            bg:'#F00',
            time:2,
            x:0,
            y:0
        }
        var options = $.extend(defaults, options);
        if (!options.msg||isNaN(options.side)) {
        throw new Error('params error');
    }
    if(!$('#jquery_tips_style').length){
        var style='<style id="jquery_tips_style" type="text/css">';
        style+='.jq_tips_box{padding:10px;position:absolute;overflow:hidden;display:inline;display:none;z-index:10176523;}';
        style+='.jq_tips_arrow{display:block;width:0px;height:0px;position:absolute;}';
        style+='.jq_tips_top{border-left:10px solid transparent;left:20px;bottom:0px;}';
        style+='.jq_tips_left{border-top:10px solid transparent;right:0px;top:18px;}';
        style+='.jq_tips_bottom{border-left:10px solid transparent;left:20px;top:0px;}';
        style+='.jq_tips_right{border-top:10px solid transparent;left:0px;top:18px;}';
        style+='.jq_tips_info{word-wrap: break-word;word-break:normal;border-radius:4px;padding:5px 8px;max-width:130px;overflow:hidden;box-shadow:1px 1px 1px #999;font-size:12px;cursor:pointer;}';
        style+='</style>';
        $(document.body).append(style);
    }
        this.each(function(){
            var element=$(this);
            var element_top=element.offset().top,element_left=element.offset().left,element_height=element.outerHeight(),element_width=element.outerWidth();
            options.side=options.side<1?1:options.side>4?4:Math.round(options.side);
            var sideName=options.side==1?'top':options.side==2?'right':options.side==3?'bottom':options.side==4?'left':'top';
            var tips=$('<div class="jq_tips_box"><i class="jq_tips_arrow jq_tips_'+sideName+'"></i><div class="jq_tips_info">'+options.msg+'</div></div>').appendTo(document.body);
            tips.find('.jq_tips_arrow').css('border-'+sideName,'10px solid '+options.bg);
            tips.find('.jq_tips_info').css({
                color:options.color,
                backgroundColor:options.bg
            });
            switch(options.side){
                case 1:
                    tips.css({
                        top:element_top-tips.outerHeight()+options.x,
                        left:element_left-10+options.y
                    });
                    break;
                case 2:
                    tips.css({
                        top:element_top-20+options.x,
                        left:element_left+element_width+options.y
                    });
                    break;
                case 3:
                    tips.css({
                        top:element_top+element_height+options.x,
                        left:element_left-10+options.y
                    });
                    break;
                case 4:
                    tips.css({
                        top:element_top-20+options.x,
                        left:element_left-tips.outerWidth()+options.y
                    });
                    break;
                default:
            }
            var closeTime;
            tips.fadeIn('fast').click(function(){
                clearTimeout(closeTime);
                tips.fadeOut('fast',function(){
                    tips.remove();
                })
            })
            if(options.time){
                closeTime=setTimeout(function(){
                    tips.click();
                },options.time*1000);
                tips.hover(function(){
                    clearTimeout(closeTime);
                },function(){
                    closeTime=setTimeout(function(){
                        tips.click();
                    },options.time*1000);
                })
            }
        });
        return this;
    };
})(jQuery);