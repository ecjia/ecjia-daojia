# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v2.1.0

### Added

- Support PHP `8.x`

### Changed

- Composer `2.x` is supported now
- Minimal required PHP version now is `7.3` (`7.2` security support ended January 1st, 2021)

## v2.0.0

### Removed

- Laravel framework integration

## v1.6.0

### Changed

- Minimal required PHP version now is `7.2` [#PR6]
- GitHub actions as main CI [#PR6]
- `JsonEncodeDecodeException::*` now return `self` instead `static` [#PR6]
- Some anonymous functions now static [#PR6]

### Added

- Docker as development environment [#PR6]
- Dependency `ext-mbstring` [#PR6]
- Dev-dependency `phpstan/phpstan` with maximal level [#PR6]
- `declare(strict_types=1);` into each PHP file [#PR6]
- Type definitions in methods parameters and return values, where it possible [#PR6]

### Fixed

- Autoload paths in `composer.json` (eg.: `src` &rarr; `src/`) [#PR6]
- Object iteration method in `Json::emptyArraysToObjects()` now uses `get_object_vars()` instead direct [#PR6]

[#PR6]:https://github.com/tarampampam/wrappers-php/pull/6

## v1.5.1

### Fixed

- `decode` function annotation

## v1.5.0

### Added

- Encode options (this options can be applied for `Json::encode()` method only):
  - `JSON_EMPTY_ARRAYS_TO_OBJECTS` for converting empty arrays `[]` into empty objects `{}`
  - `JSON_PRETTY_PRINT_2_SPACES` for using 2 (instead 4) whitespaces in returned data to format it

## v1.4.0

### Added

- Package Makefile

### Changed

- Maximal `laravel/laravel` package version now is `5.7.*`

## v1.3.0

### Changed

- Maximal PHP version now is undefined
- CI changed - using now [Travis-CI][travis]

[travis]:https://travis-ci.org/

## v1.2.0

### Changed

- Laravel facade renamed from `JsonWrapperFacade` to `Json`

## v1.1.0

### Changed

- Default exceptions codes now equals `JSON_ERROR_*` codes

## v1.0.0

### Changed

- First release

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
