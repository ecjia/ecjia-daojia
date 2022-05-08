<?php

namespace Royalcms\Component\Foundation\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Foundation\Composer;
use Royalcms\Component\Foundation\Optimize\ClassAliasLoader;
use Royalcms\Component\Foundation\Optimize\ClassPreloader;
use Royalcms\Component\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('composer', function ($royalcms) {
            return new Composer($royalcms['files'], $royalcms->basePath());
        });

        $this->royalcms->alias('composer', Composer::class);

        $this->royalcms->singleton('classpreloader', function ($royalcms) {
            return new ClassPreloader($royalcms);
        });

        $this->royalcms->singleton('classaliasloader', function ($royalcms) {
            return new ClassAliasLoader($royalcms);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Composer::class,
            'composer',
            'classpreloader'
        ];
    }
}
