<?php

namespace Royalcms\Component\Foundation\Console;


use Royalcms\Component\Console\Command;
use Royalcms\Component\Foundation\Optimize\ClassAliasLoader;

class OptimizeAliasCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'optimize:alias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the framework for better performance';

    /**
     * The class Pre Loader instance.
     *
     * @var \Royalcms\Component\Foundation\Optimize\ClassAliasLoader
     */
    protected $loader;

    /**
     * Create a new optimize command instance.
     *
     * @param  \Royalcms\Component\Foundation\Composer  $composer
     * @return void
     */
    public function __construct(ClassAliasLoader $loader)
    {
        parent::__construct();

        $this->loader = $loader;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Generating optimized class alias loader');

        $this->loader->compile();
    }

}
