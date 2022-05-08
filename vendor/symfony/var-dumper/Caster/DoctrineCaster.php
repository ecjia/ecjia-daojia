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

use Doctrine\Common\Proxy\Proxy as CommonProxy;
<<<<<<< HEAD
use Doctrine\ORM\Proxy\Proxy as OrmProxy;
use Doctrine\ORM\PersistentCollection;
=======
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Proxy\Proxy as OrmProxy;
>>>>>>> v2-test
use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Casts Doctrine related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
<<<<<<< HEAD
 */
class DoctrineCaster
{
    public static function castCommonProxy(CommonProxy $proxy, array $a, Stub $stub, $isNested)
    {
        foreach (array('__cloner__', '__initializer__') as $k) {
            if (array_key_exists($k, $a)) {
=======
 *
 * @final
 */
class DoctrineCaster
{
    public static function castCommonProxy(CommonProxy $proxy, array $a, Stub $stub, bool $isNested)
    {
        foreach (['__cloner__', '__initializer__'] as $k) {
            if (\array_key_exists($k, $a)) {
>>>>>>> v2-test
                unset($a[$k]);
                ++$stub->cut;
            }
        }

        return $a;
    }

<<<<<<< HEAD
    public static function castOrmProxy(OrmProxy $proxy, array $a, Stub $stub, $isNested)
    {
        foreach (array('_entityPersister', '_identifier') as $k) {
            if (array_key_exists($k = "\0Doctrine\\ORM\\Proxy\\Proxy\0".$k, $a)) {
=======
    public static function castOrmProxy(OrmProxy $proxy, array $a, Stub $stub, bool $isNested)
    {
        foreach (['_entityPersister', '_identifier'] as $k) {
            if (\array_key_exists($k = "\0Doctrine\\ORM\\Proxy\\Proxy\0".$k, $a)) {
>>>>>>> v2-test
                unset($a[$k]);
                ++$stub->cut;
            }
        }

        return $a;
    }

<<<<<<< HEAD
    public static function castPersistentCollection(PersistentCollection $coll, array $a, Stub $stub, $isNested)
    {
        foreach (array('snapshot', 'association', 'typeClass') as $k) {
            if (array_key_exists($k = "\0Doctrine\\ORM\\PersistentCollection\0".$k, $a)) {
=======
    public static function castPersistentCollection(PersistentCollection $coll, array $a, Stub $stub, bool $isNested)
    {
        foreach (['snapshot', 'association', 'typeClass'] as $k) {
            if (\array_key_exists($k = "\0Doctrine\\ORM\\PersistentCollection\0".$k, $a)) {
>>>>>>> v2-test
                $a[$k] = new CutStub($a[$k]);
            }
        }

        return $a;
    }
}
