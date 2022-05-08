<p align="center">
  <img alt="logo" src="https://hsto.org/webt/0v/qb/0p/0vqb0pp6ntyyd8mbdkkj0wsllwo.png" width="90" />
</p>

# The Most Useful Wrappers For PHP Functions

[![Version][badge_packagist_version]][link_packagist]
[![Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

This package contains most useful wrappers for native PHP functions.

## Install

Require this package with composer using the following command:

```shell
$ composer require tarampampam/wrappers-php "^2.0"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

## Usage

### [`\Tarampampam\Wrappers\Json`](./src/Json.php)

This wrapper was wrote for throwing exceptions (`JsonEncodeDecodeException`) on any tries to work with wrong json string or converting wrong object into json string.

Also method `::decode(...)` by default returns associated array instead object (`$assoc = true`).

Examples:

```php
<?php

use Tarampampam\Wrappers\Json;

Json::encode(['foo' => 'bar']); // {"foo":"bar"}
Json::encode(tmpfile());        // Throws an exception - value cannot be resource

Json::decode('{"foo":"bar"}');        // ['foo' => 'bar']
Json::decode('{"foo":"bar"}', false); // $object->foo === bar
Json::decode('{"foo":"ba');           // Throws an exception - wrong json string

Json::encode([], JSON_EMPTY_ARRAYS_TO_OBJECTS); // {}
Json::encode(['foo' => []], JSON_EMPTY_ARRAYS_TO_OBJECTS); // {"foo":{}}

Json::encode(['foo' => 'bar'], JSON_PRETTY_PRINT_2_SPACES);
// {
//   "foo": "bar"
// }
```

### Testing

For package testing we use `phpunit` framework and `docker-ce` + `docker-compose` as develop environment. So, just write into your terminal after repository cloning:

```shell script
$ make build
$ make latest # or 'make lowest'
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changeslog].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/tarampampam/wrappers-php.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/tarampampam/wrappers-php.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/workflow/status/tarampampam/wrappers-php/tests?maxAge=30
[badge_coverage]:https://img.shields.io/codecov/c/github/tarampampam/wrappers-php/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/tarampampam/wrappers-php.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/tarampampam/wrappers-php.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/tarampampam/wrappers-php.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/tarampampam/wrappers-php/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/tarampampam/wrappers-php.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/tarampampam/wrappers-php.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/tarampampam/wrappers-php/releases
[link_packagist]:https://packagist.org/packages/tarampampam/wrappers-php
[link_build_status]:https://github.com/tarampampam/wrappers-php/actions
[link_coverage]:https://codecov.io/gh/tarampampam/wrappers-php/
[link_changeslog]:https://github.com/tarampampam/wrappers-php/blob/master/CHANGELOG.md
[link_issues]:https://github.com/tarampampam/wrappers-php/issues
[link_create_issue]:https://github.com/tarampampam/wrappers-php/issues/new
[link_commits]:https://github.com/tarampampam/wrappers-php/commits
[link_pulls]:https://github.com/tarampampam/wrappers-php/pulls
[link_license]:https://github.com/tarampampam/wrappers-php/blob/master/LICENSE
[getcomposer]:https://getcomposer.org/download/
