<h1 align="center">Royalcms Component Pay</h1>


## 支持的支付方法
### 1、支付宝
- 电脑支付
- 手机网站支付
- APP 支付
- 刷卡支付
- 扫码支付
- 账户转账

|  method   |   描述       |
| :-------: | :-------:   |
|  web      | 电脑支付     |
|  wap      | 手机网站支付 |
|  app      | APP 支付    |
|  pos      | 刷卡支付  |
|  scan     | 扫码支付  |
|  transfer | 帐户转账  |

### 2、微信
- 公众号支付
- 小程序支付
- H5 支付
- 扫码支付
- 刷卡支付
- APP 支付
- 企业付款
- 普通红包
- 分裂红包

| method |   描述     |
| :-----: | :-------: |
| mp      | 公众号支付  |
| miniapp | 小程序支付  |
| wap     | H5 支付    |
| scan    | 扫码支付    |
| pos     | 刷卡支付    |
| app     | APP 支付  |
| transfer     | 企业付款 |
| redpack      | 普通红包 |
| groupRedpack | 分裂红包 |

## 支持的方法
所有网关均支持以下方法

- find(array/string $order)  
说明：查找订单接口  
参数：`$order` 为 `string` 类型时，请传入系统订单号，对应支付宝或微信中的 `out_trade_no`； `array` 类型时，参数请参考支付宝或微信官方文档。  
返回：查询成功，返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$colletion->xxx` 或 `$collection['xxx']` 访问服务器返回的数据。  
异常：`GatewayException` 或 `InvalidSignException`  

- refund(array $order)  
说明：退款接口  
参数：`$order` 数组格式，退款参数。  
返回：退款成功，返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$colletion->xxx` 或 `$collection['xxx']` 访问服务器返回的数据。  
异常：`GatewayException` 或 `InvalidSignException`

- cancel(array/string $order)  
说明：取消订单接口  
参数：`$order` 为 `string` 类型时，请传入系统订单号，对应支付宝或微信中的 `out_trade_no`； `array` 类型时，参数请参考支付宝或微信官方文档。    
返回：取消成功，返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$colletion->xxx` 或 `$collection['xxx']` 访问服务器返回的数据。  
异常：`GatewayException` 或 `InvalidSignException`

- close(array/string $order)  
说明：关闭订单接口  
参数：`$order` 为 `string` 类型时，请传入系统订单号，对应支付宝或微信中的 `out_trade_no`； `array` 类型时，参数请参考支付宝或微信官方文档。  
返回：关闭成功，返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$colletion->xxx` 或 `$collection['xxx']` 访问服务器返回的数据。  
异常：`GatewayException` 或 `InvalidSignException`  

- verify()  
说明：验证服务器返回消息是否合法  
返回：验证成功，返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$colletion->xxx` 或 `$collection['xxx']` 访问服务器返回的数据。  
异常：`GatewayException` 或 `InvalidSignException`  

- PAYMETHOD(array $order)  
说明：进行支付；具体支付方法名称请参考「支持的支付方法」一栏  
返回：成功，返回 `Royalcms\Component\Support\Collection` 实例，可以通过 `$colletion->xxx` 或 `$collection['xxx']` 访问服务器返回的数据或 `Symfony\Component\HttpFoundation\Response` 实例，可通过 `return $response->send()`(laravel 框架中直接 `return $response`) 返回，具体请参考文档。  
异常：`GatewayException` 或 `InvalidSignException`  


## 使用说明

### 支付宝
```php
<?php

namespace App\Http\Controllers;

use Royalcms\Component\Pay\Pay;
use Royalcms\Component\Pay\Log;

class PayController extends Controller
{
    protected $config = [
        'app_id' => '2018000000000001',
        'notify_url' => 'http://royalcms.cn/notify.php',
        'return_url' => 'http://royalcms.cn/return.php',
        'ali_public_key' => '',
        // 加密方式： **RSA2**  
        'private_key' => '',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'debug'
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];

    public function index()
    {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject' => 'test subject - 测试',
        ];

        $alipay = Pay::alipay($this->config)->web($order);

        return $alipay->send();// laravel 框架中请直接 `return $alipay`
    }

    public function returnCallback()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    public function notifyCallback()
    {
        $alipay = Pay::alipay($this->config);
    
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }
}
```

### 微信
```php
<?php

