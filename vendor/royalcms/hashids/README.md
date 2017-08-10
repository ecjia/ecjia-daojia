# Hashids

A hashids wrapper for Royalcms Component.

## Installation

#### Facade

To add facade support for Royalcms, add the following line inside your `config/facade.php` under the alias section...

```php
'RC_Hashids' => 'Royalcms\Component\Hashids\Facades\Hashids',
```

then add the following to your `.env` file:

```ini
# HASHIDS

HASHIDS_SALT = YOURSECRETKEY
HASHIDS_LENGTH = 8
HASHIDS_ALPHABET = abcedfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPAQRSTUVWXYZ1234567890
```

## Settings

|name    |description                     |default                                                        |
|--------|--------------------------------|---------------------------------------------------------------|
|salt    |The secret used for hashing.    |MYREALLYSECRETSALT                                             |
|length  |The maximum length of the hash. |10                                                             |
|alphabet|The characters used for hashing.|abcedefghijklmnopqrstuvwxyzABCEDEFGHIJKLMNOPQRSTUVWXYZ123456890|

## Usage

### Encode

Encode a series of integers

```php
royalcms('hashids')->encode(...$integers);
```

or with the facade

```php
RC_Hashids::encode(...$integers);
```

### Decode

Decode a encoded string back to the original integers

```php
royalcms('hashids')->decode($encoded);
```

or with the facade

```php
RC_Hashids::decode($encoded);
```

## License

This library is licensed under [MIT](http://choosealicense.org/licenses/mit), see [license.md](license.md) for details.
