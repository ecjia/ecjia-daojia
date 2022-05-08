<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

<<<<<<< HEAD
use Symfony\Component\Debug\Exception\FlattenException;
=======
use Symfony\Component\ErrorHandler\Exception\FlattenException;
>>>>>>> v2-test
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ExceptionDataCollector.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> v2-test
 */
class ExceptionDataCollector extends DataCollector
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (null !== $exception) {
            $this->data = array(
                'exception' => FlattenException::create($exception),
            );
=======
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        if (null !== $exception) {
            $this->data = [
                'exception' => FlattenException::createFromThrowable($exception),
            ];
>>>>>>> v2-test
        }
    }

    /**
<<<<<<< HEAD
=======
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->data = [];
    }

    /**
>>>>>>> v2-test
     * Checks if the exception is not null.
     *
     * @return bool true if the exception is not null, false otherwise
     */
    public function hasException()
    {
        return isset($this->data['exception']);
    }

    /**
     * Gets the exception.
     *
<<<<<<< HEAD
     * @return \Exception The exception
=======
     * @return \Exception|FlattenException
>>>>>>> v2-test
     */
    public function getException()
    {
        return $this->data['exception'];
    }

    /**
     * Gets the exception message.
     *
     * @return string The exception message
     */
    public function getMessage()
    {
        return $this->data['exception']->getMessage();
    }

    /**
     * Gets the exception code.
     *
     * @return int The exception code
     */
    public function getCode()
    {
        return $this->data['exception']->getCode();
    }

    /**
     * Gets the status code.
     *
     * @return int The status code
     */
    public function getStatusCode()
    {
        return $this->data['exception']->getStatusCode();
    }

    /**
     * Gets the exception trace.
     *
     * @return array The exception trace
     */
    public function getTrace()
    {
        return $this->data['exception']->getTrace();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'exception';
    }
}
