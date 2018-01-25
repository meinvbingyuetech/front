## 安装
```
wget https://cdn.bingo.ren/phantomjs-2.1.1-linux-x86_64.tar.bz2
tar -jxvf phantomjs-2.1.1-linux-x86_64.tar.bz2
phantomjs-2.1.1-linux-x86_64/bin/phantomjs -v
 
如果地址失效，则访问自己的百度网盘
https://pan.baidu.com/s/1snftaAp
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
 
## 执行命令生成图片
```
/home/js/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /data/js/require.js http://www.baidu.com /data/files/2018/1/25/baidu.png
 
都用 绝对路径比较靠谱
 
简约的命令如下，便于理解 （访问百度网址，并生成baidu.png的图片）
phantomjs require.js http://www.baidu.com baidu.png
```

## php调用命令
```php
        $save_base_path = public_path('share');

        //文件相对目录
        list($year,$month,$date) = explode('-',date('Y-m-d'));
        $path_format = sprintf('files/%d/%d/%d',$year,$month,$date);

        //文件名称
        $file_name = date('YmdHis').'-'.Helper::randomStr(6).'.png';

        $full_path = $save_base_path.'/'.$path_format.'/';
        $relative_name =
        $full_name = $full_path.$file_name;

        //创建目录
        if(!file_exists($full_path)){
            if(!is_writeable($save_base_path)){
                throw new \Exception('目录权限不足');
            }
            mkdir($full_path,0755,true);
        }

        $js_path = public_path('js/require.js');

        $link = "http://www.baidu.com";

        $command = "/home/js/phantomjs-2.1.1-linux-x86_64/bin/phantomjs {$js_path} {$link} {$full_name}";

        $flag = exec($command,$output,$return);
        dd($output,$return,$flag);
```
