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

namespace PhpSpec;

<<<<<<< HEAD
use PhpSpec\Matcher\MatchersProviderInterface;
use PhpSpec\Wrapper\WrapperInterface;
use PhpSpec\Wrapper\SubjectContainerInterface;
=======
use PhpSpec\Matcher\MatchersProvider;
use PhpSpec\Wrapper\ObjectWrapper;
use PhpSpec\Wrapper\SubjectContainer;
>>>>>>> v2-test
use PhpSpec\Wrapper\Subject;
use ArrayAccess;

/**
 * The object behaviour is the default base class for specification.
 *
 * Most specs will extend this class directly.
 *
 * Its responsibility is to proxy method calls to PhpSpec caller which will
 * wrap the results into PhpSpec subjects. This results will then be able to
 * be matched against expectations.
 *
 * @method void beConstructedWith(...$arguments)
 * @method void beConstructedThrough($factoryMethod, array $constructorArguments = array())
 * @method void beAnInstanceOf($class)
<<<<<<< HEAD
 * @method void shouldHaveType($type)
 * @method void shouldImplement($interface)
 * @method Subject\Expectation\DuringCall shouldThrow($exception = null)
 */
class ObjectBehavior implements
    ArrayAccess,
    MatchersProviderInterface,
    SubjectContainerInterface,
    WrapperInterface,
    SpecificationInterface
=======
 *
 * @method void shouldHaveType($type)
 * @method void shouldNotHaveType($type)
 * @method void shouldBeAnInstanceOf($type)
 * @method void shouldNotBeAnInstanceOf($type)
 * @method void shouldImplement($interface)
 * @method void shouldNotImplement($interface)
 *
 * @method void shouldIterateAs($iterable)
 * @method void shouldYield($iterable)
 * @method void shouldNotIterateAs($iterable)
 * @method void shouldNotYield($iterable)
 *
 * @method void shouldIterateLike($iterable)
 * @method void shouldYieldLike($iterable)
 * @method void shouldNotIterateLike($iterable)
 * @method void shouldNotYieldLike($iterable)
 *
 * @method void shouldStartIteratingAs($iterable)
 * @method void shouldStartYielding($iterable)
 * @method void shouldNotStartIteratingAs($iterable)
 * @method void shouldNotStartYielding($iterable)
 *
 * @method Subject\Expectation\DuringCall shouldThrow($exception = null)
 * @method Subject\Expectation\DuringCall shouldNotThrow($exception = null)
 * @method Subject\Expectation\DuringCall shouldTrigger($level = null, $message = null)
 *
 * @method void shouldHaveCount($count)
 * @method void shouldNotHaveCount($count)
 * @method void shouldContain($element)
 * @method void shouldNotContain($element)
 * @method void shouldHaveKeyWithValue($key, $value)
 * @method void shouldNotHaveKeyWithValue($key, $value)
 * @method void shouldHaveKey($key)
 * @method void shouldNotHaveKey($key)
 */
abstract class ObjectBehavior implements
    ArrayAccess,
    MatchersProvider,
    SubjectContainer,
    ObjectWrapper,
    Specification
>>>>>>> v2-test
{
    /**
     * @var Subject
     */
    protected $object;

    /**
     * Override this method to provide your own inline matchers
     *
     * @link http://phpspec.net/cookbook/matchers.html Matchers cookbook
     * @return array a list of inline matchers
     */
<<<<<<< HEAD
    public function getMatchers()
=======
    public function getMatchers(): array
>>>>>>> v2-test
    {
        return array();
    }

    /**
     * Used by { @link PhpSpec\Runner\Maintainer\SubjectMaintainer::prepare() }
     * to prepare the subject with all the needed collaborators for proxying
     * object behaviour
     *
     * @param Subject $subject
     */
<<<<<<< HEAD
    public function setSpecificationSubject(Subject $subject)
=======
    public function setSpecificationSubject(Subject $subject): void
>>>>>>> v2-test
    {
        $this->object = $subject;
    }

    /**
     * Gets the unwrapped proxied object from PhpSpec subject
     *
     * @return object
     */
    public function getWrappedObject()
    {
        return $this->object->getWrappedObject();
    }

    /**
     * Checks if a key exists in case object implements ArrayAccess
     *
     * @param string|integer $key
     *
     * @return Subject
     */
<<<<<<< HEAD
    public function offsetExists($key)
=======
    public function offsetExists($key): Subject
>>>>>>> v2-test
    {
        return $this->object->offsetExists($key);
    }

    /**
     * Gets the value in a particular position in the ArrayAccess object
     *
     * @param string|integer $key
     *
     * @return Subject
     */
<<<<<<< HEAD
    public function offsetGet($key)
=======
    public function offsetGet($key): Subject
>>>>>>> v2-test
    {
        return $this->object->offsetGet($key);
    }

    /**
     * Sets the value in a particular position in the ArrayAccess object
     *
     * @param string|integer $key
     * @param mixed          $value
     */
    public function offsetSet($key, $value)
    {
        $this->object->offsetSet($key, $value);
    }

    /**
     * Unsets a position in the ArrayAccess object
     *
     * @param string|integer $key
     */
    public function offsetUnset($key)
    {
        $this->object->offsetUnset($key);
    }

    /**
     * Proxies all calls to the PhpSpec subject
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function __call($method, array $arguments = array())
    {
        return call_user_func_array(array($this->object, $method), $arguments);
=======
    public function __call(string $method, array $arguments = array())
    {
        return \call_user_func_array(array($this->object, $method), $arguments);
>>>>>>> v2-test
    }

    /**
     * Proxies setting to the PhpSpec subject
     *
     * @param string $property
     * @param mixed  $value
     */
<<<<<<< HEAD
    public function __set($property, $value)
=======
    public function __set(string $property, $value)
>>>>>>> v2-test
    {
        $this->object->$property = $value;
    }

    /**
     * Proxies getting to the PhpSpec subject
     *
     * @param string $property
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function __get($property)
=======
    public function __get(string $property)
>>>>>>> v2-test
    {
        return $this->object->$property;
    }

    /**
     * Proxies functor calls to PhpSpec subject
     *
     * @return mixed
     */
    public function __invoke()
    {
<<<<<<< HEAD
        return call_user_func_array(array($this->object, '__invoke'), func_get_args());
=======
        return \call_user_func_array(array($this->object, '__invoke'), \func_get_args());
>>>>>>> v2-test
    }
}
