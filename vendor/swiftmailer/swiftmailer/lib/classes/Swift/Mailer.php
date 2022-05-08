<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Swift Mailer class.
 *
 * @author Chris Corbyn
 */
class Swift_Mailer
{
    /** The Transport used to send messages */
<<<<<<< HEAD
    private $_transport;

    /**
     * Create a new Mailer using $transport for delivery.
     *
     * @param Swift_Transport $transport
     */
    public function __construct(Swift_Transport $transport)
    {
        $this->_transport = $transport;
    }

    /**
     * Create a new Mailer instance.
     *
     * @param Swift_Transport $transport
     *
     * @return Swift_Mailer
     */
    public static function newInstance(Swift_Transport $transport)
    {
        return new self($transport);
=======
    private $transport;

    /**
     * Create a new Mailer using $transport for delivery.
     */
    public function __construct(Swift_Transport $transport)
    {
        $this->transport = $transport;
>>>>>>> v2-test
    }

    /**
     * Create a new class instance of one of the message services.
     *
     * For example 'mimepart' would create a 'message.mimepart' instance
     *
     * @param string $service
     *
     * @return object
     */
    public function createMessage($service = 'message')
    {
        return Swift_DependencyContainer::getInstance()
            ->lookup('message.'.$service);
    }

    /**
     * Send the given Message like it would be sent in a mail client.
     *
     * All recipients (with the exception of Bcc) will be able to see the other
     * recipients this message was sent to.
     *
     * Recipient/sender data will be retrieved from the Message object.
     *
     * The return value is the number of recipients who were accepted for
     * delivery.
     *
<<<<<<< HEAD
     * @param Swift_Mime_Message $message
     * @param array              $failedRecipients An array of failures by-reference
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $failedRecipients = (array) $failedRecipients;

        if (!$this->_transport->isStarted()) {
            $this->_transport->start();
=======
     * @param array $failedRecipients An array of failures by-reference
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $failedRecipients = (array) $failedRecipients;

        // FIXME: to be removed in 7.0 (as transport must now start itself on send)
        if (!$this->transport->isStarted()) {
            $this->transport->start();
>>>>>>> v2-test
        }

        $sent = 0;

        try {
<<<<<<< HEAD
            $sent = $this->_transport->send($message, $failedRecipients);
=======
            $sent = $this->transport->send($message, $failedRecipients);
>>>>>>> v2-test
        } catch (Swift_RfcComplianceException $e) {
            foreach ($message->getTo() as $address => $name) {
                $failedRecipients[] = $address;
            }
        }

        return $sent;
    }

    /**
     * Register a plugin using a known unique key (e.g. myPlugin).
<<<<<<< HEAD
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->_transport->registerPlugin($plugin);
=======
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->transport->registerPlugin($plugin);
>>>>>>> v2-test
    }

    /**
     * The Transport used to send messages.
     *
     * @return Swift_Transport
     */
    public function getTransport()
    {
<<<<<<< HEAD
        return $this->_transport;
=======
        return $this->transport;
>>>>>>> v2-test
    }
}
