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

namespace PhpSpec\Matcher;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Exception\Fracture\MethodNotFoundException;

class ObjectStateMatcher implements MatcherInterface
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\MethodFailureException;
use PhpSpec\Exception\Fracture\MethodNotFoundException;
use PhpSpec\Wrapper\DelayedCall;

final class ObjectStateMatcher implements Matcher
>>>>>>> v2-test
{
    /**
     * @var string
     */
    private static $regex = '/(be|have)(.+)/';
    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     */
    public function __construct(PresenterInterface $presenter)
=======
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
>>>>>>> v2-test
    {
        $this->presenter = $presenter;
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supports($name, $subject, array $arguments)
    {
        return is_object($subject) && !is_callable($subject)
=======
    public function supports(string $name, $subject, array $arguments): bool
    {
        return \is_object($subject) && !is_callable($subject)
>>>>>>> v2-test
            && (0 === strpos($name, 'be') || 0 === strpos($name, 'have'))
        ;
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
<<<<<<< HEAD
     * @throws \PhpSpec\Exception\Example\FailureException
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
     */
    public function positiveMatch($name, $subject, array $arguments)
=======
     * @throws \PhpSpec\Exception\Example\MethodFailureException
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
     */
    public function positiveMatch(string $name, $subject, array $arguments) : ?DelayedCall
>>>>>>> v2-test
    {
        preg_match(self::$regex, $name, $matches);
        $method   = ('be' === $matches[1] ? 'is' : 'has').ucfirst($matches[2]);
        $callable = array($subject, $method);

        if (!method_exists($subject, $method)) {
            throw new MethodNotFoundException(sprintf(
                'Method %s not found.',
                $this->presenter->presentValue($callable)
            ), $subject, $method, $arguments);
        }

<<<<<<< HEAD
        if (true !== $result = call_user_func_array($callable, $arguments)) {
            throw $this->getFailureExceptionFor($callable, true, $result);
        }
=======
        if (true !== $result = \call_user_func_array($callable, $arguments)) {
            throw $this->getMethodFailureExceptionFor($callable, true, $result);
        }

        return null;
>>>>>>> v2-test
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
<<<<<<< HEAD
     * @throws \PhpSpec\Exception\Example\FailureException
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
     */
    public function negativeMatch($name, $subject, array $arguments)
=======
     * @throws \PhpSpec\Exception\Example\MethodFailureException
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
     */
    public function negativeMatch(string $name, $subject, array $arguments) : ?DelayedCall
>>>>>>> v2-test
    {
        preg_match(self::$regex, $name, $matches);
        $method   = ('be' === $matches[1] ? 'is' : 'has').ucfirst($matches[2]);
        $callable = array($subject, $method);

        if (!method_exists($subject, $method)) {
            throw new MethodNotFoundException(sprintf(
                'Method %s not found.',
                $this->presenter->presentValue($callable)
            ), $subject, $method, $arguments);
        }

<<<<<<< HEAD
        if (false !== $result = call_user_func_array($callable, $arguments)) {
            throw $this->getFailureExceptionFor($callable, false, $result);
        }
=======
        if (false !== $result = \call_user_func_array($callable, $arguments)) {
            throw $this->getMethodFailureExceptionFor($callable, false, $result);
        }

        return null;
>>>>>>> v2-test
    }

    /**
     * @return int
     */
<<<<<<< HEAD
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return 50;
    }

    /**
     * @param callable $callable
<<<<<<< HEAD
     * @param Boolean  $expectedBool
     * @param Boolean  $result
     *
     * @return FailureException
     */
    private function getFailureExceptionFor($callable, $expectedBool, $result)
    {
        return new FailureException(sprintf(
=======
     * @param boolean  $expectedBool
     * @param mixed    $result
     *
     * @return MethodFailureException
     */
    private function getMethodFailureExceptionFor(callable $callable, bool $expectedBool, $result): MethodFailureException
    {
        return new MethodFailureException(sprintf(
>>>>>>> v2-test
            "Expected %s to return %s, but got %s.",
            $this->presenter->presentValue($callable),
            $this->presenter->presentValue($expectedBool),
            $this->presenter->presentValue($result)
<<<<<<< HEAD
        ));
=======
        ), $expectedBool, $result, $callable[0], $callable[1]);
>>>>>>> v2-test
    }
}
