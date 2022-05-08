<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generated when a message is being sent.
 *
 * @author Chris Corbyn
 */
class Swift_Events_SendEvent extends Swift_Events_EventObject
{
    /** Sending has yet to occur */
    const RESULT_PENDING = 0x0001;

    /** Email is spooled, ready to be sent */
    const RESULT_SPOOLED = 0x0011;

    /** Sending was successful */
    const RESULT_SUCCESS = 0x0010;

    /** Sending worked, but there were some failures */
    const RESULT_TENTATIVE = 0x0100;

    /** Sending failed */
    const RESULT_FAILED = 0x1000;

    /**
     * The Message being sent.
     *
<<<<<<< HEAD
     * @var Swift_Mime_Message
     */
    private $_message;
=======
     * @var Swift_Mime_SimpleMessage
     */
    private $message;
>>>>>>> v2-test

    /**
     * Any recipients which failed after sending.
     *
     * @var string[]
     */
<<<<<<< HEAD
    private $_failedRecipients = array();
=======
    private $failedRecipients = [];
>>>>>>> v2-test

    /**
     * The overall result as a bitmask from the class constants.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_result;

    /**
     * Create a new SendEvent for $source and $message.
     *
     * @param Swift_Transport    $source
     * @param Swift_Mime_Message $message
     */
    public function __construct(Swift_Transport $source, Swift_Mime_Message $message)
    {
        parent::__construct($source);
        $this->_message = $message;
        $this->_result = self::RESULT_PENDING;
=======
    private $result;

    /**
     * Create a new SendEvent for $source and $message.
     */
    public function __construct(Swift_Transport $source, Swift_Mime_SimpleMessage $message)
    {
        parent::__construct($source);
        $this->message = $message;
        $this->result = self::RESULT_PENDING;
>>>>>>> v2-test
    }

    /**
     * Get the Transport used to send the Message.
     *
     * @return Swift_Transport
     */
    public function getTransport()
    {
        return $this->getSource();
    }

    /**
     * Get the Message being sent.
     *
<<<<<<< HEAD
     * @return Swift_Mime_Message
     */
    public function getMessage()
    {
        return $this->_message;
=======
     * @return Swift_Mime_SimpleMessage
     */
    public function getMessage()
    {
        return $this->message;
>>>>>>> v2-test
    }

    /**
     * Set the array of addresses that failed in sending.
     *
     * @param array $recipients
     */
    public function setFailedRecipients($recipients)
    {
<<<<<<< HEAD
        $this->_failedRecipients = $recipients;
=======
        $this->failedRecipients = $recipients;
>>>>>>> v2-test
    }

    /**
     * Get an recipient addresses which were not accepted for delivery.
     *
     * @return string[]
     */
    public function getFailedRecipients()
    {
<<<<<<< HEAD
        return $this->_failedRecipients;
=======
        return $this->failedRecipients;
>>>>>>> v2-test
    }

    /**
     * Set the result of sending.
     *
     * @param int $result
     */
    public function setResult($result)
    {
<<<<<<< HEAD
        $this->_result = $result;
=======
        $this->result = $result;
>>>>>>> v2-test
    }

    /**
     * Get the result of this Event.
     *
     * The return value is a bitmask from
     * {@see RESULT_PENDING, RESULT_SUCCESS, RESULT_TENTATIVE, RESULT_FAILED}
     *
     * @return int
     */
    public function getResult()
    {
<<<<<<< HEAD
        return $this->_result;
=======
        return $this->result;
>>>>>>> v2-test
    }
}
