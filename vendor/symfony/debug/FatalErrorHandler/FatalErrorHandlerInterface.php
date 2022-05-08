<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\FatalErrorHandler;

use Symfony\Component\Debug\Exception\FatalErrorException;

<<<<<<< HEAD
=======
@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4, use "%s" instead.', FatalErrorHandlerInterface::class, \Symfony\Component\ErrorHandler\FatalErrorHandler\FatalErrorHandlerInterface::class), \E_USER_DEPRECATED);

>>>>>>> v2-test
/**
 * Attempts to convert fatal errors to exceptions.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\FatalErrorHandler\FatalErrorHandlerInterface instead.
>>>>>>> v2-test
 */
interface FatalErrorHandlerInterface
{
    /**
     * Attempts to convert an error into an exception.
     *
<<<<<<< HEAD
     * @param array               $error     An array as returned by error_get_last()
     * @param FatalErrorException $exception A FatalErrorException instance
=======
     * @param array $error An array as returned by error_get_last()
>>>>>>> v2-test
     *
     * @return FatalErrorException|null A FatalErrorException instance if the class is able to convert the error, null otherwise
     */
    public function handleError(array $error, FatalErrorException $exception);
}
