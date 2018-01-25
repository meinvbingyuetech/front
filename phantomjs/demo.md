## 安装
```
wget https://cdn.bingo.ren/phantomjs-2.1.1-linux-x86_64.tar.bz2
tar -jxvf phantomjs-2.1.1-linux-x86_64.tar.bz2
phantomjs-2.1.1-linux-x86_64/bin/phantomjs -v

```

## request.js
```js
var page = require('webpage').create();
var system = require('system');

var url = system.args[1];
var save_path = system.args[2];

page.open(url, function () {
    page.render(save_path);
    console.info('success');
    phantom.exit();
});

```
 
## 执行生成图片
```
/home/js/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /data/js/require.js http://www.baidu.com /data/files/2018/1/25/baidu.png
 
都用 绝对路径比较靠谱
 
简约的命令如下，便于理解 （访问百度网址，并生成baidu.png的图片）
phantomjs require.js http://www.baidu.com baidu.png
```
