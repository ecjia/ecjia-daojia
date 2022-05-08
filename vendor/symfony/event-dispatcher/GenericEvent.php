<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher;

<<<<<<< HEAD
=======
use Symfony\Contracts\EventDispatcher\Event;

>>>>>>> v2-test
/**
 * Event encapsulation class.
 *
 * Encapsulates events thus decoupling the observer from the subject they encapsulate.
 *
 * @author Drak <drak@zikula.org>
 */
class GenericEvent extends Event implements \ArrayAccess, \IteratorAggregate
{
<<<<<<< HEAD
    /**
     * Event subject.
     *
     * @var mixed usually object or callable
     */
    protected $subject;

    /**
     * Array of arguments.
     *
     * @var array
     */
=======
    protected $subject;
>>>>>>> v2-test
    protected $arguments;

    /**
     * Encapsulate an event with $subject and $args.
     *
<<<<<<< HEAD
     * @param mixed $subject   The subject of the event, usually an object
     * @param array $arguments Arguments to store in the event
     */
    public function __construct($subject = null, array $arguments = array())
=======
     * @param mixed $subject   The subject of the event, usually an object or a callable
     * @param array $arguments Arguments to store in the event
     */
    public function __construct($subject = null, array $arguments = [])
>>>>>>> v2-test
    {
        $this->subject = $subject;
        $this->arguments = $arguments;
    }

    /**
     * Getter for subject property.
     *
<<<<<<< HEAD
     * @return mixed $subject The observer subject
=======
     * @return mixed The observer subject
>>>>>>> v2-test
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get argument by key.
     *
<<<<<<< HEAD
     * @param string $key Key
     *
     * @return mixed Contents of array key
     *
     * @throws \InvalidArgumentException If key is not found.
     */
    public function getArgument($key)
=======
     * @return mixed Contents of array key
     *
     * @throws \InvalidArgumentException if key is not found
     */
    public function getArgument(string $key)
>>>>>>> v2-test
    {
        if ($this->hasArgument($key)) {
            return $this->arguments[$key];
        }

        throw new \InvalidArgumentException(sprintf('Argument "%s" not found.', $key));
    }

    /**
     * Add argument to event.
     *
<<<<<<< HEAD
     * @param string $key   Argument name
     * @param mixed  $value Value
     *
     * @return GenericEvent
     */
    public function setArgument($key, $value)
=======
     * @param mixed $value Value
     *
     * @return $this
     */
    public function setArgument(string $key, $value)
>>>>>>> v2-test
    {
        $this->arguments[$key] = $value;

        return $this;
    }

    /**
     * Getter for all arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set args property.
     *
<<<<<<< HEAD
     * @param array $args Arguments
     *
     * @return GenericEvent
     */
    public function setArguments(array $args = array())
=======
     * @return $this
     */
    public function setArguments(array $args = [])
>>>>>>> v2-test
    {
        $this->arguments = $args;

        return $this;
    }

    /**
     * Has argument.
     *
<<<<<<< HEAD
     * @param string $key Key of arguments array
     *
     * @return bool
     */
    public function hasArgument($key)
    {
        return array_key_exists($key, $this->arguments);
=======
     * @return bool
     */
    public function hasArgument(string $key)
    {
        return \array_key_exists($key, $this->arguments);
>>>>>>> v2-test
    }

    /**
     * ArrayAccess for argument getter.
     *
     * @param string $key Array key
     *
     * @return mixed
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException If key does not exist in $this->args.
=======
     * @throws \InvalidArgumentException if key does not exist in $this->args
>>>>>>> v2-test
     */
    public function offsetGet($key)
    {
        return $this->getArgument($key);
    }

    /**
     * ArrayAccess for argument setter.
     *
     * @param string $key   Array key to set
     * @param mixed  $value Value
     */
    public function offsetSet($key, $value)
    {
        $this->setArgument($key, $value);
    }

    /**
     * ArrayAccess for unset argument.
     *
     * @param string $key Array key
     */
    public function offsetUnset($key)
    {
        if ($this->hasArgument($key)) {
            unset($this->arguments[$key]);
        }
    }

    /**
     * ArrayAccess has argument.
     *
     * @param string $key Array key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->hasArgument($key);
    }

    /**
     * IteratorAggregate for iterating over the object like an array.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->arguments);
    }
}
