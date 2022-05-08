<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generated when a TransportException is thrown from the Transport system.
 *
 * @author Chris Corbyn
 */
class Swift_Events_TransportExceptionEvent extends Swift_Events_EventObject
{
    /**
     * The Exception thrown.
     *
     * @var Swift_TransportException
     */
<<<<<<< HEAD
    private $_exception;

    /**
     * Create a new TransportExceptionEvent for $transport.
     *
     * @param Swift_Transport          $transport
     * @param Swift_TransportException $ex
=======
    private $exception;

    /**
     * Create a new TransportExceptionEvent for $transport.
>>>>>>> v2-test
     */
    public function __construct(Swift_Transport $transport, Swift_TransportException $ex)
    {
        parent::__construct($transport);
<<<<<<< HEAD
        $this->_exception = $ex;
=======
        $this->exception = $ex;
>>>>>>> v2-test
    }

    /**
     * Get the TransportException thrown.
     *
     * @return Swift_TransportException
     */
    public function getException()
    {
<<<<<<< HEAD
        return $this->_exception;
=======
        return $this->exception;
>>>>>>> v2-test
    }
}
