<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
<<<<<<< HEAD
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
=======
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleSignalEvent;
>>>>>>> v2-test
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Exception\LogicException;
<<<<<<< HEAD
=======
use Symfony\Component\Console\Exception\NamespaceNotFoundException;
use Symfony\Component\Console\Exception\RuntimeException;
>>>>>>> v2-test
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputAwareInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
<<<<<<< HEAD
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
=======
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SignalRegistry\SignalRegistry;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\ResetInterface;
>>>>>>> v2-test

/**
 * An Application is the container for a collection of commands.
 *
 * It is the main entry point of a Console application.
 *
 * This class is optimized for a standard CLI environment.
 *
 * Usage:
 *
 *     $app = new Application('myapp', '1.0 (stable)');
 *     $app->add(new SimpleCommand());
 *     $app->run();
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class Application
{
    private $commands = array();
=======
class Application implements ResetInterface
{
    private $commands = [];
>>>>>>> v2-test
    private $wantHelps = false;
    private $runningCommand;
    private $name;
    private $version;
    private $commandLoader;
    private $catchExceptions = true;
    private $autoExit = true;
    private $definition;
    private $helperSet;
    private $dispatcher;
    private $terminal;
    private $defaultCommand;
<<<<<<< HEAD
    private $singleCommand;
    private $initialized;

    /**
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
=======
    private $singleCommand = false;
    private $initialized;
    private $signalRegistry;
    private $signalsToDispatchEvent = [];

    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
>>>>>>> v2-test
    {
        $this->name = $name;
        $this->version = $version;
        $this->terminal = new Terminal();
        $this->defaultCommand = 'list';
<<<<<<< HEAD
    }

=======
        if (\defined('SIGINT') && SignalRegistry::isSupported()) {
            $this->signalRegistry = new SignalRegistry();
            $this->signalsToDispatchEvent = [\SIGINT, \SIGTERM, \SIGUSR1, \SIGUSR2];
        }
    }

    /**
     * @final
     */
>>>>>>> v2-test
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function setCommandLoader(CommandLoaderInterface $commandLoader)
    {
        $this->commandLoader = $commandLoader;
    }

<<<<<<< HEAD
=======
    public function getSignalRegistry(): SignalRegistry
    {
        if (!$this->signalRegistry) {
            throw new RuntimeException('Signals are not supported. Make sure that the `pcntl` extension is installed and that "pcntl_*" functions are not disabled by your php.ini\'s "disable_functions" directive.');
        }

        return $this->signalRegistry;
    }

    public function setSignalsToDispatchEvent(int ...$signalsToDispatchEvent)
    {
        $this->signalsToDispatchEvent = $signalsToDispatchEvent;
    }

