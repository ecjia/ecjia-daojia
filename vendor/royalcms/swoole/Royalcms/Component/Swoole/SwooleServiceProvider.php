<?php

namespace Royalcms\Component\Swoole;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Swoole\Console\SwooleCommand;

class SwooleServiceProvider extends ServiceProvider
{
    protected $commands = [
        'command.swoole'
    ];

    public function boot()
    {
        $this->package('royalcms/swoole');
    }

    public function register()
    {
        $this->royalcms->singleton('command.swoole', function ($royalcms) {
            return new SwooleCommand();
        });
        
        $this->commands('command.swoole');
    }

}