<?php

namespace Royalcms\Component\SmartyView;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class SmartyConsoleServiceProvider
 *
 */
class SmartyConsoleServiceProvider extends ServiceProvider
{
    /** @var bool  */
    protected $defer = true;

    /**
     * @return void
     */
    public function boot()
    {
        // register commands
        $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.smarty.clear.compiled',
            'command.smarty.clear.cache',
            'command.smarty.optimize',
            'command.smarty.info',
        ];
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        // Package Info command
        $this->royalcms->singleton('command.smarty.info', function () {
            return new Console\PackageInfoCommand;
        });

        // cache clear
        $this->royalcms->singleton('command.smarty.clear.cache', function ($royalcms) {
            return new Console\CacheClearCommand($royalcms['smarty.view']->getSmarty());
        });

        // clear compiled
        $this->royalcms->singleton('command.smarty.clear.compiled', function ($royalcms) {
            return new Console\ClearCompiledCommand($royalcms['smarty.view']->getSmarty());
        });

        // clear compiled
        $this->royalcms->singleton('command.smarty.optimize', function ($royalcms) {
            return new Console\OptimizeCommand($royalcms['smarty.view']->getSmarty(), $royalcms['config']);
        });

        $this->commands(
            [
                'command.smarty.clear.compiled',
                'command.smarty.clear.cache',
                'command.smarty.optimize',
                'command.smarty.info',
            ]
        );
    }
}
