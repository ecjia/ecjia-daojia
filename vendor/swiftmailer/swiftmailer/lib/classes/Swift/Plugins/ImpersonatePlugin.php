<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Replaces the sender of a message.
 *
 * @author Arjen Brouwer
 */
class Swift_Plugins_ImpersonatePlugin implements Swift_Events_SendListener
{
    /**
     * The sender to impersonate.
     *
<<<<<<< HEAD
     * @var String
     */
    private $_sender;
=======
     * @var string
     */
    private $sender;
>>>>>>> v2-test

    /**
     * Create a new ImpersonatePlugin to impersonate $sender.
     *
     * @param string $sender address
     */
    public function __construct($sender)
    {
<<<<<<< HEAD
        $this->_sender = $sender;
=======
        $this->sender = $sender;
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

        // save current recipients
        $headers->addPathHeader('X-Swift-Return-Path', $message->getReturnPath());

        // replace them with the one to send to
<<<<<<< HEAD
        $message->setReturnPath($this->_sender);
=======
        $message->setReturnPath($this->sender);
>>>>>>> v2-test
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

        // restore original headers
        $headers = $message->getHeaders();

        if ($headers->has('X-Swift-Return-Path')) {
            $message->setReturnPath($headers->get('X-Swift-Return-Path')->getAddress());
            $headers->removeAll('X-Swift-Return-Path');
        }
    }
}
