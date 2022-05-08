# JSON-RPC over HTTP(S) for PHP

## Overview

This package allows you to set up a JSON-RPC client and/or server over HTTP(S),
using your own PHP code to evaluate the requests.

This package abstracts away the details of the JSON-RPC messaging format and
the HTTP(S) headers that are necessary for the client and server to communicate
successfully.

You're free to use your own library to handle the requests. Likewise, you're free
to route requests to your server endpoint through any system that you prefer!
(See the "examples" folder for ready-to-use examples.)

This package allows you to communicate with a URL endpoint: If don't need to
send or receive HTTP(S) headers, but just want to abstract away the internal
JSON-RPC messaging format, then you should use the
[php-json-rpc](https://github.com/datto/php-json-rpc) package instead.


## Features

* Correct: fully compliant with the [JSON-RPC 2.0 specifications](http://www.jsonrpc.org/specification)
* Reliable: works in all environments (even when CURL is not installed)
* Flexible: you can choose your own system for interpreting the JSON-RPC method strings
* Minimalistic: just two tiny files
* Ready to use, with working examples


## Examples

### Client

```php
$client = new Client('http://api.example.com');

$client->query(1, 'add', array(1, 2));

$reply = $client->send();
```

### Server

```php
$api = new Api();

$server = new Server($api);

$server->reply();
```

*See the "examples" folder for more examples.*


## Requirements

* PHP >= 7.0


## License

This package is released under an open-source license: [LGPL-3.0](https://www.gnu.org/licenses/lgpl-3.0.html)


## Installation

If you're using [Composer](https://getcomposer.org/), you can include this library
([datto/json-rpc-http](https://packagist.org/packages/datto/json-rpc-http)) like this:
```
composer require "datto/json-rpc-http"
```


## Getting started

1. Try the examples: Look in the "examples" directory and follow the README
instructions.

2. After you've successfully run an example, replace the example "src" code
with your own code.

3. Call the new API from within your own project!


## Changelog

See what has changed:
[Changelog](https://github.com/datto/php-json-rpc-http/blob/master/CHANGELOG.md)


## Author

[Spencer Mortensen](http://spencermortensen.com/contact/)
