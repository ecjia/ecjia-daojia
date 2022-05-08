<?php

namespace Royalcms\Component\Console;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ProcessUtils;
use Royalcms\Component\Contracts\Events\Dispatcher;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Console\Application as LaravelApplication;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Illuminate\Console\Command as LaravelCommand;
use Royalcms\Component\Contracts\Console\Royalcms as RoyalcmsContract;
use Symfony\Component\Process\PhpExecutableFinder;

class Royalcms extends LaravelApplication implements RoyalcmsContract
{
    /**
     * The Royalcms application instance.
     *
     * @var \Royalcms\Component\Contracts\Container\Container
     */
    protected $royalcms;

//    /**
//     * The output from the previous command.
//     *
//     * @var \Symfony\Component\Console\Output\BufferedOutput
//     */
//    protected $lastOutput;

    /**
     * Create a new Artisan console application.
     *
     * @param  \Royalcms\Component\Contracts\Container\Container  $royalcms
     * @param  \Royalcms\Component\Contracts\Events\Dispatcher  $events
     * @param  string  $version
     * @return void
     */
    public function __construct(Container $royalcms, Dispatcher $events, $version)
    {
        $this->royalcms = $royalcms;

        parent::__construct($royalcms, $events, $version);

        $this->setName('Royalcms Framework');

        $events->fire('royalcms.start', [$this]);
    }

    /**
     * Determine the proper PHP executable.
     *
     * @return string
     */
    public static function phpBinary()
    {
        return ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));
    }

    /**
     * Determine the proper Artisan executable.
     *
     * @return string
     */
    public static function artisanBinary()
    {
        return defined('ARTISAN_BINARY') ? ProcessUtils::escapeArgument(ARTISAN_BINARY) : config('system.binary', 'royalcms');
    }

    /**
     * Format the given command as a fully-qualified executable command.
     *
     * @param  string  $string
     * @return string
     */
    public static function formatCommandString($string)
    {
        return sprintf('%s %s %s', static::phpBinary(), static::artisanBinary(), $string);
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        $parameters = collect($parameters)->prepend($command);

        $this->lastOutput = new BufferedOutput;

        $this->setCatchExceptions(false);

        $result = $this->run(new ArrayInput($parameters->toArray()), $this->lastOutput);

        $this->setCatchExceptions(true);

        return $result;
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        return $this->lastOutput ? $this->lastOutput->fetch() : '';
    }

    /**
     * Add a command to the console.
     *
     * @param  \Symfony\Component\Console\Command\Command  $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function add(SymfonyCommand $command)
    {
        if ($command instanceof Command) {
            $command->setRoyalcms($this->royalcms);
        }
        elseif ($command instanceof LaravelCommand) {
            $command->setLaravel($this->royalcms);
        }
        return $this->addToParent($command);
    }

    /**
     * Add the command to the parent instance.
     *
     * @param  \Symfony\Component\Console\Command\Command  $command
     * @return \Symfony\Component\Console\Command\Command
     */
    protected function addToParent(SymfonyCommand $command)
    {
        return parent::addToParent($command);
    }

    /**
     * Add a command, resolving through the application.
     *
     * @param  string  $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function resolve($command)
    {
        return $this->add($this->royalcms->make($command));
    }

    /**
     * Resolve an array of commands through the application.
     *
     * @param  array|mixed  $commands
     * @return $this
     */
    public function resolveCommands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        foreach ($commands as $command) {
            $this->resolve($command);
        }

        return $this;
    }

    /**
     * Get the default input definitions for the applications.
     *
     * This is used to add the --env option to every available command.
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $definition->addOption($this->getEnvironmentOption());

        return $definition;
    }

    /**
     * Get the global environment option for the definition.
     *
     * @return \Symfony\Component\Console\Input\InputOption
     */
    protected function getEnvironmentOption()
    {
        $message = 'The environment the command should run under.';

        return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
    }

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getRoyalcms()
    {
        return $this->royalcms;
    }
}
