# UULive

## 安装
```bash
composer install #安装php依赖
npm install #安装前端依赖
npm run build #生成前端压缩文件
```

## 常用命令
```bash
#国际化配置/translations/messages.zh_CN.yaml
php bin/console translation:update --dump-messages zh_CN #显示需要国际化的字段
php bin/console translation:update --force zh_CN 生成中文

```