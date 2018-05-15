/*  
    http://www.dailycoding.com/ 
    Topbar message plugin

	$("body").showTopbarMessage({ width: "600px",background: "#FF3366", close: 1500, content: "请选择评分星级"});
	$("body").showTopbarMessage({width: "600px",background: "#95c51b", close: 1500, content: "评论成功"});

*/
(function ($) {
    $.fn.showTopbarMessage = function (options) {

        var defaults = {
            background: "#888",
            borderColor: "#000",
            foreColor: "#000",
            height: "50px",
			width: $(window).width()+"px",
            fontSize: "20px",
            close: "1000",
			content: "Hello"
        };
        var options = $.extend(defaults, options);

		var mid_width = (options.width.replace("px",""))/2+"px";
       
		var barStyle = " z-index:99999;width: " + options.width + ";position: fixed;height: " + options.height + ";top: 0px;left: 50%;right: 0px;margin-left:-"+mid_width+";display: none;";
        //var overlayStyle = "height: " + options.height + ";filter: alpha(opacity=50);-moz-opacity: 0.5;-khtml-opacity: 0.5;opacity: 0.5;background-color: " + options.background + ";border-bottom: solid 5px " + options.borderColor + ";";
		var overlayStyle = "height: " + options.height + ";background-color: " + options.background + ";border-bottom: solid 5px " + options.borderColor + ";";
        var messageStyle = " width: " + options.width + ";position: absolute;height: " + options.height + ";top: 0px;left: 50%;margin-left:-"+mid_width+";right: 0px;color: " + options.foreColor + ";font-weight: bold;font-size: " + options.fontSize + ";text-align: center;padding: 10px 0px";
		
		//点击DIV区域，移除
		$("body").delegate(".topbarBox","click",function(){
			$(".topbarBox").remove();
		});

        return this.each(function () {

            if ($(".topbarBox").length > 0) {
                //先移除已经存在的提示
                $(".topbarBox").hide()
                $(".topbarBox").slideUp(200, function () {
                    $(".topbarBox").remove();
                });
            }

            var html = ""
                + "<div class='topbarBox' style='" + barStyle + "'>"
                + "  <div style='" + overlayStyle + "'>&nbsp;</div>"
				+ "  <div style='" + messageStyle + "'>" + options.content + "</div>"
                + "</div>"

            $(html).appendTo($('body')).slideDown(200).delay(options.close).slideUp(200, function () {
				$(this).remove();
			});

        });
    };
})(jQuery);