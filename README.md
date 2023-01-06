# web安全寒假考核     基础版

1月4号拿到任务 1月6号完成全部基础任务 进阶的功能暂时不做了 留时间给别的吧（还有原因是和几个高中同学开的mc服务器需要开荒了orz

简单写写构思的应用功能实现

1.用户注册、登录、修改密码。基础的连接了一个数据库。在user表里，我保存base64编码后的用户名以及密码的sha256值，来保障数据库不会被sql注入，以及数据如果泄露的话不会直接泄露明文密码。

2.文件的管理与保存。我在每一个用户注册的时候为其单独创建了一张表，用来存储文件的hash和用户定义的文件名。在file总表里，我保存了所有文件的hash、path和文件的被使用次数（相同文件的引用次数）。在文件上传时会有一次对hash的判断，若相同则不会保存在服务器硬盘以节省服务器空间，保证相同文件仅会被存储一次。当文件被删除时，其对应的引用计数器被-1，若小于等于0则会在服务器和数据库销毁这一文件。

3.数据安全措施。分几点来说吧

- 用户账户安全。基本上对文件的所有操作都需要对session验证，尽量防止出现越权操作的可能。
- 用户数据安全。这一点我没什么能做的，也不可能给他加个端对端加密吧，或者多重备份什么的
- 服务器安全。服务器对上传的文件会全部重新命名，同时不会暴漏真实的文件路径（下载功能是通过download.php读取转发），防止上传并运行木马。在防止报错而暴露文件方面，基本上有可能报错的地方都进行了关闭错误日志。在数据库方面，用户名、密码查询时都是对计算过后的值进行查询，基本防范了sql注入。

4.如果你真想运行这个程序，我的建议是直接把这些文件扔进apache根目录，nginx没测试。我不敢对这个服务的性能、安全性负责，毕竟之前从来没写过php，让你的服务器直接崩溃也说不定。

5.遗憾。~~主要因为我懒狗了~~  如果你仔细翻翻login.php,你会发现一个关于admin的session。这个管理员的功能在开项目的第一天是想做的，没想到第二天就摆了，做完基础得了。以及其他文件，看一眼以后真有屎山那感觉。只能说还有很大提升的空间了。