<<<<<<< HEAD
[![Build Status](https://travis-ci.org/sebastianbergmann/comparator.svg?branch=master)](https://travis-ci.org/sebastianbergmann/comparator)

# Comparator
=======
# sebastian/comparator

[![CI Status](https://github.com/sebastianbergmann/comparator/workflows/CI/badge.svg)](https://github.com/sebastianbergmann/comparator/actions)
[![Type Coverage](https://shepherd.dev/github/sebastianbergmann/comparator/coverage.svg)](https://shepherd.dev/github/sebastianbergmann/comparator)
>>>>>>> v2-test

This component provides the functionality to compare PHP values for equality.

## Installation

<<<<<<< HEAD
To add Comparator as a local, per-project dependency to your project, simply add a dependency on `sebastian/comparator` to your project's `composer.json` file. Here is a minimal example of a `composer.json` file that just defines a dependency on Comparator 1.2:

```JSON
{
    "require": {
        "sebastian/comparator": "~1.2"
    }
}
=======
You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

```
composer require sebastian/comparator
```

If you only need this library during development, for instance to run your project's test suite, then you should add it as a development-time dependency:

```
composer require --dev sebastian/comparator
>>>>>>> v2-test
```

## Usage

```php
<?php
use SebastianBergmann\Comparator\Factory;
use SebastianBergmann\Comparator\ComparisonFailure;

$date1 = new DateTime('2013-03-29 04:13:35', new DateTimeZone('America/New_York'));
$date2 = new DateTime('2013-03-29 03:13:35', new DateTimeZone('America/Chicago'));

$factory = new Factory;
$comparator = $factory->getComparatorFor($date1, $date2);

try {
    $comparator->assertEquals($date1, $date2);
    print "Dates match";
<<<<<<< HEAD
}

catch (ComparisonFailure $failure) {
    print "Dates don't match";
}
```

=======
} catch (ComparisonFailure $failure) {
    print "Dates don't match";
}
```
>>>>>>> v2-test
