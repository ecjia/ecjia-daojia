<?php


namespace Royalcms\Component\Database;

use Illuminate\Database\MySqlConnection as LaravelMySqlConnection;
use Royalcms\Component\Database\Schema\Grammars\MySqlGrammar;
use Royalcms\Component\Database\Schema\MySqlBuilder as SchemaBuilder;
use Royalcms\Component\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use PDO;
use Royalcms\Component\Database\Query\Builder as QueryBuilder;

class MySqlConnection extends LaravelMySqlConnection
{

    /**
     * The default fetch mode of the connection.
     *
     * @var int
     */
    protected $fetchMode = PDO::FETCH_ASSOC;

    /**
     * Get the default query grammar instance.
     *
     * @return \Royalcms\Component\Database\Query\Grammars\MySqlGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Schema\Grammars\Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new MySqlGrammar());
    }

    /**
     * Get a new query builder instance.
     *
     * @return \Royalcms\Component\Database\Query\Builder
     */
    public function query()
    {
        return new QueryBuilder(
            $this, $this->getQueryGrammar(), $this->getPostProcessor()
        );
    }

    /**
     * Get the default fetch mode for the connection.
     *
     * @return int
     */
    public function getFetchMode()
    {
        return $this->fetchMode;
    }

    /**
     * Set the default fetch mode for the connection.
     *
     * @param  int  $fetchMode
     * @return int
     */
    public function setFetchMode($fetchMode)
    {
        $this->fetchMode = $fetchMode;
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new SchemaBuilder($this);
    }

    /**
     * Get the table with prefix full table name for the connection.
     *
     * @todo royalcms
     * @return string
     */
    public function getTableFullName($table)
    {
        return $this->tablePrefix . $table;
    }

}