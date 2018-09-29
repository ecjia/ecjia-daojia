<?php

namespace Royalcms\Component\Swoole;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Swoole\Foundation\Console\SwooleCommand;

class SwooleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->package('royalcms/swoole');
    }

    public function register()
    {
        $this->commands(SwooleCommand::class);
    }

}