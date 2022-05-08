<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * HelperSet represents a set of helpers to be used with a command.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HelperSet implements \IteratorAggregate
{
    /**
     * @var Helper[]
     */
<<<<<<< HEAD
    private $helpers = array();
=======
    private $helpers = [];
>>>>>>> v2-test
    private $command;

    /**
     * @param Helper[] $helpers An array of helper
     */
<<<<<<< HEAD
    public function __construct(array $helpers = array())
=======
    public function __construct(array $helpers = [])
>>>>>>> v2-test
    {
        foreach ($helpers as $alias => $helper) {
            $this->set($helper, \is_int($alias) ? null : $alias);
        }
    }

<<<<<<< HEAD
    /**
     * Sets a helper.
     *
     * @param HelperInterface $helper The helper instance
     * @param string          $alias  An alias
     */
    public function set(HelperInterface $helper, $alias = null)
=======
    public function set(HelperInterface $helper, string $alias = null)
>>>>>>> v2-test
    {
        $this->helpers[$helper->getName()] = $helper;
        if (null !== $alias) {
            $this->helpers[$alias] = $helper;
        }

        $helper->setHelperSet($this);
    }

    /**
     * Returns true if the helper if defined.
     *
<<<<<<< HEAD
     * @param string $name The helper name
     *
     * @return bool true if the helper is defined, false otherwise
     */
    public function has($name)
=======
     * @return bool true if the helper is defined, false otherwise
     */
    public function has(string $name)
>>>>>>> v2-test
    {
        return isset($this->helpers[$name]);
    }

    /**
     * Gets a helper value.
     *
<<<<<<< HEAD
     * @param string $name The helper name
     *
=======
>>>>>>> v2-test
     * @return HelperInterface The helper instance
     *
     * @throws InvalidArgumentException if the helper is not defined
     */
<<<<<<< HEAD
    public function get($name)
=======
    public function get(string $name)
>>>>>>> v2-test
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('The helper "%s" is not defined.', $name));
        }

        return $this->helpers[$name];
    }

    public function setCommand(Command $command = null)
    {
        $this->command = $command;
    }

    /**
     * Gets the command associated with this helper set.
     *
     * @return Command A Command instance
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return Helper[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->helpers);
    }
}
