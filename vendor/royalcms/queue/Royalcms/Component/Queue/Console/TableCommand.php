<?php

namespace Royalcms\Component\Queue\Console;

use Royalcms\Component\Support\Str;
use Royalcms\Component\Console\Command;
use Royalcms\Component\Foundation\Composer;
use Royalcms\Component\Filesystem\Filesystem;

class TableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the queue jobs database table';

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Royalcms\Component\Foundation\Composer
     */
    protected $composer;

    /**
     * Create a new queue job table command instance.
     *
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  \Royalcms\Component\Foundation\Composer    $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $table = $this->royalcms['config']['queue.connections.database.table'];

        $tableClassName = Str::studly($table);

        $fullPath = $this->createBaseMigration($table);

        $stub = str_replace(
            ['{{table}}', '{{tableClassName}}'], [$table, $tableClassName], $this->files->get(__DIR__.'/stubs/jobs.stub')
        );

        $this->files->put($fullPath, $stub);

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @param  string  $table
     * @return string
     */
    protected function createBaseMigration($table = 'jobs')
    {
        $name = 'create_'.$table.'_table';

        $path = $this->royalcms->databasePath().'/migrations';

        return $this->royalcms['migration.creator']->create($name, $path);
    }
}
