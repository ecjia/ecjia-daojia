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
@trigger_error(sprintf('The "%s" class is deprecated since Symfony 4.4.', FatalThrowableError::class), \E_USER_DEPRECATED);

>>>>>>> v2-test
/**
 * Fatal Throwable Error.
 *
 * @author Nicolas Grekas <p@tchwork.com>
<<<<<<< HEAD
 */
class FatalThrowableError extends FatalErrorException
{
    public function __construct(\Throwable $e)
    {
        if ($e instanceof \ParseError) {
            $message = 'Parse error: '.$e->getMessage();
            $severity = E_PARSE;
        } elseif ($e instanceof \TypeError) {
            $message = 'Type error: '.$e->getMessage();
            $severity = E_RECOVERABLE_ERROR;
        } else {
            $message = $e->getMessage();
            $severity = E_ERROR;
        }

        \ErrorException::__construct(
            $message,
            $e->getCode(),
            $severity,
            $e->getFile(),
            $e->getLine()
=======
 *
 * @deprecated since Symfony 4.4
 */
class FatalThrowableError extends FatalErrorException
{
    private $originalClassName;

    public function __construct(\Throwable $e)
    {
        $this->originalClassName = get_debug_type($e);

        if ($e instanceof \ParseError) {
            $severity = \E_PARSE;
        } elseif ($e instanceof \TypeError) {
            $severity = \E_RECOVERABLE_ERROR;
        } else {
            $severity = \E_ERROR;
        }

        \ErrorException::__construct(
            $e->getMessage(),
            $e->getCode(),
            $severity,
            $e->getFile(),
            $e->getLine(),
            $e->getPrevious()
>>>>>>> v2-test
        );

        $this->setTrace($e->getTrace());
    }
<<<<<<< HEAD
=======

    public function getOriginalClassName(): string
    {
        return $this->originalClassName;
    }
>>>>>>> v2-test
}
