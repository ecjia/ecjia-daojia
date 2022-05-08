<<<<<<< HEAD
<?php namespace Royalcms\Component\Model;

use Royalcms\Component\Support\Facades\Config;
use RC_Hook;
use Royalcms\Component\Foundation\Loader;
use Royalcms\Component\Foundation\RoyalcmsObject;

class ModelManage extends RoyalcmsObject {
    
    private static $_cache_model = array();
    
    private static $_sql_execute = array();
    
    private $null_model;
    
=======
<?php

namespace Royalcms\Component\Model;

use Royalcms\Component\Support\Facades\Config;
use RC_Hook;
use RC_Loader;
use Royalcms\Component\Foundation\RoyalcmsObject;

class ModelManage extends RoyalcmsObject
{

    private static $_cache_model = array();

    private static $_sql_execute = array();

    private $null_model;

>>>>>>> v2-test
    /**
     * 添加一条SQL语句
     * @param string $sql
     */
<<<<<<< HEAD
    public static function sql_add($sql) {
        self::$_sql_execute[] = $sql;
    }
    
=======
    public static function sql_add($sql)
    {
        self::$_sql_execute[] = $sql;
    }

>>>>>>> v2-test
    /**
     * 获取所有的SQL语句
     * @return array
     */
<<<<<<< HEAD
    public static function sql_all() {
        return self::$_sql_execute;
    }
    
=======
    public static function sql_all()
    {
        return self::$_sql_execute;
    }

>>>>>>> v2-test
    /**
     * 获取SQL语句条数
     * @return number
     */
<<<<<<< HEAD
    public static function sql_count() {
        return count(self::$_sql_execute);
    }
    
=======
    public static function sql_count()
    {
        return count(self::$_sql_execute);
    }

>>>>>>> v2-test
    /**
     * 实例化模型
     * file 访问系统下的数据模型
     * app/file 访问应用下的数据模型
     * @param string $model
     */
<<<<<<< HEAD
    public static function model($model) {
=======
    public static function model($model)
    {
>>>>>>> v2-test

        if (isset(self::$_cache_model[$model]) && is_object(self::$_cache_model[$model])) {
            return self::$_cache_model[$model];
        }

<<<<<<< HEAD
        $file_arr = array();
        $model_file_name = $model;
        
        if (strpos($model, '/')) {
            $file_arr = explode('/', $model);
        }
        
        if (! empty($file_arr[0])) {
            $m = $file_arr[0];
        }
        
        if (! empty($file_arr[1])) {
            $model_file_name = $file_arr[1];
        }
        
=======
        $file_arr        = array();
        $model_file_name = $model;

        if (strpos($model, '/')) {
            $file_arr = explode('/', $model);
        }

        if (!empty($file_arr[0])) {
            $m = $file_arr[0];
        }

        if (!empty($file_arr[1])) {
            $model_file_name = $file_arr[1];
        }

>>>>>>> v2-test
        if (empty($m)) {
            $m = 'system';
        }

        if ($m != Config::get('system.admin_entrance') && $m != 'system') {
<<<<<<< HEAD
            self::$_cache_model[$model] = Loader::load_app_model($model_file_name, $m);
        } else {
            self::$_cache_model[$model] = Loader::load_sys_model($model_file_name);
=======
            self::$_cache_model[$model] = RC_Loader::load_app_model($model_file_name, $m);
        } else {
            self::$_cache_model[$model] = RC_Loader::load_sys_model($model_file_name);
>>>>>>> v2-test
        }

        return self::$_cache_model[$model];
    }
<<<<<<< HEAD
    
    public function __construct() {
        $this->null_model = new NullModel();
    }
    
    public function null_model() {
        return $this->null_model;
    }
    
=======

    public function __construct()
    {
        $this->null_model = new NullModel();
    }

    public function null_model()
    {
        return $this->null_model;
    }

>>>>>>> v2-test
    /**
     * 检查表是否存在
     *
     * @param $table 表名
     * @return boolean
     */
<<<<<<< HEAD
    public function table_exists($table) {
        return $this->null_model->table_exists($table);
    }
    
    public function table_prefix($table) {
        return $this->null_model->db_tablepre . $table;
    }
    
=======
    public function table_exists($table)
    {
        return $this->null_model->table_exists($table);
    }

    public function table_prefix($table)
    {
        return $this->null_model->db_tablepre . $table;
    }

>>>>>>> v2-test
    /**
     * 创建表
     * @param unknown $table
     * @return bool If table already exists or was created by function.
     */
<<<<<<< HEAD
    public function create_table($table, $schemes, $engine = 'InnoDB', $charset = 'utf8mb4', $collate = 'utf8mb4_unicode_ci') {
=======
    public function create_table($table, $schemes, $engine = 'InnoDB', $charset = 'utf8mb4', $collate = 'utf8mb4_unicode_ci')
    {
>>>>>>> v2-test
        if (version_compare($this->database_version(), '5.5.0', '<')) {
            $charset = 'utf8';
            $collate = 'utf8_unicode_ci';
        }
<<<<<<< HEAD
        
        if (is_array($schemes)) {
            $table = $this->table_prefix($table);
            $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (";
            $sql .= implode(',', $schemes);
            $sql .= ") ENGINE={$engine} DEFAULT CHARSET={$charset} COLLATE={$collate};";
=======

        if (is_array($schemes)) {
            $table = $this->table_prefix($table);
            $sql   = "CREATE TABLE IF NOT EXISTS `{$table}` (";
            $sql   .= implode(',', $schemes);
            $sql   .= ") ENGINE={$engine} DEFAULT CHARSET={$charset} COLLATE={$collate};";
>>>>>>> v2-test
            $this->null_model->execute($sql);
            return $this->null_model->error();
        } else {
            return false;
        }
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    /**
     * 删除表
     *
     * @param unknown $table
     */
<<<<<<< HEAD
    public function drop_table($table) {
        return $this->null_model->drop_table($this->table_prefix($table));
    }
    
=======
    public function drop_table($table)
    {
        return $this->null_model->drop_table($this->table_prefix($table));
    }

>>>>>>> v2-test
    /**
     * 修复数据表
     *
     * @param unknown $table
     * @return boolean
     */
<<<<<<< HEAD
    public function repair_table($table) {
        return $this->null_model->repair($this->table_prefix($table));
    }
    
    
=======
    public function repair_table($table)
    {
        return $this->null_model->repair($this->table_prefix($table));
    }


>>>>>>> v2-test
    /**
     * 优化表解决表碎片问题
     *
     * @param array $table
     *            表
     * @return bool
     */
<<<<<<< HEAD
    public function optimize_table($table) {
        return $this->null_model->optimize($this->table_prefix($table));
    }
    
    
=======
    public function optimize_table($table)
    {
        return $this->null_model->optimize($this->table_prefix($table));
    }


>>>>>>> v2-test
    /**
     * 清空表
     *
     * @param unknown $table
     */
<<<<<<< HEAD
    public function truncate_table($table) {
        return $this->null_model->truncate($this->table_prefix($table));
    }
    
    
=======
    public function truncate_table($table)
    {
        return $this->null_model->truncate($this->table_prefix($table));
    }


>>>>>>> v2-test
    /**
     * 修改表名
     *
     * @param unknown $old
     * @param unknown $new
     */
<<<<<<< HEAD
    public function rename_table($old_table, $new_table) {
        return $this->null_model->rename($this->table_prefix($old_table), $this->table_prefix($new_table));
    }
    
=======
    public function rename_table($old_table, $new_table)
    {
        return $this->null_model->rename($this->table_prefix($old_table), $this->table_prefix($new_table));
    }

>>>>>>> v2-test
    /**
     * 查询表结构描述信息
     * @param string $table_name
     * @return object or array
     */
<<<<<<< HEAD
    public function describe_table($table_name, $return = 'object') {
=======
    public function describe_table($table_name, $return = 'object')
    {
>>>>>>> v2-test
        $result = $this->null_model->query("DESCRIBE {$table_name};");
        if ($result == 'object') {
            $result = json_encode($result);
            $result = json_decode($result);
        }
        return $result;
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    /**
     * 获得表信息
     *
     * @param array $table
     */
<<<<<<< HEAD
    public function table_info($table = null) {
        return $this->null_model->table_info($table);
    }
    
=======
    public function table_info($table = null)
    {
        return $this->null_model->table_info($table);
    }

>>>>>>> v2-test
    /**
     * 获得数据表大小
     *
     * @param string $table
     */
<<<<<<< HEAD
    public function table_size($table = null) {
        return $this->null_model->table_size($table);
    }
    
    /**
     * add index
     *
     * @since 3.4
     *
     * @param string $table Database table name.
     * @param string $index Database table index column.
     * @return bool True, when done with execution.
     */
    public function add_index($table, $index) {
=======
    public function table_size($table = null)
    {
        return $this->null_model->table_size($table);
    }

    /**
     * add index
     *
     * @param string $table Database table name.
     * @param string $index Database table index column.
     * @return bool True, when done with execution.
     * @since 3.4
     *
     */
    public function add_index($table, $index)
    {
>>>>>>> v2-test
        self::drop_index($table, $index);
        $this->null_model->execute("ALTER TABLE `$table` ADD INDEX ( `$index` )");
        return true;
    }
<<<<<<< HEAD
    
    /**
     * drop index
     *
     * @since 3.4
     *
     * @param string $table Database table name.
     * @param string $index Index name to drop.
     * @return bool True, when finished.
     */
    public function drop_index($table, $index) {
=======

    /**
     * drop index
     *
     * @param string $table Database table name.
     * @param string $index Index name to drop.
     * @return bool True, when finished.
     * @since 3.4
     *
     */
    public function drop_index($table, $index)
    {
>>>>>>> v2-test
        $this->null_model->execute("ALTER TABLE `$table` DROP INDEX `$index`");
        // Now we need to take out all the extra ones we may have created
        for ($i = 0; $i < 25; $i++) {
            $this->null_model->execute("ALTER TABLE `$table` DROP INDEX `{$index}_$i`");
        }
        return true;
    }
<<<<<<< HEAD
    
    /**
     * show index
     *
     * @since 3.4
     *
     * @param string $table Database table name.
     * @return bool True, when finished.
     */
    public function show_index($table_name) {
        $result = $this->null_model->query("SHOW INDEX FROM {$table_name};");
        return $result;
    }
    
=======

    /**
     * show index
     *
     * @param string $table Database table name.
     * @return bool True, when finished.
     * @since 3.4
     *
     */
    public function show_index($table_name)
    {
        $result = $this->null_model->query("SHOW INDEX FROM {$table_name};");
        return $result;
    }

>>>>>>> v2-test
    /**
     ** add_column()
     ** Add column to db table if it doesn't exist.
     *
     * @since 3.4
     *
     ** Returns:  true if already exists or on successful completion
     **           false on error
     */
<<<<<<< HEAD
    public function add_column($table_name, $column_name, $create_ddl) {
        if ($this->null_model->table($table_name, 0)->field_exists($column_name)){
            return true;
        }
    
        //didn't find it try to create it.
        $q = $this->null_model->execute($create_ddl);
        // we cannot directly tell that whether this succeeded!
        if ($this->null_model->table($table_name, 0)->field_exists($column_name)){
=======
    public function add_column($table_name, $column_name, $create_ddl)
    {
        if ($this->null_model->table($table_name, 0)->field_exists($column_name)) {
            return true;
        }

        //didn't find it try to create it.
        $q = $this->null_model->execute($create_ddl);
        // we cannot directly tell that whether this succeeded!
        if ($this->null_model->table($table_name, 0)->field_exists($column_name)) {
>>>>>>> v2-test
            return true;
        }
        return false;
    }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
    /**
     * 创建数据库
     *
     * @param string $database
     */
<<<<<<< HEAD
    public function create_database($database) {
        return $this->null_model->create_database($database);
    }
    
    /**
     * 返回数据库版本号
     */
    public function database_version() {
        return $this->null_model->version();
    }
    
    /**
     * 获得数据库大小
     */
    public function database_size($tablepre = null) {
        return $this->null_model->database_size($tablepre);
    }
    
    /**
     * 获得数据库列表
     */
    public function database_tables($tablepre = null) {
        return $this->null_model->database_tables($tablepre);
    }
    
=======
    public function create_database($database)
    {
        return $this->null_model->create_database($database);
    }

    /**
     * 返回数据库版本号
     */
    public function database_version()
    {
        return $this->null_model->version();
    }

    /**
     * 获得数据库大小
     */
    public function database_size($tablepre = null)
    {
        return $this->null_model->database_size($tablepre);
    }

    /**
     * 获得数据库列表
     */
    public function database_tables($tablepre = null)
    {
        return $this->null_model->database_tables($tablepre);
    }

>>>>>>> v2-test
    /**
     * {@internal Missing Short Description}}
     *
     * {@internal Missing Long Description}}
     *
<<<<<<< HEAD
     * @since 1.5.0
     *
     * @param unknown_type $queries
     * @param unknown_type $execute
     * @return unknown
     */
    public function database_delta( $queries = '', $execute = true ) {
        // Separate individual queries into an array
        if ( !is_array($queries) ) {
            $queries = explode( ';', $queries );
            $queries = array_filter( $queries );
        }
    
        /**
         * Filter the dbDelta SQL queries.
         *
         * @since 3.4.0
         *
         * @param array $queries An array of dbDelta SQL queries.
         */
        $queries = RC_Hook::apply_filters( 'dbdelta_queries', $queries );
    
        $cqueries = array(); // Creation Queries
        $iqueries = array(); // Insertion Queries
        $for_update = array();
    
        // Create a tablename index for an array ($cqueries) of queries
        foreach($queries as $qry) {
            if (preg_match("|CREATE TABLE ([^ ]*)|", $qry, $matches)) {
                $cqueries[ trim( $matches[1], '`' ) ] = $qry;
                $for_update[$matches[1]] = 'Created table '.$matches[1];
=======
     * @param unknown_type $queries
     * @param unknown_type $execute
     * @return unknown
     * @since 1.5.0
     *
     */
    public function database_delta($queries = '', $execute = true)
    {
        // Separate individual queries into an array
        if (!is_array($queries)) {
            $queries = explode(';', $queries);
            $queries = array_filter($queries);
        }

        /**
         * Filter the dbDelta SQL queries.
         *
         * @param array $queries An array of dbDelta SQL queries.
         * @since 3.4.0
         *
         */
        $queries = RC_Hook::apply_filters('dbdelta_queries', $queries);

        $cqueries   = array(); // Creation Queries
        $iqueries   = array(); // Insertion Queries
        $for_update = array();

        // Create a tablename index for an array ($cqueries) of queries
        foreach ($queries as $qry) {
            if (preg_match("|CREATE TABLE ([^ ]*)|", $qry, $matches)) {
                $cqueries[trim($matches[1], '`')] = $qry;
                $for_update[$matches[1]]          = 'Created table ' . $matches[1];
>>>>>>> v2-test
            } else if (preg_match("|CREATE DATABASE ([^ ]*)|", $qry, $matches)) {
                array_unshift($cqueries, $qry);
            } else if (preg_match("|INSERT INTO ([^ ]*)|", $qry, $matches)) {
                $iqueries[] = $qry;
            } else if (preg_match("|UPDATE ([^ ]*)|", $qry, $matches)) {
                $iqueries[] = $qry;
            } else {
                // Unrecognized query type
            }
        }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
        /**
         * Filter the dbDelta SQL queries for creating tables and/or databases.
         *
         * Queries filterable via this hook contain "CREATE TABLE" or "CREATE DATABASE".
         *
<<<<<<< HEAD
         * @since 3.4.0
         *
         * @param array $cqueries An array of dbDelta create SQL queries.
         */
        $cqueries = RC_Hook::apply_filters( 'dbdelta_create_queries', $cqueries );
    
=======
         * @param array $cqueries An array of dbDelta create SQL queries.
         * @since 3.4.0
         *
         */
        $cqueries = RC_Hook::apply_filters('dbdelta_create_queries', $cqueries);

>>>>>>> v2-test
        /**
         * Filter the dbDelta SQL queries for inserting or updating.
         *
         * Queries filterable via this hook contain "INSERT INTO" or "UPDATE".
         *
<<<<<<< HEAD
         * @since 3.4.0
         *
         * @param array $iqueries An array of dbDelta insert or update SQL queries.
        */
        $iqueries = RC_Hook::apply_filters( 'dbdelta_insert_queries', $iqueries );

        foreach ( $cqueries as $table => $qry ) {    
            // Fetch the table column structure from the database
            $tablefields = $this->describe_table($table);
    
            if ( ! $tablefields ) {
                continue;
            }
    
=======
         * @param array $iqueries An array of dbDelta insert or update SQL queries.
         * @since 3.4.0
         *
         */
        $iqueries = RC_Hook::apply_filters('dbdelta_insert_queries', $iqueries);

        foreach ($cqueries as $table => $qry) {
            // Fetch the table column structure from the database
            $tablefields = $this->describe_table($table);

            if (!$tablefields) {
                continue;
            }

>>>>>>> v2-test
            // Clear the field and index arrays
            $cfields = $indices = array();
            // Get all of the field names in the query from between the parens
            preg_match('|\((.*)\)|ms', $qry, $match2);
            $qryline = trim($match2[1]);
<<<<<<< HEAD
    
            // Separate field lines into an array
            $flds = explode("\n", $qryline);
    
            //echo "<hr/><pre>\n".print_r(strtolower($table), true).":\n".print_r($cqueries, true)."</pre><hr/>";
    
=======

            // Separate field lines into an array
            $flds = explode("\n", $qryline);

            //echo "<hr/><pre>\n".print_r(strtolower($table), true).":\n".print_r($cqueries, true)."</pre><hr/>";

>>>>>>> v2-test
            // For every field line specified in the query
            foreach ($flds as $fld) {
                // Extract the field name
                preg_match("|^([^ ]*)|", trim($fld), $fvals);
<<<<<<< HEAD
                $fieldname = trim( $fvals[1], '`' );
    
=======
                $fieldname = trim($fvals[1], '`');

>>>>>>> v2-test
                // Verify the found field name
                $validfield = true;
                switch (strtolower($fieldname)) {
                    case '':
                    case 'primary':
                    case 'index':
                    case 'fulltext':
                    case 'unique':
                    case 'key':
                        $validfield = false;
<<<<<<< HEAD
                        $indices[] = trim(trim($fld), ", \n");
                        break;
                }
                $fld = trim($fld);
    
=======
                        $indices[]  = trim(trim($fld), ", \n");
                        break;
                }
                $fld = trim($fld);

>>>>>>> v2-test
                // If it's a valid field, add it to the field array
                if ($validfield) {
                    $cfields[strtolower($fieldname)] = trim($fld, ", \n");
                }
            }
<<<<<<< HEAD
    
=======

>>>>>>> v2-test
            // For every field in the table
            foreach ($tablefields as $tablefield) {
                // If the table field exists in the field array...
                if (array_key_exists(strtolower($tablefield->Field), $cfields)) {
                    // Get the field type from the query
<<<<<<< HEAD
                    preg_match("|".$tablefield->Field." ([^ ]*( unsigned)?)|i", $cfields[strtolower($tablefield->Field)], $matches);
                    $fieldtype = $matches[1];
    
                    // Is actual field type different from the field type in query?
                    if ($tablefield->Type != $fieldtype) {
                        // Add a query to change the column type
                        $cqueries[] = "ALTER TABLE {$table} CHANGE COLUMN {$tablefield->Field} " . $cfields[strtolower($tablefield->Field)];
                        $for_update[$table.'.'.$tablefield->Field] = "Changed type of {$table}.{$tablefield->Field} from {$tablefield->Type} to {$fieldtype}";
                    }
    
=======
                    preg_match("|" . $tablefield->Field . " ([^ ]*( unsigned)?)|i", $cfields[strtolower($tablefield->Field)], $matches);
                    $fieldtype = $matches[1];

                    // Is actual field type different from the field type in query?
                    if ($tablefield->Type != $fieldtype) {
                        // Add a query to change the column type
                        $cqueries[]                                    = "ALTER TABLE {$table} CHANGE COLUMN {$tablefield->Field} " . $cfields[strtolower($tablefield->Field)];
                        $for_update[$table . '.' . $tablefield->Field] = "Changed type of {$table}.{$tablefield->Field} from {$tablefield->Type} to {$fieldtype}";
                    }

>>>>>>> v2-test
                    // Get the default value from the array
                    //echo "{$cfields[strtolower($tablefield->Field)]}<br>";
                    if (preg_match("| DEFAULT '(.*?)'|i", $cfields[strtolower($tablefield->Field)], $matches)) {
                        $default_value = $matches[1];
                        if ($tablefield->Default != $default_value) {
                            // Add a query to change the column's default value
<<<<<<< HEAD
                            $cqueries[] = "ALTER TABLE {$table} ALTER COLUMN {$tablefield->Field} SET DEFAULT '{$default_value}'";
                            $for_update[$table.'.'.$tablefield->Field] = "Changed default value of {$table}.{$tablefield->Field} from {$tablefield->Default} to {$default_value}";
                        }
                    }
    
=======
                            $cqueries[]                                    = "ALTER TABLE {$table} ALTER COLUMN {$tablefield->Field} SET DEFAULT '{$default_value}'";
                            $for_update[$table . '.' . $tablefield->Field] = "Changed default value of {$table}.{$tablefield->Field} from {$tablefield->Default} to {$default_value}";
                        }
                    }

>>>>>>> v2-test
                    // Remove the field from the array (so it's not added)
                    unset($cfields[strtolower($tablefield->Field)]);
                } else {
                    // This field exists in the table, but not in the creation queries?
                }
            }
<<<<<<< HEAD
    
            // For every remaining field specified for the table
            foreach ($cfields as $fieldname => $fielddef) {
                // Push a query line into $cqueries that adds the field to that table
                $cqueries[] = "ALTER TABLE {$table} ADD COLUMN $fielddef";
                $for_update[$table.'.'.$fieldname] = 'Added column '.$table.'.'.$fieldname;
            }
    
            // Index stuff goes here
            // Fetch the table index structure from the database
            $tableindices = $this->show_index($table);
    
            if ($tableindices) {
                // Clear the index array
                unset($index_ary);
        
                // For every index in the table
    			foreach ($tableindices as $tableindex) {
        			// Add the index to the index data array
        			$keyname = $tableindex->Key_name;
    			    $index_ary[$keyname]['columns'][] = array('fieldname' => $tableindex->Column_name, 'subpart' => $tableindex->Sub_part);
    			    $index_ary[$keyname]['unique'] = ($tableindex->Non_unique == 0) ? true : false;
			    }
        
			    // For each actual index in the index array
			    foreach ($index_ary as $index_name => $index_data) {
    			    // Build a create string to compare to the query
    			    $index_string = '';
    			    if ($index_name == 'PRIMARY') {
    			        $index_string .= 'PRIMARY ';
    			    } else if($index_data['unique']) {
=======

            // For every remaining field specified for the table
            foreach ($cfields as $fieldname => $fielddef) {
                // Push a query line into $cqueries that adds the field to that table
                $cqueries[]                            = "ALTER TABLE {$table} ADD COLUMN $fielddef";
                $for_update[$table . '.' . $fieldname] = 'Added column ' . $table . '.' . $fieldname;
            }

            // Index stuff goes here
            // Fetch the table index structure from the database
            $tableindices = $this->show_index($table);

            if ($tableindices) {
                // Clear the index array
                unset($index_ary);

                // For every index in the table
                foreach ($tableindices as $tableindex) {
                    // Add the index to the index data array
                    $keyname                          = $tableindex->Key_name;
                    $index_ary[$keyname]['columns'][] = array('fieldname' => $tableindex->Column_name, 'subpart' => $tableindex->Sub_part);
                    $index_ary[$keyname]['unique']    = ($tableindex->Non_unique == 0) ? true : false;
                }

                // For each actual index in the index array
                foreach ($index_ary as $index_name => $index_data) {
                    // Build a create string to compare to the query
                    $index_string = '';
                    if ($index_name == 'PRIMARY') {
                        $index_string .= 'PRIMARY ';
                    } else if ($index_data['unique']) {
>>>>>>> v2-test
                        $index_string .= 'UNIQUE ';
                    }
                    $index_string .= 'KEY ';
                    if ($index_name != 'PRIMARY') {
                        $index_string .= $index_name;
                    }
                    $index_columns = '';
                    // For each column in the index
<<<<<<< HEAD
			        foreach ($index_data['columns'] as $column_data) {
    			        if ($index_columns != '') {
    			            $index_columns .= ',';
    			        }
    			        // Add the field to the column list string
    			        $index_columns .= $column_data['fieldname'];
    			        if ($column_data['subpart'] != '') {
                            $index_columns .= '('.$column_data['subpart'].')';
    			        }
                    }
			        // Add the column list to the index create string
			        $index_string .= ' ('.$index_columns.')';
			        if (!(($aindex = array_search($index_string, $indices)) === false)) {
=======
                    foreach ($index_data['columns'] as $column_data) {
                        if ($index_columns != '') {
                            $index_columns .= ',';
                        }
                        // Add the field to the column list string
                        $index_columns .= $column_data['fieldname'];
                        if ($column_data['subpart'] != '') {
                            $index_columns .= '(' . $column_data['subpart'] . ')';
                        }
                    }
                    // Add the column list to the index create string
                    $index_string .= ' (' . $index_columns . ')';
                    if (!(($aindex = array_search($index_string, $indices)) === false)) {
>>>>>>> v2-test
                        unset($indices[$aindex]);
                        //echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">{$table}:<br />Found index:".$index_string."</pre>\n";
                    }
                    //else echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">{$table}:<br /><b>Did not find index:</b>".$index_string."<br />".print_r($indices, true)."</pre>\n";
                }
            }
<<<<<<< HEAD
    
            // For every remaining index specified for the table
            foreach ( (array) $indices as $index ) {
                // Push a query line into $cqueries that adds the index to that table
                $cqueries[] = "ALTER TABLE {$table} ADD $index";
=======

            // For every remaining index specified for the table
            foreach ((array)$indices as $index) {
                // Push a query line into $cqueries that adds the index to that table
                $cqueries[]   = "ALTER TABLE {$table} ADD $index";
>>>>>>> v2-test
                $for_update[] = 'Added index ' . $table . ' ' . $index;
            }

            // Remove the original table creation query from processing
<<<<<<< HEAD
    		unset( $cqueries[ $table ], $for_update[ $table ] );
	   }
    
    	$allqueries = array_merge($cqueries, $iqueries);
    	if ($execute) {
    		foreach ($allqueries as $query) {
    			//echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">".print_r($query, true)."</pre>\n";
    			$this->null_model->execute($query);
    		}
    	}
    
    	return $for_update;
    }
    
=======
            unset($cqueries[$table], $for_update[$table]);
        }

        $allqueries = array_merge($cqueries, $iqueries);
        if ($execute) {
            foreach ($allqueries as $query) {
                //echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">".print_r($query, true)."</pre>\n";
                $this->null_model->execute($query);
            }
        }

        return $for_update;
    }

>>>>>>> v2-test
}

// end