<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug;

<<<<<<< HEAD
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\Debug\FatalErrorHandler\UndefinedFunctionFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\UndefinedMethodFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\ClassNotFoundFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\FatalErrorHandlerInterface;
=======
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\Debug\Exception\SilencedErrorContext;
use Symfony\Component\Debug\FatalErrorHandler\ClassNotFoundFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\FatalErrorHandlerInterface;
use Symfony\Component\Debug\FatalErrorHandler\UndefinedFunctionFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\UndefinedMethodFatalErrorHandler;

@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4, use "%s" instead.', ErrorHandler::class, \Symfony\Component\ErrorHandler\ErrorHandler::class), \E_USER_DEPRECATED);
>>>>>>> v2-test

/**
 * A generic ErrorHandler for the PHP engine.
 *
 * Provides five bit fields that control how errors are handled:
 * - thrownErrors: errors thrown as \ErrorException
 * - loggedErrors: logged errors, when not @-silenced
 * - scopedErrors: errors thrown or logged with their local context
<<<<<<< HEAD
 * - tracedErrors: errors logged with their stack trace, only once for repeated errors
=======
 * - tracedErrors: errors logged with their stack trace
>>>>>>> v2-test
 * - screamedErrors: never @-silenced errors
 *
 * Each error level can be logged by a dedicated PSR-3 logger object.
 * Screaming only applies to logging.
 * Throwing takes precedence over logging.
 * Uncaught exceptions are logged as E_ERROR.
 * E_DEPRECATED and E_USER_DEPRECATED levels never throw.
 * E_RECOVERABLE_ERROR and E_USER_ERROR levels always throw.
 * Non catchable errors that can be detected at shutdown time are logged when the scream bit field allows so.
 * As errors have a performance cost, repeated errors are all logged, so that the developer
 * can see them and weight them as more important to fix than others of the same level.
 *
 * @author Nicolas Grekas <p@tchwork.com>
<<<<<<< HEAD
 */
class ErrorHandler
{
    /**
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    const TYPE_DEPRECATION = -100;

    private $levels = array(
        E_DEPRECATED => 'Deprecated',
        E_USER_DEPRECATED => 'User Deprecated',
        E_NOTICE => 'Notice',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice',
        E_WARNING => 'Warning',
        E_USER_WARNING => 'User Warning',
        E_COMPILE_WARNING => 'Compile Warning',
        E_CORE_WARNING => 'Core Warning',
        E_USER_ERROR => 'User Error',
        E_RECOVERABLE_ERROR => 'Catchable Fatal Error',
        E_COMPILE_ERROR => 'Compile Error',
        E_PARSE => 'Parse Error',
        E_ERROR => 'Error',
        E_CORE_ERROR => 'Core Error',
    );

    private $loggers = array(
        E_DEPRECATED => array(null, LogLevel::INFO),
        E_USER_DEPRECATED => array(null, LogLevel::INFO),
        E_NOTICE => array(null, LogLevel::WARNING),
        E_USER_NOTICE => array(null, LogLevel::WARNING),
        E_STRICT => array(null, LogLevel::WARNING),
        E_WARNING => array(null, LogLevel::WARNING),
        E_USER_WARNING => array(null, LogLevel::WARNING),
        E_COMPILE_WARNING => array(null, LogLevel::WARNING),
        E_CORE_WARNING => array(null, LogLevel::WARNING),
        E_USER_ERROR => array(null, LogLevel::CRITICAL),
        E_RECOVERABLE_ERROR => array(null, LogLevel::CRITICAL),
        E_COMPILE_ERROR => array(null, LogLevel::CRITICAL),
        E_PARSE => array(null, LogLevel::CRITICAL),
        E_ERROR => array(null, LogLevel::CRITICAL),
        E_CORE_ERROR => array(null, LogLevel::CRITICAL),
    );
=======
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 *
 * @final since Symfony 4.3
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\ErrorHandler instead.
 */
class ErrorHandler
{
    private $levels = [
        \E_DEPRECATED => 'Deprecated',
        \E_USER_DEPRECATED => 'User Deprecated',
        \E_NOTICE => 'Notice',
        \E_USER_NOTICE => 'User Notice',
        \E_STRICT => 'Runtime Notice',
        \E_WARNING => 'Warning',
        \E_USER_WARNING => 'User Warning',
        \E_COMPILE_WARNING => 'Compile Warning',
        \E_CORE_WARNING => 'Core Warning',
        \E_USER_ERROR => 'User Error',
        \E_RECOVERABLE_ERROR => 'Catchable Fatal Error',
        \E_COMPILE_ERROR => 'Compile Error',
        \E_PARSE => 'Parse Error',
        \E_ERROR => 'Error',
        \E_CORE_ERROR => 'Core Error',
    ];

