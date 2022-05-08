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
 * ServiceUnavailableHttpException.
 *
=======
>>>>>>> v2-test
 * @author Ben Ramsey <ben@benramsey.com>
 */
class ServiceUnavailableHttpException extends HttpException
{
    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param int|string $retryAfter The number of seconds or HTTP-date after which the request may be retried
     * @param string     $message    The internal exception message
     * @param \Exception $previous   The previous exception
     * @param int        $code       The internal exception code
     */
    public function __construct($retryAfter = null, $message = null, \Exception $previous = null, $code = 0)
    {
        $headers = array();
        if ($retryAfter) {
            $headers = array('Retry-After' => $retryAfter);
=======
     * @param int|string $retryAfter The number of seconds or HTTP-date after which the request may be retried
     * @param string     $message    The internal exception message
     * @param \Throwable $previous   The previous exception
     * @param int        $code       The internal exception code
     */
    public function __construct($retryAfter = null, string $message = null, \Throwable $previous = null, ?int $code = 0, array $headers = [])
    {
        if ($retryAfter) {
            $headers['Retry-After'] = $retryAfter;
>>>>>>> v2-test
        }

        parent::__construct(503, $message, $previous, $headers, $code);
    }
}
