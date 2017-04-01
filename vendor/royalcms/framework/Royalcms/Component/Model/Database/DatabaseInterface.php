<?php namespace Royalcms\Component\Model\Database;

/**
 * 数据库操作接口
 *
 * @package database
 */
interface DatabaseInterface
{

    /**
     * 获得连接，参数为表名
     */
    public function connect_database();

    /**
     * 关闭数据库
     */
    public function close();

    /**
     * 发送没有返回值的sql
     *
     * @param string $sql            
     */
    public function execute($sql);

    /**
     * 有返回值的sql
     *
     * @param string $sql            
     */
    public function query($sql);

    /**
     * 获得最后插入的id
     */
    public function last_insert_id();

    /**
     * 获得最后受影响的行数
     */
    public function last_affected_rows();

    /**
     * 获得版本
     */
    public function version();

    /**
     * 自动提交模式true开启false关闭
     */
    public function begin_trans();

    /**
     * 提供一个事务
     */
    public function commit();

    /**
     * 回滚事务
     */
    public function rollback();

    /**
     * 数据安全处理
     *
     * @param unknown $str            
     */
    public function escape_string($str);
}


// end