<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session;

use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;

/**
 * Interface for the session.
 *
 * @author Drak <drak@zikula.org>
 */
interface SessionInterface
{
    /**
     * Starts the session storage.
     *
<<<<<<< HEAD
     * @return bool True if session started
     *
     * @throws \RuntimeException If session fails to start.
=======
     * @return bool
     *
     * @throws \RuntimeException if session fails to start
>>>>>>> v2-test
     */
    public function start();

    /**
     * Returns the session ID.
     *
<<<<<<< HEAD
     * @return string The session ID
=======
     * @return string
>>>>>>> v2-test
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
     * @return string
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
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     *
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                      will leave the system settings unchanged, 0 sets the cookie
     *                      to expire with browser session. Time is in seconds, and is
     *                      not a Unix timestamp.
     *
<<<<<<< HEAD
     * @return bool True if session invalidated, false if error
     */
    public function invalidate($lifetime = null);
=======
     * @return bool
     */
    public function invalidate(int $lifetime = null);
>>>>>>> v2-test

    /**
     * Migrates the current session to a new session id while maintaining all
     * session attributes.
     *
     * @param bool $destroy  Whether to delete the old session or leave it to garbage collection
     * @param int  $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                       will leave the system settings unchanged, 0 sets the cookie
     *                       to expire with browser session. Time is in seconds, and is
     *                       not a Unix timestamp.
     *
<<<<<<< HEAD
     * @return bool True if session migrated, false if error
     */
    public function migrate($destroy = false, $lifetime = null);
=======
     * @return bool
     */
    public function migrate(bool $destroy = false, int $lifetime = null);
>>>>>>> v2-test

    /**
     * Force the session to be saved and closed.
     *
     * This method is generally not required for real sessions as
     * the session will be automatically saved at the end of
     * code execution.
     */
    public function save();

    /**
     * Checks if an attribute is defined.
     *
<<<<<<< HEAD
     * @param string $name The attribute name
     *
     * @return bool true if the attribute is defined, false otherwise
     */
    public function has($name);
=======
     * @return bool
     */
    public function has(string $name);
>>>>>>> v2-test

    /**
     * Returns an attribute.
     *
<<<<<<< HEAD
     * @param string $name    The attribute name
     * @param mixed  $default The default value if not found
     *
     * @return mixed
     */
    public function get($name, $default = null);
=======
     * @param mixed $default The default value if not found
     *
     * @return mixed
     */
    public function get(string $name, $default = null);
>>>>>>> v2-test

    /**
     * Sets an attribute.
     *
<<<<<<< HEAD
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value);
=======
     * @param mixed $value
     */
    public function set(string $name, $value);
>>>>>>> v2-test

    /**
     * Returns attributes.
     *
<<<<<<< HEAD
     * @return array Attributes
=======
     * @return array
>>>>>>> v2-test
     */
    public function all();

    /**
     * Sets attributes.
<<<<<<< HEAD
     *
     * @param array $attributes Attributes
=======
>>>>>>> v2-test
     */
    public function replace(array $attributes);

    /**
     * Removes an attribute.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return mixed The removed value or null when it does not exist
     */
    public function remove($name);
=======
     * @return mixed The removed value or null when it does not exist
     */
    public function remove(string $name);
>>>>>>> v2-test

    /**
     * Clears all attributes.
     */
    public function clear();

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted();

    /**
     * Registers a SessionBagInterface with the session.
<<<<<<< HEAD
     *
     * @param SessionBagInterface $bag
=======
>>>>>>> v2-test
     */
    public function registerBag(SessionBagInterface $bag);

    /**
     * Gets a bag instance by name.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return SessionBagInterface
     */
    public function getBag($name);
=======
     * @return SessionBagInterface
     */
    public function getBag(string $name);
>>>>>>> v2-test

    /**
     * Gets session meta.
     *
     * @return MetadataBag
     */
    public function getMetadataBag();
}
