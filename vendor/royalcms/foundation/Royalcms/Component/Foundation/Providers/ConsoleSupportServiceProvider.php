<?php

namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Royalcms\Component\Console\ScheduleServiceProvider',
        'Royalcms\Component\Database\MigrationServiceProvider',
        'Royalcms\Component\Database\SeedServiceProvider',
        'Royalcms\Component\Foundation\Providers\ComposerServiceProvider',
        'Royalcms\Component\Queue\ConsoleServiceProvider',
        'Royalcms\Component\Routing\GeneratorServiceProvider',
        'Royalcms\Component\Session\CommandsServiceProvider',
    ];
}
