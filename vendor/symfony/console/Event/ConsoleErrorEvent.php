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

use Symfony\Component\Console\Command\Command;
<<<<<<< HEAD
use Symfony\Component\Console\Exception\InvalidArgumentException;
=======
>>>>>>> v2-test
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Allows to handle throwables thrown while running a command.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
final class ConsoleErrorEvent extends ConsoleEvent
{
    private $error;
    private $exitCode;

<<<<<<< HEAD
    public function __construct(InputInterface $input, OutputInterface $output, $error, Command $command = null)
    {
        parent::__construct($command, $input, $output);

        $this->setError($error);
    }

    /**
     * Returns the thrown error/exception.
     *
     * @return \Throwable
     */
    public function getError()
=======
    public function __construct(InputInterface $input, OutputInterface $output, \Throwable $error, Command $command = null)
    {
        parent::__construct($command, $input, $output);

        $this->error = $error;
    }

    public function getError(): \Throwable
>>>>>>> v2-test
    {
        return $this->error;
    }

<<<<<<< HEAD
    /**
     * Replaces the thrown error/exception.
     *
     * @param \Throwable $error
     */
    public function setError($error)
    {
        if (!$error instanceof \Throwable && !$error instanceof \Exception) {
            throw new InvalidArgumentException(sprintf('The error passed to ConsoleErrorEvent must be an instance of \Throwable or \Exception, "%s" was passed instead.', \is_object($error) ? \get_class($error) : \gettype($error)));
        }

        $this->error = $error;
    }

    /**
     * Sets the exit code.
     *
     * @param int $exitCode The command exit code
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = (int) $exitCode;
=======
    public function setError(\Throwable $error): void
    {
        $this->error = $error;
    }

    public function setExitCode(int $exitCode): void
    {
        $this->exitCode = $exitCode;
>>>>>>> v2-test

        $r = new \ReflectionProperty($this->error, 'code');
        $r->setAccessible(true);
        $r->setValue($this->error, $this->exitCode);
    }

<<<<<<< HEAD
    /**
     * Gets the exit code.
     *
     * @return int The command exit code
     */
    public function getExitCode()
=======
    public function getExitCode(): int
>>>>>>> v2-test
    {
        return null !== $this->exitCode ? $this->exitCode : (\is_int($this->error->getCode()) && 0 !== $this->error->getCode() ? $this->error->getCode() : 1);
    }
}
