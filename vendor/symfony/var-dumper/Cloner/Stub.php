<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Cloner;

/**
 * Represents the main properties of a PHP variable.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Stub
{
<<<<<<< HEAD
    const TYPE_REF = 'ref';
    const TYPE_STRING = 'string';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';
    const TYPE_RESOURCE = 'resource';

    const STRING_BINARY = 'bin';
    const STRING_UTF8 = 'utf8';

    const ARRAY_ASSOC = 'assoc';
    const ARRAY_INDEXED = 'indexed';
=======
    public const TYPE_REF = 1;
    public const TYPE_STRING = 2;
    public const TYPE_ARRAY = 3;
    public const TYPE_OBJECT = 4;
    public const TYPE_RESOURCE = 5;

    public const STRING_BINARY = 1;
    public const STRING_UTF8 = 2;

    public const ARRAY_ASSOC = 1;
    public const ARRAY_INDEXED = 2;
>>>>>>> v2-test

    public $type = self::TYPE_REF;
    public $class = '';
    public $value;
    public $cut = 0;
    public $handle = 0;
    public $refCount = 0;
    public $position = 0;
<<<<<<< HEAD
=======
    public $attr = [];

    private static $defaultProperties = [];

    /**
     * @internal
     */
    public function __sleep(): array
    {
        $properties = [];

        if (!isset(self::$defaultProperties[$c = static::class])) {
            self::$defaultProperties[$c] = get_class_vars($c);

            foreach ((new \ReflectionClass($c))->getStaticProperties() as $k => $v) {
                unset(self::$defaultProperties[$c][$k]);
            }
        }

        foreach (self::$defaultProperties[$c] as $k => $v) {
            if ($this->$k !== $v) {
                $properties[] = $k;
            }
        }

        return $properties;
    }
>>>>>>> v2-test
}
