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
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Wrapper\Unwrapper;
use PhpSpec\Wrapper\DelayedCall;
use PhpSpec\Factory\ReflectionFactory;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Exception\Example\NotEqualException;
use PhpSpec\Exception\Fracture\MethodNotFoundException;

<<<<<<< HEAD
class ThrowMatcher implements MatcherInterface
=======
final class ThrowMatcher implements Matcher
>>>>>>> v2-test
{
    /**
     * @var array
     */
    private static $ignoredProperties = array('file', 'line', 'string', 'trace', 'previous');

    /**
     * @var Unwrapper
     */
    private $unwrapper;

    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
     * @var ReflectionFactory
     */
    private $factory;

    /**
     * @param Unwrapper              $unwrapper
<<<<<<< HEAD
     * @param PresenterInterface     $presenter
     * @param ReflectionFactory|null $factory
     */
    public function __construct(Unwrapper $unwrapper, PresenterInterface $presenter, ReflectionFactory $factory = null)
    {
        $this->unwrapper = $unwrapper;
        $this->presenter = $presenter;
        $this->factory   = $factory ?: new ReflectionFactory();
=======
     * @param Presenter              $presenter
     * @param ReflectionFactory|null $factory
     */
    public function __construct(Unwrapper $unwrapper, Presenter $presenter, ReflectionFactory $factory)
    {
        $this->unwrapper = $unwrapper;
        $this->presenter = $presenter;
        $this->factory   = $factory;
>>>>>>> v2-test
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
=======
    public function supports(string $name, $subject, array $arguments): bool
>>>>>>> v2-test
    {
        return 'throw' === $name;
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return DelayedCall
     */
<<<<<<< HEAD
    public function positiveMatch($name, $subject, array $arguments)
=======
    public function positiveMatch(string $name, $subject, array $arguments): DelayedCall
>>>>>>> v2-test
    {
        return $this->getDelayedCall(array($this, 'verifyPositive'), $subject, $arguments);
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return DelayedCall
     */
<<<<<<< HEAD
    public function negativeMatch($name, $subject, array $arguments)
=======
    public function negativeMatch(string $name, $subject, array $arguments): DelayedCall
>>>>>>> v2-test
    {
        return $this->getDelayedCall(array($this, 'verifyNegative'), $subject, $arguments);
    }

    /**
     * @param callable           $callable
     * @param array              $arguments
     * @param null|object|string $exception
     *
     * @throws \PhpSpec\Exception\Example\FailureException
     * @throws \PhpSpec\Exception\Example\NotEqualException
     */
<<<<<<< HEAD
    public function verifyPositive($callable, array $arguments, $exception = null)
=======
    public function verifyPositive(callable $callable, array $arguments, $exception = null)
>>>>>>> v2-test
    {
        $exceptionThrown = null;

        try {
<<<<<<< HEAD
            call_user_func_array($callable, $arguments);
=======
            \call_user_func_array($callable, $arguments);
>>>>>>> v2-test
        } catch (\Exception $e) {
            $exceptionThrown = $e;
        } catch (\Throwable $e) {
            $exceptionThrown = $e;
        }

        if (!$exceptionThrown) {
            throw new FailureException('Expected to get exception / throwable, none got.');
        }

        if (null === $exception) {
            return;
        }

        if (!$exceptionThrown instanceof $exception) {
<<<<<<< HEAD
            throw new FailureException(
                sprintf(
                    'Expected exception of class %s, but got %s.',
                    $this->presenter->presentValue($exception),
                    $this->presenter->presentValue($exceptionThrown)
=======
            $format = 'Expected exception of class %s, but got %s.';

            if ($exceptionThrown instanceof \Error) {
                $format = 'Expected exception of class %s, but got %s with the message: "%s"';
            }

            throw new FailureException(
                sprintf(
                    $format,
                    $this->presenter->presentValue($exception),
                    $this->presenter->presentValue($exceptionThrown),
                    $exceptionThrown->getMessage()
>>>>>>> v2-test
                )
            );
        }

<<<<<<< HEAD
        if (is_object($exception)) {
            $exceptionRefl = $this->factory->create($exception);
            foreach ($exceptionRefl->getProperties() as $property) {
                if (in_array($property->getName(), self::$ignoredProperties, true)) {
=======
        if (\is_object($exception)) {
            $exceptionRefl = $this->factory->create($exception);
            foreach ($exceptionRefl->getProperties() as $property) {
                if (\in_array($property->getName(), self::$ignoredProperties, true)) {
>>>>>>> v2-test
                    continue;
                }

                $property->setAccessible(true);
                $expected = $property->getValue($exception);
                $actual = $property->getValue($exceptionThrown);

                if (null !== $expected && $actual !== $expected) {
                    throw new NotEqualException(
                        sprintf(
                            'Expected exception `%s` to be %s, but it is %s.',
                            $property->getName(),
                            $this->presenter->presentValue($expected),
                            $this->presenter->presentValue($actual)
                        ), $expected, $actual
                    );
                }
            }
        }
    }

    /**
     * @param callable           $callable
     * @param array              $arguments
     * @param string|null|object $exception
     *
     * @throws \PhpSpec\Exception\Example\FailureException
     */
<<<<<<< HEAD
    public function verifyNegative($callable, array $arguments, $exception = null)
=======
    public function verifyNegative(callable $callable, array $arguments, $exception = null)
>>>>>>> v2-test
    {
        $exceptionThrown = null;

        try {
<<<<<<< HEAD
            call_user_func_array($callable, $arguments);
=======
            \call_user_func_array($callable, $arguments);
>>>>>>> v2-test
        } catch (\Exception $e) {
            $exceptionThrown = $e;
        } catch (\Throwable $e) {
            $exceptionThrown = $e;
        }

        if ($exceptionThrown && null === $exception) {
            throw new FailureException(
                sprintf(
                    'Expected to not throw any exceptions, but got %s.',
                    $this->presenter->presentValue($exceptionThrown)
                )
            );
        }

        if ($exceptionThrown && $exceptionThrown instanceof $exception) {
            $invalidProperties = array();
<<<<<<< HEAD
            if (is_object($exception)) {
                $exceptionRefl = $this->factory->create($exception);
                foreach ($exceptionRefl->getProperties() as $property) {
                    if (in_array($property->getName(), self::$ignoredProperties, true)) {
=======
            if (\is_object($exception)) {
                $exceptionRefl = $this->factory->create($exception);
                foreach ($exceptionRefl->getProperties() as $property) {
                    if (\in_array($property->getName(), self::$ignoredProperties, true)) {
>>>>>>> v2-test
                        continue;
                    }

                    $property->setAccessible(true);
                    $expected = $property->getValue($exception);
                    $actual = $property->getValue($exceptionThrown);

                    if (null !== $expected && $actual === $expected) {
                        $invalidProperties[] = sprintf(
                            '  `%s`=%s',
                            $property->getName(),
                            $this->presenter->presentValue($expected)
                        );
                    }
                }
            }

            $withProperties = '';
<<<<<<< HEAD
            if (count($invalidProperties) > 0) {
=======
            if (\count($invalidProperties) > 0) {
>>>>>>> v2-test
                $withProperties = sprintf(
                    ' with'.PHP_EOL.'%s,'.PHP_EOL,
                    implode(",\n", $invalidProperties)
                );
            }

            throw new FailureException(
                sprintf(
                    'Expected to not throw %s exception%s but got it.',
                    $this->presenter->presentValue($exception),
                    $withProperties
                )
            );
        }
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
        return 1;
    }

    /**
     * @param callable $check
     * @param mixed    $subject
     * @param array    $arguments
     *
     * @return DelayedCall
     */
<<<<<<< HEAD
    private function getDelayedCall($check, $subject, array $arguments)
=======
    private function getDelayedCall(callable $check, $subject, array $arguments): DelayedCall
>>>>>>> v2-test
    {
        $exception = $this->getException($arguments);
        $unwrapper = $this->unwrapper;

        return new DelayedCall(
            function ($method, $arguments) use ($check, $subject, $exception, $unwrapper) {
                $arguments = $unwrapper->unwrapAll($arguments);

                $methodName = $arguments[0];
<<<<<<< HEAD
                $arguments = isset($arguments[1]) ? $arguments[1] : array();
=======
                $arguments = $arguments[1] ?? array();
>>>>>>> v2-test
                $callable = array($subject, $methodName);

                list($class, $methodName) = array($subject, $methodName);
                if (!method_exists($class, $methodName) && !method_exists($class, '__call')) {
                    throw new MethodNotFoundException(
<<<<<<< HEAD
                        sprintf('Method %s::%s not found.', get_class($class), $methodName),
=======
                        sprintf('Method %s::%s not found.', \get_class($class), $methodName),
>>>>>>> v2-test
                        $class,
                        $methodName,
                        $arguments
                    );
                }

<<<<<<< HEAD
                return call_user_func($check, $callable, $arguments, $exception);
=======
                return \call_user_func($check, $callable, $arguments, $exception);
>>>>>>> v2-test
            }
        );
    }

    /**
     * @param array $arguments
     *
<<<<<<< HEAD
     * @return null|string
=======
     * @return null|string|\Throwable
>>>>>>> v2-test
     * @throws \PhpSpec\Exception\Example\MatcherException
     */
    private function getException(array $arguments)
    {
<<<<<<< HEAD
        if (0 === count($arguments)) {
            return null;
        }

        if (is_string($arguments[0])) {
            return $arguments[0];
        }

        if (is_object($arguments[0])) {
            if (class_exists('\Throwable') && $arguments[0] instanceof \Throwable) {
                return $arguments[0];
            } elseif ($arguments[0] instanceof \Exception) {
=======
        if (0 === \count($arguments)) {
            return null;
        }

        if (\is_string($arguments[0])) {
            return $arguments[0];
        }

        if (\is_object($arguments[0])) {
            if ($arguments[0] instanceof \Throwable) {
>>>>>>> v2-test
                return $arguments[0];
            }
        }

        throw new MatcherException(
            sprintf(
                "Wrong argument provided in throw matcher.\n".
                "Fully qualified classname or exception instance expected,\n".
                "Got %s.",
                $this->presenter->presentValue($arguments[0])
            )
        );
    }
}
