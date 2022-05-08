<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Reduces network flooding when sending large amounts of mail.
 *
 * @author Chris Corbyn
 */
class Swift_Plugins_AntiFloodPlugin implements Swift_Events_SendListener, Swift_Plugins_Sleeper
{
    /**
     * The number of emails to send before restarting Transport.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_threshold;
=======
    private $threshold;
>>>>>>> v2-test

    /**
     * The number of seconds to sleep for during a restart.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_sleep;
=======
    private $sleep;
>>>>>>> v2-test

    /**
     * The internal counter.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_counter = 0;
=======
    private $counter = 0;
>>>>>>> v2-test

    /**
     * The Sleeper instance for sleeping.
     *
     * @var Swift_Plugins_Sleeper
     */
<<<<<<< HEAD
    private $_sleeper;
=======
    private $sleeper;
>>>>>>> v2-test

    /**
     * Create a new AntiFloodPlugin with $threshold and $sleep time.
     *
     * @param int                   $threshold
     * @param int                   $sleep     time
     * @param Swift_Plugins_Sleeper $sleeper   (not needed really)
     */
    public function __construct($threshold = 99, $sleep = 0, Swift_Plugins_Sleeper $sleeper = null)
    {
        $this->setThreshold($threshold);
        $this->setSleepTime($sleep);
<<<<<<< HEAD
        $this->_sleeper = $sleeper;
=======
        $this->sleeper = $sleeper;
>>>>>>> v2-test
    }

    /**
     * Set the number of emails to send before restarting.
     *
     * @param int $threshold
     */
    public function setThreshold($threshold)
    {
<<<<<<< HEAD
        $this->_threshold = $threshold;
=======
        $this->threshold = $threshold;
>>>>>>> v2-test
    }

    /**
     * Get the number of emails to send before restarting.
     *
     * @return int
     */
    public function getThreshold()
    {
<<<<<<< HEAD
        return $this->_threshold;
=======
        return $this->threshold;
>>>>>>> v2-test
    }

    /**
     * Set the number of seconds to sleep for during a restart.
     *
     * @param int $sleep time
     */
    public function setSleepTime($sleep)
    {
<<<<<<< HEAD
        $this->_sleep = $sleep;
=======
        $this->sleep = $sleep;
>>>>>>> v2-test
    }

    /**
     * Get the number of seconds to sleep for during a restart.
     *
     * @return int
     */
    public function getSleepTime()
    {
<<<<<<< HEAD
        return $this->_sleep;
=======
        return $this->sleep;
>>>>>>> v2-test
    }

    /**
     * Invoked immediately before the Message is sent.
<<<<<<< HEAD
     *
     * @param Swift_Events_SendEvent $evt
=======
>>>>>>> v2-test
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
    }

    /**
     * Invoked immediately after the Message is sent.
<<<<<<< HEAD
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        ++$this->_counter;
        if ($this->_counter >= $this->_threshold) {
            $transport = $evt->getTransport();
            $transport->stop();
            if ($this->_sleep) {
                $this->sleep($this->_sleep);
            }
            $transport->start();
            $this->_counter = 0;
=======
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        ++$this->counter;
        if ($this->counter >= $this->threshold) {
            $transport = $evt->getTransport();
            $transport->stop();
            if ($this->sleep) {
                $this->sleep($this->sleep);
            }
            $transport->start();
            $this->counter = 0;
>>>>>>> v2-test
        }
    }

    /**
     * Sleep for $seconds.
     *
     * @param int $seconds
     */
    public function sleep($seconds)
    {
<<<<<<< HEAD
        if (isset($this->_sleeper)) {
            $this->_sleeper->sleep($seconds);
=======
        if (isset($this->sleeper)) {
            $this->sleeper->sleep($seconds);
>>>>>>> v2-test
        } else {
            sleep($seconds);
        }
    }
}
