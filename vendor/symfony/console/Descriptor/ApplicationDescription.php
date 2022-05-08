<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Descriptor;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class ApplicationDescription
{
<<<<<<< HEAD
    const GLOBAL_NAMESPACE = '_global';
=======
    public const GLOBAL_NAMESPACE = '_global';
>>>>>>> v2-test

    private $application;
    private $namespace;
    private $showHidden;

    /**
     * @var array
     */
    private $namespaces;

    /**
     * @var Command[]
     */
    private $commands;

    /**
     * @var Command[]
     */
    private $aliases;

<<<<<<< HEAD
    /**
     * @param Application $application
     * @param string|null $namespace
     * @param bool        $showHidden
     */
    public function __construct(Application $application, $namespace = null, $showHidden = false)
=======
    public function __construct(Application $application, string $namespace = null, bool $showHidden = false)
>>>>>>> v2-test
    {
        $this->application = $application;
        $this->namespace = $namespace;
        $this->showHidden = $showHidden;
    }

<<<<<<< HEAD
    /**
     * @return array
     */
    public function getNamespaces()
=======
    public function getNamespaces(): array
>>>>>>> v2-test
    {
        if (null === $this->namespaces) {
            $this->inspectApplication();
        }

        return $this->namespaces;
    }

    /**
     * @return Command[]
     */
<<<<<<< HEAD
    public function getCommands()
=======
    public function getCommands(): array
>>>>>>> v2-test
    {
        if (null === $this->commands) {
            $this->inspectApplication();
        }

        return $this->commands;
    }

    /**
<<<<<<< HEAD
     * @param string $name
     *
     * @return Command
     *
     * @throws CommandNotFoundException
     */
    public function getCommand($name)
    {
        if (!isset($this->commands[$name]) && !isset($this->aliases[$name])) {
            throw new CommandNotFoundException(sprintf('Command %s does not exist.', $name));
        }

        return isset($this->commands[$name]) ? $this->commands[$name] : $this->aliases[$name];
=======
     * @throws CommandNotFoundException
     */
    public function getCommand(string $name): Command
    {
        if (!isset($this->commands[$name]) && !isset($this->aliases[$name])) {
            throw new CommandNotFoundException(sprintf('Command "%s" does not exist.', $name));
        }

        return $this->commands[$name] ?? $this->aliases[$name];
>>>>>>> v2-test
    }

    private function inspectApplication()
    {
<<<<<<< HEAD
        $this->commands = array();
        $this->namespaces = array();

        $all = $this->application->all($this->namespace ? $this->application->findNamespace($this->namespace) : null);
        foreach ($this->sortCommands($all) as $namespace => $commands) {
            $names = array();
=======
        $this->commands = [];
        $this->namespaces = [];

        $all = $this->application->all($this->namespace ? $this->application->findNamespace($this->namespace) : null);
        foreach ($this->sortCommands($all) as $namespace => $commands) {
            $names = [];
>>>>>>> v2-test

            /** @var Command $command */
            foreach ($commands as $name => $command) {
                if (!$command->getName() || (!$this->showHidden && $command->isHidden())) {
                    continue;
                }

                if ($command->getName() === $name) {
                    $this->commands[$name] = $command;
                } else {
                    $this->aliases[$name] = $command;
                }

                $names[] = $name;
            }

<<<<<<< HEAD
            $this->namespaces[$namespace] = array('id' => $namespace, 'commands' => $names);
        }
    }

    /**
     * @return array
     */
    private function sortCommands(array $commands)
    {
        $namespacedCommands = array();
        $globalCommands = array();
        foreach ($commands as $name => $command) {
            $key = $this->application->extractNamespace($name, 1);
            if (!$key) {
                $globalCommands['_global'][$name] = $command;
=======
            $this->namespaces[$namespace] = ['id' => $namespace, 'commands' => $names];
        }
    }

    private function sortCommands(array $commands): array
    {
        $namespacedCommands = [];
        $globalCommands = [];
        $sortedCommands = [];
        foreach ($commands as $name => $command) {
            $key = $this->application->extractNamespace($name, 1);
            if (\in_array($key, ['', self::GLOBAL_NAMESPACE], true)) {
                $globalCommands[$name] = $command;
>>>>>>> v2-test
            } else {
                $namespacedCommands[$key][$name] = $command;
            }
        }
<<<<<<< HEAD
        ksort($namespacedCommands);
        $namespacedCommands = array_merge($globalCommands, $namespacedCommands);

        foreach ($namespacedCommands as &$commandsSet) {
            ksort($commandsSet);
        }
        // unset reference to keep scope clear
        unset($commandsSet);

        return $namespacedCommands;
=======

        if ($globalCommands) {
            ksort($globalCommands);
            $sortedCommands[self::GLOBAL_NAMESPACE] = $globalCommands;
        }

        if ($namespacedCommands) {
            ksort($namespacedCommands);
            foreach ($namespacedCommands as $key => $commandsSet) {
                ksort($commandsSet);
                $sortedCommands[$key] = $commandsSet;
            }
        }

        return $sortedCommands;
>>>>>>> v2-test
    }
}
