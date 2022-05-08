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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
interface CommandLoaderInterface
{
    /**
     * Loads a command.
     *
<<<<<<< HEAD
     * @param string $name
     *
=======
>>>>>>> v2-test
     * @return Command
     *
     * @throws CommandNotFoundException
     */
<<<<<<< HEAD
    public function get($name);
=======
    public function get(string $name);
>>>>>>> v2-test

    /**
     * Checks if a command exists.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return bool
     */
    public function has($name);
=======
     * @return bool
     */
    public function has(string $name);
>>>>>>> v2-test

    /**
     * @return string[] All registered command names
     */
    public function getNames();
}
