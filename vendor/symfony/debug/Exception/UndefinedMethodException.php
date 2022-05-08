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
@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4, use "%s" instead.', UndefinedMethodException::class, \Symfony\Component\ErrorHandler\Error\UndefinedMethodError::class), \E_USER_DEPRECATED);

>>>>>>> v2-test
/**
 * Undefined Method Exception.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
<<<<<<< HEAD
 */
class UndefinedMethodException extends FatalErrorException
{
    public function __construct($message, \ErrorException $previous)
=======
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\Error\UndefinedMethodError instead.
 */
class UndefinedMethodException extends FatalErrorException
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
