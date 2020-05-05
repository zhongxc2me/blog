# README

## Laravel
### MySQL
**如果你是在版本低于5.7的MySQL release上创建索引，那就需要你手动配置迁移生成的默认字符串长度**
**在AppServiceProvider.php文件里的boot方法里设置**
```
public function boot()
{
    \Schema::defaultStringLength(191);
}
```

## 常用命令
### 淘宝镜像安装
cnpm install

### 自动编译更新
npm run watch

### 创建策略文件
artisan make:policy --model=User UserPolicy
### 创建模型工厂
artisan make:factory --model=Blog BlogFactory


### 安装中文语言包
**默认表单提示是英文的，我们可以安装中文语言包进行汉化**
```
composer require caouecs/laravel-lang:~3.0
```
**包含大多数语言，语言包位于vendor/caouecs/laravel-lang/src 目录中**
**使用**
> 1. 根据需要复制语言包 resources/lang 目录
> 2. 修改 config/app.php 配置
```
'locale' => 'zh-CN'
```





## Laravel 6.10.1 引入前端框架Bootstrap日记 - & jQuery
### 官方方法
```
cd /path/of/your/project
composer require laravel/ui --dev
php artisan ui bootstrap
php artisan ui bootstrap --auth
npm install
npm run dev
```


root /var/www/html/blog/public/;

# Add index.php to the list if you are using PHP
index index.php index.html index.htm index.nginx-debian.html;

server_name _;

location / {
        # First attempt to serve request as file, then
        # as directory, then fall back to displaying a 404.
        #try_files $uri $uri/ =404;
        try_files $uri $uri/ /index.php?$query_string;
}

# pass PHP scripts to FastCGI server
#
location ~ \.php$ {
        include snippets/fastcgi-php.conf;
#
#       # With php-fpm (or other unix sockets):
        fastcgi_pass unix:/run/php/php7.2-fpm.sock;
#       # With php-cgi (or other tcp sockets):
#       fastcgi_pass 127.0.0.1:9000;
}

server {
    listen 8070;
    
    server_name localhost;
    
    root /var/www/LaySNS;
    index index.html;
    
    location / {
        try_files $uri $uri/ =404;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        #
        #       # With php-fpm (or other unix sockets):
        fastcgi_pass unix:/run/php/php7.2-fpm.sock;
        #       # With php-cgi (or other tcp sockets):
        #       fastcgi_pass 127.0.0.1:9000;
    }
}


docker run -tid -p 8089:80 \ 
-v /Users/kings/www:/var/www/html \ 
-v /Users/kings/data/nginx/conf/conf.d:/etc/nginx/conf.d/ \
--name php_nginx \
--link phpfpm:php \
--link amazing_gagarin:mysql 

docker run -tid \
-v /Users/kings/www/:/www \
--name phpfpm \
-d php:fpm

docker run -tid -p 8080:80 -p 8089:8089 \
-v /Users/kings/www:/var/www/html \
-v /Users/kings/data/nginx/conf/conf.d:/etc/nginx/conf.d/ \
--name php_nginx \
--link myphpfpm:myphpfpm \
--link mysql5.7:mysql5.7 \
nginx

docker run --name myphpfpm -v /data/ftp:/www -d php:7.3.5-fpm
docker run -tid -v /Users/kings/www:/var/www/html --name myphpfpm -d php:fpm
