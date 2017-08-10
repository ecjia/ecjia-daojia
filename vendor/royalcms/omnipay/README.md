Omnipay for Royalcms
==============

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel 5 via a ServiceProvider to make Configuring multiple payment tunnels a breeze!


### Usage

```php
$cardInput = [
	'number'      => '4444333322221111',
	'firstName'   => 'MR. WALTER WHITE',
	'expiryMonth' => '03',
	'expiryYear'  => '16',
	'cvv'         => '333',
];

$card = RC_Omnipay::creditCard($cardInput);
$response = RC_Omnipay::purchase([
	'amount'    => '100.00',
	'returnUrl' => 'http://royalcms.cn/payment/return',
	'cancelUrl' => 'http://royalcms.cn/payment/cancel',
	'card'      => $cardInput
])->send();

dd($response->getMessage());
```
    
This will use the gateway specified in the config as `default`.

However, you can also specify a gateway to use.

```php
RC_Omnipay::setGateway('eway');

$response = RC_Omnipay::purchase([
	'amount' => '100.00',
	'card'   => $cardInput
])->send();

dd($response->getMessage());
```
    
In addition you can take an instance of the gateway.

```php
$gateway = RC_Omnipay::gateway('eway');
```
