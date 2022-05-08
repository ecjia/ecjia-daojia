<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Contains a list of redundant Transports so when one fails, the next is used.
 *
 * @author Chris Corbyn
 */
class Swift_Transport_FailoverTransport extends Swift_Transport_LoadBalancedTransport
{
    /**
     * Registered transport currently used.
     *
     * @var Swift_Transport
     */
<<<<<<< HEAD
    private $_currentTransport;
=======
    private $currentTransport;
>>>>>>> v2-test

    // needed as __construct is called from elsewhere explicitly
    public function __construct()
    {
        parent::__construct();
    }

    /**
<<<<<<< HEAD
=======
     * {@inheritdoc}
     */
    public function ping()
    {
        $maxTransports = \count($this->transports);
        for ($i = 0; $i < $maxTransports
            && $transport = $this->getNextTransport(); ++$i) {
            if ($transport->ping()) {
                return true;
            } else {
                $this->killCurrentTransport();
            }
        }

        return \count($this->transports) > 0;
    }

    /**
>>>>>>> v2-test
     * Send the given Message.
     *
     * Recipient/sender data will be retrieved from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
<<<<<<< HEAD
     * @param Swift_Mime_Message $message
     * @param string[]           $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $maxTransports = count($this->_transports);
        $sent = 0;
        $this->_lastUsedTransport = null;

        for ($i = 0; $i < $maxTransports
            && $transport = $this->_getNextTransport(); ++$i) {
=======
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $maxTransports = \count($this->transports);
        $sent = 0;
        $this->lastUsedTransport = null;

        for ($i = 0; $i < $maxTransports
            && $transport = $this->getNextTransport(); ++$i) {
>>>>>>> v2-test
            try {
                if (!$transport->isStarted()) {
                    $transport->start();
                }

                if ($sent = $transport->send($message, $failedRecipients)) {
<<<<<<< HEAD
                    $this->_lastUsedTransport = $transport;
=======
                    $this->lastUsedTransport = $transport;
>>>>>>> v2-test

                    return $sent;
                }
            } catch (Swift_TransportException $e) {
<<<<<<< HEAD
                $this->_killCurrentTransport();
            }
        }

        if (count($this->_transports) == 0) {
            throw new Swift_TransportException(
                'All Transports in FailoverTransport failed, or no Transports available'
                );
=======
                $this->killCurrentTransport();
            }
        }

        if (0 == \count($this->transports)) {
            throw new Swift_TransportException('All Transports in FailoverTransport failed, or no Transports available');
>>>>>>> v2-test
        }

        return $sent;
    }

<<<<<<< HEAD
    protected function _getNextTransport()
    {
        if (!isset($this->_currentTransport)) {
            $this->_currentTransport = parent::_getNextTransport();
        }

        return $this->_currentTransport;
    }

    protected function _killCurrentTransport()
    {
        $this->_currentTransport = null;
        parent::_killCurrentTransport();
=======
    protected function getNextTransport()
    {
        if (!isset($this->currentTransport)) {
            $this->currentTransport = parent::getNextTransport();
        }

        return $this->currentTransport;
    }

    protected function killCurrentTransport()
    {
        $this->currentTransport = null;
        parent::killCurrentTransport();
>>>>>>> v2-test
    }
}
