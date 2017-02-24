<?php namespace Royalcms\Component\DbExporter;

class DbExportHandler
{
    /**
     * @var DbMigrations
     */
    protected $migrator;

    /**
     * @var DbSeeding
     */
    protected $seeder;

    /**
     * Inject the DbMigrations class
     * @param DbMigrations $DbMigrations
     * @param DbSeeding $DbSeeding
     */
    function __construct(DbMigrations $DbMigrations, DbSeeding $DbSeeding)
    {
        $this->migrator = $DbMigrations;
        $this->seeder = $DbSeeding;
    }

    /**
     * Create migrations from the given DB
     * @param String null $database
     * @return $this
     */
    public function migrate($database = null)
    {
        $this->migrator->convert($database)->write();

        return $this;
    }

    /**
     * @param null $database
     * @return $this
     */
    public function seed($database = null)
    {
        $this->seeder->convert($database)->write();

        return $this;
    }

    /**
     * Helper function to generate the migration and the seed in one command
     * @param null $database
     * @return $this
     */
    public function migrateAndSeed($database = null)
    {
        // Run the migrator generator
        $this->migrator->convert($database)->write();

        // Run the seeder generator
        $this->seeder->convert($database)->write();

        return $this;
    }

    /**
     * Add tables to the ignore array
     * @param $tables
     * @return $this
     */
    public function ignore($tables)
    {
        DbExporter::$ignore = array_merge(DbExporter::$ignore, (array)$tables);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMigrationsFilePath()
    {
        return DbMigrations::$filePath;
    }

    public function uploadTo($remote)
    {
        DbExporter::$remote = $remote;

        return $this;
    }

}

