<?php

namespace Royalcms\Component\Database\Console\Migrations;

use Royalcms\Component\Console\Command;

class BaseCommand extends Command
{
    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->royalcms->databasePath().'/migrations';
    }
}
