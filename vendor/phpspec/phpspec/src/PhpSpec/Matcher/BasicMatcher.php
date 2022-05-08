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

use PhpSpec\Exception\Example\FailureException;
<<<<<<< HEAD

abstract class BasicMatcher implements MatcherInterface
=======
use PhpSpec\Wrapper\DelayedCall;

abstract class BasicMatcher implements Matcher
>>>>>>> v2-test
{
    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
<<<<<<< HEAD
     * @return mixed
     *
     *   @throws FailureException
     */
    final public function positiveMatch($name, $subject, array $arguments)
=======
     * @return void
     *
     * @throws FailureException
     */
    final public function positiveMatch(string $name, $subject, array $arguments): ?DelayedCall
>>>>>>> v2-test
    {
        if (false === $this->matches($subject, $arguments)) {
            throw $this->getFailureException($name, $subject, $arguments);
        }

<<<<<<< HEAD
        return $subject;
=======
        return null;
>>>>>>> v2-test
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
<<<<<<< HEAD
     * @return mixed
     *
     * @throws FailureException
     */
    final public function negativeMatch($name, $subject, array $arguments)
=======
     * @return void
     *
     * @throws FailureException
     */
    final public function negativeMatch(string $name, $subject, array $arguments): ?DelayedCall
>>>>>>> v2-test
    {
        if (true === $this->matches($subject, $arguments)) {
            throw $this->getNegativeFailureException($name, $subject, $arguments);
        }

<<<<<<< HEAD
        return $subject;
=======
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
        return 100;
    }

    /**
     * @param mixed $subject
     * @param array $arguments
     *
     * @return boolean
     */
<<<<<<< HEAD
    abstract protected function matches($subject, array $arguments);
=======
    abstract protected function matches($subject, array $arguments): bool;
>>>>>>> v2-test

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
<<<<<<< HEAD
    abstract protected function getFailureException($name, $subject, array $arguments);
=======
    abstract protected function getFailureException(string $name, $subject, array $arguments): FailureException;
>>>>>>> v2-test

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
<<<<<<< HEAD
    abstract protected function getNegativeFailureException($name, $subject, array $arguments);
=======
    abstract protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException;
>>>>>>> v2-test
}