>>>>>>> v2-test
    /**
     * Runs the current application.
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @throws \Exception When running fails. Bypass this when {@link setCatchExceptions()}.
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
<<<<<<< HEAD
        putenv('LINES='.$this->terminal->getHeight());
        putenv('COLUMNS='.$this->terminal->getWidth());
=======
        if (\function_exists('putenv')) {
            @putenv('LINES='.$this->terminal->getHeight());
            @putenv('COLUMNS='.$this->terminal->getWidth());
        }
>>>>>>> v2-test

        if (null === $input) {
            $input = new ArgvInput();
        }

        if (null === $output) {
            $output = new ConsoleOutput();
        }

<<<<<<< HEAD
        $renderException = function ($e) use ($output) {
            if (!$e instanceof \Exception) {
                $e = class_exists(FatalThrowableError::class) ? new FatalThrowableError($e) : new \ErrorException($e->getMessage(), $e->getCode(), E_ERROR, $e->getFile(), $e->getLine());
            }
            if ($output instanceof ConsoleOutputInterface) {
                $this->renderException($e, $output->getErrorOutput());
            } else {
                $this->renderException($e, $output);
=======
        $renderException = function (\Throwable $e) use ($output) {
            if ($output instanceof ConsoleOutputInterface) {
                $this->renderThrowable($e, $output->getErrorOutput());
            } else {
                $this->renderThrowable($e, $output);
>>>>>>> v2-test
            }
        };
        if ($phpHandler = set_exception_handler($renderException)) {
            restore_exception_handler();
            if (!\is_array($phpHandler) || !$phpHandler[0] instanceof ErrorHandler) {
<<<<<<< HEAD
                $debugHandler = true;
            } elseif ($debugHandler = $phpHandler[0]->setExceptionHandler($renderException)) {
                $phpHandler[0]->setExceptionHandler($debugHandler);
            }
        }

        if (null !== $this->dispatcher && $this->dispatcher->hasListeners(ConsoleEvents::EXCEPTION)) {
            @trigger_error(sprintf('The "ConsoleEvents::EXCEPTION" event is deprecated since Symfony 3.3 and will be removed in 4.0. Listen to the "ConsoleEvents::ERROR" event instead.'), E_USER_DEPRECATED);
        }

=======
                $errorHandler = true;
            } elseif ($errorHandler = $phpHandler[0]->setExceptionHandler($renderException)) {
                $phpHandler[0]->setExceptionHandler($errorHandler);
            }
        }

>>>>>>> v2-test
        $this->configureIO($input, $output);

        try {
            $exitCode = $this->doRun($input, $output);
        } catch (\Exception $e) {
            if (!$this->catchExceptions) {
                throw $e;
            }

            $renderException($e);

            $exitCode = $e->getCode();
            if (is_numeric($exitCode)) {
                $exitCode = (int) $exitCode;
                if (0 === $exitCode) {
                    $exitCode = 1;
                }
            } else {
                $exitCode = 1;
            }
        } finally {
            // if the exception handler changed, keep it
            // otherwise, unregister $renderException
            if (!$phpHandler) {
                if (set_exception_handler($renderException) === $renderException) {
                    restore_exception_handler();
                }
                restore_exception_handler();
<<<<<<< HEAD
            } elseif (!$debugHandler) {
=======
            } elseif (!$errorHandler) {
>>>>>>> v2-test
                $finalHandler = $phpHandler[0]->setExceptionHandler(null);
                if ($finalHandler !== $renderException) {
                    $phpHandler[0]->setExceptionHandler($finalHandler);
                }
            }
        }

        if ($this->autoExit) {
            if ($exitCode > 255) {
                $exitCode = 255;
            }

            exit($exitCode);
        }

        return $exitCode;
    }

    /**
     * Runs the current application.
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
<<<<<<< HEAD
        if (true === $input->hasParameterOption(array('--version', '-V'), true)) {
=======
        if (true === $input->hasParameterOption(['--version', '-V'], true)) {
>>>>>>> v2-test
            $output->writeln($this->getLongVersion());

            return 0;
        }

<<<<<<< HEAD
        $name = $this->getCommandName($input);
        if (true === $input->hasParameterOption(array('--help', '-h'), true)) {
            if (!$name) {
                $name = 'help';
                $input = new ArrayInput(array('command_name' => $this->defaultCommand));
=======
        try {
            // Makes ArgvInput::getFirstArgument() able to distinguish an option from an argument.
            $input->bind($this->getDefinition());
        } catch (ExceptionInterface $e) {
            // Errors must be ignored, full binding/validation happens later when the command is known.
        }

        $name = $this->getCommandName($input);
        if (true === $input->hasParameterOption(['--help', '-h'], true)) {
            if (!$name) {
                $name = 'help';
                $input = new ArrayInput(['command_name' => $this->defaultCommand]);
>>>>>>> v2-test
            } else {
                $this->wantHelps = true;
            }
        }

        if (!$name) {
            $name = $this->defaultCommand;
            $definition = $this->getDefinition();
            $definition->setArguments(array_merge(
                $definition->getArguments(),
<<<<<<< HEAD
                array(
                    'command' => new InputArgument('command', InputArgument::OPTIONAL, $definition->getArgument('command')->getDescription(), $name),
                )
=======
                [
                    'command' => new InputArgument('command', InputArgument::OPTIONAL, $definition->getArgument('command')->getDescription(), $name),
                ]
>>>>>>> v2-test
            ));
        }

        try {
<<<<<<< HEAD
            $e = $this->runningCommand = null;
            // the command name MUST be the first element of the input
            $command = $this->find($name);
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }
        if (null !== $e) {
            if (null !== $this->dispatcher) {
                $event = new ConsoleErrorEvent($input, $output, $e);
                $this->dispatcher->dispatch(ConsoleEvents::ERROR, $event);
                $e = $event->getError();

                if (0 === $event->getExitCode()) {
                    return 0;
                }
            }

            throw $e;
=======
            $this->runningCommand = null;
            // the command name MUST be the first element of the input
            $command = $this->find($name);
        } catch (\Throwable $e) {
            if (!($e instanceof CommandNotFoundException && !$e instanceof NamespaceNotFoundException) || 1 !== \count($alternatives = $e->getAlternatives()) || !$input->isInteractive()) {
                if (null !== $this->dispatcher) {
                    $event = new ConsoleErrorEvent($input, $output, $e);
                    $this->dispatcher->dispatch($event, ConsoleEvents::ERROR);

                    if (0 === $event->getExitCode()) {
                        return 0;
                    }

                    $e = $event->getError();
                }

                throw $e;
            }

            $alternative = $alternatives[0];

            $style = new SymfonyStyle($input, $output);
            $style->block(sprintf("\nCommand \"%s\" is not defined.\n", $name), null, 'error');
            if (!$style->confirm(sprintf('Do you want to run "%s" instead? ', $alternative), false)) {
                if (null !== $this->dispatcher) {
                    $event = new ConsoleErrorEvent($input, $output, $e);
                    $this->dispatcher->dispatch($event, ConsoleEvents::ERROR);

                    return $event->getExitCode();
                }

                return 1;
            }

            $command = $this->find($alternative);
>>>>>>> v2-test
        }

        $this->runningCommand = $command;
        $exitCode = $this->doRunCommand($command, $input, $output);
        $this->runningCommand = null;

        return $exitCode;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
    }

>>>>>>> v2-test
    public function setHelperSet(HelperSet $helperSet)
    {
        $this->helperSet = $helperSet;
    }

    /**
     * Get the helper set associated with the command.
     *
     * @return HelperSet The HelperSet instance associated with this command
     */
    public function getHelperSet()
    {
        if (!$this->helperSet) {
            $this->helperSet = $this->getDefaultHelperSet();
        }

        return $this->helperSet;
    }

    public function setDefinition(InputDefinition $definition)
    {
        $this->definition = $definition;
    }

    /**
     * Gets the InputDefinition related to this Application.
     *
     * @return InputDefinition The InputDefinition instance
     */
    public function getDefinition()
    {
        if (!$this->definition) {
            $this->definition = $this->getDefaultInputDefinition();
        }

        if ($this->singleCommand) {
            $inputDefinition = $this->definition;
            $inputDefinition->setArguments();

            return $inputDefinition;
        }

        return $this->definition;
    }

    /**
     * Gets the help message.
     *
     * @return string A help message
     */
    public function getHelp()
    {
        return $this->getLongVersion();
    }

    /**
     * Gets whether to catch exceptions or not during commands execution.
     *
     * @return bool Whether to catch exceptions or not during commands execution
     */
    public function areExceptionsCaught()
    {
        return $this->catchExceptions;
    }

    /**
     * Sets whether to catch exceptions or not during commands execution.
<<<<<<< HEAD
     *
     * @param bool $boolean Whether to catch exceptions or not during commands execution
     */
    public function setCatchExceptions($boolean)
    {
        $this->catchExceptions = (bool) $boolean;
=======
     */
    public function setCatchExceptions(bool $boolean)
    {
        $this->catchExceptions = $boolean;
>>>>>>> v2-test
    }

    /**
     * Gets whether to automatically exit after a command execution or not.
     *
     * @return bool Whether to automatically exit after a command execution or not
     */
    public function isAutoExitEnabled()
    {
        return $this->autoExit;
    }

    /**
     * Sets whether to automatically exit after a command execution or not.
<<<<<<< HEAD
     *
     * @param bool $boolean Whether to automatically exit after a command execution or not
     */
    public function setAutoExit($boolean)
    {
        $this->autoExit = (bool) $boolean;
=======
     */
    public function setAutoExit(bool $boolean)
    {
        $this->autoExit = $boolean;
>>>>>>> v2-test
    }

    /**
     * Gets the name of the application.
     *
     * @return string The application name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the application name.
<<<<<<< HEAD
     *
     * @param string $name The application name
     */
    public function setName($name)
=======
     **/
    public function setName(string $name)
>>>>>>> v2-test
    {
        $this->name = $name;
    }

    /**
     * Gets the application version.
     *
     * @return string The application version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the application version.
<<<<<<< HEAD
     *
     * @param string $version The application version
     */
    public function setVersion($version)
=======
     */
    public function setVersion(string $version)
>>>>>>> v2-test
    {
        $this->version = $version;
    }

    /**
     * Returns the long version of the application.
     *
     * @return string The long application version
     */
    public function getLongVersion()
    {
        if ('UNKNOWN' !== $this->getName()) {
            if ('UNKNOWN' !== $this->getVersion()) {
                return sprintf('%s <info>%s</info>', $this->getName(), $this->getVersion());
            }

            return $this->getName();
        }

        return 'Console Tool';
    }

    /**
     * Registers a new command.
     *
<<<<<<< HEAD
     * @param string $name The command name
     *
     * @return Command The newly created command
     */
    public function register($name)
=======
     * @return Command The newly created command
     */
    public function register(string $name)
>>>>>>> v2-test
    {
        return $this->add(new Command($name));
    }

    /**
     * Adds an array of command objects.
     *
     * If a Command is not enabled it will not be added.
     *
     * @param Command[] $commands An array of commands
     */
    public function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->add($command);
        }
    }

    /**
     * Adds a command object.
     *
     * If a command with the same name already exists, it will be overridden.
     * If the command is not enabled it will not be added.
     *
     * @return Command|null The registered command if enabled or null
     */
    public function add(Command $command)
    {
        $this->init();

        $command->setApplication($this);

        if (!$command->isEnabled()) {
            $command->setApplication(null);

<<<<<<< HEAD
            return;
        }

        if (null === $command->getDefinition()) {
            throw new LogicException(sprintf('Command class "%s" is not correctly initialized. You probably forgot to call the parent constructor.', \get_class($command)));
        }

        if (!$command->getName()) {
            throw new LogicException(sprintf('The command defined in "%s" cannot have an empty name.', \get_class($command)));
=======
            return null;
        }

        // Will throw if the command is not correctly initialized.
        $command->getDefinition();

        if (!$command->getName()) {
            throw new LogicException(sprintf('The command defined in "%s" cannot have an empty name.', get_debug_type($command)));
>>>>>>> v2-test
        }

        $this->commands[$command->getName()] = $command;

        foreach ($command->getAliases() as $alias) {
            $this->commands[$alias] = $command;
        }

        return $command;
    }

    /**
     * Returns a registered command by name or alias.
     *
<<<<<<< HEAD
     * @param string $name The command name or alias
     *
=======
>>>>>>> v2-test
     * @return Command A Command object
     *
     * @throws CommandNotFoundException When given command name does not exist
     */
