- 获取节点数据
```
a href="javascript:void(0);" data-name="meinvbingyue" data-id="1" class="grid-row-delete">删除</a>
                                        
$('.grid-row-delete').click(function () {
    var name = $(this).data('name');
    var id = $(this).data);
    console.log(name)
});
```
