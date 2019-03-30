# 书香工大
> 原有书香工大因某些原因不可用，故从头做起

## 目前功能
- 读书会报名/管理

## 最佳实践

开发前请先阅读[最佳实践指南](https://zjutjh.gitbooks.io/document/content/1.3-Laravel/1.3.1-%E6%9C%80%E4%BD%B3%E5%AE%9E%E8%B7%B5.html)

## 开始开发
首先复制.env.example的内容至.env（新建）
> cp .env.example .env

然后执行install，安装相关包  
> composer install

然后生成laravel应用的key
> php artisan key:generate

然后生成jwt秘钥
> php artisan jwt:generate

然后迁移，记得在.env配置
> php artisan migrate --seed
