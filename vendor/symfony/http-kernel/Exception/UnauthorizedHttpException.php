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
 * UnauthorizedHttpException.
 *
=======
>>>>>>> v2-test
 * @author Ben Ramsey <ben@benramsey.com>
 */
class UnauthorizedHttpException extends HttpException
{
    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string     $challenge WWW-Authenticate challenge string
     * @param string     $message   The internal exception message
     * @param \Exception $previous  The previous exception
     * @param int        $code      The internal exception code
     */
    public function __construct($challenge, $message = null, \Exception $previous = null, $code = 0)
    {
        $headers = array('WWW-Authenticate' => $challenge);
=======
     * @param string     $challenge WWW-Authenticate challenge string
     * @param string     $message   The internal exception message
     * @param \Throwable $previous  The previous exception
     * @param int        $code      The internal exception code
     */
    public function __construct(string $challenge, string $message = null, \Throwable $previous = null, ?int $code = 0, array $headers = [])
    {
        $headers['WWW-Authenticate'] = $challenge;
>>>>>>> v2-test

        parent::__construct(401, $message, $previous, $headers, $code);
    }
}
