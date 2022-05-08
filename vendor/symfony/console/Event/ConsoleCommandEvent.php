<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Event;

/**
 * Allows to do things before the command is executed, like skipping the command or changing the input.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class ConsoleCommandEvent extends ConsoleEvent
=======
final class ConsoleCommandEvent extends ConsoleEvent
>>>>>>> v2-test
{
    /**
     * The return code for skipped commands, this will also be passed into the terminate event.
     */
<<<<<<< HEAD
    const RETURN_CODE_DISABLED = 113;
=======
    public const RETURN_CODE_DISABLED = 113;
>>>>>>> v2-test

    /**
     * Indicates if the command should be run or skipped.
     */
    private $commandShouldRun = true;

    /**
     * Disables the command, so it won't be run.
<<<<<<< HEAD
     *
     * @return bool
     */
    public function disableCommand()
=======
     */
    public function disableCommand(): bool
>>>>>>> v2-test
    {
        return $this->commandShouldRun = false;
    }

<<<<<<< HEAD
    /**
     * Enables the command.
     *
     * @return bool
     */
    public function enableCommand()
=======
    public function enableCommand(): bool
>>>>>>> v2-test
    {
        return $this->commandShouldRun = true;
    }

    /**
     * Returns true if the command is runnable, false otherwise.
<<<<<<< HEAD
     *
     * @return bool
     */
    public function commandShouldRun()
=======
     */
    public function commandShouldRun(): bool
>>>>>>> v2-test
    {
        return $this->commandShouldRun;
    }
}
