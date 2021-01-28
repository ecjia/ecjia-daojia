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
use PhpSpec\Wrapper\DelayedCall;

abstract class BasicMatcher implements Matcher
{
    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return void
     *
     * @throws FailureException
     */
    final public function positiveMatch(string $name, $subject, array $arguments): ?DelayedCall
    {
        if (false === $this->matches($subject, $arguments)) {
            throw $this->getFailureException($name, $subject, $arguments);
        }

        return null;
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return void
     *
     * @throws FailureException
     */
    final public function negativeMatch(string $name, $subject, array $arguments): ?DelayedCall
    {
        if (true === $this->matches($subject, $arguments)) {
            throw $this->getNegativeFailureException($name, $subject, $arguments);
        }

        return null;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return 100;
    }

    /**
     * @param mixed $subject
     * @param array $arguments
     *
     * @return boolean
     */
    abstract protected function matches($subject, array $arguments): bool;

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
    abstract protected function getFailureException(string $name, $subject, array $arguments): FailureException;

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
    abstract protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException;
}
