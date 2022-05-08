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

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
=======
>>>>>>> v2-test
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
<<<<<<< HEAD

/**
 * Session.
 *
=======
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

// Help opcache.preload discover always-needed symbols
class_exists(AttributeBag::class);
class_exists(FlashBag::class);
class_exists(SessionBagProxy::class);

/**
>>>>>>> v2-test
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Drak <drak@zikula.org>
 */
class Session implements SessionInterface, \IteratorAggregate, \Countable
{
<<<<<<< HEAD
    /**
     * Storage driver.
     *
     * @var SessionStorageInterface
     */
    protected $storage;

    /**
     * @var string
     */
    private $flashName;

    /**
     * @var string
     */
    private $attributeName;

    /**
     * Constructor.
     *
     * @param SessionStorageInterface $storage    A SessionStorageInterface instance
     * @param AttributeBagInterface   $attributes An AttributeBagInterface instance, (defaults null for default AttributeBag)
     * @param FlashBagInterface       $flashes    A FlashBagInterface instance (defaults null for default FlashBag)
     */
    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
    {
        $this->storage = $storage ?: new NativeSessionStorage();
=======
    protected $storage;

    private $flashName;
    private $attributeName;
    private $data = [];
    private $usageIndex = 0;
    private $usageReporter;

    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null, callable $usageReporter = null)
    {
        $this->storage = $storage ?: new NativeSessionStorage();
        $this->usageReporter = $usageReporter;
>>>>>>> v2-test

        $attributes = $attributes ?: new AttributeBag();
        $this->attributeName = $attributes->getName();
        $this->registerBag($attributes);

        $flashes = $flashes ?: new FlashBag();
        $this->flashName = $flashes->getName();
        $this->registerBag($flashes);
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        return $this->storage->start();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function has($name)
    {
        return $this->storage->getBag($this->attributeName)->has($name);
=======
    public function has(string $name)
    {
        return $this->getAttributeBag()->has($name);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function get($name, $default = null)
    {
        return $this->storage->getBag($this->attributeName)->get($name, $default);
=======
    public function get(string $name, $default = null)
    {
        return $this->getAttributeBag()->get($name, $default);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($name, $value)
    {
        $this->storage->getBag($this->attributeName)->set($name, $value);
=======
    public function set(string $name, $value)
    {
        $this->getAttributeBag()->set($name, $value);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
<<<<<<< HEAD
        return $this->storage->getBag($this->attributeName)->all();
=======
        return $this->getAttributeBag()->all();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function replace(array $attributes)
    {
<<<<<<< HEAD
        $this->storage->getBag($this->attributeName)->replace($attributes);
=======
        $this->getAttributeBag()->replace($attributes);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function remove($name)
    {
        return $this->storage->getBag($this->attributeName)->remove($name);
=======
    public function remove(string $name)
    {
        return $this->getAttributeBag()->remove($name);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
<<<<<<< HEAD
        $this->storage->getBag($this->attributeName)->clear();
=======
        $this->getAttributeBag()->clear();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted()
    {
        return $this->storage->isStarted();
    }

    /**
     * Returns an iterator for attributes.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
<<<<<<< HEAD
        return new \ArrayIterator($this->storage->getBag($this->attributeName)->all());
=======
        return new \ArrayIterator($this->getAttributeBag()->all());
>>>>>>> v2-test
    }

    /**
     * Returns the number of attributes.
     *
<<<<<<< HEAD
     * @return int The number of attributes
     */
    public function count()
    {
        return count($this->storage->getBag($this->attributeName)->all());
=======
     * @return int
     */
    public function count()
    {
        return \count($this->getAttributeBag()->all());
    }

    public function &getUsageIndex(): int
    {
        return $this->usageIndex;
    }

    /**
     * @internal
     */
    public function isEmpty(): bool
    {
        if ($this->isStarted()) {
            ++$this->usageIndex;
            if ($this->usageReporter && 0 <= $this->usageIndex) {
                ($this->usageReporter)();
            }
        }
        foreach ($this->data as &$data) {
            if (!empty($data)) {
                return false;
            }
        }

        return true;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function invalidate($lifetime = null)
=======
    public function invalidate(int $lifetime = null)
>>>>>>> v2-test
    {
        $this->storage->clear();

        return $this->migrate(true, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function migrate($destroy = false, $lifetime = null)
=======
    public function migrate(bool $destroy = false, int $lifetime = null)
>>>>>>> v2-test
    {
        return $this->storage->regenerate($destroy, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->storage->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->storage->getId();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setId($id)
    {
        $this->storage->setId($id);
=======
    public function setId(string $id)
    {
        if ($this->storage->getId() !== $id) {
            $this->storage->setId($id);
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->storage->getName();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setName($name)
=======
    public function setName(string $name)
>>>>>>> v2-test
    {
        $this->storage->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataBag()
    {
<<<<<<< HEAD
=======
        ++$this->usageIndex;
        if ($this->usageReporter && 0 <= $this->usageIndex) {
            ($this->usageReporter)();
        }

>>>>>>> v2-test
        return $this->storage->getMetadataBag();
    }

    /**
     * {@inheritdoc}
     */
    public function registerBag(SessionBagInterface $bag)
    {
<<<<<<< HEAD
        $this->storage->registerBag($bag);
=======
        $this->storage->registerBag(new SessionBagProxy($bag, $this->data, $this->usageIndex, $this->usageReporter));
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getBag($name)
    {
        return $this->storage->getBag($name);
=======
    public function getBag(string $name)
    {
        $bag = $this->storage->getBag($name);

        return method_exists($bag, 'getBag') ? $bag->getBag() : $bag;
>>>>>>> v2-test
    }

    /**
     * Gets the flashbag interface.
     *
     * @return FlashBagInterface
     */
    public function getFlashBag()
    {
        return $this->getBag($this->flashName);
    }
<<<<<<< HEAD
=======

    /**
     * Gets the attributebag interface.
     *
     * Note that this method was added to help with IDE autocompletion.
     */
    private function getAttributeBag(): AttributeBagInterface
    {
        return $this->getBag($this->attributeName);
    }
>>>>>>> v2-test
}
