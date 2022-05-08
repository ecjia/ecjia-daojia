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

class CallbackMatcher extends BasicMatcher
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;

final class CallbackMatcher extends BasicMatcher
>>>>>>> v2-test
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var callable
     */
    private $callback;
    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
     * @param string             $name
     * @param callable           $callback
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     */
    public function __construct($name, $callback, PresenterInterface $presenter)
=======
     * @param Presenter $presenter
     */
    public function __construct(string $name, callable $callback, Presenter $presenter)
>>>>>>> v2-test
    {
        $this->name      = $name;
        $this->callback  = $callback;
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
=======
    public function supports(string $name, $subject, array $arguments): bool
>>>>>>> v2-test
    {
        return $name === $this->name;
    }

    /**
<<<<<<< HEAD
     * @param string $subject
     * @param array  $arguments
     *
     * @return bool
     */
    protected function matches($subject, array $arguments)
    {
        array_unshift($arguments, $subject);

        return (Boolean) call_user_func_array($this->callback, $arguments);
=======
     * @param mixed $subject
     * @param array $arguments
     *
     * @return bool
     */
    protected function matches($subject, array $arguments): bool
    {
        array_unshift($arguments, $subject);

        return (Boolean) \call_user_func_array($this->callback, $arguments);
>>>>>>> v2-test
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
<<<<<<< HEAD
    protected function getFailureException($name, $subject, array $arguments)
=======
    protected function getFailureException(string $name, $subject, array $arguments): FailureException
>>>>>>> v2-test
    {
        return new FailureException(sprintf(
            '%s expected to %s(%s), but it is not.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentString($name),
            implode(', ', array_map(array($this->presenter, 'presentValue'), $arguments))
        ));
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
<<<<<<< HEAD
    protected function getNegativeFailureException($name, $subject, array $arguments)
=======
    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
>>>>>>> v2-test
    {
        return new FailureException(sprintf(
            '%s not expected to %s(%s), but it did.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentString($name),
            implode(', ', array_map(array($this->presenter, 'presentValue'), $arguments))
        ));
    }
}
