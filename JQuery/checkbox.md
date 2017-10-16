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
