**安装**  

1、克隆  
```
git clone git@github.com:indextank/micro-app.git
```

2、进入目录
```
cd micro-app
```

3、安装依赖
```$xslt
php composer install 
```

4、初始化项目  
```
本项目基于.env部署方式，非yii自带的environment初始化部署~~
涉及.env文件中内容新增，请务必也要在.env.example文件中新增~~并通知项目负责人....切记！！！

现在，

请将根目录下的.env.example文件重命名为.env
PS: Windows系统下不支持直接修改，可以在phpstorm编辑器里面修改、重命名
```
5、配置数据库信息
```$xslt
数据库相关配置信息都在.env文件中，禁止在config/database.php中修改
```

6、安装数据库
```$xslt
php ./yii migrate/up
```

7、建议更新第三方扩展包(可选)
```$xslt
php composer.phar update
```

8、初始化账号密码，一键创建总管理员账号密码(可选)     

```$xslt
php ./yii password/init

PS: 注意保存 - 非本地部署，一般情况下不需要执行
```



#### Api Demo

地址:  http://micro-api.default.com/v1/site/login
Method: Post  
Content-type: application/json  
Body:  {"username":"admin","password":"123456","group":"wechat"}