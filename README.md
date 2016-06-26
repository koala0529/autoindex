# autoindex extend

* 1.本项目修改自SourceForge autoindex项目;
* 2.文件下载时小于32M的情况使用直接下载，在高于32M时使用断点下载;
* 3.修改本身自带的文件上传功能，采用Huploadify插件，支持断点上传大文件;
* 4.自己写了一个名称为koala的模板，在文件列表上方显示搜索功能框；
* 5.修改了其中的一些框架类，比如upload ，url，search,admin...
* 6.Huploadify插件修复了断点上传中实时显示已上传大小。

# 修改目的

* 1.就是使用SourceForge的php免费空间，搭建自己的网盘，sf的php空间有些诸多的限制，比如说32M大小的文件直接下载时会提示文件过大
所以呢，就在此基础上修改了小于32m时使用直接下载，大于32m时使用断点下载；
* 2.自带的default模板的搜索框显示在最下方，不符合使用习惯，所以修改到了显示在上方一行中；
* 3.其自带的上传功能在上传大文件时，sf会提示文件过大不能上传，所以借助Huploadify插件实现了断点上传。
* 4.登录ssh可以使用wget命令下载，速度杠杠的，真正的离线下载网盘，只要是wget支持的协议都可以使用。
可惜的是apache用户不能使用wget命令下载，会提示no route to host，默认路由可能做了拦截，要不然就可以打造php离线下载网盘了。
这可能也是GoAgent php server无法使用的原因。。。

# 空间写入权限
sf php的空间默认不具有写入权限，所以需要登录ssh利用chmod 777修改htdocs目录权限，当然还用AutoIndex.conf.php，
hidden_files，.htpasswd.autoindex等文件的权限以便在线管理autoindex文件。


# 个人网盘首页

* http://download.koala.tk

### 集成了phpshell，访问时请在域名后输入/phpshell即可打开shell，默认账户密码均为admin。

# 感谢

* 1.autoindex 项目
* 2.jquery.Huploadify.js 项目@吕大豹
* 3.http://www.jb51.net/article/38005.htm
* 4.phpshell项目