    private $loggers = [
        \E_DEPRECATED => [null, LogLevel::INFO],
        \E_USER_DEPRECATED => [null, LogLevel::INFO],
        \E_NOTICE => [null, LogLevel::WARNING],
        \E_USER_NOTICE => [null, LogLevel::WARNING],
        \E_STRICT => [null, LogLevel::WARNING],
        \E_WARNING => [null, LogLevel::WARNING],
        \E_USER_WARNING => [null, LogLevel::WARNING],
        \E_COMPILE_WARNING => [null, LogLevel::WARNING],
        \E_CORE_WARNING => [null, LogLevel::WARNING],
        \E_USER_ERROR => [null, LogLevel::CRITICAL],
        \E_RECOVERABLE_ERROR => [null, LogLevel::CRITICAL],
        \E_COMPILE_ERROR => [null, LogLevel::CRITICAL],
        \E_PARSE => [null, LogLevel::CRITICAL],
        \E_ERROR => [null, LogLevel::CRITICAL],
        \E_CORE_ERROR => [null, LogLevel::CRITICAL],
    ];
>>>>>>> v2-test

    private $thrownErrors = 0x1FFF; // E_ALL - E_DEPRECATED - E_USER_DEPRECATED
    private $scopedErrors = 0x1FFF; // E_ALL - E_DEPRECATED - E_USER_DEPRECATED
    private $tracedErrors = 0x77FB; // E_ALL - E_STRICT - E_PARSE
    private $screamedErrors = 0x55; // E_ERROR + E_CORE_ERROR + E_COMPILE_ERROR + E_PARSE
    private $loggedErrors = 0;
<<<<<<< HEAD

    private $loggedTraces = array();
    private $isRecursive = 0;
    private $isRoot = false;
    private $exceptionHandler;

    private static $reservedMemory;
    private static $stackedErrors = array();
    private static $stackedErrorLevels = array();

