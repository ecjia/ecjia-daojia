<?php namespace Royalcms\Component\DbExporter;

use Royalcms\Component\Support\Facades\DB;

abstract class DbExporter
{
    /**
     * Contains the ignore tables
     * @var array $ignore
     */
    public static $ignore = array('migrations');
    public static $remote;

    /**
     * Get all the tables
     * @return mixed
     */
    protected function getTables()
    {
        $pdo = DB::connection()->getPdo();
        return $pdo->query('SELECT table_name FROM information_schema.tables WHERE table_schema="' . $this->database . '"');
    }

    public function getTableIndexes($table)
    {
        $pdo = DB::connection()->getPdo();
        return $pdo->query('SHOW INDEX FROM ' . $table . ' WHERE Key_name != "PRIMARY"');
    }

    /**
     * Get all the columns for a given table
     * @param $table
     * @return mixed
     */
    protected function getTableDescribes($table)
    {
        return DB::table(DB::raw('information_schema.columns'))
            ->where('table_schema', '=', $this->database)
            ->where('table_name', '=', $table)
            ->get($this->selects);
    }

    /**
     * Grab all the table data
     * @param $table
     * @return mixed
     */
    protected function getTableData($table)
    {
        return DB::table($table)->get();
    }

    /**
     * Write the file
     * @return mixed
     */
    abstract public function write();

    /**
     * Convert the database to a usefull format
     * @param null $database
     * @return mixed
     */
    abstract public function convert($database = null);

    /**
     * Put the converted stub into a template
     * @return mixed
     */
    abstract protected function compile();
}
