<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Sends Messages over SMTP.
 *
 * @author Chris Corbyn
 */
abstract class Swift_Transport_AbstractSmtpTransport implements Swift_Transport
{
    /** Input-Output buffer for sending/receiving SMTP commands and responses */
<<<<<<< HEAD
    protected $_buffer;

    /** Connection status */
    protected $_started = false;

    /** The domain name to use in HELO command */
    protected $_domain = '[127.0.0.1]';

    /** The event dispatching layer */
    protected $_eventDispatcher;

    /** Source Ip */
    protected $_sourceIp;

    /** Return an array of params for the Buffer */
    abstract protected function _getBufferParams();
=======
    protected $buffer;

    /** Connection status */
    protected $started = false;

    /** The domain name to use in HELO command */
    protected $domain = '[127.0.0.1]';

    /** The event dispatching layer */
    protected $eventDispatcher;

    protected $addressEncoder;

    /** Whether the PIPELINING SMTP extension is enabled (RFC 2920) */
    protected $pipelining = null;

    /** The pipelined commands waiting for response */
    protected $pipeline = [];

    /** Source Ip */
    protected $sourceIp;

    /** Return an array of params for the Buffer */
    abstract protected function getBufferParams();
>>>>>>> v2-test

    /**
     * Creates a new EsmtpTransport using the given I/O buffer.
     *
<<<<<<< HEAD
     * @param Swift_Transport_IoBuffer     $buf
     * @param Swift_Events_EventDispatcher $dispatcher
     */
    public function __construct(Swift_Transport_IoBuffer $buf, Swift_Events_EventDispatcher $dispatcher)
    {
        $this->_eventDispatcher = $dispatcher;
        $this->_buffer = $buf;
        $this->_lookupHostname();
=======
     * @param string $localDomain
     */
    public function __construct(Swift_Transport_IoBuffer $buf, Swift_Events_EventDispatcher $dispatcher, $localDomain = '127.0.0.1', Swift_AddressEncoder $addressEncoder = null)
    {
        $this->buffer = $buf;
        $this->eventDispatcher = $dispatcher;
        $this->addressEncoder = $addressEncoder ?? new Swift_AddressEncoder_IdnAddressEncoder();
        $this->setLocalDomain($localDomain);
>>>>>>> v2-test
    }

    /**
     * Set the name of the local domain which Swift will identify itself as.
     *
     * This should be a fully-qualified domain name and should be truly the domain
     * you're using.
     *
<<<<<<< HEAD
     * If your server doesn't have a domain name, use the IP in square
     * brackets (i.e. [127.0.0.1]).
     *
     * @param string $domain
     *
     * @return Swift_Transport_AbstractSmtpTransport
     */
    public function setLocalDomain($domain)
    {
        $this->_domain = $domain;
=======
     * If your server does not have a domain name, use the IP address. This will
     * automatically be wrapped in square brackets as described in RFC 5321,
     * section 4.1.3.
     *
     * @param string $domain
     *
     * @return $this
     */
    public function setLocalDomain($domain)
    {
        if ('[' !== substr($domain, 0, 1)) {
            if (filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $domain = '['.$domain.']';
            } elseif (filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $domain = '[IPv6:'.$domain.']';
            }
        }

        $this->domain = $domain;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Get the name of the domain Swift will identify as.
     *
<<<<<<< HEAD
=======
     * If an IP address was specified, this will be returned wrapped in square
     * brackets as described in RFC 5321, section 4.1.3.
     *
>>>>>>> v2-test
     * @return string
     */
    public function getLocalDomain()
    {
<<<<<<< HEAD
        return $this->_domain;
=======
        return $this->domain;
>>>>>>> v2-test
    }

    /**
     * Sets the source IP.
     *
     * @param string $source
     */
    public function setSourceIp($source)
    {
<<<<<<< HEAD
        $this->_sourceIp = $source;
=======
        $this->sourceIp = $source;
>>>>>>> v2-test
    }

    /**
     * Returns the IP used to connect to the destination.
     *
     * @return string
     */
    public function getSourceIp()
    {
<<<<<<< HEAD
        return $this->_sourceIp;
=======
        return $this->sourceIp;
    }

    public function setAddressEncoder(Swift_AddressEncoder $addressEncoder)
    {
        $this->addressEncoder = $addressEncoder;
    }

    public function getAddressEncoder()
    {
        return $this->addressEncoder;
>>>>>>> v2-test
    }

    /**
     * Start the SMTP connection.
     */
    public function start()
    {
<<<<<<< HEAD
        if (!$this->_started) {
            if ($evt = $this->_eventDispatcher->createTransportChangeEvent($this)) {
                $this->_eventDispatcher->dispatchEvent($evt, 'beforeTransportStarted');
=======
        if (!$this->started) {
            if ($evt = $this->eventDispatcher->createTransportChangeEvent($this)) {
                $this->eventDispatcher->dispatchEvent($evt, 'beforeTransportStarted');
>>>>>>> v2-test
                if ($evt->bubbleCancelled()) {
                    return;
                }
            }

            try {
<<<<<<< HEAD
                $this->_buffer->initialize($this->_getBufferParams());
            } catch (Swift_TransportException $e) {
                $this->_throwException($e);
            }
            $this->_readGreeting();
            $this->_doHeloCommand();

            if ($evt) {
                $this->_eventDispatcher->dispatchEvent($evt, 'transportStarted');
            }

            $this->_started = true;
=======
                $this->buffer->initialize($this->getBufferParams());
            } catch (Swift_TransportException $e) {
                $this->throwException($e);
            }
            $this->readGreeting();
            $this->doHeloCommand();

            if ($evt) {
                $this->eventDispatcher->dispatchEvent($evt, 'transportStarted');
            }

            $this->started = true;
>>>>>>> v2-test
        }
    }

    /**
     * Test if an SMTP connection has been established.
     *
     * @return bool
     */
    public function isStarted()
    {
<<<<<<< HEAD
        return $this->_started;
=======
        return $this->started;
>>>>>>> v2-test
    }

    /**
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
        $sent = 0;
        $failedRecipients = (array) $failedRecipients;

        if ($evt = $this->_eventDispatcher->createSendEvent($this, $message)) {
            $this->_eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
=======
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        if (!$this->isStarted()) {
            $this->start();
        }

        $sent = 0;
        $failedRecipients = (array) $failedRecipients;

        if ($evt = $this->eventDispatcher->createSendEvent($this, $message)) {
            $this->eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
>>>>>>> v2-test
            if ($evt->bubbleCancelled()) {
                return 0;
            }
        }

<<<<<<< HEAD
        if (!$reversePath = $this->_getReversePath($message)) {
            $this->_throwException(new Swift_TransportException(
                'Cannot send message without a sender address'
                )
            );
=======
        if (!$reversePath = $this->getReversePath($message)) {
            $this->throwException(new Swift_TransportException('Cannot send message without a sender address'));
>>>>>>> v2-test
        }

        $to = (array) $message->getTo();
        $cc = (array) $message->getCc();
        $tos = array_merge($to, $cc);
        $bcc = (array) $message->getBcc();

<<<<<<< HEAD
        $message->setBcc(array());

        try {
            $sent += $this->_sendTo($message, $reversePath, $tos, $failedRecipients);
            $sent += $this->_sendBcc($message, $reversePath, $bcc, $failedRecipients);
        } catch (Exception $e) {
            $message->setBcc($bcc);
            throw $e;
        }

        $message->setBcc($bcc);

        if ($evt) {
            if ($sent == count($to) + count($cc) + count($bcc)) {
=======
        $message->setBcc([]);

        try {
            $sent += $this->sendTo($message, $reversePath, $tos, $failedRecipients);
            $sent += $this->sendBcc($message, $reversePath, $bcc, $failedRecipients);
        } finally {
            $message->setBcc($bcc);
        }

        if ($evt) {
            if ($sent == \count($to) + \count($cc) + \count($bcc)) {
>>>>>>> v2-test
                $evt->setResult(Swift_Events_SendEvent::RESULT_SUCCESS);
            } elseif ($sent > 0) {
                $evt->setResult(Swift_Events_SendEvent::RESULT_TENTATIVE);
            } else {
                $evt->setResult(Swift_Events_SendEvent::RESULT_FAILED);
            }
            $evt->setFailedRecipients($failedRecipients);
<<<<<<< HEAD
            $this->_eventDispatcher->dispatchEvent($evt, 'sendPerformed');
=======
            $this->eventDispatcher->dispatchEvent($evt, 'sendPerformed');
>>>>>>> v2-test
        }

        $message->generateId(); //Make sure a new Message ID is used

        return $sent;
    }

    /**
     * Stop the SMTP connection.
     */
    public function stop()
    {
<<<<<<< HEAD
        if ($this->_started) {
            if ($evt = $this->_eventDispatcher->createTransportChangeEvent($this)) {
                $this->_eventDispatcher->dispatchEvent($evt, 'beforeTransportStopped');
=======
        if ($this->started) {
            if ($evt = $this->eventDispatcher->createTransportChangeEvent($this)) {
                $this->eventDispatcher->dispatchEvent($evt, 'beforeTransportStopped');
>>>>>>> v2-test
                if ($evt->bubbleCancelled()) {
                    return;
                }
            }

            try {
<<<<<<< HEAD
                $this->executeCommand("QUIT\r\n", array(221));
=======
                $this->executeCommand("QUIT\r\n", [221]);
>>>>>>> v2-test
            } catch (Swift_TransportException $e) {
            }

            try {
<<<<<<< HEAD
                $this->_buffer->terminate();

                if ($evt) {
                    $this->_eventDispatcher->dispatchEvent($evt, 'transportStopped');
                }
            } catch (Swift_TransportException $e) {
                $this->_throwException($e);
            }
        }
        $this->_started = false;
=======
                $this->buffer->terminate();

                if ($evt) {
                    $this->eventDispatcher->dispatchEvent($evt, 'transportStopped');
                }
            } catch (Swift_TransportException $e) {
                $this->throwException($e);
            }
        }
        $this->started = false;
    }

    /**
     * {@inheritdoc}
     */
    public function ping()
    {
        try {
            if (!$this->isStarted()) {
                $this->start();
            }

            $this->executeCommand("NOOP\r\n", [250]);
        } catch (Swift_TransportException $e) {
            try {
                $this->stop();
            } catch (Swift_TransportException $e) {
            }

            return false;
        }

        return true;
>>>>>>> v2-test
    }

    /**
     * Register a plugin.
<<<<<<< HEAD
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->_eventDispatcher->bindEventListener($plugin);
=======
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->eventDispatcher->bindEventListener($plugin);
>>>>>>> v2-test
    }

    /**
     * Reset the current mail transaction.
     */
    public function reset()
    {
<<<<<<< HEAD
        $this->executeCommand("RSET\r\n", array(250));
=======
        $this->executeCommand("RSET\r\n", [250], $failures, true);
>>>>>>> v2-test
    }

    /**
     * Get the IoBuffer where read/writes are occurring.
     *
     * @return Swift_Transport_IoBuffer
     */
    public function getBuffer()
    {
<<<<<<< HEAD
        return $this->_buffer;
=======
        return $this->buffer;
>>>>>>> v2-test
    }

    /**
     * Run a command against the buffer, expecting the given response codes.
     *
     * If no response codes are given, the response will not be validated.
     * If codes are given, an exception will be thrown on an invalid response.
<<<<<<< HEAD
=======
     * If the command is RCPT TO, and the pipeline is non-empty, no exception
     * will be thrown; instead the failing address is added to $failures.
>>>>>>> v2-test
     *
     * @param string   $command
     * @param int[]    $codes
     * @param string[] $failures An array of failures by-reference
<<<<<<< HEAD
     *
     * @return string
     */
    public function executeCommand($command, $codes = array(), &$failures = null)
    {
        $failures = (array) $failures;
        $seq = $this->_buffer->write($command);
        $response = $this->_getFullResponse($seq);
        if ($evt = $this->_eventDispatcher->createCommandEvent($this, $command, $codes)) {
            $this->_eventDispatcher->dispatchEvent($evt, 'commandSent');
        }
        $this->_assertResponseCode($response, $codes);
=======
     * @param bool     $pipeline Do not wait for response
     * @param string   $address  the address, if command is RCPT TO
     *
     * @return string|null The server response, or null if pipelining is enabled
     */
    public function executeCommand($command, $codes = [], &$failures = null, $pipeline = false, $address = null)
    {
        $failures = (array) $failures;
        $seq = $this->buffer->write($command);
        if ($evt = $this->eventDispatcher->createCommandEvent($this, $command, $codes)) {
            $this->eventDispatcher->dispatchEvent($evt, 'commandSent');
        }

        $this->pipeline[] = [$command, $seq, $codes, $address];

        if ($pipeline && $this->pipelining) {
            return null;
        }

        $response = null;

        while ($this->pipeline) {
            list($command, $seq, $codes, $address) = array_shift($this->pipeline);
            $response = $this->getFullResponse($seq);
            try {
                $this->assertResponseCode($response, $codes);
            } catch (Swift_TransportException $e) {
                if ($this->pipeline && $address) {
                    $failures[] = $address;
                } else {
                    $this->throwException($e);
                }
            }
        }
>>>>>>> v2-test

        return $response;
    }

    /** Read the opening SMTP greeting */
<<<<<<< HEAD
    protected function _readGreeting()
    {
        $this->_assertResponseCode($this->_getFullResponse(0), array(220));
    }

    /** Send the HELO welcome */
    protected function _doHeloCommand()
    {
        $this->executeCommand(
            sprintf("HELO %s\r\n", $this->_domain), array(250)
=======
    protected function readGreeting()
    {
        $this->assertResponseCode($this->getFullResponse(0), [220]);
    }

    /** Send the HELO welcome */
    protected function doHeloCommand()
    {
        $this->executeCommand(
            sprintf("HELO %s\r\n", $this->domain), [250]
>>>>>>> v2-test
            );
    }

    /** Send the MAIL FROM command */
<<<<<<< HEAD
    protected function _doMailFromCommand($address)
    {
        $this->executeCommand(
            sprintf("MAIL FROM:<%s>\r\n", $address), array(250)
=======
    protected function doMailFromCommand($address)
    {
        $address = $this->addressEncoder->encodeString($address);
        $this->executeCommand(
            sprintf("MAIL FROM:<%s>\r\n", $address), [250], $failures, true
>>>>>>> v2-test
            );
    }

    /** Send the RCPT TO command */
<<<<<<< HEAD
    protected function _doRcptToCommand($address)
    {
        $this->executeCommand(
            sprintf("RCPT TO:<%s>\r\n", $address), array(250, 251, 252)
=======
    protected function doRcptToCommand($address)
    {
        $address = $this->addressEncoder->encodeString($address);
        $this->executeCommand(
            sprintf("RCPT TO:<%s>\r\n", $address), [250, 251, 252], $failures, true, $address
>>>>>>> v2-test
            );
    }

    /** Send the DATA command */
<<<<<<< HEAD
    protected function _doDataCommand()
    {
        $this->executeCommand("DATA\r\n", array(354));
    }

    /** Stream the contents of the message over the buffer */
    protected function _streamMessage(Swift_Mime_Message $message)
    {
        $this->_buffer->setWriteTranslations(array("\r\n." => "\r\n.."));
        try {
            $message->toByteStream($this->_buffer);
            $this->_buffer->flushBuffers();
        } catch (Swift_TransportException $e) {
            $this->_throwException($e);
        }
        $this->_buffer->setWriteTranslations(array());
        $this->executeCommand("\r\n.\r\n", array(250));
    }

    /** Determine the best-use reverse path for this message */
    protected function _getReversePath(Swift_Mime_Message $message)
=======
    protected function doDataCommand(&$failedRecipients)
    {
        $this->executeCommand("DATA\r\n", [354], $failedRecipients);
    }

    /** Stream the contents of the message over the buffer */
    protected function streamMessage(Swift_Mime_SimpleMessage $message)
    {
        $this->buffer->setWriteTranslations(["\r\n." => "\r\n.."]);
        try {
            $message->toByteStream($this->buffer);
            $this->buffer->flushBuffers();
        } catch (Swift_TransportException $e) {
            $this->throwException($e);
        }
        $this->buffer->setWriteTranslations([]);
        $this->executeCommand("\r\n.\r\n", [250]);
    }

    /** Determine the best-use reverse path for this message */
    protected function getReversePath(Swift_Mime_SimpleMessage $message)
>>>>>>> v2-test
    {
        $return = $message->getReturnPath();
        $sender = $message->getSender();
        $from = $message->getFrom();
        $path = null;
        if (!empty($return)) {
            $path = $return;
        } elseif (!empty($sender)) {
            // Don't use array_keys
            reset($sender); // Reset Pointer to first pos
            $path = key($sender); // Get key
        } elseif (!empty($from)) {
            reset($from); // Reset Pointer to first pos
            $path = key($from); // Get key
        }

        return $path;
    }

    /** Throw a TransportException, first sending it to any listeners */
<<<<<<< HEAD
    protected function _throwException(Swift_TransportException $e)
    {
        if ($evt = $this->_eventDispatcher->createTransportExceptionEvent($this, $e)) {
            $this->_eventDispatcher->dispatchEvent($evt, 'exceptionThrown');
=======
    protected function throwException(Swift_TransportException $e)
    {
        if ($evt = $this->eventDispatcher->createTransportExceptionEvent($this, $e)) {
            $this->eventDispatcher->dispatchEvent($evt, 'exceptionThrown');
>>>>>>> v2-test
            if (!$evt->bubbleCancelled()) {
                throw $e;
            }
        } else {
            throw $e;
        }
    }

    /** Throws an Exception if a response code is incorrect */
<<<<<<< HEAD
    protected function _assertResponseCode($response, $wanted)
    {
        list($code) = sscanf($response, '%3d');
        $valid = (empty($wanted) || in_array($code, $wanted));

        if ($evt = $this->_eventDispatcher->createResponseEvent($this, $response,
            $valid)) {
            $this->_eventDispatcher->dispatchEvent($evt, 'responseReceived');
        }

        if (!$valid) {
            $this->_throwException(
                new Swift_TransportException(
                    'Expected response code '.implode('/', $wanted).' but got code '.
                    '"'.$code.'", with message "'.$response.'"',
                    $code)
                );
=======
    protected function assertResponseCode($response, $wanted)
    {
        if (!$response) {
            $this->throwException(new Swift_TransportException('Expected response code '.implode('/', $wanted).' but got an empty response'));
        }

        list($code) = sscanf($response, '%3d');
        $valid = (empty($wanted) || \in_array($code, $wanted));

        if ($evt = $this->eventDispatcher->createResponseEvent($this, $response,
            $valid)) {
            $this->eventDispatcher->dispatchEvent($evt, 'responseReceived');
        }

        if (!$valid) {
            $this->throwException(new Swift_TransportException('Expected response code '.implode('/', $wanted).' but got code "'.$code.'", with message "'.$response.'"', $code));
>>>>>>> v2-test
        }
    }

    /** Get an entire multi-line response using its sequence number */
<<<<<<< HEAD
    protected function _getFullResponse($seq)
=======
    protected function getFullResponse($seq)
>>>>>>> v2-test
    {
        $response = '';
        try {
            do {
<<<<<<< HEAD
                $line = $this->_buffer->readLine($seq);
                $response .= $line;
            } while (null !== $line && false !== $line && ' ' != $line{3});
        } catch (Swift_TransportException $e) {
            $this->_throwException($e);
        } catch (Swift_IoException $e) {
            $this->_throwException(
                new Swift_TransportException(
                    $e->getMessage())
                );
=======
                $line = $this->buffer->readLine($seq);
                $response .= $line;
            } while (null !== $line && false !== $line && ' ' != $line[3]);
        } catch (Swift_TransportException $e) {
            $this->throwException($e);
        } catch (Swift_IoException $e) {
            $this->throwException(new Swift_TransportException($e->getMessage(), 0, $e));
>>>>>>> v2-test
        }

        return $response;
    }

    /** Send an email to the given recipients from the given reverse path */
<<<<<<< HEAD
    private function _doMailTransaction($message, $reversePath, array $recipients, array &$failedRecipients)
    {
        $sent = 0;
        $this->_doMailFromCommand($reversePath);
        foreach ($recipients as $forwardPath) {
            try {
                $this->_doRcptToCommand($forwardPath);
                ++$sent;
            } catch (Swift_TransportException $e) {
                $failedRecipients[] = $forwardPath;
            }
        }

        if ($sent != 0) {
            $this->_doDataCommand();
            $this->_streamMessage($message);
=======
    private function doMailTransaction($message, $reversePath, array $recipients, array &$failedRecipients)
    {
        $sent = 0;
        $this->doMailFromCommand($reversePath);
        foreach ($recipients as $forwardPath) {
            try {
                $this->doRcptToCommand($forwardPath);
                ++$sent;
            } catch (Swift_TransportException $e) {
                $failedRecipients[] = $forwardPath;
            } catch (Swift_AddressEncoderException $e) {
                $failedRecipients[] = $forwardPath;
            }
        }

        if (0 != $sent) {
            $sent += \count($failedRecipients);
            $this->doDataCommand($failedRecipients);
            $sent -= \count($failedRecipients);

            $this->streamMessage($message);
>>>>>>> v2-test
        } else {
            $this->reset();
        }

        return $sent;
    }

    /** Send a message to the given To: recipients */
<<<<<<< HEAD
    private function _sendTo(Swift_Mime_Message $message, $reversePath, array $to, array &$failedRecipients)
=======
    private function sendTo(Swift_Mime_SimpleMessage $message, $reversePath, array $to, array &$failedRecipients)
>>>>>>> v2-test
    {
        if (empty($to)) {
            return 0;
        }

<<<<<<< HEAD
        return $this->_doMailTransaction($message, $reversePath, array_keys($to),
=======
        return $this->doMailTransaction($message, $reversePath, array_keys($to),
>>>>>>> v2-test
            $failedRecipients);
    }

    /** Send a message to all Bcc: recipients */
<<<<<<< HEAD
    private function _sendBcc(Swift_Mime_Message $message, $reversePath, array $bcc, array &$failedRecipients)
    {
        $sent = 0;
        foreach ($bcc as $forwardPath => $name) {
            $message->setBcc(array($forwardPath => $name));
            $sent += $this->_doMailTransaction(
                $message, $reversePath, array($forwardPath), $failedRecipients
=======
    private function sendBcc(Swift_Mime_SimpleMessage $message, $reversePath, array $bcc, array &$failedRecipients)
    {
        $sent = 0;
        foreach ($bcc as $forwardPath => $name) {
            $message->setBcc([$forwardPath => $name]);
            $sent += $this->doMailTransaction(
                $message, $reversePath, [$forwardPath], $failedRecipients
>>>>>>> v2-test
                );
        }

        return $sent;
    }

<<<<<<< HEAD
    /** Try to determine the hostname of the server this is run on */
    private function _lookupHostname()
    {
        if (!empty($_SERVER['SERVER_NAME']) && $this->_isFqdn($_SERVER['SERVER_NAME'])) {
            $this->_domain = $_SERVER['SERVER_NAME'];
        } elseif (!empty($_SERVER['SERVER_ADDR'])) {
            // Set the address literal tag (See RFC 5321, section: 4.1.3)
            if (false === strpos($_SERVER['SERVER_ADDR'], ':')) {
                $prefix = ''; // IPv4 addresses are not tagged.
            } else {
                $prefix = 'IPv6:'; // Adding prefix in case of IPv6.
            }

            $this->_domain = sprintf('[%s%s]', $prefix, $_SERVER['SERVER_ADDR']);
        }
    }

    /** Determine is the $hostname is a fully-qualified name */
    private function _isFqdn($hostname)
    {
        // We could do a really thorough check, but there's really no point
        if (false !== $dotPos = strpos($hostname, '.')) {
            return ($dotPos > 0) && ($dotPos != strlen($hostname) - 1);
        }

        return false;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->stop();
=======
    /**
     * Destructor.
     */
    public function __destruct()
    {
        try {
            $this->stop();
        } catch (Exception $e) {
        }
    }

    public function __sleep()
    {
        throw new \BadMethodCallException('Cannot serialize '.__CLASS__);
    }

    public function __wakeup()
    {
        throw new \BadMethodCallException('Cannot unserialize '.__CLASS__);
>>>>>>> v2-test
    }
}
