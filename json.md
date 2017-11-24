```js

// parse用于从一个字符串中解析出json对象 注意：单引号写在{}外，每个属性名都必须用双引号，否则会抛出异常
var str = '{"name":"jason","age":"23"}'
var obj = JSON.parse(str);

// 用于从一个对象解析出字符串
var obj = {a:1,b:2};
var str = JSON.stringify(obj);


// 删除
var user  = {
    'user1' : {
        'name' : 'meinvbingyue'
    },
    'user2' : {
        'name' : 'jason'
    },
};
delete user['user1'];
console.log(user);


```
