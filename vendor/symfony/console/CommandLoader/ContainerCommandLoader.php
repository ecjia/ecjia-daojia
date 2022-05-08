<?php

<<<<<<< HEAD
=======
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

>>>>>>> v2-test
namespace Symfony\Component\Console\CommandLoader;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * Loads commands from a PSR-11 container.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ContainerCommandLoader implements CommandLoaderInterface
{
    private $container;
    private $commandMap;

    /**
<<<<<<< HEAD
     * @param ContainerInterface $container  A container from which to load command services
     * @param array              $commandMap An array with command names as keys and service ids as values
=======
     * @param array $commandMap An array with command names as keys and service ids as values
>>>>>>> v2-test
     */
    public function __construct(ContainerInterface $container, array $commandMap)
    {
        $this->container = $container;
        $this->commandMap = $commandMap;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function get($name)
=======
    public function get(string $name)
>>>>>>> v2-test
    {
        if (!$this->has($name)) {
            throw new CommandNotFoundException(sprintf('Command "%s" does not exist.', $name));
        }

        return $this->container->get($this->commandMap[$name]);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function has($name)
=======
    public function has(string $name)
>>>>>>> v2-test
    {
        return isset($this->commandMap[$name]) && $this->container->has($this->commandMap[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getNames()
    {
        return array_keys($this->commandMap);
    }
}
