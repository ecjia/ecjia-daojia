<?php namespace Royalcms\Component\Debugbar\Console;

use DebugBar\DebugBar;
use Royalcms\Component\Console\Command;

class ClearCommand extends Command
{
    protected $name = 'debugbar:clear';
    protected $description = 'Clear the Debugbar Storage';
    protected $debugbar;

    public function __construct(DebugBar $debugbar)
    {
        $this->debugbar = $debugbar;

        parent::__construct();
    }

    public function fire()
    {
        if (($storage = $this->debugbar->getStorage()) !== false) {
            $storage->clear();
            $this->info('Debugbar Storage cleared!');
        } else {
            $this->error('No Debugbar Storage found..');
        }
    }
}
