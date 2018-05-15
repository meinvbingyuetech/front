/****
<script src="js/jquery.js"></script>
<script src="js/func.sel.js"></script>
e.g:
将"*"号替换为选项代号
<input id="chk_*_{$smarty.section.item.index}" type="checkbox" name="chk_*" value="{$music[item].mid}"/>

<a href="javascript:void(0);" onclick="do_select('*')">执行操作</a>
<a id="sel_all_*" href="javascript:void(0);" onclick="all_sel('*')">全选</a>
<a href="javascript:void(0);" onclick="sui_sel('*')">随机</a>
*/

/**
//执行选取操作
function do_select(val) {
    var f = "";
    $("input[name='chk_" + val + "']").each(function() {
        if ($(this).attr("checked") == true) {
            if (f) {
                f += ",";
            }
            f += $(this).attr("value");
        }
    });

    if (f) {
        alert("选取的ID值："+f);
    } else {
        alert("请选择您要操作的选项！");
    }
}
*/