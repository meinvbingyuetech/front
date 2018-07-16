###判断checkbox是否选中的3种方法
- 方法一：
```js
if ($("#checkbox-id").get(0).checked) {
    // do something
}
```

- 方法二：
```js
if($('#checkbox-id').is(':checked')) {
    // do something
}
```

- 方法三：
```js
if($('#checkbox-id').prop('checked'))
{
　　//do something
}
```
----

- 先记录起来
```javascript
$("#cb1").prop("checked",true); //标准写法，推荐！
$("#cb1").prop({checked:true}); //map键值对    
$("#cb1").prop("checked",function(){
    return true;//函数返回true或false
});
```

```php
$('.check-title').click(function(event) {
               $(this).toggleClass('flag');
               if ( $(this).hasClass('flag') ){
                   $(this).parents('.permission_group').find('input[type="checkbox"]').prop('checked','true');
               }
               else {
                   $(this).parents('.permission_group').find('input[type="checkbox"]').removeAttr('checked');
               }
            });
```

```php
/**
     * 选择权限组后，勾选上所有该组权限
     */
    $('input[name="chk_permisison_group"]').click(function () {
        $(this).parent().siblings().find('input[type="checkbox"]').prop('checked',this.checked);
    });

    /**
     * 权限子项操作
     */
    $('input[name="permission[]"]').click(function () {
        // 如果子项选择为true，则判断其他是否都是选择true，如果是，则权限组也勾选上
        if(this.checked){
            var all_chk_obj = $(this).parent().parent().find('input[type="checkbox"]');

            var check_true_num = 0;
            for(var i=0;i<all_chk_obj.length;i++){
                if($(all_chk_obj[i]).prop('checked')){
                    check_true_num++;
                }
            }

            if(check_true_num == all_chk_obj.length){
                $(this).parent().parent().parent().find('.col-sm-2 input[type="checkbox"]').prop('checked',true);
            }

        }else{
            // 如果子项取消勾选后，权限组也取消
            $(this).parent().parent().siblings().find('input[type="checkbox"]').prop('checked',false);
        }
    });
    
    
    
```
