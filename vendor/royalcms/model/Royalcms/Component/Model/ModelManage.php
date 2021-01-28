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

    /**
     * 添加一条SQL语句
     * @param string $sql
     */
    public static function sql_add($sql)
    {
        self::$_sql_execute[] = $sql;
    }

    /**
     * 获取所有的SQL语句
     * @return array
     */
    public static function sql_all()
    {
        return self::$_sql_execute;
    }

    /**
     * 获取SQL语句条数
     * @return number
     */
    public static function sql_count()
    {
        return count(self::$_sql_execute);
    }

    /**
     * 实例化模型
     * file 访问系统下的数据模型
     * app/file 访问应用下的数据模型
     * @param string $model
     */
    public static function model($model)
    {

        if (isset(self::$_cache_model[$model]) && is_object(self::$_cache_model[$model])) {
            return self::$_cache_model[$model];
        }

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

        if (empty($m)) {
            $m = 'system';
        }

        if ($m != Config::get('system.admin_entrance') && $m != 'system') {
            self::$_cache_model[$model] = RC_Loader::load_app_model($model_file_name, $m);
        } else {
            self::$_cache_model[$model] = RC_Loader::load_sys_model($model_file_name);
        }

        return self::$_cache_model[$model];
    }

    public function __construct()
    {
        $this->null_model = new NullModel();
    }

    public function null_model()
    {
        return $this->null_model;
    }

    /**
     * 检查表是否存在
     *
     * @param $table 表名
     * @return boolean
     */
    public function table_exists($table)
    {
        return $this->null_model->table_exists($table);
    }

    public function table_prefix($table)
    {
        return $this->null_model->db_tablepre . $table;
    }

    /**
     * 创建表
     * @param unknown $table
     * @return bool If table already exists or was created by function.
     */
    public function create_table($table, $schemes, $engine = 'InnoDB', $charset = 'utf8mb4', $collate = 'utf8mb4_unicode_ci')
    {
        if (version_compare($this->database_version(), '5.5.0', '<')) {
            $charset = 'utf8';
            $collate = 'utf8_unicode_ci';
        }

        if (is_array($schemes)) {
            $table = $this->table_prefix($table);
            $sql   = "CREATE TABLE IF NOT EXISTS `{$table}` (";
            $sql   .= implode(',', $schemes);
            $sql   .= ") ENGINE={$engine} DEFAULT CHARSET={$charset} COLLATE={$collate};";
            $this->null_model->execute($sql);
            return $this->null_model->error();
        } else {
            return false;
        }
    }

    /**
     * 删除表
     *
     * @param unknown $table
     */
    public function drop_table($table)
    {
        return $this->null_model->drop_table($this->table_prefix($table));
    }

    /**
     * 修复数据表
     *
     * @param unknown $table
     * @return boolean
     */
    public function repair_table($table)
    {
        return $this->null_model->repair($this->table_prefix($table));
    }


    /**
     * 优化表解决表碎片问题
     *
     * @param array $table
     *            表
     * @return bool
     */
    public function optimize_table($table)
    {
        return $this->null_model->optimize($this->table_prefix($table));
    }


    /**
     * 清空表
     *
     * @param unknown $table
     */
    public function truncate_table($table)
    {
        return $this->null_model->truncate($this->table_prefix($table));
    }


    /**
     * 修改表名
     *
     * @param unknown $old
     * @param unknown $new
     */
    public function rename_table($old_table, $new_table)
    {
        return $this->null_model->rename($this->table_prefix($old_table), $this->table_prefix($new_table));
    }

    /**
     * 查询表结构描述信息
     * @param string $table_name
     * @return object or array
     */
    public function describe_table($table_name, $return = 'object')
    {
        $result = $this->null_model->query("DESCRIBE {$table_name};");
        if ($result == 'object') {
            $result = json_encode($result);
            $result = json_decode($result);
        }
        return $result;
    }

    /**
     * 获得表信息
     *
     * @param array $table
     */
    public function table_info($table = null)
    {
        return $this->null_model->table_info($table);
    }

    /**
     * 获得数据表大小
     *
     * @param string $table
     */
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
        self::drop_index($table, $index);
        $this->null_model->execute("ALTER TABLE `$table` ADD INDEX ( `$index` )");
        return true;
    }

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
        $this->null_model->execute("ALTER TABLE `$table` DROP INDEX `$index`");
        // Now we need to take out all the extra ones we may have created
        for ($i = 0; $i < 25; $i++) {
            $this->null_model->execute("ALTER TABLE `$table` DROP INDEX `{$index}_$i`");
        }
        return true;
    }

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

    /**
     ** add_column()
     ** Add column to db table if it doesn't exist.
     *
     * @since 3.4
     *
     ** Returns:  true if already exists or on successful completion
     **           false on error
     */
    public function add_column($table_name, $column_name, $create_ddl)
    {
        if ($this->null_model->table($table_name, 0)->field_exists($column_name)) {
            return true;
        }

        //didn't find it try to create it.
        $q = $this->null_model->execute($create_ddl);
        // we cannot directly tell that whether this succeeded!
        if ($this->null_model->table($table_name, 0)->field_exists($column_name)) {
            return true;
        }
        return false;
    }

    /**
     * 创建数据库
     *
     * @param string $database
     */
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

    /**
     * {@internal Missing Short Description}}
     *
     * {@internal Missing Long Description}}
     *
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

        /**
         * Filter the dbDelta SQL queries for creating tables and/or databases.
         *
         * Queries filterable via this hook contain "CREATE TABLE" or "CREATE DATABASE".
         *
         * @param array $cqueries An array of dbDelta create SQL queries.
         * @since 3.4.0
         *
         */
        $cqueries = RC_Hook::apply_filters('dbdelta_create_queries', $cqueries);

        /**
         * Filter the dbDelta SQL queries for inserting or updating.
         *
         * Queries filterable via this hook contain "INSERT INTO" or "UPDATE".
         *
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

            // Clear the field and index arrays
            $cfields = $indices = array();
            // Get all of the field names in the query from between the parens
            preg_match('|\((.*)\)|ms', $qry, $match2);
            $qryline = trim($match2[1]);

            // Separate field lines into an array
            $flds = explode("\n", $qryline);

            //echo "<hr/><pre>\n".print_r(strtolower($table), true).":\n".print_r($cqueries, true)."</pre><hr/>";

            // For every field line specified in the query
            foreach ($flds as $fld) {
                // Extract the field name
                preg_match("|^([^ ]*)|", trim($fld), $fvals);
                $fieldname = trim($fvals[1], '`');

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
                        $indices[]  = trim(trim($fld), ", \n");
                        break;
                }
                $fld = trim($fld);

                // If it's a valid field, add it to the field array
                if ($validfield) {
                    $cfields[strtolower($fieldname)] = trim($fld, ", \n");
                }
            }

            // For every field in the table
            foreach ($tablefields as $tablefield) {
                // If the table field exists in the field array...
                if (array_key_exists(strtolower($tablefield->Field), $cfields)) {
                    // Get the field type from the query
                    preg_match("|" . $tablefield->Field . " ([^ ]*( unsigned)?)|i", $cfields[strtolower($tablefield->Field)], $matches);
                    $fieldtype = $matches[1];

                    // Is actual field type different from the field type in query?
                    if ($tablefield->Type != $fieldtype) {
                        // Add a query to change the column type
                        $cqueries[]                                    = "ALTER TABLE {$table} CHANGE COLUMN {$tablefield->Field} " . $cfields[strtolower($tablefield->Field)];
                        $for_update[$table . '.' . $tablefield->Field] = "Changed type of {$table}.{$tablefield->Field} from {$tablefield->Type} to {$fieldtype}";
                    }

                    // Get the default value from the array
                    //echo "{$cfields[strtolower($tablefield->Field)]}<br>";
                    if (preg_match("| DEFAULT '(.*?)'|i", $cfields[strtolower($tablefield->Field)], $matches)) {
                        $default_value = $matches[1];
                        if ($tablefield->Default != $default_value) {
                            // Add a query to change the column's default value
                            $cqueries[]                                    = "ALTER TABLE {$table} ALTER COLUMN {$tablefield->Field} SET DEFAULT '{$default_value}'";
                            $for_update[$table . '.' . $tablefield->Field] = "Changed default value of {$table}.{$tablefield->Field} from {$tablefield->Default} to {$default_value}";
                        }
                    }

                    // Remove the field from the array (so it's not added)
                    unset($cfields[strtolower($tablefield->Field)]);
                } else {
                    // This field exists in the table, but not in the creation queries?
                }
            }

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
                        $index_string .= 'UNIQUE ';
                    }
                    $index_string .= 'KEY ';
                    if ($index_name != 'PRIMARY') {
                        $index_string .= $index_name;
                    }
                    $index_columns = '';
                    // For each column in the index
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
                        unset($indices[$aindex]);
                        //echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">{$table}:<br />Found index:".$index_string."</pre>\n";
                    }
                    //else echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">{$table}:<br /><b>Did not find index:</b>".$index_string."<br />".print_r($indices, true)."</pre>\n";
                }
            }

            // For every remaining index specified for the table
            foreach ((array)$indices as $index) {
                // Push a query line into $cqueries that adds the index to that table
                $cqueries[]   = "ALTER TABLE {$table} ADD $index";
                $for_update[] = 'Added index ' . $table . ' ' . $index;
            }

            // Remove the original table creation query from processing
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

}

// end