<?php

namespace Royalcms\Component\Model\Database;

use PDOException;

/**
 * PDO数据库操作类
 *
 * @package Royalcms
 * @subpackage Component
 */
class Pdo extends Database
{

    protected static $is_connect   = null; // 是否连接
    public           $link         = null; // 数据库连接
    private          $PDOStatement = null; // 预声明
    public           $affected_rows;       // 受影响条数

    /**
     * 构造函数
     */
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

    function connect_database()
    {
        if (is_null(self::$is_connect)) {
            $dsn      = "mysql:host=" . $this->config['host'] . ';dbname=' . $this->config['database'];
            $username = $this->config['username'];
            $password = $this->config['password'];
            try {
                self::$is_connect = new Pdo($dsn, $username, $password);
                self::set_charts();
            } catch (PDOException $e) {
                return false;
            }
        }
        $this->link = self::$is_connect;
        return true;
    }

    /**
     * 设置字符集
     */
    static private function set_charts()
    {
        $character = $this->config['charset'];
        $sql       = "SET character_set_connection=$character,character_set_results=$character,character_set_client=binary";
        self::$is_connect->query($sql);
    }

    /**
     * 获得最后插入的ID号
     *
     * @see database_interface::last_insert_id()
     */
    public function last_insert_id()
    {
        return $this->link->lastInsertId();
    }

    /**
     * 获得受影响的行数
     *
     * @see database_interface::last_affected_rows()
     */
    public function last_affected_rows()
    {
        return $this->$affected_rows;
    }

    /**
     * 数据安全处理
     *
     * @see database_interface::escape_string()
     */
    public function escape_string($str)
    {
        return rc_addslashes($str);
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
        // 释放结果
        if (!$this->PDOStatement)
            $this->result_free();
        $this->PDOStatement = $this->link->prepare($sql);
        // 预准备失败
        if ($this->PDOStatement === false) {
            $this->error($this->link->errorCode() . "\t" . $this->last_sql);
            return false;
        }
        $result = $this->PDOStatement->execute();
        // 执行SQL失败
        if ($result === false) {
            $this->error($this->link->errorCode() . "\t" . $this->last_sql);
            return false;
        } else {
            $insert_id = $this->link->lastInsertId();
            return $insert_id ? $insert_id : true;
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
        $cache_name = $sql . ROUTE_M . ROUTE_C . ROUTE_A;
        if ($cache_time >= 0) {
            $result = \RC_Cache::query_cache_get($cache_name);
            if ($result) {
                // 查询参数初始化
                $this->optInit();
                return $result;
            }
        }
        // 发送SQL
        if (!$this->execute($sql)) {
            return false;
        }
        $list = $this->PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        // 受影响条数
        $this->affected_rows = count($list);
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
        return $this->link->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    /**
     * 开启事务处理
     *
     * @see database_interface::begin_trans()
     */
    public function begin_trans()
    {
        $this->link->beginTransaction();
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
     * 释放连接资源
     *
     * @see database_interface::close()
     */
    public function close()
    {
        if (is_object($this->link)) {
            $this->link       = null;
            self::$is_connect = null;
        }
    }

    /**
     * 遍历结果集(根据INSERT_ID)
     *
     * @return unknown
     */
    protected function fetch()
    {
        $res = $this->last_query->fetch(PDO::FETCH_ASSOC);
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
        $this->PDOStatement = null;
    }
}

// end