<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Attribute;

/**
 * This class relates to session attribute storage.
 */
class AttributeBag implements AttributeBagInterface, \IteratorAggregate, \Countable
{
    private $name = 'attributes';
<<<<<<< HEAD

    /**
     * @var string
     */
    private $storageKey;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * Constructor.
     *
     * @param string $storageKey The key used to store attributes in the session
     */
    public function __construct($storageKey = '_sf2_attributes')
=======
    private $storageKey;

    protected $attributes = [];

    /**
     * @param string $storageKey The key used to store attributes in the session
     */
    public function __construct(string $storageKey = '_sf2_attributes')
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
    public function initialize(array &$attributes)
    {
        $this->attributes = &$attributes;
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
<<<<<<< HEAD
    public function has($name)
    {
        return array_key_exists($name, $this->attributes);
=======
    public function has(string $name)
    {
        return \array_key_exists($name, $this->attributes);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function get($name, $default = null)
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
=======
    public function get(string $name, $default = null)
    {
        return \array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($name, $value)
=======
    public function set(string $name, $value)
>>>>>>> v2-test
    {
        $this->attributes[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function replace(array $attributes)
    {
<<<<<<< HEAD
        $this->attributes = array();
=======
        $this->attributes = [];
>>>>>>> v2-test
        foreach ($attributes as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function remove($name)
    {
        $retval = null;
        if (array_key_exists($name, $this->attributes)) {
=======
    public function remove(string $name)
    {
        $retval = null;
        if (\array_key_exists($name, $this->attributes)) {
>>>>>>> v2-test
            $retval = $this->attributes[$name];
            unset($this->attributes[$name]);
        }

        return $retval;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $return = $this->attributes;
<<<<<<< HEAD
        $this->attributes = array();
=======
        $this->attributes = [];
>>>>>>> v2-test

        return $return;
    }

    /**
     * Returns an iterator for attributes.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->attributes);
    }

    /**
     * Returns the number of attributes.
     *
     * @return int The number of attributes
     */
    public function count()
    {
<<<<<<< HEAD
        return count($this->attributes);
=======
        return \count($this->attributes);
>>>>>>> v2-test
    }
}