    /**
     * Same init value as thrownErrors.
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    private $displayErrors = 0x1FFF;
=======
    private $traceReflector;

    private $isRecursive = 0;
    private $isRoot = false;
    private $exceptionHandler;
    private $bootstrappingLogger;

    private static $reservedMemory;
    private static $toStringException = null;
    private static $silencedErrorCache = [];
    private static $silencedErrorCount = 0;
    private static $exitCode = 0;
>>>>>>> v2-test

    /**
     * Registers the error handler.
     *
<<<<<<< HEAD
     * @param self|null|int $handler The handler to register, or @deprecated (since version 2.6, to be removed in 3.0) bit field of thrown levels
     * @param bool          $replace Whether to replace or not any existing handler
     *
     * @return self The registered error handler
     */
    public static function register($handler = null, $replace = true)
=======
     * @param self|null $handler The handler to register
     * @param bool      $replace Whether to replace or not any existing handler
     *
     * @return self The registered error handler
     */
    public static function register(self $handler = null, $replace = true)
>>>>>>> v2-test
    {
        if (null === self::$reservedMemory) {
            self::$reservedMemory = str_repeat('x', 10240);
            register_shutdown_function(__CLASS__.'::handleFatalError');
        }

<<<<<<< HEAD
        $levels = -1;

        if ($handlerIsNew = !$handler instanceof self) {
            // @deprecated polymorphism, to be removed in 3.0
            if (null !== $handler) {
                $levels = $replace ? $handler : 0;
                $replace = true;
            }
            $handler = new static();
        }

        if (null === $prev = set_error_handler(array($handler, 'handleError'))) {
            restore_error_handler();
            // Specifying the error types earlier would expose us to https://bugs.php.net/63206
            set_error_handler(array($handler, 'handleError'), $handler->thrownErrors | $handler->loggedErrors);
            $handler->isRoot = true;
        }

        if ($handlerIsNew && is_array($prev) && $prev[0] instanceof self) {
            $handler = $prev[0];
            $replace = false;
        }
        if ($replace || !$prev) {
            $handler->setExceptionHandler(set_exception_handler(array($handler, 'handleException')));
        } else {
            restore_error_handler();
        }

        $handler->throwAt($levels & $handler->thrownErrors, true);
=======
        if ($handlerIsNew = null === $handler) {
            $handler = new static();
        }

        if (null === $prev = set_error_handler([$handler, 'handleError'])) {
            restore_error_handler();
            // Specifying the error types earlier would expose us to https://bugs.php.net/63206
            set_error_handler([$handler, 'handleError'], $handler->thrownErrors | $handler->loggedErrors);
            $handler->isRoot = true;
        }

        if ($handlerIsNew && \is_array($prev) && $prev[0] instanceof self) {
            $handler = $prev[0];
            $replace = false;
        }
        if (!$replace && $prev) {
            restore_error_handler();
            $handlerIsRegistered = \is_array($prev) && $handler === $prev[0];
        } else {
            $handlerIsRegistered = true;
        }
        if (\is_array($prev = set_exception_handler([$handler, 'handleException'])) && $prev[0] instanceof self) {
            restore_exception_handler();
            if (!$handlerIsRegistered) {
                $handler = $prev[0];
            } elseif ($handler !== $prev[0] && $replace) {
                set_exception_handler([$handler, 'handleException']);
                $p = $prev[0]->setExceptionHandler(null);
                $handler->setExceptionHandler($p);
                $prev[0]->setExceptionHandler($p);
            }
        } else {
            $handler->setExceptionHandler($prev);
        }

        $handler->throwAt(\E_ALL & $handler->thrownErrors, true);
>>>>>>> v2-test

        return $handler;
    }

<<<<<<< HEAD
    /**
     * Sets a logger to non assigned errors levels.
     *
     * @param LoggerInterface $logger  A PSR-3 logger to put as default for the given levels
     * @param array|int       $levels  An array map of E_* to LogLevel::* or an integer bit field of E_* constants
     * @param bool            $replace Whether to replace or not any existing logger
     */
    public function setDefaultLogger(LoggerInterface $logger, $levels = null, $replace = false)
    {
        $loggers = array();

        if (is_array($levels)) {
            foreach ($levels as $type => $logLevel) {
                if (empty($this->loggers[$type][0]) || $replace) {
                    $loggers[$type] = array($logger, $logLevel);
=======
    public function __construct(BufferingLogger $bootstrappingLogger = null)
    {
        if ($bootstrappingLogger) {
            $this->bootstrappingLogger = $bootstrappingLogger;
            $this->setDefaultLogger($bootstrappingLogger);
        }
        $this->traceReflector = new \ReflectionProperty(\Exception::class, 'trace');
        $this->traceReflector->setAccessible(true);
    }

    /**
     * Sets a logger to non assigned errors levels.
     *
     * @param array|int $levels  An array map of E_* to LogLevel::* or an integer bit field of E_* constants
     * @param bool      $replace Whether to replace or not any existing logger
     */
    public function setDefaultLogger(LoggerInterface $logger, $levels = \E_ALL, $replace = false)
    {
        $loggers = [];

        if (\is_array($levels)) {
            foreach ($levels as $type => $logLevel) {
                if (empty($this->loggers[$type][0]) || $replace || $this->loggers[$type][0] === $this->bootstrappingLogger) {
                    $loggers[$type] = [$logger, $logLevel];
>>>>>>> v2-test
                }
            }
        } else {
            if (null === $levels) {
<<<<<<< HEAD
                $levels = E_ALL | E_STRICT;
            }
            foreach ($this->loggers as $type => $log) {
                if (($type & $levels) && (empty($log[0]) || $replace)) {
=======
                $levels = \E_ALL;
            }
            foreach ($this->loggers as $type => $log) {
                if (($type & $levels) && (empty($log[0]) || $replace || $log[0] === $this->bootstrappingLogger)) {
>>>>>>> v2-test
                    $log[0] = $logger;
                    $loggers[$type] = $log;
                }
            }
        }

        $this->setLoggers($loggers);
    }

    /**
     * Sets a logger for each error level.
     *
     * @param array $loggers Error levels to [LoggerInterface|null, LogLevel::*] map
     *
     * @return array The previous map
     *
     * @throws \InvalidArgumentException
     */
    public function setLoggers(array $loggers)
    {
        $prevLogged = $this->loggedErrors;
        $prev = $this->loggers;
<<<<<<< HEAD
=======
        $flush = [];
>>>>>>> v2-test

        foreach ($loggers as $type => $log) {
            if (!isset($prev[$type])) {
                throw new \InvalidArgumentException('Unknown error type: '.$type);
            }
<<<<<<< HEAD
            if (!is_array($log)) {
                $log = array($log);
            } elseif (!array_key_exists(0, $log)) {
                throw new \InvalidArgumentException('No logger provided');
=======
            if (!\is_array($log)) {
                $log = [$log];
            } elseif (!\array_key_exists(0, $log)) {
                throw new \InvalidArgumentException('No logger provided.');
>>>>>>> v2-test
            }
            if (null === $log[0]) {
                $this->loggedErrors &= ~$type;
            } elseif ($log[0] instanceof LoggerInterface) {
                $this->loggedErrors |= $type;
            } else {
<<<<<<< HEAD
                throw new \InvalidArgumentException('Invalid logger provided');
            }
            $this->loggers[$type] = $log + $prev[$type];
        }
        $this->reRegister($prevLogged | $this->thrownErrors);

=======
                throw new \InvalidArgumentException('Invalid logger provided.');
            }
            $this->loggers[$type] = $log + $prev[$type];

            if ($this->bootstrappingLogger && $prev[$type][0] === $this->bootstrappingLogger) {
                $flush[$type] = $type;
            }
        }
        $this->reRegister($prevLogged | $this->thrownErrors);

        if ($flush) {
            foreach ($this->bootstrappingLogger->cleanLogs() as $log) {
                $type = $log[2]['exception'] instanceof \ErrorException ? $log[2]['exception']->getSeverity() : \E_ERROR;
                if (!isset($flush[$type])) {
                    $this->bootstrappingLogger->log($log[0], $log[1], $log[2]);
                } elseif ($this->loggers[$type][0]) {
                    $this->loggers[$type][0]->log($this->loggers[$type][1], $log[1], $log[2]);
                }
            }
        }

>>>>>>> v2-test
        return $prev;
    }

    /**
     * Sets a user exception handler.
     *
     * @param callable $handler A handler that will be called on Exception
     *
     * @return callable|null The previous exception handler
<<<<<<< HEAD
     *
     * @throws \InvalidArgumentException
     */
    public function setExceptionHandler($handler)
    {
        if (null !== $handler && !is_callable($handler)) {
            throw new \LogicException('The exception handler must be a valid PHP callable.');
        }
=======
     */
    public function setExceptionHandler(callable $handler = null)
    {
>>>>>>> v2-test
        $prev = $this->exceptionHandler;
        $this->exceptionHandler = $handler;

        return $prev;
    }

    /**
     * Sets the PHP error levels that throw an exception when a PHP error occurs.
     *
     * @param int  $levels  A bit field of E_* constants for thrown errors
     * @param bool $replace Replace or amend the previous value
     *
     * @return int The previous value
     */
    public function throwAt($levels, $replace = false)
    {
        $prev = $this->thrownErrors;
<<<<<<< HEAD
        $this->thrownErrors = ($levels | E_RECOVERABLE_ERROR | E_USER_ERROR) & ~E_USER_DEPRECATED & ~E_DEPRECATED;
=======
        $this->thrownErrors = ($levels | \E_RECOVERABLE_ERROR | \E_USER_ERROR) & ~\E_USER_DEPRECATED & ~\E_DEPRECATED;
>>>>>>> v2-test
        if (!$replace) {
            $this->thrownErrors |= $prev;
        }
        $this->reRegister($prev | $this->loggedErrors);

<<<<<<< HEAD
        // $this->displayErrors is @deprecated since version 2.6
        $this->displayErrors = $this->thrownErrors;

=======
>>>>>>> v2-test
        return $prev;
    }

    /**
     * Sets the PHP error levels for which local variables are preserved.
     *
     * @param int  $levels  A bit field of E_* constants for scoped errors
     * @param bool $replace Replace or amend the previous value
     *
     * @return int The previous value
     */
    public function scopeAt($levels, $replace = false)
    {
        $prev = $this->scopedErrors;
        $this->scopedErrors = (int) $levels;
        if (!$replace) {
            $this->scopedErrors |= $prev;
        }

        return $prev;
    }

    /**
     * Sets the PHP error levels for which the stack trace is preserved.
     *
     * @param int  $levels  A bit field of E_* constants for traced errors
     * @param bool $replace Replace or amend the previous value
     *
     * @return int The previous value
     */
    public function traceAt($levels, $replace = false)
    {
        $prev = $this->tracedErrors;
        $this->tracedErrors = (int) $levels;
        if (!$replace) {
            $this->tracedErrors |= $prev;
        }

        return $prev;
    }

    /**
     * Sets the error levels where the @-operator is ignored.
     *
     * @param int  $levels  A bit field of E_* constants for screamed errors
     * @param bool $replace Replace or amend the previous value
     *
     * @return int The previous value
     */
    public function screamAt($levels, $replace = false)
    {
        $prev = $this->screamedErrors;
        $this->screamedErrors = (int) $levels;
        if (!$replace) {
            $this->screamedErrors |= $prev;
        }

        return $prev;
    }

    /**
     * Re-registers as a PHP error handler if levels changed.
     */
<<<<<<< HEAD
    private function reRegister($prev)
    {
        if ($prev !== $this->thrownErrors | $this->loggedErrors) {
            $handler = set_error_handler('var_dump');
            $handler = is_array($handler) ? $handler[0] : null;
=======
    private function reRegister(int $prev)
    {
        if ($prev !== $this->thrownErrors | $this->loggedErrors) {
            $handler = set_error_handler('var_dump');
            $handler = \is_array($handler) ? $handler[0] : null;
>>>>>>> v2-test
            restore_error_handler();
            if ($handler === $this) {
                restore_error_handler();
                if ($this->isRoot) {
<<<<<<< HEAD
                    set_error_handler(array($this, 'handleError'), $this->thrownErrors | $this->loggedErrors);
                } else {
                    set_error_handler(array($this, 'handleError'));
=======
                    set_error_handler([$this, 'handleError'], $this->thrownErrors | $this->loggedErrors);
                } else {
                    set_error_handler([$this, 'handleError']);
>>>>>>> v2-test
                }
            }
        }
    }

    /**
     * Handles errors by filtering then logging them according to the configured bit fields.
     *
<<<<<<< HEAD
     * @param int    $type      One of the E_* constants
     * @param string $message
     * @param string $file
     * @param int    $line
     * @param array  $context
     * @param array  $backtrace
=======
     * @param int    $type    One of the E_* constants
     * @param string $message
     * @param string $file
     * @param int    $line
>>>>>>> v2-test
     *
     * @return bool Returns false when no handling happens so that the PHP engine can handle the error itself
     *
     * @throws \ErrorException When $this->thrownErrors requests so
     *
     * @internal
     */
<<<<<<< HEAD
    public function handleError($type, $message, $file, $line, array $context, array $backtrace = null)
    {
        $level = error_reporting() | E_RECOVERABLE_ERROR | E_USER_ERROR | E_DEPRECATED | E_USER_DEPRECATED;
=======
    public function handleError($type, $message, $file, $line)
    {
        if (\PHP_VERSION_ID >= 70300 && \E_WARNING === $type && '"' === $message[0] && false !== strpos($message, '" targeting switch is equivalent to "break')) {
            $type = \E_DEPRECATED;
        }

        // Level is the current error reporting level to manage silent error.
        $level = error_reporting();
        $silenced = 0 === ($level & $type);
        // Strong errors are not authorized to be silenced.
        $level |= \E_RECOVERABLE_ERROR | \E_USER_ERROR | \E_DEPRECATED | \E_USER_DEPRECATED;
>>>>>>> v2-test
        $log = $this->loggedErrors & $type;
        $throw = $this->thrownErrors & $type & $level;
        $type &= $level | $this->screamedErrors;

        if (!$type || (!$log && !$throw)) {
<<<<<<< HEAD
            return $type && $log;
        }

        if (PHP_VERSION_ID < 50400 && isset($context['GLOBALS']) && ($this->scopedErrors & $type)) {
            $e = $context;                  // Whatever the signature of the method,
            unset($e['GLOBALS'], $context); // $context is always a reference in 5.3
            $context = $e;
        }

        if (null !== $backtrace && $type & E_ERROR) {
            // E_ERROR fatal errors are triggered on HHVM when
            // hhvm.error_handling.call_user_handler_on_fatals=1
            // which is the way to get their backtrace.
            $this->handleFatalError(compact('type', 'message', 'file', 'line', 'backtrace'));

            return true;
        }

        if ($throw) {
            if (($this->scopedErrors & $type) && class_exists('Symfony\Component\Debug\Exception\ContextErrorException')) {
                // Checking for class existence is a work around for https://bugs.php.net/42098
                $throw = new ContextErrorException($this->levels[$type].': '.$message, 0, $type, $file, $line, $context);
            } else {
                $throw = new \ErrorException($this->levels[$type].': '.$message, 0, $type, $file, $line);
            }

            if (PHP_VERSION_ID <= 50407 && (PHP_VERSION_ID >= 50400 || PHP_VERSION_ID <= 50317)) {
                // Exceptions thrown from error handlers are sometimes not caught by the exception
                // handler and shutdown handlers are bypassed before 5.4.8/5.3.18.
                // We temporarily re-enable display_errors to prevent any blank page related to this bug.

                $throw->errorHandlerCanary = new ErrorHandlerCanary();
            }

            throw $throw;
        }

        // For duplicated errors, log the trace only once
        $e = md5("{$type}/{$line}/{$file}\x00{$message}", true);
        $trace = true;

        if (!($this->tracedErrors & $type) || isset($this->loggedTraces[$e])) {
            $trace = false;
        } else {
            $this->loggedTraces[$e] = 1;
        }

        $e = compact('type', 'file', 'line', 'level');

        if ($type & $level) {
            if ($this->scopedErrors & $type) {
                $e['scope_vars'] = $context;
                if ($trace) {
                    $e['stack'] = $backtrace ?: debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
                }
            } elseif ($trace) {
                if (null === $backtrace) {
                    $e['stack'] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                } else {
                    foreach ($backtrace as &$frame) {
                        unset($frame['args'], $frame);
                    }
                    $e['stack'] = $backtrace;
                }
            }
=======
            return !$silenced && $type && $log;
        }
        $scope = $this->scopedErrors & $type;

        if (false !== strpos($message, "@anonymous\0")) {
            $logMessage = $this->levels[$type].': '.(new FlattenException())->setMessage($message)->getMessage();
        } else {
            $logMessage = $this->levels[$type].': '.$message;
        }

        if (null !== self::$toStringException) {
            $errorAsException = self::$toStringException;
            self::$toStringException = null;
        } elseif (!$throw && !($type & $level)) {
            if (!isset(self::$silencedErrorCache[$id = $file.':'.$line])) {
                $lightTrace = $this->tracedErrors & $type ? $this->cleanTrace(debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 5), $type, $file, $line, false) : [];
                $errorAsException = new SilencedErrorContext($type, $file, $line, isset($lightTrace[1]) ? [$lightTrace[0]] : $lightTrace);
            } elseif (isset(self::$silencedErrorCache[$id][$message])) {
                $lightTrace = null;
                $errorAsException = self::$silencedErrorCache[$id][$message];
                ++$errorAsException->count;
            } else {
                $lightTrace = [];
                $errorAsException = null;
            }

            if (100 < ++self::$silencedErrorCount) {
                self::$silencedErrorCache = $lightTrace = [];
                self::$silencedErrorCount = 1;
            }
            if ($errorAsException) {
                self::$silencedErrorCache[$id][$message] = $errorAsException;
            }
            if (null === $lightTrace) {
                return true;
            }
        } else {
            $errorAsException = new \ErrorException($logMessage, 0, $type, $file, $line);

            if ($throw || $this->tracedErrors & $type) {
                $backtrace = $errorAsException->getTrace();
                $lightTrace = $this->cleanTrace($backtrace, $type, $file, $line, $throw);
                $this->traceReflector->setValue($errorAsException, $lightTrace);
            } else {
                $this->traceReflector->setValue($errorAsException, []);
                $backtrace = [];
            }
        }

        if ($throw) {
            if (\PHP_VERSION_ID < 70400 && \E_USER_ERROR & $type) {
                for ($i = 1; isset($backtrace[$i]); ++$i) {
                    if (isset($backtrace[$i]['function'], $backtrace[$i]['type'], $backtrace[$i - 1]['function'])
                        && '__toString' === $backtrace[$i]['function']
                        && '->' === $backtrace[$i]['type']
                        && !isset($backtrace[$i - 1]['class'])
                        && ('trigger_error' === $backtrace[$i - 1]['function'] || 'user_error' === $backtrace[$i - 1]['function'])
                    ) {
                        // Here, we know trigger_error() has been called from __toString().
                        // PHP triggers a fatal error when throwing from __toString().
                        // A small convention allows working around the limitation:
                        // given a caught $e exception in __toString(), quitting the method with
                        // `return trigger_error($e, E_USER_ERROR);` allows this error handler
                        // to make $e get through the __toString() barrier.

                        $context = 4 < \func_num_args() ? (func_get_arg(4) ?: []) : [];

                        foreach ($context as $e) {
                            if ($e instanceof \Throwable && $e->__toString() === $message) {
                                self::$toStringException = $e;

                                return true;
                            }
                        }

                        // Display the original error message instead of the default one.
                        $this->handleException($errorAsException);

                        // Stop the process by giving back the error to the native handler.
                        return false;
                    }
                }
            }

            throw $errorAsException;
>>>>>>> v2-test
        }

        if ($this->isRecursive) {
            $log = 0;
<<<<<<< HEAD
        } elseif (self::$stackedErrorLevels) {
            self::$stackedErrors[] = array($this->loggers[$type][0], ($type & $level) ? $this->loggers[$type][1] : LogLevel::DEBUG, $message, $e);
        } else {
            try {
                $this->isRecursive = true;
                $this->loggers[$type][0]->log(($type & $level) ? $this->loggers[$type][1] : LogLevel::DEBUG, $message, $e);
                $this->isRecursive = false;
            } catch (\Exception $e) {
                $this->isRecursive = false;

                throw $e;
            } catch (\Throwable $e) {
                $this->isRecursive = false;

                throw $e;
            }
        }

        return $type && $log;
=======
        } else {
            if (\PHP_VERSION_ID < (\PHP_VERSION_ID < 70400 ? 70316 : 70404)) {
                $currentErrorHandler = set_error_handler('var_dump');
                restore_error_handler();
            }

            try {
                $this->isRecursive = true;
                $level = ($type & $level) ? $this->loggers[$type][1] : LogLevel::DEBUG;
                $this->loggers[$type][0]->log($level, $logMessage, $errorAsException ? ['exception' => $errorAsException] : []);
            } finally {
                $this->isRecursive = false;

                if (\PHP_VERSION_ID < (\PHP_VERSION_ID < 70400 ? 70316 : 70404)) {
                    set_error_handler($currentErrorHandler);
                }
            }
        }

        return !$silenced && $type && $log;
>>>>>>> v2-test
    }

    /**
     * Handles an exception by logging then forwarding it to another handler.
     *
     * @param \Exception|\Throwable $exception An exception to handle
     * @param array                 $error     An array as returned by error_get_last()
     *
     * @internal
     */
    public function handleException($exception, array $error = null)
    {
<<<<<<< HEAD
        if (!$exception instanceof \Exception) {
            $exception = new FatalThrowableError($exception);
        }
        $type = $exception instanceof FatalErrorException ? $exception->getSeverity() : E_ERROR;

        if (($this->loggedErrors & $type) || $exception instanceof FatalThrowableError) {
            $e = array(
                'type' => $type,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'level' => error_reporting(),
                'stack' => $exception->getTrace(),
            );
            if ($exception instanceof FatalErrorException) {
                if ($exception instanceof FatalThrowableError) {
                    $error = array(
                        'type' => $type,
                        'message' => $message = $exception->getMessage(),
                        'file' => $e['file'],
                        'line' => $e['line'],
                    );
                } else {
                    $message = 'Fatal '.$exception->getMessage();
                }
            } elseif ($exception instanceof \ErrorException) {
                $message = 'Uncaught '.$exception->getMessage();
                if ($exception instanceof ContextErrorException) {
                    $e['context'] = $exception->getContext();
                }
            } else {
                $message = 'Uncaught Exception: '.$exception->getMessage();
            }
        }
        if ($this->loggedErrors & $type) {
            $this->loggers[$type][0]->log($this->loggers[$type][1], $message, $e);
=======
        if (null === $error) {
            self::$exitCode = 255;
        }
        if (!$exception instanceof \Exception) {
            $exception = new FatalThrowableError($exception);
        }
        $type = $exception instanceof FatalErrorException ? $exception->getSeverity() : \E_ERROR;
        $handlerException = null;

        if (($this->loggedErrors & $type) || $exception instanceof FatalThrowableError) {
            if (false !== strpos($message = $exception->getMessage(), "@anonymous\0")) {
                $message = (new FlattenException())->setMessage($message)->getMessage();
            }
            if ($exception instanceof FatalErrorException) {
                if ($exception instanceof FatalThrowableError) {
                    $error = [
                        'type' => $type,
                        'message' => $message,
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                    ];
                } else {
                    $message = 'Fatal '.$message;
                }
            } elseif ($exception instanceof \ErrorException) {
                $message = 'Uncaught '.$message;
            } else {
                $message = 'Uncaught Exception: '.$message;
            }
        }
        if ($this->loggedErrors & $type) {
            try {
                $this->loggers[$type][0]->log($this->loggers[$type][1], $message, ['exception' => $exception]);
            } catch (\Throwable $handlerException) {
            }
>>>>>>> v2-test
        }
        if ($exception instanceof FatalErrorException && !$exception instanceof OutOfMemoryException && $error) {
            foreach ($this->getFatalErrorHandlers() as $handler) {
                if ($e = $handler->handleError($error, $exception)) {
                    $exception = $e;
                    break;
                }
            }
        }
<<<<<<< HEAD
        if (empty($this->exceptionHandler)) {
            throw $exception; // Give back $exception to the native handler
        }
        try {
            call_user_func($this->exceptionHandler, $exception);
        } catch (\Exception $handlerException) {
        } catch (\Throwable $handlerException) {
        }
        if (isset($handlerException)) {
            $this->exceptionHandler = null;
            $this->handleException($handlerException);
        }
=======
        $exceptionHandler = $this->exceptionHandler;
        $this->exceptionHandler = null;
        try {
            if (null !== $exceptionHandler) {
                $exceptionHandler($exception);

                return;
            }
            $handlerException = $handlerException ?: $exception;
        } catch (\Throwable $handlerException) {
        }
        if ($exception === $handlerException) {
            self::$reservedMemory = null; // Disable the fatal error handler
            throw $exception; // Give back $exception to the native handler
        }
        $this->handleException($handlerException);
>>>>>>> v2-test
    }

    /**
     * Shutdown registered function for handling PHP fatal errors.
     *
     * @param array $error An array as returned by error_get_last()
     *
     * @internal
     */
    public static function handleFatalError(array $error = null)
    {
        if (null === self::$reservedMemory) {
            return;
        }

<<<<<<< HEAD
        self::$reservedMemory = null;

        $handler = set_error_handler('var_dump');
        $handler = is_array($handler) ? $handler[0] : null;
        restore_error_handler();

        if (!$handler instanceof self) {
            return;
        }

        if (null === $error) {
            $error = error_get_last();
        }

        try {
            while (self::$stackedErrorLevels) {
                static::unstackErrors();
            }
        } catch (\Exception $exception) {
            // Handled below
        } catch (\Throwable $exception) {
            // Handled below
        }

        if ($error && $error['type'] &= E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR) {
            // Let's not throw anymore but keep logging
            $handler->throwAt(0, true);
            $trace = isset($error['backtrace']) ? $error['backtrace'] : null;
=======
        $handler = self::$reservedMemory = null;
        $handlers = [];
        $previousHandler = null;
        $sameHandlerLimit = 10;

        while (!\is_array($handler) || !$handler[0] instanceof self) {
            $handler = set_exception_handler('var_dump');
            restore_exception_handler();

            if (!$handler) {
                break;
            }
            restore_exception_handler();

            if ($handler !== $previousHandler) {
                array_unshift($handlers, $handler);
                $previousHandler = $handler;
            } elseif (0 === --$sameHandlerLimit) {
                $handler = null;
                break;
            }
        }
        foreach ($handlers as $h) {
            set_exception_handler($h);
        }
        if (!$handler) {
            return;
        }
        if ($handler !== $h) {
            $handler[0]->setExceptionHandler($h);
        }
        $handler = $handler[0];
        $handlers = [];

        if ($exit = null === $error) {
            $error = error_get_last();
        }

        if ($error && $error['type'] &= \E_PARSE | \E_ERROR | \E_CORE_ERROR | \E_COMPILE_ERROR) {
            // Let's not throw anymore but keep logging
            $handler->throwAt(0, true);
            $trace = $error['backtrace'] ?? null;
>>>>>>> v2-test

            if (0 === strpos($error['message'], 'Allowed memory') || 0 === strpos($error['message'], 'Out of memory')) {
                $exception = new OutOfMemoryException($handler->levels[$error['type']].': '.$error['message'], 0, $error['type'], $error['file'], $error['line'], 2, false, $trace);
            } else {
                $exception = new FatalErrorException($handler->levels[$error['type']].': '.$error['message'], 0, $error['type'], $error['file'], $error['line'], 2, true, $trace);
            }
<<<<<<< HEAD
        } elseif (!isset($exception)) {
            return;
        }

        try {
            $handler->handleException($exception, $error);
        } catch (FatalErrorException $e) {
            // Ignore this re-throw
        }
    }

    /**
     * Configures the error handler for delayed handling.
     * Ensures also that non-catchable fatal errors are never silenced.
     *
     * As shown by http://bugs.php.net/42098 and http://bugs.php.net/60724
     * PHP has a compile stage where it behaves unusually. To workaround it,
     * we plug an error handler that only stacks errors for later.
     *
     * The most important feature of this is to prevent
     * autoloading until unstackErrors() is called.
     */
    public static function stackErrors()
    {
        self::$stackedErrorLevels[] = error_reporting(error_reporting() | E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
    }

    /**
     * Unstacks stacked errors and forwards to the logger.
     */
    public static function unstackErrors()
    {
        $level = array_pop(self::$stackedErrorLevels);

        if (null !== $level) {
            $e = error_reporting($level);
            if ($e !== ($level | E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR)) {
                // If the user changed the error level, do not overwrite it
                error_reporting($e);
            }
        }

        if (empty(self::$stackedErrorLevels)) {
            $errors = self::$stackedErrors;
            self::$stackedErrors = array();

            foreach ($errors as $e) {
                $e[0]->log($e[1], $e[2], $e[3]);
            }
=======
        } else {
            $exception = null;
        }

        try {
            if (null !== $exception) {
                self::$exitCode = 255;
                $handler->handleException($exception, $error);
            }
        } catch (FatalErrorException $e) {
            // Ignore this re-throw
        }

        if ($exit && self::$exitCode) {
            $exitCode = self::$exitCode;
            register_shutdown_function('register_shutdown_function', function () use ($exitCode) { exit($exitCode); });
>>>>>>> v2-test
        }
    }

    /**
     * Gets the fatal error handlers.
     *
     * Override this method if you want to define more fatal error handlers.
     *
     * @return FatalErrorHandlerInterface[] An array of FatalErrorHandlerInterface
     */
    protected function getFatalErrorHandlers()
    {
<<<<<<< HEAD
        return array(
            new UndefinedFunctionFatalErrorHandler(),
            new UndefinedMethodFatalErrorHandler(),
            new ClassNotFoundFatalErrorHandler(),
        );
    }

    /**
     * Sets the level at which the conversion to Exception is done.
     *
     * @param int|null $level The level (null to use the error_reporting() value and 0 to disable)
     *
     * @deprecated since version 2.6, to be removed in 3.0. Use throwAt() instead.
     */
    public function setLevel($level)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0. Use the throwAt() method instead.', E_USER_DEPRECATED);

        $level = null === $level ? error_reporting() : $level;
        $this->throwAt($level, true);
    }

    /**
     * Sets the display_errors flag value.
     *
     * @param int $displayErrors The display_errors flag value
     *
     * @deprecated since version 2.6, to be removed in 3.0. Use throwAt() instead.
     */
    public function setDisplayErrors($displayErrors)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0. Use the throwAt() method instead.', E_USER_DEPRECATED);

        if ($displayErrors) {
            $this->throwAt($this->displayErrors, true);
        } else {
            $displayErrors = $this->displayErrors;
            $this->throwAt(0, true);
            $this->displayErrors = $displayErrors;
        }
    }

    /**
     * Sets a logger for the given channel.
     *
     * @param LoggerInterface $logger  A logger interface
     * @param string          $channel The channel associated with the logger (deprecation, emergency or scream)
     *
     * @deprecated since version 2.6, to be removed in 3.0. Use setLoggers() or setDefaultLogger() instead.
     */
    public static function setLogger(LoggerInterface $logger, $channel = 'deprecation')
    {
        @trigger_error('The '.__METHOD__.' static method is deprecated since version 2.6 and will be removed in 3.0. Use the setLoggers() or setDefaultLogger() methods instead.', E_USER_DEPRECATED);

        $handler = set_error_handler('var_dump');
        $handler = is_array($handler) ? $handler[0] : null;
        restore_error_handler();
        if (!$handler instanceof self) {
            return;
        }
        if ('deprecation' === $channel) {
            $handler->setDefaultLogger($logger, E_DEPRECATED | E_USER_DEPRECATED, true);
            $handler->screamAt(E_DEPRECATED | E_USER_DEPRECATED);
        } elseif ('scream' === $channel) {
            $handler->setDefaultLogger($logger, E_ALL | E_STRICT, false);
            $handler->screamAt(E_ALL | E_STRICT);
        } elseif ('emergency' === $channel) {
            $handler->setDefaultLogger($logger, E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR, true);
            $handler->screamAt(E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
        }
    }

    /**
     * @deprecated since version 2.6, to be removed in 3.0. Use handleError() instead.
     */
    public function handle($level, $message, $file = 'unknown', $line = 0, $context = array())
    {
        $this->handleError(E_USER_DEPRECATED, 'The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0. Use the handleError() method instead.', __FILE__, __LINE__, array());

        return $this->handleError($level, $message, $file, $line, (array) $context);
    }

    /**
     * Handles PHP fatal errors.
     *
     * @deprecated since version 2.6, to be removed in 3.0. Use handleFatalError() instead.
     */
    public function handleFatal()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0. Use the handleFatalError() method instead.', E_USER_DEPRECATED);

        static::handleFatalError();
    }
}

/**
 * Private class used to work around https://bugs.php.net/54275.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
class ErrorHandlerCanary
{
    private static $displayErrors = null;

    public function __construct()
    {
        if (null === self::$displayErrors) {
            self::$displayErrors = ini_set('display_errors', 1);
        }
    }

    public function __destruct()
    {
        if (null !== self::$displayErrors) {
            ini_set('display_errors', self::$displayErrors);
            self::$displayErrors = null;
        }
=======
        return [
            new UndefinedFunctionFatalErrorHandler(),
            new UndefinedMethodFatalErrorHandler(),
            new ClassNotFoundFatalErrorHandler(),
        ];
    }

    /**
     * Cleans the trace by removing function arguments and the frames added by the error handler and DebugClassLoader.
     */
    private function cleanTrace(array $backtrace, int $type, string $file, int $line, bool $throw): array
    {
        $lightTrace = $backtrace;

        for ($i = 0; isset($backtrace[$i]); ++$i) {
            if (isset($backtrace[$i]['file'], $backtrace[$i]['line']) && $backtrace[$i]['line'] === $line && $backtrace[$i]['file'] === $file) {
                $lightTrace = \array_slice($lightTrace, 1 + $i);
                break;
            }
        }
        if (class_exists(DebugClassLoader::class, false)) {
            for ($i = \count($lightTrace) - 2; 0 < $i; --$i) {
                if (DebugClassLoader::class === ($lightTrace[$i]['class'] ?? null)) {
                    array_splice($lightTrace, --$i, 2);
                }
            }
        }
        if (!($throw || $this->scopedErrors & $type)) {
            for ($i = 0; isset($lightTrace[$i]); ++$i) {
                unset($lightTrace[$i]['args'], $lightTrace[$i]['object']);
            }
        }

        return $lightTrace;
>>>>>>> v2-test
    }
}
