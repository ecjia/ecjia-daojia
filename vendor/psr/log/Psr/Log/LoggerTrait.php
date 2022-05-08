<?php

namespace Psr\Log;

/**
 * This is a simple Logger trait that classes unable to extend AbstractLogger
 * (because they extend another class, etc) can include.
 *
<<<<<<< HEAD
 * It simply delegates all log-level-specific methods to the `log` method to 
 * reduce boilerplate code that a simple Logger that does the same thing with 
=======
 * It simply delegates all log-level-specific methods to the `log` method to
 * reduce boilerplate code that a simple Logger that does the same thing with
>>>>>>> v2-test
 * messages regardless of the error level has to implement.
 */
trait LoggerTrait
{
    /**
     * System is unusable.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
<<<<<<< HEAD
     * @param array $context
     * @return null
=======
     * @param array  $context
     *
     * @return void
>>>>>>> v2-test
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

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
    abstract public function log($level, $message, array $context = array());
}
