/****
<script src="js/jquery.js"></script>
<script src="js/func.sel.js"></script>
e.g:
��"*"���滻Ϊѡ�����
<input id="chk_*_{$smarty.section.item.index}" type="checkbox" name="chk_*" value="{$music[item].mid}"/>

<a href="javascript:void(0);" onclick="do_select('*')">ִ�в���</a>
<a id="sel_all_*" href="javascript:void(0);" onclick="all_sel('*')">ȫѡ</a>
<a href="javascript:void(0);" onclick="sui_sel('*')">���</a>
*/

/**
//ִ��ѡȡ����
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
        alert("ѡȡ��IDֵ��"+f);
    } else {
        alert("��ѡ����Ҫ������ѡ�");
    }
}
*/