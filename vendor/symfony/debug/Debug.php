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
=======
@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4, use "%s" instead.', Debug::class, \Symfony\Component\ErrorHandler\Debug::class), \E_USER_DEPRECATED);

>>>>>>> v2-test
/**
 * Registers all the debug tools.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\Debug instead.
>>>>>>> v2-test
 */
class Debug
{
    private static $enabled = false;

    /**
     * Enables the debug tools.
     *
     * This method registers an error handler and an exception handler.
     *
<<<<<<< HEAD
     * If the Symfony ClassLoader component is available, a special
     * class loader is also registered.
     *
     * @param int  $errorReportingLevel The level of error reporting you want
     * @param bool $displayErrors       Whether to display errors (for development) or just log them (for production)
     */
    public static function enable($errorReportingLevel = null, $displayErrors = true)
=======
     * @param int  $errorReportingLevel The level of error reporting you want
     * @param bool $displayErrors       Whether to display errors (for development) or just log them (for production)
     */
    public static function enable($errorReportingLevel = \E_ALL, $displayErrors = true)
>>>>>>> v2-test
    {
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        if (null !== $errorReportingLevel) {
            error_reporting($errorReportingLevel);
        } else {
<<<<<<< HEAD
            error_reporting(-1);
        }

        if ('cli' !== PHP_SAPI) {
            ini_set('display_errors', 0);
            ExceptionHandler::register();
        } elseif ($displayErrors && (!ini_get('log_errors') || ini_get('error_log'))) {
            // CLI - display errors only if they're not already logged to STDERR
            ini_set('display_errors', 1);
        }
        $handler = ErrorHandler::register();
        if (!$displayErrors) {
            $handler->throwAt(0, true);
=======
            error_reporting(\E_ALL);
        }

        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true)) {
            ini_set('display_errors', 0);
            ExceptionHandler::register();
        } elseif ($displayErrors && (!filter_var(ini_get('log_errors'), \FILTER_VALIDATE_BOOLEAN) || ini_get('error_log'))) {
            // CLI - display errors only if they're not already logged to STDERR
            ini_set('display_errors', 1);
        }
        if ($displayErrors) {
            ErrorHandler::register(new ErrorHandler(new BufferingLogger()));
        } else {
            ErrorHandler::register()->throwAt(0, true);
>>>>>>> v2-test
        }

        DebugClassLoader::enable();
    }
}
