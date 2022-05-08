<?php

namespace Psr\Log;

/**
<<<<<<< HEAD
 * Describes a logger instance
=======
 * Describes a logger instance.
>>>>>>> v2-test
 *
 * The message MUST be a string or object implementing __toString().
 *
 * The message MAY contain placeholders in the form: {foo} where foo
 * will be replaced by the context data in key "foo".
 *
<<<<<<< HEAD
 * The context array can contain arbitrary data, the only assumption that
=======
 * The context array can contain arbitrary data. The only assumption that
>>>>>>> v2-test
 * can be made by implementors is that if an Exception instance is given
 * to produce a stack trace, it MUST be in a key named "exception".
 *
 * See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 * for the full interface specification.
 */
interface LoggerInterface
{
    /**
     * System is unusable.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function emergency($message, array $context = array());

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function alert($message, array $context = array());

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function critical($message, array $context = array());

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function error($message, array $context = array());

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function warning($message, array $context = array());

    /**
     * Normal but significant events.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function notice($message, array $context = array());

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function info($message, array $context = array());

    /**
     * Detailed debug information.
     *
<<<<<<< HEAD
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function debug($message, array $context = array());

    /**
     * Logs with an arbitrary level.
     *
<<<<<<< HEAD
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
=======
     * @param mixed   $level
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
>>>>>>> v2-test
     */
    public function log($level, $message, array $context = array());
}
