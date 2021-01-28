<?php

namespace Royalcms\Component\Auth\Console;

use Royalcms\Component\Console\Command;

class ClearResetsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'auth:clear-resets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush expired password reset tokens';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->royalcms['auth.password.tokens']->deleteExpired();

        $this->info('Expired reset tokens cleared!');
    }
}
