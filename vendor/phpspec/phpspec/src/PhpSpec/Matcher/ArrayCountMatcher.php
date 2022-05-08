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

class ArrayCountMatcher extends BasicMatcher
{
    /**
     * @var PresenterInterface
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;

final class ArrayCountMatcher extends BasicMatcher
{
    /**
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
        return 'haveCount' === $name
            && 1 == count($arguments)
            && (is_array($subject) || $subject instanceof \Countable)
=======
    public function supports(string $name, $subject, array $arguments): bool
    {
        return 'haveCount' === $name
            && 1 == \count($arguments)
            && (\is_array($subject) || $subject instanceof \Countable)
>>>>>>> v2-test
        ;
    }

    /**
     * @param mixed $subject
     * @param array $arguments
     *
     * @return bool
     */
<<<<<<< HEAD
    protected function matches($subject, array $arguments)
    {
        return $arguments[0] === count($subject);
=======
    protected function matches($subject, array $arguments): bool
    {
        return $arguments[0] === \count($subject);
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
            'Expected %s to have %s items, but got %s.',
            $this->presenter->presentValue($subject),
<<<<<<< HEAD
            $this->presenter->presentString(intval($arguments[0])),
            $this->presenter->presentString(count($subject))
=======
            $this->presenter->presentString(\intval($arguments[0])),
            $this->presenter->presentString(\count($subject))
>>>>>>> v2-test
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
            'Expected %s not to have %s items, but got it.',
            $this->presenter->presentValue($subject),
<<<<<<< HEAD
            $this->presenter->presentString(intval($arguments[0]))
=======
            $this->presenter->presentString(\intval($arguments[0]))
>>>>>>> v2-test
        ));
    }
}
