<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<< HEAD
namespace Symfony\Component\HttpKernel\Exception;

/**
 * Fatal Error Exception.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Konstanton Myakshin <koc-dp@yandex.ru>
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @deprecated Deprecated in 2.3, to be removed in 3.0. Use the same class from the Debug component instead.
 */
class FatalErrorException extends \ErrorException
{
}

namespace Symfony\Component\Debug\Exception;

use Symfony\Component\HttpKernel\Exception\FatalErrorException as LegacyFatalErrorException;
=======
namespace Symfony\Component\Debug\Exception;

@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4, use "%s" instead.', FatalErrorException::class, \Symfony\Component\ErrorHandler\Error\FatalError::class), \E_USER_DEPRECATED);
>>>>>>> v2-test

/**
 * Fatal Error Exception.
 *
 * @author Konstanton Myakshin <koc-dp@yandex.ru>
<<<<<<< HEAD
 */
class FatalErrorException extends LegacyFatalErrorException
{
    public function __construct($message, $code, $severity, $filename, $lineno, $traceOffset = null, $traceArgs = true, array $trace = null)
    {
        parent::__construct($message, $code, $severity, $filename, $lineno);
=======
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\Error\FatalError instead.
 */
class FatalErrorException extends \ErrorException
{
    public function __construct(string $message, int $code, int $severity, string $filename, int $lineno, int $traceOffset = null, bool $traceArgs = true, array $trace = null, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
>>>>>>> v2-test

        if (null !== $trace) {
            if (!$traceArgs) {
                foreach ($trace as &$frame) {
                    unset($frame['args'], $frame['this'], $frame);
                }
            }

            $this->setTrace($trace);
        } elseif (null !== $traceOffset) {
<<<<<<< HEAD
            if (function_exists('xdebug_get_function_stack')) {
=======
            if (\function_exists('xdebug_get_function_stack')) {
>>>>>>> v2-test
                $trace = xdebug_get_function_stack();
                if (0 < $traceOffset) {
                    array_splice($trace, -$traceOffset);
                }

                foreach ($trace as &$frame) {
                    if (!isset($frame['type'])) {
                        // XDebug pre 2.1.1 doesn't currently set the call type key http://bugs.xdebug.org/view.php?id=695
                        if (isset($frame['class'])) {
                            $frame['type'] = '::';
                        }
                    } elseif ('dynamic' === $frame['type']) {
                        $frame['type'] = '->';
                    } elseif ('static' === $frame['type']) {
                        $frame['type'] = '::';
                    }

                    // XDebug also has a different name for the parameters array
                    if (!$traceArgs) {
                        unset($frame['params'], $frame['args']);
                    } elseif (isset($frame['params']) && !isset($frame['args'])) {
                        $frame['args'] = $frame['params'];
                        unset($frame['params']);
                    }
                }

                unset($frame);
                $trace = array_reverse($trace);
<<<<<<< HEAD
            } elseif (function_exists('symfony_debug_backtrace')) {
                $trace = symfony_debug_backtrace();
                if (0 < $traceOffset) {
                    array_splice($trace, 0, $traceOffset);
                }
            } else {
                $trace = array();
=======
            } else {
                $trace = [];
>>>>>>> v2-test
            }

            $this->setTrace($trace);
        }
    }

    protected function setTrace($trace)
    {
<<<<<<< HEAD
        $traceReflector = new \ReflectionProperty('Exception', 'trace');
=======
        $traceReflector = new \ReflectionProperty(\Exception::class, 'trace');
>>>>>>> v2-test
        $traceReflector->setAccessible(true);
        $traceReflector->setValue($this, $trace);
    }
}
