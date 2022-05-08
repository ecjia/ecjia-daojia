<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Caster;

use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Casts PDO related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
<<<<<<< HEAD
 */
class PdoCaster
{
    private static $pdoAttributes = array(
        'CASE' => array(
            \PDO::CASE_LOWER => 'LOWER',
            \PDO::CASE_NATURAL => 'NATURAL',
            \PDO::CASE_UPPER => 'UPPER',
        ),
        'ERRMODE' => array(
            \PDO::ERRMODE_SILENT => 'SILENT',
            \PDO::ERRMODE_WARNING => 'WARNING',
            \PDO::ERRMODE_EXCEPTION => 'EXCEPTION',
        ),
=======
 *
 * @final
 */
class PdoCaster
{
    private const PDO_ATTRIBUTES = [
        'CASE' => [
            \PDO::CASE_LOWER => 'LOWER',
            \PDO::CASE_NATURAL => 'NATURAL',
            \PDO::CASE_UPPER => 'UPPER',
        ],
        'ERRMODE' => [
            \PDO::ERRMODE_SILENT => 'SILENT',
            \PDO::ERRMODE_WARNING => 'WARNING',
            \PDO::ERRMODE_EXCEPTION => 'EXCEPTION',
        ],
>>>>>>> v2-test
        'TIMEOUT',
        'PREFETCH',
        'AUTOCOMMIT',
        'PERSISTENT',
        'DRIVER_NAME',
        'SERVER_INFO',
<<<<<<< HEAD
        'ORACLE_NULLS' => array(
            \PDO::NULL_NATURAL => 'NATURAL',
            \PDO::NULL_EMPTY_STRING => 'EMPTY_STRING',
            \PDO::NULL_TO_STRING => 'TO_STRING',
        ),
=======
        'ORACLE_NULLS' => [
            \PDO::NULL_NATURAL => 'NATURAL',
            \PDO::NULL_EMPTY_STRING => 'EMPTY_STRING',
            \PDO::NULL_TO_STRING => 'TO_STRING',
        ],
>>>>>>> v2-test
        'CLIENT_VERSION',
        'SERVER_VERSION',
        'STATEMENT_CLASS',
        'EMULATE_PREPARES',
        'CONNECTION_STATUS',
        'STRINGIFY_FETCHES',
<<<<<<< HEAD
        'DEFAULT_FETCH_MODE' => array(
=======
        'DEFAULT_FETCH_MODE' => [
>>>>>>> v2-test
            \PDO::FETCH_ASSOC => 'ASSOC',
            \PDO::FETCH_BOTH => 'BOTH',
            \PDO::FETCH_LAZY => 'LAZY',
            \PDO::FETCH_NUM => 'NUM',
            \PDO::FETCH_OBJ => 'OBJ',
<<<<<<< HEAD
        ),
    );

    public static function castPdo(\PDO $c, array $a, Stub $stub, $isNested)
    {
        $attr = array();
        $errmode = $c->getAttribute(\PDO::ATTR_ERRMODE);
        $c->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        foreach (self::$pdoAttributes as $k => $v) {
            if (!isset($k[0])) {
                $k = $v;
                $v = array();
            }

            try {
                $attr[$k] = 'ERRMODE' === $k ? $errmode : $c->getAttribute(constant('PDO::ATTR_'.$k));
=======
        ],
    ];

    public static function castPdo(\PDO $c, array $a, Stub $stub, bool $isNested)
    {
        $attr = [];
        $errmode = $c->getAttribute(\PDO::ATTR_ERRMODE);
        $c->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        foreach (self::PDO_ATTRIBUTES as $k => $v) {
            if (!isset($k[0])) {
                $k = $v;
                $v = [];
            }

            try {
                $attr[$k] = 'ERRMODE' === $k ? $errmode : $c->getAttribute(\constant('PDO::ATTR_'.$k));
>>>>>>> v2-test
                if ($v && isset($v[$attr[$k]])) {
                    $attr[$k] = new ConstStub($v[$attr[$k]], $attr[$k]);
                }
            } catch (\Exception $e) {
            }
        }
<<<<<<< HEAD

        $prefix = Caster::PREFIX_VIRTUAL;
        $a += array(
            $prefix.'inTransaction' => method_exists($c, 'inTransaction'),
            $prefix.'errorInfo' => $c->errorInfo(),
            $prefix.'attributes' => $attr,
        );
=======
        if (isset($attr[$k = 'STATEMENT_CLASS'][1])) {
            if ($attr[$k][1]) {
                $attr[$k][1] = new ArgsStub($attr[$k][1], '__construct', $attr[$k][0]);
            }
            $attr[$k][0] = new ClassStub($attr[$k][0]);
        }

        $prefix = Caster::PREFIX_VIRTUAL;
        $a += [
            $prefix.'inTransaction' => method_exists($c, 'inTransaction'),
            $prefix.'errorInfo' => $c->errorInfo(),
            $prefix.'attributes' => new EnumStub($attr),
        ];
>>>>>>> v2-test

        if ($a[$prefix.'inTransaction']) {
            $a[$prefix.'inTransaction'] = $c->inTransaction();
        } else {
            unset($a[$prefix.'inTransaction']);
        }

        if (!isset($a[$prefix.'errorInfo'][1], $a[$prefix.'errorInfo'][2])) {
            unset($a[$prefix.'errorInfo']);
        }

        $c->setAttribute(\PDO::ATTR_ERRMODE, $errmode);

        return $a;
    }

<<<<<<< HEAD
    public static function castPdoStatement(\PDOStatement $c, array $a, Stub $stub, $isNested)
=======
    public static function castPdoStatement(\PDOStatement $c, array $a, Stub $stub, bool $isNested)
>>>>>>> v2-test
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $a[$prefix.'errorInfo'] = $c->errorInfo();

        if (!isset($a[$prefix.'errorInfo'][1], $a[$prefix.'errorInfo'][2])) {
            unset($a[$prefix.'errorInfo']);
        }

        return $a;
    }
}
