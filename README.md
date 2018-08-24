> 环境 

    linux centos php7.1 

> swoole 

    pecl install swoole
    
-    文档地址 www.swoole.com
    
> 测试

- netcat: 安装
    
    https://blog.csdn.net/json_zjs/article/details/80260793
    
        下载适合的版本
        wget   http://vault.centos.org/6.4/os/x86_64/Packages/nc-1.84-22.el6.x86_64.rpm
        安装
        rpm   -iUv    nc-1.84-22.el6.x86_64.rpm
        
        另一种方法：
        下载地址是：http://vault.centos.org/6.3/os/i386/Packages/nc-1.84-22.el6.i686.rpm
        
        从这里开始模仿路径一步步找：http://vault.centos.org/
        
        根据你们的版本找到相应的nc进行下载安装。安装命令 rpm -iUv 软件包名称！
    
- telnet安装：
    
        yum search telnet
        yum list telnet 
        yum install
