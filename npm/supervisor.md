```

注意：每次我们更新代码后，都需要手动停止并重启应用，使用 supervisor 模块可以解决这个问题，每当我们保存修改的文件时，supervisor 都会自动帮我们重启应用。通过：

$ npm install -g supervisor
安装 supervisor 。使用 supervisor 命令启动 app.js：

$ supervisor app

```