namespace App\Http\Controllers;

use Royalcms\Component\Pay\Pay;
use Royalcms\Component\Pay\Log;

class PayController extends Controller
{
    protected $config = [
        'appid' => 'wxxxxxxxxxxxxxxx', // APP APPID
        'app_id' => 'wxxxxxxxxxxxxxxx', // 公众号 APPID
        'miniapp_id' => 'wxxxxxxxxxxxxxxx', // 小程序 APPID
        'mch_id' => '1xxxxxxxx',
        'key' => 'mxxxxxxxxxxxxxxxxxxxxxxxx',
        'notify_url' => 'http://royalcms.cn/notify.php',
        'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'debug'
        ],
        'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];

    public function index()
    {
        $order = [
            'out_trade_no' => time(),
            'total_fee' => '1', // **单位：分**
            'body' => 'test body - 测试',
            'openid' => 'oxxxxxxxxxxxxxxxxxxxxx',
        ];

        $pay = Pay::wechat($this->config)->mp($order);

        // $pay->appId
        // $pay->timeStamp
        // $pay->nonceStr
        // $pay->package
        // $pay->signType
    }

    public function notify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (Exception $e) {
            // $e->getMessage();
        }
        
        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }
}
```

## 文档
* [支付宝](docs/alipay/README.md)
  * [支付](docs/alipay/pay.md)
    * [电脑支付](docs/alipay/pay.md#一、电脑支付)
    * [手机网站支付](/docs/alipay/pay.md#二、手机网站支付)
    * [APP 支付](docs/alipay/pay.md#三、app-支付)
    * [刷卡支付](docs/alipay/pay.md#四、刷卡支付)
    * [扫码支付](docs/alipay/pay.md#五、扫码支付)
    * [账户转账](docs/alipay/pay.md#六、转账)
  * [退款](docs/alipay/refund.md)
  * [查询](docs/alipay/find.md)
  * [取消](docs/alipay/cancel.md)
  * [关闭](docs/alipay/close.md)
  * [对账单](docs/alipay/download.md)
  * [验证服务器数据](docs/alipay/verify.md)
  * [向支付宝服务器确认收到异步通知](docs/alipay/success.md)
* [微信](docs/wechat/README.md)
  * [支付](docs/wechat/pay.md)
    * [公众号支付](docs/wechat/pay.md#一、公众号支付)
    * [手机网站支付](docs/wechat/pay.md#二、手机网站支付)
    * [APP 支付](docs/wechat/pay.md#三、app-支付)
    * [刷卡支付](docs/wechat/pay.md#四、刷卡支付)
    * [扫码支付](docs/wechat/pay.md#五、扫码支付)
    * [账户转账](docs/wechat/pay.md#六、账户转账)
    * [小程序支付](docs/wechat/pay.md#七、小程序)
    * [普通红包](docs/wechat/pay.md#八、普通红包)
    * [裂变红包](docs/wechat/pay.md#九、裂变红包)
  * [退款](docs/wechat/refund.md)
  * [查询](docs/wechat/find.md)
  * [取消](docs/wechat/cancel.md)
  * [关闭](docs/wechat/close.md)
  * [验证服务器数据](docs/wechat/verify.md)
  * [向微信服务器确认收到异步通知](docs/wechat/success.md)
* [其它]()
  * [其他功能](docs/others/others.md)
  * [FAQ](docs/others/faq.md)


## 错误
如果在调用相关支付网关 API 时有错误产生，会抛出 `GatewayException`,`InvalidSignException` 错误，可以通过 `$e->getMessage()` 查看，同时，也可通过 `$e->raw` 查看调用 API 后返回的原始数据，该值为数组格式。

### 所有异常

* Royalcms\Component\Pay\Exceptions\InvalidGatewayException ，表示使用了除本 SDK 支持的支付网关。
* Royalcms\Component\Pay\Exceptions\InvalidSignException ，表示验签失败。
* Royalcms\Component\Pay\Exceptions\InvalidConfigException ，表示缺少配置参数，如，`ali_public_key`, `private_key` 等。
* Royalcms\Component\Pay\Exceptions\GatewayException ，表示支付宝/微信服务器返回的数据非正常结果，例如，参数错误，对账单不存在等。


## LICENSE
MIT