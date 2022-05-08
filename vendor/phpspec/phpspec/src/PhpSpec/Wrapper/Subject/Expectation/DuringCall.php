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

namespace PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\Exception\Example\MatcherException;
<<<<<<< HEAD
use PhpSpec\Matcher\MatcherInterface;
=======
use PhpSpec\Matcher\Matcher;
>>>>>>> v2-test
use PhpSpec\Util\Instantiator;
use PhpSpec\Wrapper\Subject\WrappedObject;

abstract class DuringCall
{
    /**
<<<<<<< HEAD
     * @var MatcherInterface
=======
     * @var Matcher
>>>>>>> v2-test
     */
    private $matcher;
    /**
     * @var mixed
     */
    private $subject;
    /**
     * @var array
     */
    private $arguments;
    /**
     * @var WrappedObject
     */
    private $wrappedObject;

    /**
<<<<<<< HEAD
     * @param MatcherInterface $matcher
     */
    public function __construct(MatcherInterface $matcher)
=======
     * @param Matcher $matcher
     */
    public function __construct(Matcher $matcher)
>>>>>>> v2-test
    {
        $this->matcher = $matcher;
    }

    /**
     * @param string $alias
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @param WrappedObject|null $wrappedObject
     *
     * @return $this
     */
<<<<<<< HEAD
    public function match($alias, $subject, array $arguments = array(), $wrappedObject = null)
=======
    public function match(string $alias, $subject, array $arguments = array(), $wrappedObject = null)
>>>>>>> v2-test
    {
        $this->subject = $subject;
        $this->arguments = $arguments;
        $this->wrappedObject = $wrappedObject;

        return $this;
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function during($method, array $arguments = array())
    {
        if ($method === '__construct') {
            $this->subject->beAnInstanceOf($this->wrappedObject->getClassname(), $arguments);
=======
    public function during(string $method, array $arguments = array())
    {
        if ($method === '__construct') {
            $this->subject->beAnInstanceOf($this->wrappedObject->getClassName(), $arguments);
>>>>>>> v2-test

            return $this->duringInstantiation();
        }

        $object = $this->wrappedObject->instantiate();

        return $this->runDuring($object, $method, $arguments);
    }

    /**
     * @return mixed
     */
    public function duringInstantiation()
    {
        if ($factoryMethod = $this->wrappedObject->getFactoryMethod()) {
<<<<<<< HEAD
            $method = is_array($factoryMethod) ? $factoryMethod[1] : $factoryMethod;
=======
            $method = \is_array($factoryMethod) ? $factoryMethod[1] : $factoryMethod;
>>>>>>> v2-test
        } else {
            $method = '__construct';
        }
        $instantiator = new Instantiator();
<<<<<<< HEAD
        $object = $instantiator->instantiate($this->wrappedObject->getClassname());
=======
        $object = $instantiator->instantiate($this->wrappedObject->getClassName());
>>>>>>> v2-test

        return $this->runDuring($object, $method, $this->wrappedObject->getArguments());
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws MatcherException
     */
<<<<<<< HEAD
    public function __call($method, array $arguments = array())
=======
    public function __call(string $method, array $arguments = array())
>>>>>>> v2-test
    {
        if (preg_match('/^during(.+)$/', $method, $matches)) {
            return $this->during(lcfirst($matches[1]), $arguments);
        }

        throw new MatcherException('Incorrect usage of matcher Throw, '.
            'either prefix the method with "during" and capitalize the '.
            'first character of the method or use ->during(\'callable\', '.
            'array(arguments)).'.PHP_EOL.'E.g.'.PHP_EOL.'->during'.
            ucfirst($method).'(arguments)'.PHP_EOL.'or'.PHP_EOL.
            '->during(\''.$method.'\', array(arguments))');
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    protected function getArguments()
=======
    protected function getArguments(): array
>>>>>>> v2-test
    {
        return $this->arguments;
    }

    /**
<<<<<<< HEAD
     * @return MatcherInterface
     */
    protected function getMatcher()
=======
     * @return Matcher
     */
    protected function getMatcher(): Matcher
>>>>>>> v2-test
    {
        return $this->matcher;
    }

    /**
     * @param object $object
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    abstract protected function runDuring($object, $method, array $arguments = array());
}
