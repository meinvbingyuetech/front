- 创建package.json
  ```
  npm init
  或
  npm init --yes
  ```
  
----
- 全局安装（在命令行里直接使用，比如 grunt CLI）
  
    ```
    npm install npm@latest -g
    
    npm uninstall -g <package>
    ```

- npm install 默认安装到本地，会安装在 package.json 中 dependencies 和 devDependencies 里的所有模块
  
  ```
  $ npm install mysql
  $ npm install mongoose
  $ npm install sax@latest
  $ npm install sax@0.1.1
  $ npm install sax@">=0.1.0 <0.2.0"
  ```
  
- 如果想只安装 dependencies 中的内容
  - npm install --production

- 将这个包名及对应的版本添加到 package.json的 dependencies
  - npm install <package_name> --save
  
- 将这个包名及对应的版本添加到 package.json的 devDependencies
  - npm install <package_name> --save-dev

----
- 更新npm

    ```
    npm install npm -g
    ```
    
- 查看依赖的包是否有新版本

    ```
    npm outdated
    ```
    
- 更新指定包 

    ```
    npm update mysql
    ```
    
- 更新所有
    
    ```
    npm update
    ```
- 改变npm-cache 的目录

    ```
    npm config get cache
    npm config set cache "e:\cache\npm\npm-cache"
    ```
- 查看指定包的信息

    ```
    npm info mysql 
    ```
- 查看主页或仓库

    ```
    cnpm home mysql
    cnpm repo mysql
    ```

----
- 一些坑
```
npm install --no-bin-links
```
