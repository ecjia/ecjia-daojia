<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Does real time reporting of pass/fail for each recipient.
 *
 * @author Chris Corbyn
 */
class Swift_Plugins_ReporterPlugin implements Swift_Events_SendListener
{
    /**
     * The reporter backend which takes notifications.
     *
     * @var Swift_Plugins_Reporter
     */
<<<<<<< HEAD
    private $_reporter;

    /**
     * Create a new ReporterPlugin using $reporter.
     *
     * @param Swift_Plugins_Reporter $reporter
     */
    public function __construct(Swift_Plugins_Reporter $reporter)
    {
        $this->_reporter = $reporter;
=======
    private $reporter;

    /**
     * Create a new ReporterPlugin using $reporter.
     */
    public function __construct(Swift_Plugins_Reporter $reporter)
    {
        $this->reporter = $reporter;
>>>>>>> v2-test
    }

    /**
     * Not used.
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
    }

    /**
     * Invoked immediately after the Message is sent.
<<<<<<< HEAD
     *
     * @param Swift_Events_SendEvent $evt
=======
>>>>>>> v2-test
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        $message = $evt->getMessage();
        $failures = array_flip($evt->getFailedRecipients());
        foreach ((array) $message->getTo() as $address => $null) {
<<<<<<< HEAD
            $this->_reporter->notify($message, $address, array_key_exists($address, $failures) ? Swift_Plugins_Reporter::RESULT_FAIL : Swift_Plugins_Reporter::RESULT_PASS);
        }
        foreach ((array) $message->getCc() as $address => $null) {
            $this->_reporter->notify($message, $address, array_key_exists($address, $failures) ? Swift_Plugins_Reporter::RESULT_FAIL : Swift_Plugins_Reporter::RESULT_PASS);
        }
        foreach ((array) $message->getBcc() as $address => $null) {
            $this->_reporter->notify($message, $address, array_key_exists($address, $failures) ? Swift_Plugins_Reporter::RESULT_FAIL : Swift_Plugins_Reporter::RESULT_PASS);
=======
            $this->reporter->notify($message, $address, (\array_key_exists($address, $failures) ? Swift_Plugins_Reporter::RESULT_FAIL : Swift_Plugins_Reporter::RESULT_PASS));
        }
        foreach ((array) $message->getCc() as $address => $null) {
            $this->reporter->notify($message, $address, (\array_key_exists($address, $failures) ? Swift_Plugins_Reporter::RESULT_FAIL : Swift_Plugins_Reporter::RESULT_PASS));
        }
        foreach ((array) $message->getBcc() as $address => $null) {
            $this->reporter->notify($message, $address, (\array_key_exists($address, $failures) ? Swift_Plugins_Reporter::RESULT_FAIL : Swift_Plugins_Reporter::RESULT_PASS));
>>>>>>> v2-test
        }
    }
}
