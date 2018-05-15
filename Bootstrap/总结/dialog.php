

/****************************************************************************************************************/
http://www.runoob.com/bootstrap/bootstrap-modal-plugin.html

http://getbootstrap.com/javascript/#modals

<button type="button" class="btn btn-primary" onclick="show()">显示</button> 
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">点击弹出窗口</button> 
<!-- 模态框（Modal） --> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
                <h4 class="modal-title" id="myModalLabel">模态框（Modal）标题</h4> 
            </div> 
            <div class="modal-body">在这里添加一些文本</div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
                <button type="button" class="btn btn-primary">提交更改</button> 
            </div> 
        </div>
    </div>
</div>

<script>
function show(){
    $('#myModal').modal('show');
}    
</script>
/****************************************************************************************************************/

http://bootboxjs.com/


bootbox.dialog({
    title:"操作记录",
    message: "<span >"+html+"</span>",
    buttons:            
    {
        "success" :
         {
            "label" : "<i class='icon-ok'></i> 确定",
            "className" : "btn-sm btn-success",
            "callback": function() {
                //bootbox.hideAll();
            }
        }
    }
});


bootbox.dialog({
    title:"消息提示",
    message: "<span class='bigger-110'>发票号已经填写，确定重新提交吗？</span>",
    buttons:            
    {
        "success" :
         {
            "label" : "<i class='icon-ok'></i> 确定",
            "className" : "btn-sm btn-success",
            "callback": function() {
                //return false;
            }
        },
        "button" :
        {
            "label" : "取消",
            "className" : "btn-sm"
        }
    }
});