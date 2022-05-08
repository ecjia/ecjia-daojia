# JSON-RPC for PHP


## Overview

This package allows you to create and evaluate JSON-RPC messages, using your own
PHP code to evaluate the requests.

This package allows you to create and evaluate any JSON-RPC message. It
implements the JSON-RPC specifications, but does *not* provide a transport
layer—which you'll also need if you want to send or receive messages over a
distance! One of the beautiful features of JSON-RPC is that you can use *any*
transport layer to carry your messages: This package gives you that option.

If you're looking for an end-to-end solution, with the transport layer included,
then you should use one of these alternative packages instead:
* To send messages over HTTP(S), use the
[php-json-rpc-http](https://github.com/datto/php-json-rpc-http) package.
* To send messages over SSH, use the
[php-json-rpc-ssh](https://github.com/datto/php-json-rpc-ssh) package.


## Features

* Correct: fully compliant with the [JSON-RPC 2.0 specifications](http://www.jsonrpc.org/specification) (100% unit-test coverage)
* Flexible: you can use your own code to evaluate the JSON-RPC method strings
* Minimalistic: extremely lightweight
* Ready to use, with working examples


## Examples

### Client

```php
$client = new Client();

$client->query(1, 'add', array(1, 2));

$message = $client->encode();

// message: {"jsonrpc":"2.0","method":"add","params":[1,2],"id":1}
```

### Server

```php
$api = new Api();

$server = new Server($api);

$reply = $server->reply($message);

// reply: {"jsonrpc":"2.0","result":3,"id":1}
```

*See the [examples](https://github.com/datto/php-json-rpc/tree/master/examples) folder for full working examples.*


## Requirements

* PHP >= 7.0


## License

This package is released under an open-source license: [LGPL-3.0](https://www.gnu.org/licenses/lgpl-3.0.html)


## Installation

If you're using [Composer](https://getcomposer.org/), you can include this library
([datto/json-rpc](https://packagist.org/packages/datto/json-rpc)) like this:
```
composer require "datto/json-rpc"
```


## Getting started

1. Try the examples. You can run the examples from the project directory like this:
	```
	php examples/client.php
	php examples/server.php
	```

2. Take a look at the code "examples/src"—then replace it with your own!


## Unit tests

You can run the suite of unit tests from the project directory like this:
```
./vendor/bin/phpunit
```


## Changelog

See what has changed:
[Changelog](https://github.com/datto/php-json-rpc/blob/master/CHANGELOG.md)


## Author

[Spencer Mortensen](http://spencermortensen.com/contact/)
