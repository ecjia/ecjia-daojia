# 说明

**请先熟悉 支付宝支付 开发文档！**

使用的加密方式为支付宝官方推荐的 **RSA2**，目前只支持这一种加密方式，且没有支持其他加密方式的计划。

# QuickReference

```php
use Royalcms\Component\Pay\Pay;

$config = [
    'app_id' => '2018082000295641',
    'notify_url' => 'http://xxxxx.cn/notify.php',
    'return_url' => 'http://xxxxx.cn/return.php',
    'ali_public_key' => '',
    'private_key' => '',
    'log' => [ // optional
        'file' => './logs/alipay.log',
        'level' => 'debug'
    ],
    'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
];

// 支付
$order = [
    'out_trade_no' => time(),
    'total_amount' => '1',
    'subject' => 'test subject - 测试',
];

$alipay = RC_Pay::alipay($config)->web($order);

return $alipay->send();// 框架中请直接 `return $alipay`

// 退款
$order = [
    'out_trade_no' => '1814044114',
    'refund_amount' => '0.01',
];

$result = RC_Pay::alipay($config)->refund($order); // 返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 查询
$result = RC_Pay::alipay($config)->find('out_trade_no_123456'); // 返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 取消
$result = RC_Pay::alipay($config)->cancel('out_trade_no_123456'); // 返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 关闭
$result = RC_Pay::alipay($config)->close('out_trade_no_123456'); // 返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 验证服务器数据
$alipay = RC_Pay::alipay($config)

// 是的，验签就这么简单！
$data = $alipay->verify(); // 返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$data->xxx` 访问服务器返回的数据。

$alipay->success()->send(); // 向支付宝服务器确认接收到的数据。royalcms 框架中请直接 `return $alipay->success()`
```

# 注意

后续文档中，如果没有特别说明， `$alipay` 均代表`RC_Pay::alipay($config)`

