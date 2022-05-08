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
 * Metadata container.
 *
 * Adds metadata to the session.
 *
 * @author Drak <drak@zikula.org>
 */
class MetadataBag implements SessionBagInterface
{
<<<<<<< HEAD
    const CREATED = 'c';
    const UPDATED = 'u';
    const LIFETIME = 'l';
=======
    public const CREATED = 'c';
    public const UPDATED = 'u';
    public const LIFETIME = 'l';
>>>>>>> v2-test

    /**
     * @var string
     */
    private $name = '__metadata';

    /**
     * @var string
     */
    private $storageKey;

    /**
     * @var array
     */
<<<<<<< HEAD
    protected $meta = array(self::CREATED => 0, self::UPDATED => 0, self::LIFETIME => 0);
=======
    protected $meta = [self::CREATED => 0, self::UPDATED => 0, self::LIFETIME => 0];
>>>>>>> v2-test

    /**
     * Unix timestamp.
     *
     * @var int
     */
    private $lastUsed;

    /**
     * @var int
     */
    private $updateThreshold;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string $storageKey      The key used to store bag in the session
     * @param int    $updateThreshold The time to wait between two UPDATED updates
     */
    public function __construct($storageKey = '_sf2_meta', $updateThreshold = 0)
=======
     * @param string $storageKey      The key used to store bag in the session
     * @param int    $updateThreshold The time to wait between two UPDATED updates
     */
    public function __construct(string $storageKey = '_sf2_meta', int $updateThreshold = 0)
>>>>>>> v2-test
    {
        $this->storageKey = $storageKey;
        $this->updateThreshold = $updateThreshold;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array &$array)
    {
        $this->meta = &$array;

        if (isset($array[self::CREATED])) {
            $this->lastUsed = $this->meta[self::UPDATED];

            $timeStamp = time();
            if ($timeStamp - $array[self::UPDATED] >= $this->updateThreshold) {
                $this->meta[self::UPDATED] = $timeStamp;
            }
        } else {
            $this->stampCreated();
        }
    }

    /**
     * Gets the lifetime that the session cookie was set with.
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->meta[self::LIFETIME];
    }

    /**
     * Stamps a new session's metadata.
     *
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                      will leave the system settings unchanged, 0 sets the cookie
     *                      to expire with browser session. Time is in seconds, and is
     *                      not a Unix timestamp.
     */
<<<<<<< HEAD
    public function stampNew($lifetime = null)
=======
    public function stampNew(int $lifetime = null)
>>>>>>> v2-test
    {
        $this->stampCreated($lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /**
     * Gets the created timestamp metadata.
     *
     * @return int Unix timestamp
     */
    public function getCreated()
    {
        return $this->meta[self::CREATED];
    }

    /**
     * Gets the last used metadata.
     *
     * @return int Unix timestamp
     */
    public function getLastUsed()
    {
        return $this->lastUsed;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        // nothing to do
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name.
<<<<<<< HEAD
     *
     * @param string $name
     */
    public function setName($name)
=======
     */
    public function setName(string $name)
>>>>>>> v2-test
    {
        $this->name = $name;
    }

<<<<<<< HEAD
    private function stampCreated($lifetime = null)
=======
    private function stampCreated(int $lifetime = null): void
>>>>>>> v2-test
    {
        $timeStamp = time();
        $this->meta[self::CREATED] = $this->meta[self::UPDATED] = $this->lastUsed = $timeStamp;
        $this->meta[self::LIFETIME] = (null === $lifetime) ? ini_get('session.cookie_lifetime') : $lifetime;
    }
}
