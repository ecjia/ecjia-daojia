# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v2.1.0

### Changed

- Laravel `8.x` is supported now
- Minimal Laravel version now is `6.0` (Laravel `5.5` LTS got last security update August 30th, 2020)
- Dependency `tarampampam/wrappers-php` version `~2.0` is supported

## v2.0.0

### Changed

- Maximal `illuminate/*` packages version now is `7.*`
- Minimal required PHP version now is `7.2`
- Classes `RequestsStack` and `ResponsesStack` do not extend `Illuminate\Support\Collection`
- Interfaces `RequestsStackInterface` and `ResponsesStackInterface` do not extend `Illuminate\Contracts\Support\Arrayable`
- Method `push()` in `RequestsStack` and `ResponsesStack` return `void` now

### Added

- Methods `all()`, `getIterator()`, `count()`, `isEmpty()`, `isNotEmpty()` and `first()` implementation in `RequestsStack` and `ResponsesStack` classes
- Type-hints for methods in `RequestsStackInterface` and `ResponsesStackInterface` interfaces

## v1.2.0

### Changed

- CI completely moved from "Travis CI" to "Github Actions" _(travis builds disabled)_
- Minimal required PHP version now is `7.2`
- Minimal required `phpunit/phpunit` version now is `~7.5`
- `phpstan/phpstan` updated up to `^0.12`

### Added

- PHP 7.4 is supported now

## v1.1.0

### Changed

- Removed unnecessary bound checks interfaces in `ServiceProvider.php`. Due to the fact that the service provider of the package is loaded earlier than the service provider of the application

## v1.0.0

### Added

- Basic features wrote

### Changed

- All business logic now concentrated in Kernel class

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
