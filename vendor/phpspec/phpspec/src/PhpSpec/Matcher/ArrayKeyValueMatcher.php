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

use ArrayAccess;
use PhpSpec\Exception\Example\FailureException;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;

class ArrayKeyValueMatcher extends BasicMatcher
{
    /**
     * @var PresenterInterface
=======
use PhpSpec\Formatter\Presenter\Presenter;

final class ArrayKeyValueMatcher extends BasicMatcher
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
        return
            (is_array($subject) || $subject instanceof \ArrayAccess) &&
            'haveKeyWithValue' === $name &&
            2 == count($arguments)
=======
    public function supports(string $name, $subject, array $arguments): bool
    {
        return
            (\is_array($subject) || $subject instanceof \ArrayAccess) &&
            'haveKeyWithValue' === $name &&
            2 == \count($arguments)
>>>>>>> v2-test
        ;
    }

    /**
     * @param ArrayAccess|array $subject
     * @param array $arguments
     *
     * @return bool
     */
<<<<<<< HEAD
    protected function matches($subject, array $arguments)
=======
    protected function matches($subject, array $arguments): bool
>>>>>>> v2-test
    {
        $key = $arguments[0];
        $value  = $arguments[1];

        if ($subject instanceof ArrayAccess) {
            return $subject->offsetExists($key) && $subject->offsetGet($key) === $value;
        }

        return (isset($subject[$key]) || array_key_exists($arguments[0], $subject)) && $subject[$key] === $value;
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
        $key = $arguments[0];

        if (!$this->offsetExists($key, $subject)) {
            return new FailureException(sprintf('Expected %s to have key %s, but it didn\'t.',
                $this->presenter->presentValue($subject),
                $this->presenter->presentString($key)
            ));
        }

        return new FailureException(sprintf(
            'Expected %s to have value %s for %s key, but found %s.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments[1]),
            $this->presenter->presentString($key),
            $this->presenter->presentValue($subject[$key])
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
            'Expected %s not to have %s key, but it does.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentString($arguments[0])
        ));
    }

    private function offsetExists($key, $subject)
    {
<<<<<<< HEAD
        return ($subject instanceof ArrayAccess && $subject->offsetExists($key)) || array_key_exists($key, $subject);
=======
        if ($subject instanceof ArrayAccess && $subject->offsetExists($key)) {
            return true;
        }
        if (is_array($subject) && array_key_exists($key, $subject)) {
            return true;
        }
        return false;
>>>>>>> v2-test
    }
}
