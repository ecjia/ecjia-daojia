<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Listens for changes within the Transport system.
 *
 * @author Chris Corbyn
 */
interface Swift_Events_TransportChangeListener extends Swift_Events_EventListener
{
    /**
     * Invoked just before a Transport is started.
<<<<<<< HEAD
     *
     * @param Swift_Events_TransportChangeEvent $evt
=======
>>>>>>> v2-test
     */
    public function beforeTransportStarted(Swift_Events_TransportChangeEvent $evt);

    /**
     * Invoked immediately after the Transport is started.
<<<<<<< HEAD
     *
     * @param Swift_Events_TransportChangeEvent $evt
=======
>>>>>>> v2-test
     */
    public function transportStarted(Swift_Events_TransportChangeEvent $evt);

    /**
     * Invoked just before a Transport is stopped.
<<<<<<< HEAD
     *
     * @param Swift_Events_TransportChangeEvent $evt
=======
>>>>>>> v2-test
     */
    public function beforeTransportStopped(Swift_Events_TransportChangeEvent $evt);

    /**
     * Invoked immediately after the Transport is stopped.
<<<<<<< HEAD
     *
     * @param Swift_Events_TransportChangeEvent $evt
=======
>>>>>>> v2-test
     */
    public function transportStopped(Swift_Events_TransportChangeEvent $evt);
}
