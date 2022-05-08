<p align="center">
  <img src="https://hsto.org/webt/lj/s8/ev/ljs8evshzjvuhkmj_325uqycvu8.png" width="128" alt="logo"/>
</p>

# JSON-RPC 2.0

[![Version][badge_packagist_version]][link_packagist]
[![PHP Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

[JSON-RPC 2.0] is a remote procedure call protocol encoded in JSON. It is a very simple protocol, defining only a few data types and commands. JSON-RPC allows for notifications (data sent to the server that does not require a response) and for multiple calls to be sent to the server which may be answered out of order.

## Install

Require this package with composer using the following command:

```shell
$ composer require avto-dev/json-rpc-laravel "^2.0"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

## Usage example

### Create routes

Register actions for your methods in `./routes/web.php` using the facade `RpcRouter`:

```php
<?php

use AvtoDev\JsonRPC\RpcRouter;

RpcRouter::on('please_sum_array_values', 'YourNamespace\\SomeController@sum');
RpcRouter::on('show_full_request', 'YourNamespace\\SomeController@showInfo');
```

> This package already contains a [simple controller](./src/Http/Controllers/RpcController.php) implementation, which you can expand it or take it only as an example.

Add new route for `RpcController`:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::post('/rpc', 'AvtoDev\\JsonRpc\\Http\\Controllers\\RpcController');
```

> Don't forget about to load RPC routes if you want to specify routes not in the file `./routes/web.php`

### Create RPC controller

Create a new controller containing procedures to be called by `JSON` request:

```php
<?php

namespace YourNamespace;

use AvtoDev\JsonRpc\Requests\RequestInterface;

class SomeController
{
    /**
     * Get sum of array.
     *
     * @param RequestInterface $request
     *
     * @return int
     */
    public function sum(RequestInterface $request): int
    {
        return (int) \array_sum($request->getParams());
    }

    /**
     * Get info from request.
     *
     * @param RequestInterface $request
     *
     * @return mixed[]
     */
    public function showInfo(RequestInterface $request): array
    {
        return [
            'params'       => $request->getParams(),
            'notification' => $request->isNotification(),
            'method_name'  => $request->getMethod(),
            'request ID'   => $request->getId(),
        ];
    }
}
```

### Send RPC-request

```bash
$ curl 'http://localhost/rpc' \
    -H 'Content-Type: application/json;charset=utf-8' \
    --data '{"jsonrpc":"2.0","method":"please_sum_array_values","id":"UNIQ_REQUEST_ID","params":[1,2,3,4,5,6,7,8,9,10]}'

{
    "jsonrpc": "2.0",
    "result": 55,
    "id": "UNIQ_REQUEST_ID"
}
```

```bash
$ curl 'http://localhost/rpc' \
    -H 'Content-Type: application/json;charset=utf-8' \
    --data '{"jsonrpc":"2.0","method":"show_full_request","id":"UNIQ_REQUEST_ID","params":[1,2,3,4,5,6,7,8,9,10]}'

{
    "jsonrpc": "2.0",
    "result": {
        "params": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        "notification": false,
        "method_name": "please_sum_array_values",
        "request ID": "UNIQ_REQUEST_ID"
    },
    "id": "UNIQ_REQUEST_ID"
}
```

```bash
$ curl 'http://localhost/rpc' \
    -H 'Content-Type: application/json;charset=utf-8' \
    --data '{"jsonrpc":"2.0","method":"undefined_method","id":"UNIQ_REQUEST_ID"}'

{
    "jsonrpc": "2.0",
    "error": {
        "code": -32601,
        "message": "Method not found"
    },
    "id": "UNIQ_REQUEST_ID"
}
```

## Events

When the `Kernel@handle` method is called, some events are fired:

Event class                     | Description
------------------------------- | -----------
`ErroredRequestDetectedEvent`   | Detected not valid request from stack
`RequestHandledEvent`           | Means the remote method was successfully called
`RequestHandledExceptionEvent`  | An exception was thrown while executing the request

If necessary, you can create a **Listener** on this **event** and display received messages for debug.

The `EventServiceProvider` included with your [Laravel application](https://laravel.com/docs/events) provides a convenient place to register all of your application's event listeners.
 data.

## ChangeLog

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avto-dev/json-rpc-laravel.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avto-dev/json-rpc-laravel.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/workflow/status/avto-dev/json-rpc-laravel/tests/master
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/json-rpc-laravel/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/json-rpc-laravel.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/json-rpc-laravel.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/json-rpc-laravel.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/json-rpc-laravel/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/json-rpc-laravel.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/json-rpc-laravel.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avto-dev/json-rpc-laravel/releases
[link_packagist]:https://packagist.org/packages/avto-dev/json-rpc-laravel
[link_build_status]:https://github.com/avto-dev/json-rpc-laravel/actions
[link_coverage]:https://codecov.io/gh/avto-dev/json-rpc-laravel/
[link_changes_log]:https://github.com/avto-dev/json-rpc-laravel/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avto-dev/json-rpc-laravel/issues
[link_create_issue]:https://github.com/avto-dev/json-rpc-laravel/issues/new/choose
[link_commits]:https://github.com/avto-dev/json-rpc-laravel/commits
[link_pulls]:https://github.com/avto-dev/json-rpc-laravel/pulls
[link_license]:https://github.com/avto-dev/json-rpc-laravel/blob/master/LICENSE
[getcomposer]:https://getcomposer.org/download/
[JSON-RPC 2.0]:https://www.jsonrpc.org/specification
