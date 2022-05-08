# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [5.0.6] - 2020-03-03
### Changed
 - Removed the exit statements from the "Server" class, so you can control the
   termination of your own scripts

## [5.0.5] - 2020-02-28
### Changed
 - Updated the internal "datto/json-rpc" dependency

## [5.0.4] - 2020-02-20
### Changed
 - Content types are now allowed to contain optional character set data
   (e.g. "application/json; charset=utf8")

## [5.0.3] - 2019-09-19
### Changed
 - In the past, when the client encounters a transmission error, after receiving
   an HTTP response from the server, we would throw an HttpException containing
   the HTTP response. However, if that response is an "HTTP 200" success response,
   then we'd rather see the ErrorException, since that ErrorException is more
   likely to help us troubleshoot. In this version, we'll continue to throw the
   HttpException, unless the response is an "HTTP 200" success response,
   in which case we'll throw the more useful ErrorException.

## [5.0.2] - 2019-08-19
 - No changes to the external behavior.

## [5.0.1] - 2019-08-16
 - No changes to the external behavior.

## [5.0.0] - 2019-07-26
### Added
 - The new "Client::reset" method allows you to abandon queries without sending
   them.
### Changed
 - In the "Client::query" method, it's no longer necessary to explicitly
   manage message IDs through the "$id" option. Instead, provide a "$response"
   variable. When you call the "Client::send" method, the response will magically
   appear in your "$response" variable through pass by reference. Usually, the
   response will be the raw value that you're expecting from the server.
   However, you could receive an "ErrorResponse" instead! Make sure you are
   checking the response type.
 - The "HttpException" class has been renamed to: "Exceptions\HttpException"
 - The "HttpException::getHttpResponse" method has been renamed to: "Exceptions\HttpException::getResponse"
 - The "HttpResponse::getStatusCode" method has been renamed to: "HttpResponse::getCode"
 - The "HttpResponse::getReason" method has been renamed to: "HttpResponse::getMessage"
 - In the "Client::notify" and "Client::query" methods, the "$arguments" option
   MUST be an array. (In the past, it could be null.) If you're calling a method
   that takes no arguments, use an empty array!

## [4.0.0] - 2018-05-16
### Added
 - The "Client::send" method now throws an "HttpException" or "ErrorException"
   when there is an error.

### Changed
 - The "Client::query" and "Client::notify" methods now return the object handle,
   so you can chain method calls if you like.
 - The "Client::decode" method now returns a list of "Response" objects
   (rather than an associative array of raw JSON-RPC 2.0 keys and values).
