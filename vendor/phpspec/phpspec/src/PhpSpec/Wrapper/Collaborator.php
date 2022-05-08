<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Wrapper;

use Prophecy\Prophecy\ObjectProphecy;

<<<<<<< HEAD
class Collaborator implements WrapperInterface
=======
final class Collaborator implements ObjectWrapper
>>>>>>> v2-test
{
    /**
     * @var ObjectProphecy
     */
    private $prophecy;

    /**
     * @param ObjectProphecy $prophecy
     */
    public function __construct(ObjectProphecy $prophecy)
    {
        $this->prophecy  = $prophecy;
    }

    /**
     * @param string $classOrInterface
     */
<<<<<<< HEAD
    public function beADoubleOf($classOrInterface)
=======
    public function beADoubleOf(string $classOrInterface): void
>>>>>>> v2-test
    {
        if (interface_exists($classOrInterface)) {
            $this->prophecy->willImplement($classOrInterface);
        } else {
            $this->prophecy->willExtend($classOrInterface);
        }
    }

    /**
     * @param array $arguments
     */
<<<<<<< HEAD
    public function beConstructedWith(array $arguments = null)
=======
    public function beConstructedWith(array $arguments = null): void
>>>>>>> v2-test
    {
        $this->prophecy->willBeConstructedWith($arguments);
    }

    /**
     * @param string $interface
     */
<<<<<<< HEAD
    public function implement($interface)
=======
    public function implement(string $interface): void
>>>>>>> v2-test
    {
        $this->prophecy->willImplement($interface);
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function __call($method, array $arguments)
    {
        return call_user_func_array(array($this->prophecy, '__call'), array($method, $arguments));
=======
    public function __call(string $method, array $arguments)
    {
        return \call_user_func_array(array($this->prophecy, '__call'), array($method, $arguments));
>>>>>>> v2-test
    }

    /**
     * @param string $parameter
     * @param mixed  $value
     */
<<<<<<< HEAD
    public function __set($parameter, $value)
=======
    public function __set(string $parameter, $value)
>>>>>>> v2-test
    {
        $this->prophecy->$parameter = $value;
    }

    /**
     * @param string $parameter
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function __get($parameter)
=======
    public function __get(string $parameter)
>>>>>>> v2-test
    {
        return $this->prophecy->$parameter;
    }

    /**
     * @return object
     */
    public function getWrappedObject()
    {
        return $this->prophecy->reveal();
    }
}