<<<<<<< HEAD
    public function get($name)
=======
    public function get(string $name)
>>>>>>> v2-test
    {
        $this->init();

        if (!$this->has($name)) {
            throw new CommandNotFoundException(sprintf('The command "%s" does not exist.', $name));
        }

<<<<<<< HEAD
=======
        // When the command has a different name than the one used at the command loader level
        if (!isset($this->commands[$name])) {
            throw new CommandNotFoundException(sprintf('The "%s" command cannot be found because it is registered under multiple names. Make sure you don\'t set a different name via constructor or "setName()".', $name));
        }

>>>>>>> v2-test
        $command = $this->commands[$name];

        if ($this->wantHelps) {
            $this->wantHelps = false;

            $helpCommand = $this->get('help');
            $helpCommand->setCommand($command);

            return $helpCommand;
        }

        return $command;
    }

    /**
     * Returns true if the command exists, false otherwise.
     *
<<<<<<< HEAD
     * @param string $name The command name or alias
     *
     * @return bool true if the command exists, false otherwise
     */
    public function has($name)
=======
     * @return bool true if the command exists, false otherwise
     */
    public function has(string $name)
>>>>>>> v2-test
    {
        $this->init();

        return isset($this->commands[$name]) || ($this->commandLoader && $this->commandLoader->has($name) && $this->add($this->commandLoader->get($name)));
    }

    /**
     * Returns an array of all unique namespaces used by currently registered commands.
     *
     * It does not return the global namespace which always exists.
     *
     * @return string[] An array of namespaces
     */
    public function getNamespaces()
    {
<<<<<<< HEAD
        $namespaces = array();
        foreach ($this->all() as $command) {
=======
        $namespaces = [];
        foreach ($this->all() as $command) {
            if ($command->isHidden()) {
                continue;
            }

>>>>>>> v2-test
            $namespaces = array_merge($namespaces, $this->extractAllNamespaces($command->getName()));

            foreach ($command->getAliases() as $alias) {
                $namespaces = array_merge($namespaces, $this->extractAllNamespaces($alias));
            }
        }

        return array_values(array_unique(array_filter($namespaces)));
    }

    /**
     * Finds a registered namespace by a name or an abbreviation.
     *
<<<<<<< HEAD
     * @param string $namespace A namespace or abbreviation to search for
     *
     * @return string A registered namespace
     *
     * @throws CommandNotFoundException When namespace is incorrect or ambiguous
     */
    public function findNamespace($namespace)
=======
     * @return string A registered namespace
     *
     * @throws NamespaceNotFoundException When namespace is incorrect or ambiguous
     */
    public function findNamespace(string $namespace)
>>>>>>> v2-test
    {
        $allNamespaces = $this->getNamespaces();
        $expr = preg_replace_callback('{([^:]+|)}', function ($matches) { return preg_quote($matches[1]).'[^:]*'; }, $namespace);
        $namespaces = preg_grep('{^'.$expr.'}', $allNamespaces);

        if (empty($namespaces)) {
            $message = sprintf('There are no commands defined in the "%s" namespace.', $namespace);

            if ($alternatives = $this->findAlternatives($namespace, $allNamespaces)) {
                if (1 == \count($alternatives)) {
                    $message .= "\n\nDid you mean this?\n    ";
                } else {
                    $message .= "\n\nDid you mean one of these?\n    ";
                }

                $message .= implode("\n    ", $alternatives);
            }

<<<<<<< HEAD
            throw new CommandNotFoundException($message, $alternatives);
=======
            throw new NamespaceNotFoundException($message, $alternatives);
>>>>>>> v2-test
        }

        $exact = \in_array($namespace, $namespaces, true);
        if (\count($namespaces) > 1 && !$exact) {
<<<<<<< HEAD
            throw new CommandNotFoundException(sprintf("The namespace \"%s\" is ambiguous.\nDid you mean one of these?\n%s", $namespace, $this->getAbbreviationSuggestions(array_values($namespaces))), array_values($namespaces));
=======
            throw new NamespaceNotFoundException(sprintf("The namespace \"%s\" is ambiguous.\nDid you mean one of these?\n%s.", $namespace, $this->getAbbreviationSuggestions(array_values($namespaces))), array_values($namespaces));
>>>>>>> v2-test
        }

        return $exact ? $namespace : reset($namespaces);
    }

    /**
     * Finds a command by name or alias.
     *
     * Contrary to get, this command tries to find the best
     * match if you give it an abbreviation of a name or alias.
     *
<<<<<<< HEAD
     * @param string $name A command name or a command alias
     *
=======
>>>>>>> v2-test
     * @return Command A Command instance
     *
     * @throws CommandNotFoundException When command name is incorrect or ambiguous
     */
<<<<<<< HEAD
    public function find($name)
    {
        $this->init();

        $aliases = array();
=======
    public function find(string $name)
    {
        $this->init();

        $aliases = [];

        foreach ($this->commands as $command) {
            foreach ($command->getAliases() as $alias) {
                if (!$this->has($alias)) {
                    $this->commands[$alias] = $command;
                }
            }
        }

        if ($this->has($name)) {
            return $this->get($name);
        }

>>>>>>> v2-test
        $allCommands = $this->commandLoader ? array_merge($this->commandLoader->getNames(), array_keys($this->commands)) : array_keys($this->commands);
        $expr = preg_replace_callback('{([^:]+|)}', function ($matches) { return preg_quote($matches[1]).'[^:]*'; }, $name);
        $commands = preg_grep('{^'.$expr.'}', $allCommands);

        if (empty($commands)) {
            $commands = preg_grep('{^'.$expr.'}i', $allCommands);
        }

        // if no commands matched or we just matched namespaces
        if (empty($commands) || \count(preg_grep('{^'.$expr.'$}i', $commands)) < 1) {
            if (false !== $pos = strrpos($name, ':')) {
                // check if a namespace exists and contains commands
                $this->findNamespace(substr($name, 0, $pos));
            }

            $message = sprintf('Command "%s" is not defined.', $name);

            if ($alternatives = $this->findAlternatives($name, $allCommands)) {
<<<<<<< HEAD
=======
                // remove hidden commands
                $alternatives = array_filter($alternatives, function ($name) {
                    return !$this->get($name)->isHidden();
                });

>>>>>>> v2-test
                if (1 == \count($alternatives)) {
                    $message .= "\n\nDid you mean this?\n    ";
                } else {
                    $message .= "\n\nDid you mean one of these?\n    ";
                }
                $message .= implode("\n    ", $alternatives);
            }

<<<<<<< HEAD
            throw new CommandNotFoundException($message, $alternatives);
=======
            throw new CommandNotFoundException($message, array_values($alternatives));
>>>>>>> v2-test
        }

        // filter out aliases for commands which are already on the list
        if (\count($commands) > 1) {
            $commandList = $this->commandLoader ? array_merge(array_flip($this->commandLoader->getNames()), $this->commands) : $this->commands;
<<<<<<< HEAD
            $commands = array_unique(array_filter($commands, function ($nameOrAlias) use ($commandList, $commands, &$aliases) {
                $commandName = $commandList[$nameOrAlias] instanceof Command ? $commandList[$nameOrAlias]->getName() : $nameOrAlias;
=======
            $commands = array_unique(array_filter($commands, function ($nameOrAlias) use (&$commandList, $commands, &$aliases) {
                if (!$commandList[$nameOrAlias] instanceof Command) {
                    $commandList[$nameOrAlias] = $this->commandLoader->get($nameOrAlias);
                }

                $commandName = $commandList[$nameOrAlias]->getName();

>>>>>>> v2-test
                $aliases[$nameOrAlias] = $commandName;

                return $commandName === $nameOrAlias || !\in_array($commandName, $commands);
            }));
        }

<<<<<<< HEAD
        $exact = \in_array($name, $commands, true) || isset($aliases[$name]);
        if (\count($commands) > 1 && !$exact) {
=======
        if (\count($commands) > 1) {
>>>>>>> v2-test
            $usableWidth = $this->terminal->getWidth() - 10;
            $abbrevs = array_values($commands);
            $maxLen = 0;
            foreach ($abbrevs as $abbrev) {
                $maxLen = max(Helper::strlen($abbrev), $maxLen);
            }
<<<<<<< HEAD
            $abbrevs = array_map(function ($cmd) use ($commandList, $usableWidth, $maxLen) {
                if (!$commandList[$cmd] instanceof Command) {
                    return $cmd;
                }
=======
            $abbrevs = array_map(function ($cmd) use ($commandList, $usableWidth, $maxLen, &$commands) {
                if ($commandList[$cmd]->isHidden()) {
                    unset($commands[array_search($cmd, $commands)]);

                    return false;
                }

>>>>>>> v2-test
                $abbrev = str_pad($cmd, $maxLen, ' ').' '.$commandList[$cmd]->getDescription();

                return Helper::strlen($abbrev) > $usableWidth ? Helper::substr($abbrev, 0, $usableWidth - 3).'...' : $abbrev;
            }, array_values($commands));
<<<<<<< HEAD
            $suggestions = $this->getAbbreviationSuggestions($abbrevs);

            throw new CommandNotFoundException(sprintf("Command \"%s\" is ambiguous.\nDid you mean one of these?\n%s", $name, $suggestions), array_values($commands));
        }

        return $this->get($exact ? $name : reset($commands));
=======

            if (\count($commands) > 1) {
                $suggestions = $this->getAbbreviationSuggestions(array_filter($abbrevs));

                throw new CommandNotFoundException(sprintf("Command \"%s\" is ambiguous.\nDid you mean one of these?\n%s.", $name, $suggestions), array_values($commands));
            }
        }

        $command = $this->get(reset($commands));

        if ($command->isHidden()) {
            throw new CommandNotFoundException(sprintf('The command "%s" does not exist.', $name));
        }

        return $command;
>>>>>>> v2-test
    }

    /**
     * Gets the commands (registered in the given namespace if provided).
     *
     * The array keys are the full names and the values the command instances.
     *
<<<<<<< HEAD
     * @param string $namespace A namespace name
     *
     * @return Command[] An array of Command instances
     */
    public function all($namespace = null)
=======
     * @return Command[] An array of Command instances
     */
    public function all(string $namespace = null)
>>>>>>> v2-test
    {
        $this->init();

        if (null === $namespace) {
            if (!$this->commandLoader) {
                return $this->commands;
            }

            $commands = $this->commands;
            foreach ($this->commandLoader->getNames() as $name) {
                if (!isset($commands[$name]) && $this->has($name)) {
                    $commands[$name] = $this->get($name);
                }
            }

            return $commands;
        }

<<<<<<< HEAD
        $commands = array();
=======
        $commands = [];
>>>>>>> v2-test
        foreach ($this->commands as $name => $command) {
            if ($namespace === $this->extractNamespace($name, substr_count($namespace, ':') + 1)) {
                $commands[$name] = $command;
            }
        }

        if ($this->commandLoader) {
            foreach ($this->commandLoader->getNames() as $name) {
                if (!isset($commands[$name]) && $namespace === $this->extractNamespace($name, substr_count($namespace, ':') + 1) && $this->has($name)) {
                    $commands[$name] = $this->get($name);
                }
            }
        }

        return $commands;
    }

    /**
     * Returns an array of possible abbreviations given a set of names.
     *
<<<<<<< HEAD
     * @param array $names An array of names
     *
     * @return array An array of abbreviations
     */
    public static function getAbbreviations($names)
    {
        $abbrevs = array();
=======
     * @return string[][] An array of abbreviations
     */
    public static function getAbbreviations(array $names)
    {
        $abbrevs = [];
>>>>>>> v2-test
        foreach ($names as $name) {
            for ($len = \strlen($name); $len > 0; --$len) {
                $abbrev = substr($name, 0, $len);
                $abbrevs[$abbrev][] = $name;
            }
        }

        return $abbrevs;
    }

<<<<<<< HEAD
    /**
     * Renders a caught exception.
     */
    public function renderException(\Exception $e, OutputInterface $output)
    {
        $output->writeln('', OutputInterface::VERBOSITY_QUIET);

        $this->doRenderException($e, $output);
=======
    public function renderThrowable(\Throwable $e, OutputInterface $output): void
    {
        $output->writeln('', OutputInterface::VERBOSITY_QUIET);

        $this->doRenderThrowable($e, $output);
>>>>>>> v2-test

        if (null !== $this->runningCommand) {
            $output->writeln(sprintf('<info>%s</info>', sprintf($this->runningCommand->getSynopsis(), $this->getName())), OutputInterface::VERBOSITY_QUIET);
            $output->writeln('', OutputInterface::VERBOSITY_QUIET);
        }
    }

<<<<<<< HEAD
    protected function doRenderException(\Exception $e, OutputInterface $output)
=======
    protected function doRenderThrowable(\Throwable $e, OutputInterface $output): void
>>>>>>> v2-test
    {
        do {
            $message = trim($e->getMessage());
            if ('' === $message || OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
<<<<<<< HEAD
                $title = sprintf('  [%s%s]  ', \get_class($e), 0 !== ($code = $e->getCode()) ? ' ('.$code.')' : '');
=======
                $class = get_debug_type($e);
                $title = sprintf('  [%s%s]  ', $class, 0 !== ($code = $e->getCode()) ? ' ('.$code.')' : '');
>>>>>>> v2-test
                $len = Helper::strlen($title);
            } else {
                $len = 0;
            }

<<<<<<< HEAD
            $width = $this->terminal->getWidth() ? $this->terminal->getWidth() - 1 : PHP_INT_MAX;
            // HHVM only accepts 32 bits integer in str_split, even when PHP_INT_MAX is a 64 bit integer: https://github.com/facebook/hhvm/issues/1327
            if (\defined('HHVM_VERSION') && $width > 1 << 31) {
                $width = 1 << 31;
            }
            $lines = array();
            foreach ('' !== $message ? preg_split('/\r?\n/', $message) : array() as $line) {
                foreach ($this->splitStringByWidth($line, $width - 4) as $line) {
                    // pre-format lines to get the right string length
                    $lineLength = Helper::strlen($line) + 4;
                    $lines[] = array($line, $lineLength);
=======
            if (false !== strpos($message, "@anonymous\0")) {
                $message = preg_replace_callback('/[a-zA-Z_\x7f-\xff][\\\\a-zA-Z0-9_\x7f-\xff]*+@anonymous\x00.*?\.php(?:0x?|:[0-9]++\$)[0-9a-fA-F]++/', function ($m) {
                    return class_exists($m[0], false) ? (get_parent_class($m[0]) ?: key(class_implements($m[0])) ?: 'class').'@anonymous' : $m[0];
                }, $message);
            }

            $width = $this->terminal->getWidth() ? $this->terminal->getWidth() - 1 : \PHP_INT_MAX;
            $lines = [];
            foreach ('' !== $message ? preg_split('/\r?\n/', $message) : [] as $line) {
                foreach ($this->splitStringByWidth($line, $width - 4) as $line) {
                    // pre-format lines to get the right string length
                    $lineLength = Helper::strlen($line) + 4;
                    $lines[] = [$line, $lineLength];
>>>>>>> v2-test

                    $len = max($lineLength, $len);
                }
            }

<<<<<<< HEAD
            $messages = array();
=======
            $messages = [];
>>>>>>> v2-test
            if (!$e instanceof ExceptionInterface || OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $messages[] = sprintf('<comment>%s</comment>', OutputFormatter::escape(sprintf('In %s line %s:', basename($e->getFile()) ?: 'n/a', $e->getLine() ?: 'n/a')));
            }
            $messages[] = $emptyLine = sprintf('<error>%s</error>', str_repeat(' ', $len));
            if ('' === $message || OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $messages[] = sprintf('<error>%s%s</error>', $title, str_repeat(' ', max(0, $len - Helper::strlen($title))));
            }
            foreach ($lines as $line) {
                $messages[] = sprintf('<error>  %s  %s</error>', OutputFormatter::escape($line[0]), str_repeat(' ', $len - $line[1]));
            }
            $messages[] = $emptyLine;
            $messages[] = '';

            $output->writeln($messages, OutputInterface::VERBOSITY_QUIET);

            if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $output->writeln('<comment>Exception trace:</comment>', OutputInterface::VERBOSITY_QUIET);

                // exception related properties
                $trace = $e->getTrace();

<<<<<<< HEAD
                for ($i = 0, $count = \count($trace); $i < $count; ++$i) {
                    $class = isset($trace[$i]['class']) ? $trace[$i]['class'] : '';
                    $type = isset($trace[$i]['type']) ? $trace[$i]['type'] : '';
                    $function = $trace[$i]['function'];
                    $file = isset($trace[$i]['file']) ? $trace[$i]['file'] : 'n/a';
                    $line = isset($trace[$i]['line']) ? $trace[$i]['line'] : 'n/a';

                    $output->writeln(sprintf(' %s%s%s() at <info>%s:%s</info>', $class, $type, $function, $file, $line), OutputInterface::VERBOSITY_QUIET);
=======
                array_unshift($trace, [
                    'function' => '',
                    'file' => $e->getFile() ?: 'n/a',
                    'line' => $e->getLine() ?: 'n/a',
                    'args' => [],
                ]);

                for ($i = 0, $count = \count($trace); $i < $count; ++$i) {
                    $class = $trace[$i]['class'] ?? '';
                    $type = $trace[$i]['type'] ?? '';
                    $function = $trace[$i]['function'] ?? '';
                    $file = $trace[$i]['file'] ?? 'n/a';
                    $line = $trace[$i]['line'] ?? 'n/a';

                    $output->writeln(sprintf(' %s%s at <info>%s:%s</info>', $class, $function ? $type.$function.'()' : '', $file, $line), OutputInterface::VERBOSITY_QUIET);
>>>>>>> v2-test
                }

                $output->writeln('', OutputInterface::VERBOSITY_QUIET);
            }
        } while ($e = $e->getPrevious());
    }

    /**
<<<<<<< HEAD
     * Tries to figure out the terminal width in which this application runs.
     *
     * @return int|null
     *
     * @deprecated since version 3.2, to be removed in 4.0. Create a Terminal instance instead.
     */
    protected function getTerminalWidth()
    {
        @trigger_error(sprintf('The "%s()" method is deprecated as of 3.2 and will be removed in 4.0. Create a Terminal instance instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->terminal->getWidth();
    }

    /**
     * Tries to figure out the terminal height in which this application runs.
     *
     * @return int|null
     *
     * @deprecated since version 3.2, to be removed in 4.0. Create a Terminal instance instead.
     */
    protected function getTerminalHeight()
    {
        @trigger_error(sprintf('The "%s()" method is deprecated as of 3.2 and will be removed in 4.0. Create a Terminal instance instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->terminal->getHeight();
    }

    /**
     * Tries to figure out the terminal dimensions based on the current environment.
     *
     * @return array Array containing width and height
     *
     * @deprecated since version 3.2, to be removed in 4.0. Create a Terminal instance instead.
     */
    public function getTerminalDimensions()
    {
        @trigger_error(sprintf('The "%s()" method is deprecated as of 3.2 and will be removed in 4.0. Create a Terminal instance instead.', __METHOD__), E_USER_DEPRECATED);

        return array($this->terminal->getWidth(), $this->terminal->getHeight());
    }

    /**
     * Sets terminal dimensions.
     *
     * Can be useful to force terminal dimensions for functional tests.
     *
     * @param int $width  The width
     * @param int $height The height
     *
     * @return $this
     *
     * @deprecated since version 3.2, to be removed in 4.0. Set the COLUMNS and LINES env vars instead.
     */
    public function setTerminalDimensions($width, $height)
    {
        @trigger_error(sprintf('The "%s()" method is deprecated as of 3.2 and will be removed in 4.0. Set the COLUMNS and LINES env vars instead.', __METHOD__), E_USER_DEPRECATED);

        putenv('COLUMNS='.$width);
        putenv('LINES='.$height);

        return $this;
    }

    /**
=======
>>>>>>> v2-test
     * Configures the input and output instances based on the user arguments and options.
     */
    protected function configureIO(InputInterface $input, OutputInterface $output)
    {
<<<<<<< HEAD
        if (true === $input->hasParameterOption(array('--ansi'), true)) {
            $output->setDecorated(true);
        } elseif (true === $input->hasParameterOption(array('--no-ansi'), true)) {
            $output->setDecorated(false);
        }

        if (true === $input->hasParameterOption(array('--no-interaction', '-n'), true)) {
            $input->setInteractive(false);
        } elseif (\function_exists('posix_isatty')) {
            $inputStream = null;

            if ($input instanceof StreamableInputInterface) {
                $inputStream = $input->getStream();
            }

            // This check ensures that calling QuestionHelper::setInputStream() works
            // To be removed in 4.0 (in the same time as QuestionHelper::setInputStream)
            if (!$inputStream && $this->getHelperSet()->has('question')) {
                $inputStream = $this->getHelperSet()->get('question')->getInputStream(false);
            }

            if (!@posix_isatty($inputStream) && false === getenv('SHELL_INTERACTIVE')) {
                $input->setInteractive(false);
            }
=======
        if (true === $input->hasParameterOption(['--ansi'], true)) {
            $output->setDecorated(true);
        } elseif (true === $input->hasParameterOption(['--no-ansi'], true)) {
            $output->setDecorated(false);
        }

        if (true === $input->hasParameterOption(['--no-interaction', '-n'], true)) {
            $input->setInteractive(false);
>>>>>>> v2-test
        }

        switch ($shellVerbosity = (int) getenv('SHELL_VERBOSITY')) {
            case -1: $output->setVerbosity(OutputInterface::VERBOSITY_QUIET); break;
            case 1: $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE); break;
            case 2: $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE); break;
            case 3: $output->setVerbosity(OutputInterface::VERBOSITY_DEBUG); break;
            default: $shellVerbosity = 0; break;
        }

<<<<<<< HEAD
        if (true === $input->hasParameterOption(array('--quiet', '-q'), true)) {
=======
        if (true === $input->hasParameterOption(['--quiet', '-q'], true)) {
>>>>>>> v2-test
            $output->setVerbosity(OutputInterface::VERBOSITY_QUIET);
            $shellVerbosity = -1;
        } else {
            if ($input->hasParameterOption('-vvv', true) || $input->hasParameterOption('--verbose=3', true) || 3 === $input->getParameterOption('--verbose', false, true)) {
                $output->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
                $shellVerbosity = 3;
            } elseif ($input->hasParameterOption('-vv', true) || $input->hasParameterOption('--verbose=2', true) || 2 === $input->getParameterOption('--verbose', false, true)) {
                $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
                $shellVerbosity = 2;
            } elseif ($input->hasParameterOption('-v', true) || $input->hasParameterOption('--verbose=1', true) || $input->hasParameterOption('--verbose', true) || $input->getParameterOption('--verbose', false, true)) {
                $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
                $shellVerbosity = 1;
            }
        }

        if (-1 === $shellVerbosity) {
            $input->setInteractive(false);
        }

<<<<<<< HEAD
        putenv('SHELL_VERBOSITY='.$shellVerbosity);
=======
        if (\function_exists('putenv')) {
            @putenv('SHELL_VERBOSITY='.$shellVerbosity);
        }
>>>>>>> v2-test
        $_ENV['SHELL_VERBOSITY'] = $shellVerbosity;
        $_SERVER['SHELL_VERBOSITY'] = $shellVerbosity;
    }

    /**
     * Runs the current command.
     *
     * If an event dispatcher has been attached to the application,
     * events are also dispatched during the life-cycle of the command.
     *
     * @return int 0 if everything went fine, or an error code
     */
    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        foreach ($command->getHelperSet() as $helper) {
            if ($helper instanceof InputAwareInterface) {
                $helper->setInput($input);
            }
        }

<<<<<<< HEAD
=======
        if ($command instanceof SignalableCommandInterface) {
            if (!$this->signalRegistry) {
                throw new RuntimeException('Unable to subscribe to signal events. Make sure that the `pcntl` extension is installed and that "pcntl_*" functions are not disabled by your php.ini\'s "disable_functions" directive.');
            }

            if ($this->dispatcher) {
                foreach ($this->signalsToDispatchEvent as $signal) {
                    $event = new ConsoleSignalEvent($command, $input, $output, $signal);

                    $this->signalRegistry->register($signal, function ($signal, $hasNext) use ($event) {
                        $this->dispatcher->dispatch($event, ConsoleEvents::SIGNAL);

                        // No more handlers, we try to simulate PHP default behavior
                        if (!$hasNext) {
                            if (!\in_array($signal, [\SIGUSR1, \SIGUSR2], true)) {
                                exit(0);
                            }
                        }
                    });
                }
            }

            foreach ($command->getSubscribedSignals() as $signal) {
                $this->signalRegistry->register($signal, [$command, 'handleSignal']);
            }
        }

>>>>>>> v2-test
        if (null === $this->dispatcher) {
            return $command->run($input, $output);
        }

        // bind before the console.command event, so the listeners have access to input options/arguments
        try {
            $command->mergeApplicationDefinition();
            $input->bind($command->getDefinition());
        } catch (ExceptionInterface $e) {
            // ignore invalid options/arguments for now, to allow the event listeners to customize the InputDefinition
        }

        $event = new ConsoleCommandEvent($command, $input, $output);
        $e = null;

        try {
<<<<<<< HEAD
            $this->dispatcher->dispatch(ConsoleEvents::COMMAND, $event);
=======
            $this->dispatcher->dispatch($event, ConsoleEvents::COMMAND);
>>>>>>> v2-test

            if ($event->commandShouldRun()) {
                $exitCode = $command->run($input, $output);
            } else {
                $exitCode = ConsoleCommandEvent::RETURN_CODE_DISABLED;
            }
<<<<<<< HEAD
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }
        if (null !== $e) {
            if ($this->dispatcher->hasListeners(ConsoleEvents::EXCEPTION)) {
                $x = $e instanceof \Exception ? $e : new FatalThrowableError($e);
                $event = new ConsoleExceptionEvent($command, $input, $output, $x, $x->getCode());
                $this->dispatcher->dispatch(ConsoleEvents::EXCEPTION, $event);

                if ($x !== $event->getException()) {
                    $e = $event->getException();
                }
            }
            $event = new ConsoleErrorEvent($input, $output, $e, $command);
            $this->dispatcher->dispatch(ConsoleEvents::ERROR, $event);
=======
        } catch (\Throwable $e) {
            $event = new ConsoleErrorEvent($input, $output, $e, $command);
            $this->dispatcher->dispatch($event, ConsoleEvents::ERROR);
>>>>>>> v2-test
            $e = $event->getError();

            if (0 === $exitCode = $event->getExitCode()) {
                $e = null;
            }
        }

        $event = new ConsoleTerminateEvent($command, $input, $output, $exitCode);
<<<<<<< HEAD
        $this->dispatcher->dispatch(ConsoleEvents::TERMINATE, $event);
=======
        $this->dispatcher->dispatch($event, ConsoleEvents::TERMINATE);
>>>>>>> v2-test

        if (null !== $e) {
            throw $e;
        }

        return $event->getExitCode();
    }

    /**
     * Gets the name of the command based on input.
     *
<<<<<<< HEAD
     * @return string The command name
=======
     * @return string|null
>>>>>>> v2-test
     */
    protected function getCommandName(InputInterface $input)
    {
        return $this->singleCommand ? $this->defaultCommand : $input->getFirstArgument();
    }

    /**
     * Gets the default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
<<<<<<< HEAD
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),

            new InputOption('--help', '-h', InputOption::VALUE_NONE, 'Display this help message'),
=======
        return new InputDefinition([
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
            new InputOption('--help', '-h', InputOption::VALUE_NONE, 'Display help for the given command. When no command is given display help for the <info>'.$this->defaultCommand.'</info> command'),
>>>>>>> v2-test
            new InputOption('--quiet', '-q', InputOption::VALUE_NONE, 'Do not output any message'),
            new InputOption('--verbose', '-v|vv|vvv', InputOption::VALUE_NONE, 'Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug'),
            new InputOption('--version', '-V', InputOption::VALUE_NONE, 'Display this application version'),
            new InputOption('--ansi', '', InputOption::VALUE_NONE, 'Force ANSI output'),
            new InputOption('--no-ansi', '', InputOption::VALUE_NONE, 'Disable ANSI output'),
            new InputOption('--no-interaction', '-n', InputOption::VALUE_NONE, 'Do not ask any interactive question'),
<<<<<<< HEAD
        ));
=======
        ]);
>>>>>>> v2-test
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return Command[] An array of default Command instances
     */
    protected function getDefaultCommands()
    {
<<<<<<< HEAD
        return array(new HelpCommand(), new ListCommand());
=======
        return [new HelpCommand(), new ListCommand()];
>>>>>>> v2-test
    }

    /**
     * Gets the default helper set with the helpers that should always be available.
     *
     * @return HelperSet A HelperSet instance
     */
    protected function getDefaultHelperSet()
    {
<<<<<<< HEAD
        return new HelperSet(array(
=======
        return new HelperSet([
>>>>>>> v2-test
            new FormatterHelper(),
            new DebugFormatterHelper(),
            new ProcessHelper(),
            new QuestionHelper(),
<<<<<<< HEAD
        ));
=======
        ]);
>>>>>>> v2-test
    }

    /**
     * Returns abbreviated suggestions in string format.
<<<<<<< HEAD
     *
     * @param array $abbrevs Abbreviated suggestions to convert
     *
     * @return string A formatted string of abbreviated suggestions
     */
    private function getAbbreviationSuggestions($abbrevs)
=======
     */
    private function getAbbreviationSuggestions(array $abbrevs): string
>>>>>>> v2-test
    {
        return '    '.implode("\n    ", $abbrevs);
    }

    /**
     * Returns the namespace part of the command name.
     *
     * This method is not part of public API and should not be used directly.
     *
<<<<<<< HEAD
     * @param string $name  The full name of the command
     * @param string $limit The maximum number of parts of the namespace
     *
     * @return string The namespace of the command
     */
    public function extractNamespace($name, $limit = null)
    {
        $parts = explode(':', $name);
        array_pop($parts);
=======
     * @return string The namespace of the command
     */
    public function extractNamespace(string $name, int $limit = null)
    {
        $parts = explode(':', $name, -1);
>>>>>>> v2-test

        return implode(':', null === $limit ? $parts : \array_slice($parts, 0, $limit));
    }

    /**
     * Finds alternative of $name among $collection,
     * if nothing is found in $collection, try in $abbrevs.
     *
<<<<<<< HEAD
     * @param string   $name       The string
     * @param iterable $collection The collection
     *
     * @return string[] A sorted array of similar string
     */
    private function findAlternatives($name, $collection)
    {
        $threshold = 1e3;
        $alternatives = array();

        $collectionParts = array();
=======
     * @return string[] A sorted array of similar string
     */
    private function findAlternatives(string $name, iterable $collection): array
    {
        $threshold = 1e3;
        $alternatives = [];

        $collectionParts = [];
>>>>>>> v2-test
        foreach ($collection as $item) {
            $collectionParts[$item] = explode(':', $item);
        }

        foreach (explode(':', $name) as $i => $subname) {
            foreach ($collectionParts as $collectionName => $parts) {
                $exists = isset($alternatives[$collectionName]);
                if (!isset($parts[$i]) && $exists) {
                    $alternatives[$collectionName] += $threshold;
                    continue;
                } elseif (!isset($parts[$i])) {
                    continue;
                }

                $lev = levenshtein($subname, $parts[$i]);
                if ($lev <= \strlen($subname) / 3 || '' !== $subname && false !== strpos($parts[$i], $subname)) {
                    $alternatives[$collectionName] = $exists ? $alternatives[$collectionName] + $lev : $lev;
                } elseif ($exists) {
                    $alternatives[$collectionName] += $threshold;
                }
            }
        }

        foreach ($collection as $item) {
            $lev = levenshtein($name, $item);
            if ($lev <= \strlen($name) / 3 || false !== strpos($item, $name)) {
                $alternatives[$item] = isset($alternatives[$item]) ? $alternatives[$item] - $lev : $lev;
            }
        }

        $alternatives = array_filter($alternatives, function ($lev) use ($threshold) { return $lev < 2 * $threshold; });
<<<<<<< HEAD
        ksort($alternatives, SORT_NATURAL | SORT_FLAG_CASE);
=======
        ksort($alternatives, \SORT_NATURAL | \SORT_FLAG_CASE);
>>>>>>> v2-test

        return array_keys($alternatives);
    }

    /**
     * Sets the default Command name.
     *
<<<<<<< HEAD
     * @param string $commandName     The Command name
     * @param bool   $isSingleCommand Set to true if there is only one command in this application
     *
     * @return self
     */
    public function setDefaultCommand($commandName, $isSingleCommand = false)
=======
     * @return self
     */
    public function setDefaultCommand(string $commandName, bool $isSingleCommand = false)
>>>>>>> v2-test
    {
        $this->defaultCommand = $commandName;

        if ($isSingleCommand) {
            // Ensure the command exist
            $this->find($commandName);

            $this->singleCommand = true;
        }

        return $this;
    }

<<<<<<< HEAD
    private function splitStringByWidth($string, $width)
=======
    /**
     * @internal
     */
    public function isSingleCommand(): bool
    {
        return $this->singleCommand;
    }

    private function splitStringByWidth(string $string, int $width): array
>>>>>>> v2-test
    {
        // str_split is not suitable for multi-byte characters, we should use preg_split to get char array properly.
        // additionally, array_slice() is not enough as some character has doubled width.
        // we need a function to split string not by character count but by string width
        if (false === $encoding = mb_detect_encoding($string, null, true)) {
            return str_split($string, $width);
        }

        $utf8String = mb_convert_encoding($string, 'utf8', $encoding);
<<<<<<< HEAD
        $lines = array();
        $line = '';
        foreach (preg_split('//u', $utf8String) as $char) {
            // test if $char could be appended to current line
            if (mb_strwidth($line.$char, 'utf8') <= $width) {
                $line .= $char;
                continue;
            }
            // if not, push current line to array and make new line
            $lines[] = str_pad($line, $width);
            $line = $char;
=======
        $lines = [];
        $line = '';

        $offset = 0;
        while (preg_match('/.{1,10000}/u', $utf8String, $m, 0, $offset)) {
            $offset += \strlen($m[0]);

            foreach (preg_split('//u', $m[0]) as $char) {
                // test if $char could be appended to current line
                if (mb_strwidth($line.$char, 'utf8') <= $width) {
                    $line .= $char;
                    continue;
                }
                // if not, push current line to array and make new line
                $lines[] = str_pad($line, $width);
                $line = $char;
            }
>>>>>>> v2-test
        }

        $lines[] = \count($lines) ? str_pad($line, $width) : $line;

        mb_convert_variables($encoding, 'utf8', $lines);

        return $lines;
    }

    /**
     * Returns all namespaces of the command name.
     *
<<<<<<< HEAD
     * @param string $name The full name of the command
     *
     * @return string[] The namespaces of the command
     */
    private function extractAllNamespaces($name)
    {
        // -1 as third argument is needed to skip the command short name when exploding
        $parts = explode(':', $name, -1);
        $namespaces = array();
=======
     * @return string[] The namespaces of the command
     */
    private function extractAllNamespaces(string $name): array
    {
        // -1 as third argument is needed to skip the command short name when exploding
        $parts = explode(':', $name, -1);
        $namespaces = [];
>>>>>>> v2-test

        foreach ($parts as $part) {
            if (\count($namespaces)) {
                $namespaces[] = end($namespaces).':'.$part;
            } else {
                $namespaces[] = $part;
            }
        }

        return $namespaces;
    }

    private function init()
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        foreach ($this->getDefaultCommands() as $command) {
            $this->add($command);
        }
    }
}
