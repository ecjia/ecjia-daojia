<?php


namespace Royalcms\Component\Model\Traits;


trait DatabaseTrait
{
    /**
     * 创建数据库
     *
     * @param string $database
     * @param string $charset
     */
    public function create_database($database, $charset = 'utf8')
    {
        return $this->execute("CREATE DATABASE IF NOT EXISTS `$database` CHARSET $charset");
    }

    /**
     * 获得数据库大小
     */
    public function database_size($tablepre = null)
    {
        return $this->db->database_size($tablepre);
    }

    /**
     * 获得数据库列表
     */
    public function database_tables($tablepre = null)
    {
        return $this->db->tables_list($tablepre);
    }

}