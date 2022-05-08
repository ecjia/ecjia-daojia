<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Exception\Fracture;

/**
 * Class MethodInvocationException holds information about method invocation
 * exceptions
 */
abstract class MethodInvocationException extends FractureException
{
    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param string $message
     * @param mixed  $subject
     * @param string $method
     * @param array  $arguments
     */
<<<<<<< HEAD
    public function __construct($message, $subject, $method, array $arguments = array())
=======
    public function __construct(string $message, $subject, $method, array $arguments = array())
>>>>>>> v2-test
    {
        parent::__construct($message);

        $this->subject   = $subject;
        $this->method    = $method;
        $this->arguments = $arguments;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getMethodName()
=======
    public function getMethodName(): string
>>>>>>> v2-test
    {
        return $this->method;
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    public function getArguments()
=======
    public function getArguments(): array
>>>>>>> v2-test
    {
        return $this->arguments;
    }
}
