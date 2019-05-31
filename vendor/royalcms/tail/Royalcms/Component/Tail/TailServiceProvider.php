<?php

namespace Royalcms\Component\Tail;

use Royalcms\Component\Support\ServiceProvider;

class TailServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        if ($this->royalcms->runningInConsole()) {
            $this->commands([
                TailCommand::class,
            ]);
        }
    }

    public function provides()
    {
        return [
            TailCommand::class,
        ];
    }
}
