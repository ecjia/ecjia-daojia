# Omnipay: Alipay


**Alipay driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements Alipay support for Omnipay.

## Basic Usage

The following gateways are provided by this package:

| Gateway       	    		|         Description             |说明                 | Links |
|:---------------	    	|:---------------------------     |:---------         |:----------:|
| Alipay_AopPage 	    		| Alipay Page Gateway             |电脑网站支付 - new    | [Usage][link-wiki-aop-page] [Doc][link-doc-aop-page] |
| Alipay_AopApp 	    		| Alipay APP Gateway              |APP支付 - new    | [Usage][link-wiki-aop-app] [Doc][link-doc-aop-app] |
| Alipay_AopF2F 	    		| Alipay Face To Face Gateway     |当面付 - new         | [Usage][link-wiki-aop-f2f] [Doc][link-doc-aop-f2f] |
| Alipay_AopWap 	    		| Alipay WAP Gateway              |手机网站支付 - new     | [Usage][link-wiki-aop-wap] [Doc][link-doc-aop-wap] |
| Alipay_LegacyApp 	    	| Alipay Legacy APP Gateway       |APP支付      | [Usage][link-wiki-legacy-app] [Doc][link-doc-legacy-app]      |
| Alipay_LegacyExpress 		| Alipay Legacy Express Gateway   |即时到账    | [Usage][link-wiki-legacy-express] [Doc][link-doc-legacy-express]|
| Alipay_LegacyWap      	| Alipay Legacy WAP Gateway   |手机网站支付     | [Usage][link-wiki-legacy-wap] [Doc][link-doc-legacy-wap]       |

## Usage

### Purchase (购买)

```php
/**
 * @var AopAppGateway $gateway
 */
$gateway = Omnipay::create('Alipay_AopPage');
$gateway->setSignType('RSA2'); // RSA/RSA2/MD5
$gateway->setAppId('the_app_id');
$gateway->setPrivateKey('the_app_private_key');
$gateway->setAlipayPublicKey('the_alipay_public_key');
$gateway->setReturnUrl('https://www.example.com/return');
$gateway->setNotifyUrl('https://www.example.com/notify');

/**
 * @var AopTradePagePayResponse $response
 */
$response = $gateway->purchase()->setBizContent([
    'subject'      => 'test',
    'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
    'total_amount' => '0.01',
    'product_code' => 'FAST_INSTANT_TRADE_PAY',
])->send();

$url = $response->getRedirectUrl();
```

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

