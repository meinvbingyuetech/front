document.write('<scr'+'ipt src="artDialog.source.js?skin=' + (_skin || 'default') +'"></sc'+'ript>');
document.write('<scr'+'ipt src="jquery-1.6.2.min.js"></sc'+'ript>')

/********************JQ的办法****************************/
$.extend({
    includePath: '',
    include: function(file)
    {
        var files = typeof file == "string" ? [file] : file;
        for (var i = 0; i < files.length; i++)
        {
            var name = files[i].replace(/^\s|\s$/g, "");
            var att = name.split('.');
            var ext = att[att.length - 1].toLowerCase();
            var isCSS = ext == "css";
            var tag = isCSS ? "link" : "script";
            var attr = isCSS ? " type='text/css' rel='stylesheet' " : " language='javascript' type='text/javascript' ";
            var link = (isCSS ? "href" : "src") + "='" + $.includePath + name + "'";
            if ($(tag + "[" + link + "]").length == 0) document.write("<" + tag + attr + link + "></" + tag + ">");
        }
    }
});
$.include(['http://image.esunny.com/script/jquery.divbox.js','/css/pop_win.css']);


$.ajax( {
    // 加载指定的js文件到当前文档中
     url: "http://code.jquery.com/jquery-1.8.3.min.js"
    , dataType: "script"
});