<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Redirects all email to a single recipient.
 *
<<<<<<< HEAD
 * @author Fabien Potencier
=======
 * @author     Fabien Potencier
>>>>>>> v2-test
 */
class Swift_Plugins_RedirectingPlugin implements Swift_Events_SendListener
{
    /**
     * The recipient who will receive all messages.
     *
     * @var mixed
     */
<<<<<<< HEAD
    private $_recipient;
=======
    private $recipient;
>>>>>>> v2-test

    /**
     * List of regular expression for recipient whitelisting.
     *
     * @var array
     */
<<<<<<< HEAD
    private $_whitelist = array();
=======
    private $whitelist = [];
>>>>>>> v2-test

    /**
     * Create a new RedirectingPlugin.
     *
     * @param mixed $recipient
<<<<<<< HEAD
     * @param array $whitelist
     */
    public function __construct($recipient, array $whitelist = array())
    {
        $this->_recipient = $recipient;
        $this->_whitelist = $whitelist;
=======
     */
    public function __construct($recipient, array $whitelist = [])
    {
        $this->recipient = $recipient;
        $this->whitelist = $whitelist;
>>>>>>> v2-test
    }

    /**
     * Set the recipient of all messages.
     *
     * @param mixed $recipient
     */
    public function setRecipient($recipient)
    {
<<<<<<< HEAD
        $this->_recipient = $recipient;
=======
        $this->recipient = $recipient;
>>>>>>> v2-test
    }

    /**
     * Get the recipient of all messages.
     *
     * @return mixed
     */
    public function getRecipient()
    {
<<<<<<< HEAD
        return $this->_recipient;
=======
        return $this->recipient;
>>>>>>> v2-test
    }

    /**
     * Set a list of regular expressions to whitelist certain recipients.
<<<<<<< HEAD
     *
     * @param array $whitelist
     */
    public function setWhitelist(array $whitelist)
    {
        $this->_whitelist = $whitelist;
=======
     */
    public function setWhitelist(array $whitelist)
    {
        $this->whitelist = $whitelist;
>>>>>>> v2-test
    }

    /**
     * Get the whitelist.
     *
     * @return array
     */
    public function getWhitelist()
    {
<<<<<<< HEAD
        return $this->_whitelist;
=======
        return $this->whitelist;
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
        $message = $evt->getMessage();
        $headers = $message->getHeaders();

        // conditionally save current recipients

        if ($headers->has('to')) {
            $headers->addMailboxHeader('X-Swift-To', $message->getTo());
        }

        if ($headers->has('cc')) {
            $headers->addMailboxHeader('X-Swift-Cc', $message->getCc());
        }

        if ($headers->has('bcc')) {
            $headers->addMailboxHeader('X-Swift-Bcc', $message->getBcc());
        }

        // Filter remaining headers against whitelist
<<<<<<< HEAD
        $this->_filterHeaderSet($headers, 'To');
        $this->_filterHeaderSet($headers, 'Cc');
        $this->_filterHeaderSet($headers, 'Bcc');
=======
        $this->filterHeaderSet($headers, 'To');
        $this->filterHeaderSet($headers, 'Cc');
        $this->filterHeaderSet($headers, 'Bcc');
>>>>>>> v2-test

        // Add each hard coded recipient
        $to = $message->getTo();
        if (null === $to) {
<<<<<<< HEAD
            $to = array();
        }

        foreach ((array) $this->_recipient as $recipient) {
            if (!array_key_exists($recipient, $to)) {
=======
            $to = [];
        }

        foreach ((array) $this->recipient as $recipient) {
            if (!\array_key_exists($recipient, $to)) {
>>>>>>> v2-test
                $message->addTo($recipient);
            }
        }
    }

    /**
     * Filter header set against a whitelist of regular expressions.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderSet $headerSet
     * @param string               $type
     */
    private function _filterHeaderSet(Swift_Mime_HeaderSet $headerSet, $type)
    {
        foreach ($headerSet->getAll($type) as $headers) {
            $headers->setNameAddresses($this->_filterNameAddresses($headers->getNameAddresses()));
=======
     * @param string $type
     */
    private function filterHeaderSet(Swift_Mime_SimpleHeaderSet $headerSet, $type)
    {
        foreach ($headerSet->getAll($type) as $headers) {
            $headers->setNameAddresses($this->filterNameAddresses($headers->getNameAddresses()));
>>>>>>> v2-test
        }
    }

    /**
     * Filtered list of addresses => name pairs.
     *
<<<<<<< HEAD
     * @param array $recipients
     *
     * @return array
     */
    private function _filterNameAddresses(array $recipients)
    {
        $filtered = array();

        foreach ($recipients as $address => $name) {
            if ($this->_isWhitelisted($address)) {
=======
     * @return array
     */
    private function filterNameAddresses(array $recipients)
    {
        $filtered = [];

        foreach ($recipients as $address => $name) {
            if ($this->isWhitelisted($address)) {
>>>>>>> v2-test
                $filtered[$address] = $name;
            }
        }

        return $filtered;
    }

    /**
     * Matches address against whitelist of regular expressions.
     *
<<<<<<< HEAD
     * @param $recipient
     *
     * @return bool
     */
    protected function _isWhitelisted($recipient)
    {
        if (in_array($recipient, (array) $this->_recipient)) {
            return true;
        }

        foreach ($this->_whitelist as $pattern) {
=======
     * @return bool
     */
    protected function isWhitelisted($recipient)
    {
        if (\in_array($recipient, (array) $this->recipient)) {
            return true;
        }

        foreach ($this->whitelist as $pattern) {
>>>>>>> v2-test
            if (preg_match($pattern, $recipient)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Invoked immediately after the Message is sent.
<<<<<<< HEAD
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        $this->_restoreMessage($evt->getMessage());
    }

    private function _restoreMessage(Swift_Mime_Message $message)
=======
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        $this->restoreMessage($evt->getMessage());
    }

    private function restoreMessage(Swift_Mime_SimpleMessage $message)
>>>>>>> v2-test
    {
        // restore original headers
        $headers = $message->getHeaders();

        if ($headers->has('X-Swift-To')) {
            $message->setTo($headers->get('X-Swift-To')->getNameAddresses());
            $headers->removeAll('X-Swift-To');
        } else {
            $message->setTo(null);
        }

        if ($headers->has('X-Swift-Cc')) {
            $message->setCc($headers->get('X-Swift-Cc')->getNameAddresses());
            $headers->removeAll('X-Swift-Cc');
        }

        if ($headers->has('X-Swift-Bcc')) {
            $message->setBcc($headers->get('X-Swift-Bcc')->getNameAddresses());
            $headers->removeAll('X-Swift-Bcc');
        }
    }
}
