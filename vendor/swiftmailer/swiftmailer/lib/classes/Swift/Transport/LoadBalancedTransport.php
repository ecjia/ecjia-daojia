<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Redundantly and rotationally uses several Transports when sending.
 *
 * @author Chris Corbyn
 */
class Swift_Transport_LoadBalancedTransport implements Swift_Transport
{
    /**
     * Transports which are deemed useless.
     *
     * @var Swift_Transport[]
     */
<<<<<<< HEAD
    private $_deadTransports = array();
=======
    private $deadTransports = [];
>>>>>>> v2-test

    /**
     * The Transports which are used in rotation.
     *
     * @var Swift_Transport[]
     */
<<<<<<< HEAD
    protected $_transports = array();
=======
    protected $transports = [];
>>>>>>> v2-test

    /**
     * The Transport used in the last successful send operation.
     *
     * @var Swift_Transport
     */
<<<<<<< HEAD
    protected $_lastUsedTransport = null;
=======
    protected $lastUsedTransport = null;
>>>>>>> v2-test

    // needed as __construct is called from elsewhere explicitly
    public function __construct()
    {
    }

    /**
     * Set $transports to delegate to.
     *
     * @param Swift_Transport[] $transports
     */
    public function setTransports(array $transports)
    {
<<<<<<< HEAD
        $this->_transports = $transports;
        $this->_deadTransports = array();
=======
        $this->transports = $transports;
        $this->deadTransports = [];
>>>>>>> v2-test
    }

    /**
     * Get $transports to delegate to.
     *
     * @return Swift_Transport[]
     */
    public function getTransports()
    {
<<<<<<< HEAD
        return array_merge($this->_transports, $this->_deadTransports);
=======
        return array_merge($this->transports, $this->deadTransports);
>>>>>>> v2-test
    }

    /**
     * Get the Transport used in the last successful send operation.
     *
     * @return Swift_Transport
     */
    public function getLastUsedTransport()
    {
<<<<<<< HEAD
        return $this->_lastUsedTransport;
=======
        return $this->lastUsedTransport;
>>>>>>> v2-test
    }

    /**
     * Test if this Transport mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
<<<<<<< HEAD
        return count($this->_transports) > 0;
=======
        return \count($this->transports) > 0;
>>>>>>> v2-test
    }

    /**
     * Start this Transport mechanism.
     */
    public function start()
    {
<<<<<<< HEAD
        $this->_transports = array_merge($this->_transports, $this->_deadTransports);
=======
        $this->transports = array_merge($this->transports, $this->deadTransports);
>>>>>>> v2-test
    }

    /**
     * Stop this Transport mechanism.
     */
    public function stop()
    {
<<<<<<< HEAD
        foreach ($this->_transports as $transport) {
=======
        foreach ($this->transports as $transport) {
>>>>>>> v2-test
            $transport->stop();
        }
    }

    /**
<<<<<<< HEAD
=======
     * {@inheritdoc}
     */
    public function ping()
    {
        foreach ($this->transports as $transport) {
            if (!$transport->ping()) {
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
                    break;
                }
            } catch (Swift_TransportException $e) {
                $this->_killCurrentTransport();
            }
        }

        if (count($this->_transports) == 0) {
            throw new Swift_TransportException(
                'All Transports in LoadBalancedTransport failed, or no Transports available'
                );
=======
                    $this->lastUsedTransport = $transport;
                    break;
                }
            } catch (Swift_TransportException $e) {
                $this->killCurrentTransport();
            }
        }

        if (0 == \count($this->transports)) {
            throw new Swift_TransportException('All Transports in LoadBalancedTransport failed, or no Transports available');
>>>>>>> v2-test
        }

        return $sent;
    }

    /**
     * Register a plugin.
<<<<<<< HEAD
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        foreach ($this->_transports as $transport) {
=======
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        foreach ($this->transports as $transport) {
>>>>>>> v2-test
            $transport->registerPlugin($plugin);
        }
    }

    /**
     * Rotates the transport list around and returns the first instance.
     *
     * @return Swift_Transport
     */
<<<<<<< HEAD
    protected function _getNextTransport()
    {
        if ($next = array_shift($this->_transports)) {
            $this->_transports[] = $next;
=======
    protected function getNextTransport()
    {
        if ($next = array_shift($this->transports)) {
            $this->transports[] = $next;
>>>>>>> v2-test
        }

        return $next;
    }

    /**
     * Tag the currently used (top of stack) transport as dead/useless.
     */
<<<<<<< HEAD
    protected function _killCurrentTransport()
    {
        if ($transport = array_pop($this->_transports)) {
=======
    protected function killCurrentTransport()
    {
        if ($transport = array_pop($this->transports)) {
>>>>>>> v2-test
            try {
                $transport->stop();
            } catch (Exception $e) {
            }
<<<<<<< HEAD
            $this->_deadTransports[] = $transport;
=======
            $this->deadTransports[] = $transport;
>>>>>>> v2-test
        }
    }
}
