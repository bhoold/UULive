# uulive

## symfony常用命令
```bash
## 创建项目
composer create-project symfony/website-skeleton my_project_name



## 更新前端文件
npm run dev



## 国际化配置/translations/messages.zh_CN.yaml
php bin/console translation:update --dump-messages zh_CN #显示需要国际化的字段
php bin/console translation:update --force zh_CN #生成中文



## 创建数据表
//配置文件
config/packages/doctrine.yaml
//创建env设置的数据库
php bin/console doctrine:database:create
//创建实体类
php bin/console make:entity
//生成SQL文件
php bin/console make:migration
//导入数据库
php bin/console doctrine:migrations:migrate

//生成假数据(非必须)
php bin/console make:fixtures
php bin/console doctrine:fixtures:load



## 创建用户表
//创建用户实体类
php bin/console make:user
//生成SQL文件
php bin/console make:migration
//导入数据库
php bin/console doctrine:migrations:migrate



## 创建用户注册功能和页面
php bin/console make:registration-form



## 创建登录功能
php bin/console make:auth

```