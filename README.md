# 聚合支付
### composer下载
```shell script
composer require faed/pay 
```
### 生成配置文件
```shell script
php artisan vendor:publish
```
配置文件
```php
return [

    //通道
    'passageway'=>[
        'JlPayXcxPay'=>[
            //机构号
            'org_code'=> '',
            //商户号
            'mch_id'=>'',
            //私钥
            'merPriKey'=>'',
            //公钥
            'JlPubKey'=> '',
            //回调地址
            'notify_url'=>'',
        ],
    ]
];

```

