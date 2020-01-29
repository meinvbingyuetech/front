```
# 全局安装 vue-cli
cnpm install --global vue-cli

# 创建一个基于 webpack 模板的新项目(这里需要进行一些配置，默认回车即可)
vue init webpack my-project

cd my-project
cnpm install

# 进入目录，config\index.js
将 dev.host 从localhost改成0.0.0.0

# 启动项目，这样就可以本地开发调试了
cnpm run dev

# 构建正式项目，使用dist目录
cnpm run build
```
