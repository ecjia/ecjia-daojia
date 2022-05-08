<?php

namespace Psr\Log;

/**
<<<<<<< HEAD
 * This Logger can be used to avoid conditional log calls
=======
 * This Logger can be used to avoid conditional log calls.
>>>>>>> v2-test
 *
 * Logging should always be optional, and if no logger is provided to your
 * library creating a NullLogger instance to have something to throw logs at
 * is a good way to avoid littering your code with `if ($this->logger) { }`
 * blocks.
 */
class NullLogger extends AbstractLogger
{
    /**
     * Logs with an arbitrary level.
     *
<<<<<<< HEAD
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
>>>>>>> v2-test
     */
    public function log($level, $message, array $context = array())
    {
        // noop
    }
}
