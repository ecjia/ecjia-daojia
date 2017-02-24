<?php namespace Royalcms\Component\Database;

use Doctrine\DBAL\Driver\PDOPgSql\Driver as DoctrineDriver;
use Royalcms\Component\Database\Query\Processors\PostgresProcessor;
use Royalcms\Component\Database\Query\Grammars\PostgresGrammar as QueryGrammar;
use Royalcms\Component\Database\Schema\Grammars\PostgresGrammar as SchemaGrammar;

class PostgresConnection extends Connection {

	/**
	 * Get the default query grammar instance.
	 *
	 * @return \Royalcms\Component\Database\Query\Grammars\PostgresGrammar
	 */
	protected function getDefaultQueryGrammar()
	{
		return $this->withTablePrefix(new QueryGrammar);
	}

	/**
	 * Get the default schema grammar instance.
	 *
	 * @return \Royalcms\Component\Database\Schema\Grammars\PostgresGrammar
	 */
	protected function getDefaultSchemaGrammar()
	{
		return $this->withTablePrefix(new SchemaGrammar);
	}

	/**
	 * Get the default post processor instance. 
	 *
	 * @return \Royalcms\Component\Database\Query\Processors\PostgresProcessor
	 */
	protected function getDefaultPostProcessor()
	{
		return new PostgresProcessor;
	}

	/**
	 * Get the Doctrine DBAL driver.
	 *
	 * @return \Doctrine\DBAL\Driver\PDOPgSql\Driver
	 */
	protected function getDoctrineDriver()
	{
		return new DoctrineDriver;
	}

}
