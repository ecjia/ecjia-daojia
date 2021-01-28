# Changelog
All notable changes to this project will be documented in this file.

## [Unreleased]

## [3.1.26] - 2020-11-13

### Added

- PHP 8 support

## [3.1.25] - 2020-11-13

### Added

- Added an ability to prepare rows before appending rows to sheet. Just add `prepareRows` method for your export class if needed.
- Added an ability to catch exceptions from `QueueExport` job. Just add `failed` method for your export class if needed.
- Added an ability to set locale for queued export. Just implement `Illuminate\Contracts\Translation\HasLocalePreference` for your export.
- Added `JsonSerializable` support in `Maatwebsite\Excel\Validators\Failure`.
- Added `$maxExceptions` support in `Maatwebsite\Excel\Jobs\ReadChunk.php`.
- Added support to upsert models by implementing the `WithUpserts` concern.

## [3.1.24] - 2020-10-28

### Added

- Added support for `prepareForValidation` on `WithValidation` concern
- Added support for `withValidator` on `WithValidation` concern
- Added `ArrayAccess` to `Row`

### Fixed

- Corrected SkipsErrors doc block

## [3.1.23] - 2020-09-29

### Added
- Added `ignore_empty` setting to `config/excel.php`
- Added `strict_null_comparison` setting to `config/excel.php`

## [3.1.22] - 2020-09-08

- Laravel 8 support
- Lumen improvements

## [3.1.21] - 2020-08-06

### Added
- Added WithProperties concern
- Added default spreadsheet properties config
- Added WithColumnWidths concern
- Added WithStyles concern.
- Config setting to configure cell caching

### Changed
- Sheet titles longer than 31 chars get trimmed.
- Sheet titles with unsupported chars get cleaned.

### Fixed
- Fixed issue with using ShouldAutosize in combination with FromView column widths.

## [3.1.20] - 2020-07-22

### Added
- Re-sycing remote temporary file
- Remember row number
- Remember chunk offset
- WithColumnLimit concern
- WithReadFilter concern
- Publishing the stubs

### Changed
- Interacting with queued jobs
- Retry until and middleware on queued imports
- Using WithValidation with FromCollection & FromArray
- Read filters for WithLimit and HeadingRowImport
- Bump of minimum version PhpSpreadsheet

### Fixed
- Fixed test helper docblocks on the Excel facade.
- Fix for importing with a start row beyond the highest row.
- Fixed `BeforeSheet` and `AfterSheet` events receiving exportable instance instead of importable when calling on an Import.
- Fix for value binders not working in queued exports.
- Fix when using WithLimit concern when having less rows than the limit.
- Fix AfterImport job being fired twice if not using queueing.
- Raw() method now also available on Exportable.
- Fix for breaking changes in PhpSpreadsheet with empty enclosures.

[Unreleased]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.26...HEAD
[3.1.26]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.25...3.1.26
[3.1.25]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.24...3.1.25
[3.1.24]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.23...3.1.24
[3.1.23]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.22...3.1.23
[3.1.22]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.21...3.1.22
[3.1.21]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.20...3.1.21
[3.1.20]: https://github.com/Maatwebsite/Laravel-Excel/compare/3.1.19...3.1.20

_Older release notes can be found in Github releases._
