<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * StorageInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Drak <drak@zikula.org>
 */
interface SessionStorageInterface
{
    /**
     * Starts the session.
     *
     * @return bool True if started
     *
<<<<<<< HEAD
     * @throws \RuntimeException If something goes wrong starting the session.
=======
     * @throws \RuntimeException if something goes wrong starting the session
>>>>>>> v2-test
     */
    public function start();

    /**
     * Checks if the session is started.
     *
     * @return bool True if started, false otherwise
     */
    public function isStarted();

    /**
     * Returns the session ID.
     *
     * @return string The session ID or empty
     */
    public function getId();

    /**
     * Sets the session ID.
<<<<<<< HEAD
     *
     * @param string $id
     */
    public function setId($id);
=======
     */
    public function setId(string $id);
>>>>>>> v2-test

    /**
     * Returns the session name.
     *
<<<<<<< HEAD
     * @return mixed The session name
=======
     * @return string The session name
>>>>>>> v2-test
     */
    public function getName();

    /**
     * Sets the session name.
<<<<<<< HEAD
     *
     * @param string $name
     */
    public function setName($name);
=======
     */
    public function setName(string $name);
>>>>>>> v2-test

    /**
     * Regenerates id that represents this storage.
     *
     * This method must invoke session_regenerate_id($destroy) unless
     * this interface is used for a storage object designed for unit
     * or functional testing where a real PHP session would interfere
     * with testing.
     *
     * Note regenerate+destroy should not clear the session data in memory
     * only delete the session data from persistent storage.
     *
     * Care: When regenerating the session ID no locking is involved in PHP's
<<<<<<< HEAD
     * session design. See https://bugs.php.net/bug.php?id=61470 for a discussion.
=======
     * session design. See https://bugs.php.net/61470 for a discussion.
>>>>>>> v2-test
     * So you must make sure the regenerated session is saved BEFORE sending the
     * headers with the new ID. Symfony's HttpKernel offers a listener for this.
     * See Symfony\Component\HttpKernel\EventListener\SaveSessionListener.
     * Otherwise session data could get lost again for concurrent requests with the
     * new ID. One result could be that you get logged out after just logging in.
     *
     * @param bool $destroy  Destroy session when regenerating?
     * @param int  $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                       will leave the system settings unchanged, 0 sets the cookie
     *                       to expire with browser session. Time is in seconds, and is
     *                       not a Unix timestamp.
     *
     * @return bool True if session regenerated, false if error
     *
     * @throws \RuntimeException If an error occurs while regenerating this storage
     */
<<<<<<< HEAD
    public function regenerate($destroy = false, $lifetime = null);
=======
    public function regenerate(bool $destroy = false, int $lifetime = null);
>>>>>>> v2-test

    /**
     * Force the session to be saved and closed.
     *
     * This method must invoke session_write_close() unless this interface is
     * used for a storage object design for unit or functional testing where
     * a real PHP session would interfere with testing, in which case
     * it should actually persist the session data if required.
     *
<<<<<<< HEAD
     * @throws \RuntimeException If the session is saved without being started, or if the session
     *                           is already closed.
=======
     * @throws \RuntimeException if the session is saved without being started, or if the session
     *                           is already closed
>>>>>>> v2-test
     */
    public function save();

    /**
     * Clear all session data in memory.
     */
    public function clear();

    /**
     * Gets a SessionBagInterface by name.
     *
<<<<<<< HEAD
     * @param string $name
     *
=======
>>>>>>> v2-test
     * @return SessionBagInterface
     *
     * @throws \InvalidArgumentException If the bag does not exist
     */
<<<<<<< HEAD
    public function getBag($name);

    /**
     * Registers a SessionBagInterface for use.
     *
     * @param SessionBagInterface $bag
=======
    public function getBag(string $name);

    /**
     * Registers a SessionBagInterface for use.
>>>>>>> v2-test
     */
    public function registerBag(SessionBagInterface $bag);

    /**
     * @return MetadataBag
     */
    public function getMetadataBag();
}
