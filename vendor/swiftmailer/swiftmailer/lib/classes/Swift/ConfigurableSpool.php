<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2009 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class for Spools (implements time and message limits).
 *
 * @author Fabien Potencier
 */
abstract class Swift_ConfigurableSpool implements Swift_Spool
{
    /** The maximum number of messages to send per flush */
<<<<<<< HEAD
    private $_message_limit;

    /** The time limit per flush */
    private $_time_limit;
=======
    private $message_limit;

    /** The time limit per flush */
    private $time_limit;
>>>>>>> v2-test

    /**
     * Sets the maximum number of messages to send per flush.
     *
     * @param int $limit
     */
    public function setMessageLimit($limit)
    {
<<<<<<< HEAD
        $this->_message_limit = (int) $limit;
=======
        $this->message_limit = (int) $limit;
>>>>>>> v2-test
    }

    /**
     * Gets the maximum number of messages to send per flush.
     *
     * @return int The limit
     */
    public function getMessageLimit()
    {
<<<<<<< HEAD
        return $this->_message_limit;
=======
        return $this->message_limit;
>>>>>>> v2-test
    }

    /**
     * Sets the time limit (in seconds) per flush.
     *
     * @param int $limit The limit
     */
    public function setTimeLimit($limit)
    {
<<<<<<< HEAD
        $this->_time_limit = (int) $limit;
=======
        $this->time_limit = (int) $limit;
>>>>>>> v2-test
    }

    /**
     * Gets the time limit (in seconds) per flush.
     *
     * @return int The limit
     */
    public function getTimeLimit()
    {
<<<<<<< HEAD
        return $this->_time_limit;
=======
        return $this->time_limit;
>>>>>>> v2-test
    }
}
