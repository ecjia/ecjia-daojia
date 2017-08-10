<?php 

namespace Royalcms\Component\Database\Connectors;

use PDO;

class MySqlConnector extends Connector implements ConnectorInterface {

	/**
	 * Establish a database connection.
	 *
	 * @param  array  $config
	 * @return \PDO
	 */
	public function connect(array $config)
	{
		$dsn = $this->getDsn($config);

		// We need to grab the PDO options that should be used while making the brand
		// new connection instance. The PDO options control various aspects of the
		// connection's behavior, and some might be specified by the developers.
		$options = $this->getOptions($config);

		$connection = $this->createConnection($dsn, $config, $options);
		
		if (! empty($config['database'])) {
		    $connection->exec("use `{$config['database']}`;");
		}

		$collation = $config['collation'];

		// Next we will set the "names" and "collation" on the clients connections so
		// a correct character set will be used by this client. The collation also
		// is set on the server but needs to be set here on this client objects.
		if (isset($config['charset'])) {
		    $charset = $config['charset'];
		
		    $names = "set names '{$charset}'".
		        (! is_null($collation) ? " collate '{$collation}'" : '');
		
		    $connection->prepare($names)->execute();
		}
		
		// Next, we will check to see if a timezone has been specified in this config
		// and if it has we will issue a statement to modify the timezone with the
		// database. Setting this DB timezone is an optional configuration item.
		if (isset($config['timezone'])) {
		    $connection->prepare(
		        'set time_zone="'.$config['timezone'].'"'
		    )->execute();
		}
		
		// If the "strict" option has been configured for the connection we'll enable
		// strict mode on all of these tables. This enforces some extra rules when
		// using the MySQL database system and is a quicker way to enforce them.
		$this->setModes($connection, $config);

		return $connection;
	}
	
	/**
	 * Create a DSN string from a configuration.
	 *
	 * Chooses socket or host/port based on the 'unix_socket' config value.
	 *
	 * @param  array   $config
	 * @return string
	 */
	protected function getDsn(array $config)
	{
	    return $this->configHasSocket($config) ? $this->getSocketDsn($config) : $this->getHostDsn($config);
	}
	
	/**
	 * Determine if the given configuration array has a UNIX socket value.
	 *
	 * @param  array  $config
	 * @return bool
	 */
	protected function configHasSocket(array $config)
	{
	    // Sometimes the developer may specify the specific UNIX socket that should
	    // be used. If that is the case we will add that option to the string we
	    // have created so that it gets utilized while the connection is made.
	    return isset($config['unix_socket']) && ! empty($config['unix_socket']);
	}
	
	/**
	 * Get the DSN string for a socket configuration.
	 *
	 * @param  array  $config
	 * @return string
	 */
	protected function getSocketDsn(array $config)
	{
	    return "mysql:unix_socket={$config['unix_socket']};dbname={$config['database']}";
    }
	
    /**
     * Get the DSN string for a host / port configuration.
     *
     * @param  array  $config
     * @return string
     */
     protected function getHostDsn(array $config)
     {
         $host = $database = $port = null;
         
         // First we will create the basic DSN setup as well as the port if it is in
         // in the configuration options. This will give us the basic DSN we will
         // need to establish the PDO connections and return them back for use.
	     extract($config, EXTR_IF_EXISTS);
	
	     return isset($port)
                	     ? "mysql:host={$host};port={$port};dbname={$database}"
                	     : "mysql:host={$host};dbname={$database}";
     }
	
     /**
      * Set the modes for the connection.
      *
      * @param  \PDO  $connection
      * @param  array  $config
      * @return void
      */
      protected function setModes(PDO $connection, array $config)
      {
          // If the "strict" option has been configured for the connection we'll enable
          // strict mode on all of these tables. This enforces some extra rules when
          // using the MySQL database system and is a quicker way to enforce them.
	      if (isset($config['modes'])) {
	          $modes = implode(',', $config['modes']);
	
              $connection->prepare("set session sql_mode='{$modes}'")->execute();
          } elseif (isset($config['strict'])) {
            if ($config['strict']) {
                  $connection->prepare("set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'")->execute();
            } else {
                $connection->prepare("set session sql_mode='NO_ENGINE_SUBSTITUTION'")->execute();
            }
        }
    }

}
