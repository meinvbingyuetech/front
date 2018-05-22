- 获取节点数据
```
a href="javascript:void(0);" data-name="meinvbingyue" data-id="1" class="grid-row-delete">删除</a>
                                        
$('.grid-row-delete').click(function () {
    var name = $(this).data('name');
    var id = $(this).data('id');
    console.log(name)
});
```
 
- 同级元素操作
```
$('button[name="at_platform"]').click(function () {
                var id = $(this).siblings('input[name="id"]').val();
                console.log(id)
            });
```
