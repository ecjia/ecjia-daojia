<?php namespace Royalcms\Component\DbExporter;

use Royalcms\Component\Support\Facades\Config;
use Royalcms\Component\Support\Facades\File;
use Royalcms\Component\Support\Str;
use Royalcms\Component\DbExporter\Exceptions\InvalidDatabaseException;

class DbMigrations extends DbExporter
{
    protected $database;

    protected $selects = array(
        'column_name as Field',
        'column_type as Type',
        'is_nullable as Null',
        'column_key as Key',
        'column_default as Default',
        'extra as Extra',
        'data_type as Data_Type'
    );

    protected $schema;

    protected $customDb = false;

    public static $filePath;

    /**
     * Set the database name
     * @param String $database
     * @throw InvalidDatabaseException
     */
    function __construct($database)
    {
        if (empty($database)) {
            throw new InvalidDatabaseException('No database set in app/config/database.php');
        }

        $this->database = $database;
    }

    /**
     * Write the prepared migration to a file
     */
    public function write()
    {
        // Check if convert method was called before
        // If not, call it on default DB
        if (!$this->customDb) {
            $this->convert();
        }

        $schema = $this->compile();
        $filename = date('Y_m_d_His') . "_create_" . $this->database . "_database.php";
        self::$filePath = Config::get('db-exporter.export_path.migrations')."{$filename}";

        file_put_contents(self::$filePath, $schema);

        return self::$filePath;
    }

    /**
     * Convert the database to migrations
     * If none is given, use de DB from condig/database.php
     * @param null $database
     * @return $this
     */
    public function convert($database = null)
    {
        if (!is_null($database)) {
            $this->database = $database;
            $this->customDb = true;
        }

        $tables = $this->getTables();
        
        // Loop over the tables
        foreach ($tables as $key => $value) {
            // Do not export the ignored tables
            if (in_array($value['table_name'], self::$ignore)) {
                continue;
            }

            $down = "Schema::drop('{$value['table_name']}');";
            $up = "Schema::create('{$value['table_name']}', function(Blueprint $" . "table) {\n";

            $tableDescribes = $this->getTableDescribes($value['table_name']);
            // Loop over the tables fields
            foreach ($tableDescribes as $values) {
                $method = "";
                $para = strpos($values->Type, '(');
                $type = $para > -1 ? substr($values->Type, 0, $para) : $values->Type;
                $numbers = "";
                $nullable = $values->Null == "NO" ? "" : "->nullable()";
                $default = empty($values->Default) ? "" : "->default('".$values->Default."')";
                $unsigned = strpos($values->Type, "unsigned") === false ? '' : '->unsigned()';

                switch ($type) {
                    case 'int' :
                        $method = 'integer';
                        break;
                    case 'smallint' :
                        $method = 'smallInteger';
                        break;
                    case 'bigint' :
                        $method = 'bigInteger';
                        break;
                    case 'char' :
                    case 'varchar' :
                        $para = strpos($values->Type, '(');
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'string';
                        break;
                    case 'float' :
                        $method = 'float';
                        break;
                    case 'double' :
                        $para = strpos($values->Type, '('); # 6
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'double';
                        break;
                    case 'decimal' :
                        $para = strpos($values->Type, '(');
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'decimal';
                        break;
                    case 'tinyint' :
                        $method = 'boolean';
                        break;
                    case 'date' :
                        $method = 'date';
                        break;
                    case 'timestamp' :
                        $method = 'timestamp';
                        break;
                    case 'datetime' :
                        $method = 'dateTime';
                        break;
                    case 'time' :
                        $method = 'time';
                        break;
                    case 'longtext' :
                        $method = 'longText';
                        break;
                    case 'mediumtext' :
                        $method = 'mediumText';
                        break;
                    case 'text' :
                        $method = 'text';
                        break;
                    case 'longblob':
                    case 'blob' :
                        $method = 'binary';
                        break;
                    case 'enum' :
                        $method = 'enum';
                        $para = strpos($values->Type, '('); # 4
                        $options = substr($values->Type, $para + 1, -1);
                        $numbers = ', array(' . $options . ')';
                        break;
                }

                if ($values->Key == 'PRI') {
                    $method = 'increments';
                }

                $up .= "                $" . "table->{$method}('{$values->Field}'{$numbers}){$nullable}{$default}{$unsigned};\n";
            }

            $tableIndexes = $this->getTableIndexes($value['table_name']);
            if (!is_null($tableIndexes) && count($tableIndexes)){
            	foreach ($tableIndexes as $index) {
                	$up .= '                $' . "table->index('" . $index['Key_name'] . "');\n";
            	}
        	}

            $up .= "            });\n\n";

            $this->schema[$value['table_name']] = array(
                'up'   => $up,
                'down' => $down
            );
        }

        return $this;
    }

    /**
     * Compile the migration into the base migration file
     * TODO use a template with seacrh&replace
     * @return string
     */
    protected function compile()
    {
        $upSchema = "";
        $downSchema = "";

        // prevent of failure when no table
        if (!is_null($this->schema) && count($this->schema)) {
	        foreach ($this->schema as $name => $values) {
	            // check again for ignored tables
	            if (in_array($name, self::$ignore)) {
	                continue;
	            }
	            $upSchema .= "
	    /**
	     * Table: {$name}
	     */
	    {$values['up']}";

	            $downSchema .= "
	            {$values['down']}";
	        }
        }

        // Grab the template
        $template = File::get(__DIR__ . '/stubs/migration.stub');

        // Replace the classname
        $template = str_replace('{{name}}', "Create" . Str::title($this->database) . "Database", $template);

        // Replace the up and down values
        $template = str_replace('{{up}}', $upSchema, $template);
        $template = str_replace('{{down}}', $downSchema, $template);

        return $template;
    }

}
