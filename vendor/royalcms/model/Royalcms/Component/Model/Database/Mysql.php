<?php

namespace Royalcms\Component\Model\Database;

use Exception;

/**
 * mysql.class.php 数据库实现类
 *
 * @copyright (C) 2010-2013 ROYALCMS
 * @license http://www.royalcms.cn/license/
 */
final class Mysql extends Database
{

    /**
     * 数据库连接资源句柄
     */
    public $link;

    protected $hostkey;

    /**
     * 是否连接
     *
     * @var unknown
     */
    protected static $connect_pool;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 析构函数 释放连接资源
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * 真正开启数据库连接
     *
     * @return void
     */
    public function connect_database()
    {
        $this->hostkey = $this->config['host'] . '#' . $this->config['database'];
        if (array_get(self::$connect_pool, $this->hostkey)) {
            $this->link = self::$connect_pool[$this->hostkey];
        } else {
            $link = mysql_connect($this->config['host'], $this->config['username'], $this->config['password'], true);
            if (!$link) {
                $this->error('Can not connect to MySQL server');
                return false;
            }
            self::$connect_pool[$this->hostkey] = $link;
            $this->link                         = $link;
            $this->set_charset();
        }

        if ($this->config['database'] && !mysql_select_db($this->config['database'], $this->link)) {
            $this->error('Cannot use database ' . $this->config['database']);
            return false;
        }
        return $this->link;
    }

    private function set_charset()
    {
        $charset   = isset($this->config['charset']) ? $this->config['charset'] : '';
        $serverset = $charset ? "character_set_connection='$charset',character_set_results='$charset',character_set_client=binary" : '';
        $serverset .= (empty($serverset) ? '' : ',') . " sql_mode='' ";
        $serverset && mysql_query("SET $serverset", self::$connect_pool[$this->hostkey]);
    }

    /**
     * 获得最后插入的ID号
     *
     * @see database_interface::last_insert_id()
     */
    public function last_insert_id()
    {
        return mysql_insert_id($this->link);
    }

    /**
     * 获得受影响的行数
     *
     * @see database_interface::last_affected_rows()
     */
    public function last_affected_rows()
    {
        return mysql_affected_rows($this->link);
    }

    /**
     * 数据安全处理
     *
     * @param string $str
     * @see database_interface::escape_string()
     */
    public function escape_string($str)
    {
        return rc_addslashes($str);
    }

    /**
     * 提供一个事务
     *
     * @see database_interface::commit()
     */
    public function commit()
    {
        mysql_query("COMMIT", $this->link);
    }

    /**
     * 回滚事务
     *
     * @see database_interface::rollback()
     */
    public function rollback()
    {
        mysql_query("ROLLBACK", $this->link);
    }

    /**
     * 开启事务处理
     *
     * @see database_interface::begin_trans()
     */
    public function begin_trans()
    {
        mysql_query("START AUTOCOMMIT=0");
    }

    /**
     * 插入数据失败时自动转为更新数据
     *
     * @param array $field_values
     * @param array $update_values
     * @return Ambigous <boolean, number>|boolean
     */
    public function auto_replace($field_values, $update_values)
    {
        $fields = $values = array();
        foreach ($this->opt['fields'] as $value) {
            if (array_key_exists($value, $field_values) == true) {
                $fields[] = $value;
                $values[] = "'" . $field_values[$value] . "'";
            }
        }

        $sets = array();
        foreach ($update_values as $key => $value) {
            if (array_key_exists($key, $field_values) == true) {
                if (is_int($value) || is_float($value)) {
                    $sets[] = $key . ' = ' . $key . ' + ' . $value;
                } else {
                    $sets[] = $key . " = '" . $value . "'";
                }
            }
        }

        $sql          = '';
        $primary_keys = array(
            $this->opt['primary']
        );
        if (empty($primary_keys)) {
            if (!empty($fields)) {
                $sql = 'INSERT INTO ' . $this->opt['table'] . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
            }
        } else {
            // mysql version >= 4.1
            if (!empty($fields)) {
                $sql = 'INSERT INTO ' . $this->opt['table'] . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
                if (!empty($sets)) {
                    $sql .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', $sets);
                }
            }
        }

        if ($sql) {
            return $this->execute($sql);
        } else {
            return false;
        }
    }

    /**
     * 执行SQL没有返回值
     *
     * @param $sql 要执行的sql语句
     * @see database_interface::execute()
     */
    public function execute($sql)
    {
        // 查询参数初始化
        $this->opt_init();

        // 将SQL添加到调试DEBUG
        $this->debug($sql);
        is_resource($this->link) or $this->connect($this->table_name);

        $this->last_query = mysql_query($sql, $this->link);
        if ($this->last_query) {
            // 自增id
            $insert_id = mysql_insert_id($this->link);
            return $insert_id ? $insert_id : true;
        } else {
//             $this->error(array(
//                 'errno' => mysql_errno($this->link),
//                 'error' => mysql_error($this->link),
//                 'sql' => $sql
//             ));
            throw new Exception(mysql_error($this->link), mysql_errno($this->link));
            return false;
        }
    }

    /**
     * 发送查询 返回数组
     *
     * @see database_interface::query()
     */
    public function query($sql)
    {
        $options    = \RC_Config::get('cache.query_cache');
        $cache_time = $this->cache_time ? $this->cache_time : intval($options['select_time']);
        if (defined('ROUTE_M') && defined('ROUTE_C') && defined('ROUTE_A')) {
            $cache_name = md5($sql . ROUTE_M . ROUTE_C . ROUTE_A);
        } else {
            $cache_name = md5($sql);
        }
        if ($cache_time >= 0) {
            $result = \RC_Cache::query_cache_get($cache_name);
            if ($result) {
                // 查询参数初始化
                $this->opt_init();
                return $result;
            }
        }

        // SQL发送失败
        if (!$this->execute($sql)) {
            return false;
        }

        $list = array();
        while (($res = $this->fetch()) != false) {
            $list[] = $res;
        }

        if ($cache_time >= 0 && count($list) <= $options['select_length']) {
            \RC_Cache::query_cache_set($cache_name, $list, $cache_time);
        }

        return is_array($list) && !empty($list) ? $list : null;
    }

    /**
     * 获得MYSQL版本信息
     *
     * @see database_interface::version()
     */
    public function version()
    {
        is_resource($this->link) or $this->connect($this->table);
        return preg_replace('/[a-z-]/i', '', mysql_get_server_info());
    }

    /**
     * 遍历结果集(根据INSERT_ID)
     */
    protected function fetch()
    {
        $res = mysql_fetch_assoc($this->last_query);
        if (!MAGIC_QUOTES_GPC) {
            $res = rc_stripslashes($res);
        }
        if (!$res) {
            $this->result_free();
        }
        return $res;
    }

    /**
     * 释放结果集
     */
    protected function result_free()
    {
        if (isset($this->last_query)) {
            mysql_free_result($this->last_query);
        }
        $this->last_query = null;
    }

    /**
     * 释放连接资源
     *
     * @see database_interface::close()
     */
    public function close()
    {
        if (is_resource($this->link)) {
            mysql_close($this->link);
            $this->link = null;
            unset(self::$connect_pool[$this->hostkey]);
            if (is_array(self::$connect_pool) && !count(self::$connect_pool)) {
                self::$connect_pool = null;
            }
        }
    }
}


// end