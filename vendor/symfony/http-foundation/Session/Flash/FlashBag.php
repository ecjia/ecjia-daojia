<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Flash;

/**
 * FlashBag flash message container.
 *
<<<<<<< HEAD
 * \IteratorAggregate implementation is deprecated and will be removed in 3.0.
 *
 * @author Drak <drak@zikula.org>
 */
class FlashBag implements FlashBagInterface, \IteratorAggregate
{
    private $name = 'flashes';

    /**
     * Flash messages.
     *
     * @var array
     */
    private $flashes = array();

    /**
     * The storage key for flashes in the session.
     *
     * @var string
     */
    private $storageKey;

    /**
     * Constructor.
     *
     * @param string $storageKey The key used to store flashes in the session
     */
    public function __construct($storageKey = '_sf2_flashes')
=======
 * @author Drak <drak@zikula.org>
 */
class FlashBag implements FlashBagInterface
{
    private $name = 'flashes';
    private $flashes = [];
    private $storageKey;

    /**
     * @param string $storageKey The key used to store flashes in the session
     */
    public function __construct(string $storageKey = '_symfony_flashes')
>>>>>>> v2-test
    {
        $this->storageKey = $storageKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

<<<<<<< HEAD
    public function setName($name)
=======
    public function setName(string $name)
>>>>>>> v2-test
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array &$flashes)
    {
        $this->flashes = &$flashes;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function add($type, $message)
=======
    public function add(string $type, $message)
>>>>>>> v2-test
    {
        $this->flashes[$type][] = $message;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function peek($type, array $default = array())
=======
    public function peek(string $type, array $default = [])
>>>>>>> v2-test
    {
        return $this->has($type) ? $this->flashes[$type] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function peekAll()
    {
        return $this->flashes;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function get($type, array $default = array())
=======
    public function get(string $type, array $default = [])
>>>>>>> v2-test
    {
        if (!$this->has($type)) {
            return $default;
        }

        $return = $this->flashes[$type];

        unset($this->flashes[$type]);

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $return = $this->peekAll();
<<<<<<< HEAD
        $this->flashes = array();
=======
        $this->flashes = [];
>>>>>>> v2-test

        return $return;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($type, $messages)
=======
    public function set(string $type, $messages)
>>>>>>> v2-test
    {
        $this->flashes[$type] = (array) $messages;
    }

    /**
     * {@inheritdoc}
     */
    public function setAll(array $messages)
    {
        $this->flashes = $messages;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function has($type)
    {
        return array_key_exists($type, $this->flashes) && $this->flashes[$type];
=======
    public function has(string $type)
    {
        return \array_key_exists($type, $this->flashes) && $this->flashes[$type];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return array_keys($this->flashes);
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this->all();
    }
<<<<<<< HEAD

    /**
     * Returns an iterator for flashes.
     *
     * @deprecated since version 2.4, to be removed in 3.0.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.4 and will be removed in 3.0.', E_USER_DEPRECATED);

        return new \ArrayIterator($this->all());
    }
=======
>>>>>>> v2-test
}
