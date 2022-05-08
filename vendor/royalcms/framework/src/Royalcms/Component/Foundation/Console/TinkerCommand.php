<?php

namespace Royalcms\Component\Foundation\Console;

use Psy\Shell;
use Psy\Configuration;
use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class TinkerCommand extends Command
{
    /**
     * artisan commands to include in the tinker shell.
     *
     * @var array
     */
    protected $commandWhitelist = [
        'clear-compiled', 'down', 'env', 'inspire', 'migrate', 'optimize', 'up',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tinker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interact with your application';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->getApplication()->setCatchExceptions(false);

        $config = new Configuration;

        $config->getPresenter()->addCasters(
            $this->getCasters()
        );

        $shell = new Shell($config);
        $shell->addCommands($this->getCommands());
        $shell->setIncludes($this->argument('include'));

        $shell->run();
    }

    /**
     * Get artisan commands to pass through to PsySH.
     *
     * @return array
     */
    protected function getCommands()
    {
        $commands = [];

        foreach ($this->getApplication()->all() as $name => $command) {
            if (in_array($name, $this->commandWhitelist)) {
                $commands[] = $command;
            }
        }

        return $commands;
    }

    /**
     * Get an array of Laravel tailored casters.
     *
     * @return array
     */
    protected function getCasters()
    {
        return [
            'Royalcms\Component\Foundation\Royalcms' => 'Royalcms\Component\Foundation\Console\RoyalcmsCaster::castApplication',
            'Royalcms\Component\Support\Collection' => 'Royalcms\Component\Foundation\Console\RoyalcmsCaster::castCollection',
            'Royalcms\Component\Database\Eloquent\Model' => 'Royalcms\Component\Foundation\Console\RoyalcmsCaster::castModel',
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['include', InputArgument::IS_ARRAY, 'Include file(s) before starting tinker'],
        ];
    }
}
