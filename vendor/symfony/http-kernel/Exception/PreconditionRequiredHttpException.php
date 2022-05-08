<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Exception;

/**
<<<<<<< HEAD
 * PreconditionRequiredHttpException.
 *
=======
>>>>>>> v2-test
 * @author Ben Ramsey <ben@benramsey.com>
 *
 * @see http://tools.ietf.org/html/rfc6585
 */
class PreconditionRequiredHttpException extends HttpException
{
    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(428, $message, $previous, array(), $code);
=======
     * @param string     $message  The internal exception message
     * @param \Throwable $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct(string $message = null, \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(428, $message, $previous, $headers, $code);
>>>>>>> v2-test
    }
}
