<?php namespace Royalcms\Component\Model\Database;

use Exception;
use mysqli as PhpMysqli;

/**
 * mysqli数据库驱动
 *
 * @package Royalcms
 * @subpackage Component
 */

class Mysqli extends Database
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

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 析构函数
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
            $port = array_get($this->config, 'port', 3306);
            $socket = array_get($this->config, 'unix_socket');
            $link = new PhpMysqli($this->config['host'], $this->config['username'], $this->config['password'], $this->config['database'], $port, $socket);
            // 连接错误
            if ($link->connect_errno) {
                $this->error($link->connect_error);
                return false;
            }
            self::$connect_pool[$this->hostkey] = $link;
            $this->link = $link;
            $this->set_charset();
        }
        
        return $this->link;
    }

    /**
     * 设置字符集
     */
    private function set_charset()
    {
        $this->link->set_charset($this->config['charset']);
        $this->link->query("SET NAMES ".$this->config['charset']);
    }

    /**
     * 获得最后插入的ID号
     *
     * @see database_interface::last_insert_id()
     */
    public function last_insert_id()
    {
        return $this->link->insert_id;
    }

    /**
     * 获得受影响的行数
     *
     * @see database_interface::last_affected_rows()
     */
    public function last_affected_rows()
    {
        return $this->link->affected_rows;
    }

    /**
     * 数据安全处理
     *
     * @see database_interface::escape_string()
     */
    public function escape_string($str)
    {
        return $this->link->real_escape_string($str);
    }
    
    /**
     * 提供一个事务
     *
     * @see database_interface::commit()
     */
    public function commit()
    {
        $this->link->commit();
    }
    
    /**
     * 回滚事务
     *
     * @see database_interface::rollback()
     */
    public function rollback()
    {
        $this->link->rollback();
    }
    
    /**
     * 自动提交模式true开启false关闭
     *
     * @see database_interface::begin_trans()
     */
    public function begin_trans()
    {
        $stat = func_get_arg(0);
        $this->link->autocommit(! $stat);
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
                //取消判断整型或浮点型增加值
//                 if (is_int($value) || is_float($value)) {
//                     $sets[] = $key . ' = ' . $key . ' + ' . $value;
//                 } else {
//                     $sets[] = $key . " = '" . $value . "'";
//                 }
                $sets[] = $key . " = '" . $value . "'";
            }
        }
    
        $sql = '';
        $primary_keys = array(
            $this->opt['primary']
        );
        if (empty($primary_keys)) {
            if (! empty($fields)) {
                $sql = 'INSERT INTO ' . $this->opt['table'] . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
            }
        } else {
            // mysql version >= 4.1
            if (! empty($fields)) {
                $sql = 'INSERT INTO ' . $this->opt['table'] . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
                if (! empty($sets)) {
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
     * @see database_interface::execute()
     */
    public function execute($sql)
    {
        // 查询参数初始化
        $this->opt_init();
        // 将SQL添加到调试DEBUG
        $this->debug($sql);
        $this->last_query = $this->link->query($sql);
        if ($this->last_query) {
            // 自增id
            $insert_id = $this->link->insert_id;
            return $insert_id ? $insert_id : true;
        } else {
//             $this->error($this->link->error . "\t" . $sql);
            throw new Exception($this->link->error . "\t" . $sql, $this->link->errno);
            return false;
        }
    }

    /**
     * 发送查询 返回数组
     *
     * @see admin::query()
     */
    public function query($sql)
    {
        $options = \RC_Config::get('cache.query_cache');
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
        if (! $this->execute($sql)) {
            return false;
        }
        
        $list = array();
        while (($res = $this->fetch()) != false) {
            $list[] = $res;
        }
        if ($cache_time >= 0 && count($list) <= $options['select_length']) {
            \RC_Cache::query_cache_set($cache_name, $list, $cache_time);
        }
        return is_array($list) && ! empty($list) ? $list : null;
    }

    /**
     * 获得MYSQL版本信息
     *
     * @see database_interface::version()
     */
    public function version()
    {
        $version_int = $this->link->server_version;
        
        $main_version = floor($version_int/10000);
        
        $minor_version = ltrim(floor(($version_int-$main_version*10000)/100), 0);
        
        $sub_version = ltrim($version_int-$main_version*10000-$minor_version*100, 0);
        
        return implode('.', array($main_version, $minor_version, $sub_version));
    }

    /**
     * 遍历结果集(根据INSERT_ID)
     *
     * @return unknown
     */
    protected function fetch()
    {
        $res = $this->last_query->fetch_assoc();
        if (! MAGIC_QUOTES_GPC) {
            $res = rc_stripslashes($res);
        }
        if (! $res) {
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
            $this->last_query->close();
        }
    }
    
    /**
     * 释放连接资源
     *
     * @see database_interface::close()
     */
    public function close()
    {
        if (is_resource($this->link)) {
            $this->link->close();
            $this->link = null;
            unset(self::$connect_pool[$this->hostkey]);
            if (is_array(self::$connect_pool) && !count(self::$connect_pool)) {
                self::$connect_pool = null;
            }
        }
    }
    
}

// end