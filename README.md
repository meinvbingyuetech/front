### 以下代码可以判断值 （是否为undefined；是否为null；是否为空；是否为0）
```js
if (!exp)
{
    console.log('值不存在');
    return;
}
```

### 判断变量是否undefined
```js
if (typeof(file_name) == "undefined")
{
    console.log("文件名不存在");
    return;
}
```

### 判断变量是否null
```js
var exp = null; 
if (!exp && typeof(exp)!=”undefined” && exp!=0) 
{ 
alert(“is null”); 
}　
```
