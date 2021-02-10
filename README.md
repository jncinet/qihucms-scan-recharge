<h1 align="center">自定义收款码，扫码充值</h1>

## 安装

```shell
$ composer require jncinet/qihucms-scan-recharge
```

## 使用

### 数据迁移
```shell
$ php artisan migrate
```

### 发布资源
```shell
$ php artisan vendor:publish --provider="Qihucms\ScanRecharge\ScanRechargeServiceProvider"
```

## 前台页面
+ 充值页 `scan-recharge/rechange`
+ 充值记录 `scan-recharge/log`

## 后台菜单
+ 充值记录 `scan-recharge/orders`
+ 充值渠道 `scan-recharge/channels`