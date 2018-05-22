```js
//搜索
var $btnSearch = $('#search_btn');
$btnSearch.click(function () {
    var query = $('#form1').serialize();
    location.href='{{route('admin.book.list')}}'+'?'+query;
});

//重置搜索
var $btnReset = $('#reset_btn');
$btnReset.click(function () {
    location.href='{{route('admin.user.list')}}';
});
```

```html
<form id="form1">
    <input type="text" name="search_isbn" id="search_isbn" class="form-control" @if(!empty($condition['search_isbn'])) value="{{$condition['search_isbn']}}" @else placeholder="isbn" @endif>
    <input type="text" name="search_name" id="search_name" class="form-control" @if(!empty($condition['search_name'])) value="{{$condition['search_name']}}" @else placeholder="书籍名称/作者" @endif>
    <button type="button" id="search_btn" class="btn btn-primary btn-flat">搜索</button>
    <button type="button" id="reset_btn" class="btn btn-success btn-flat">重置</button>
</form>
```
