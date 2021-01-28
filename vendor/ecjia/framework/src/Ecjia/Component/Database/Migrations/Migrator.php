<?php

namespace Ecjia\Component\Database\Migrations;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    /**
     * Run the outstanding migrations at a given path.
     *
     * @param  string|array  $paths
     * @param  bool    $pretend
     * @return void
     */
    public function runLimiting($paths, $limit = 20)
    {
        $files = $this->getMigrationFiles($paths);

        // Once we grab all of the migration files for the path, we will compare them
        // against the migrations that have already been run for this package then
        // run each of the outstanding migrations against a database connection.
        $ran = $this->repository->getRan();

        $migrations = $this->pendingMigrations($files, $ran);

        $this->requireFiles($migrations);

        $this->runMigrationList($migrations, $limit);

        return $migrations;
    }


    /**
     * Run an array of migrations.
     *
     * @param  array  $migrations
     * @param  bool   $pretend
     * @return void
     */
    public function runMigrationList($migrations, $limit = 20)
    {
        // First we will just make sure that there are any migrations to run. If there
        // aren't, we will just make a note of it to the developer so they're aware
        // that all of the migrations have been run against this database system.
        if (count($migrations) == 0)
        {
            $this->note('<info>Nothing to migrate.</info>');

            return;
        }

        $batch = $this->repository->getNextBatchNumber();

        $pretend = false;

        $migrations = array_chunk($migrations, $limit);

        $migrations = array_shift($migrations);

        // Once we have the array of migrations, we will spin through them and run the
        // migrations "up" so the changes are made to the databases. We'll then log
        // that the migration was run so we don't repeat it next time we execute.
        foreach ($migrations as $file)
        {
            $this->runUp($file, $batch, $pretend);
        }
    }

}