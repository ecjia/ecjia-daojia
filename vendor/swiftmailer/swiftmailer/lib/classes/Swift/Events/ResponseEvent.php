<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generated when a response is received on a SMTP connection.
 *
 * @author Chris Corbyn
 */
class Swift_Events_ResponseEvent extends Swift_Events_EventObject
{
    /**
     * The overall result.
     *
     * @var bool
     */
<<<<<<< HEAD
    private $_valid;
=======
    private $valid;
>>>>>>> v2-test

    /**
     * The response received from the server.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_response;
=======
    private $response;
>>>>>>> v2-test

    /**
     * Create a new ResponseEvent for $source and $response.
     *
<<<<<<< HEAD
     * @param Swift_Transport $source
     * @param string          $response
     * @param bool            $valid
=======
     * @param string $response
     * @param bool   $valid
>>>>>>> v2-test
     */
    public function __construct(Swift_Transport $source, $response, $valid = false)
    {
        parent::__construct($source);
<<<<<<< HEAD
        $this->_response = $response;
        $this->_valid = $valid;
=======
        $this->response = $response;
        $this->valid = $valid;
>>>>>>> v2-test
    }

    /**
     * Get the response which was received from the server.
     *
     * @return string
     */
    public function getResponse()
    {
<<<<<<< HEAD
        return $this->_response;
=======
        return $this->response;
>>>>>>> v2-test
    }

    /**
     * Get the success status of this Event.
     *
     * @return bool
     */
    public function isValid()
    {
<<<<<<< HEAD
        return $this->_valid;
=======
        return $this->valid;
>>>>>>> v2-test
    }
}
