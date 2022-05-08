<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\Exception;

<<<<<<< HEAD
=======
@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4, use "%s" instead.', UndefinedFunctionException::class, \Symfony\Component\ErrorHandler\Error\UndefinedFunctionError::class), \E_USER_DEPRECATED);

>>>>>>> v2-test
/**
 * Undefined Function Exception.
 *
 * @author Konstanton Myakshin <koc-dp@yandex.ru>
<<<<<<< HEAD
 */
class UndefinedFunctionException extends FatalErrorException
{
    public function __construct($message, \ErrorException $previous)
=======
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\Error\UndefinedFunctionError instead.
 */
class UndefinedFunctionException extends FatalErrorException
{
    public function __construct(string $message, \ErrorException $previous)
>>>>>>> v2-test
    {
        parent::__construct(
            $message,
            $previous->getCode(),
            $previous->getSeverity(),
            $previous->getFile(),
            $previous->getLine(),
<<<<<<< HEAD
=======
            null,
            true,
            null,
>>>>>>> v2-test
            $previous->getPrevious()
        );
        $this->setTrace($previous->getTrace());
    }
}
