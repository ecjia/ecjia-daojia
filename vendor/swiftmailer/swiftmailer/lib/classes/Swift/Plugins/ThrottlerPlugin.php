<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Throttles the rate at which emails are sent.
 *
 * @author Chris Corbyn
 */
class Swift_Plugins_ThrottlerPlugin extends Swift_Plugins_BandwidthMonitorPlugin implements Swift_Plugins_Sleeper, Swift_Plugins_Timer
{
    /** Flag for throttling in bytes per minute */
    const BYTES_PER_MINUTE = 0x01;

    /** Flag for throttling in emails per second (Amazon SES) */
    const MESSAGES_PER_SECOND = 0x11;

    /** Flag for throttling in emails per minute */
    const MESSAGES_PER_MINUTE = 0x10;

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
     * The Timer instance which provides the timestamp.
     *
     * @var Swift_Plugins_Timer
     */
<<<<<<< HEAD
    private $_timer;
=======
    private $timer;
>>>>>>> v2-test

    /**
     * The time at which the first email was sent.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_start;
=======
    private $start;
>>>>>>> v2-test

    /**
     * The rate at which messages should be sent.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_rate;
=======
    private $rate;
>>>>>>> v2-test

    /**
     * The mode for throttling.
     *
     * This is {@link BYTES_PER_MINUTE} or {@link MESSAGES_PER_MINUTE}
     *
     * @var int
     */
<<<<<<< HEAD
    private $_mode;
=======
    private $mode;
>>>>>>> v2-test

    /**
     * An internal counter of the number of messages sent.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_messages = 0;
=======
    private $messages = 0;
>>>>>>> v2-test

    /**
     * Create a new ThrottlerPlugin.
     *
     * @param int                   $rate
<<<<<<< HEAD
     * @param int                   $mode,   defaults to {@link BYTES_PER_MINUTE}
=======
     * @param int                   $mode    defaults to {@link BYTES_PER_MINUTE}
>>>>>>> v2-test
     * @param Swift_Plugins_Sleeper $sleeper (only needed in testing)
     * @param Swift_Plugins_Timer   $timer   (only needed in testing)
     */
    public function __construct($rate, $mode = self::BYTES_PER_MINUTE, Swift_Plugins_Sleeper $sleeper = null, Swift_Plugins_Timer $timer = null)
    {
<<<<<<< HEAD
        $this->_rate = $rate;
        $this->_mode = $mode;
        $this->_sleeper = $sleeper;
        $this->_timer = $timer;
=======
        $this->rate = $rate;
        $this->mode = $mode;
        $this->sleeper = $sleeper;
        $this->timer = $timer;
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
        $time = $this->getTimestamp();
<<<<<<< HEAD
        if (!isset($this->_start)) {
            $this->_start = $time;
        }
        $duration = $time - $this->_start;

        switch ($this->_mode) {
            case self::BYTES_PER_MINUTE :
                $sleep = $this->_throttleBytesPerMinute($duration);
                break;
            case self::MESSAGES_PER_SECOND :
                $sleep = $this->_throttleMessagesPerSecond($duration);
                break;
            case self::MESSAGES_PER_MINUTE :
                $sleep = $this->_throttleMessagesPerMinute($duration);
                break;
            default :
=======
        if (!isset($this->start)) {
            $this->start = $time;
        }
        $duration = $time - $this->start;

        switch ($this->mode) {
            case self::BYTES_PER_MINUTE:
                $sleep = $this->throttleBytesPerMinute($duration);
                break;
            case self::MESSAGES_PER_SECOND:
                $sleep = $this->throttleMessagesPerSecond($duration);
                break;
            case self::MESSAGES_PER_MINUTE:
                $sleep = $this->throttleMessagesPerMinute($duration);
                break;
            default:
>>>>>>> v2-test
                $sleep = 0;
                break;
        }

        if ($sleep > 0) {
            $this->sleep($sleep);
        }
    }

    /**
     * Invoked when a Message is sent.
<<<<<<< HEAD
     *
     * @param Swift_Events_SendEvent $evt
=======
>>>>>>> v2-test
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        parent::sendPerformed($evt);
<<<<<<< HEAD
        ++$this->_messages;
=======
        ++$this->messages;
>>>>>>> v2-test
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

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    public function getTimestamp()
    {
<<<<<<< HEAD
        if (isset($this->_timer)) {
            return $this->_timer->getTimestamp();
=======
        if (isset($this->timer)) {
            return $this->timer->getTimestamp();
>>>>>>> v2-test
        }

        return time();
    }

    /**
     * Get a number of seconds to sleep for.
     *
     * @param int $timePassed
     *
     * @return int
     */
<<<<<<< HEAD
    private function _throttleBytesPerMinute($timePassed)
    {
        $expectedDuration = $this->getBytesOut() / ($this->_rate / 60);
=======
    private function throttleBytesPerMinute($timePassed)
    {
        $expectedDuration = $this->getBytesOut() / ($this->rate / 60);
>>>>>>> v2-test

        return (int) ceil($expectedDuration - $timePassed);
    }

    /**
     * Get a number of seconds to sleep for.
     *
     * @param int $timePassed
     *
     * @return int
     */
<<<<<<< HEAD
    private function _throttleMessagesPerSecond($timePassed)
    {
        $expectedDuration = $this->_messages / ($this->_rate);
=======
    private function throttleMessagesPerSecond($timePassed)
    {
        $expectedDuration = $this->messages / $this->rate;
>>>>>>> v2-test

        return (int) ceil($expectedDuration - $timePassed);
    }

    /**
     * Get a number of seconds to sleep for.
     *
     * @param int $timePassed
     *
     * @return int
     */
<<<<<<< HEAD
    private function _throttleMessagesPerMinute($timePassed)
    {
        $expectedDuration = $this->_messages / ($this->_rate / 60);
=======
    private function throttleMessagesPerMinute($timePassed)
    {
        $expectedDuration = $this->messages / ($this->rate / 60);
>>>>>>> v2-test

        return (int) ceil($expectedDuration - $timePassed);
    }
}
