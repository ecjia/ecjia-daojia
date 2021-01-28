<?php


namespace Royalcms\Component\Model\Traits;


trait TableTrait
{
    /**
     * 清空表
     *
     * @param unknown $table
     */
    public function truncate($table)
    {
        if (is_array($table) && !empty($table)) {
            foreach ($table as $t) {
                $this->execute("TRUNCATE TABLE `$t`");
            }

            return true;
        }
    }

    /**
     * 优化表解决表碎片问题
     *
     * @param array $table 表
     * @return bool
     */
    public function optimize($table)
    {
        if (is_array($table) && !empty($table)) {
            foreach ($table as $t) {
                $this->execute("OPTIMIZE TABLE `$t`");
            }
            return true;
        }
    }

    /**
     * 修复数据表
     *
     * @param unknown $table
     * @return boolean
     */
    public function repair($table)
    {
        if (is_array($table) && !empty($table)) {
            foreach ($table as $t) {
                $this->execute("REPAIR TABLE `$t`");
            }
            return true;
        }
    }

    /**
     * 删除表
     *
     * @param unknown $table
     */
    public function drop_table($table)
    {
        if (is_string($table)) {
            $table = array(
                $table
            );
        }
        if (is_array($table) && !empty($table)) {
            foreach ($table as $t) {
                $this->execute("DROP TABLE IF EXISTS `$t`");
            }
        }

        return true;
    }

    /**
     * 修改表名
     *
     * @param unknown $old
     * @param unknown $new
     */
    public function rename($old, $new)
    {
        $this->execute("ALTER TABLE `$old` RENAME `$new`");
    }

    /**
     * 获取数据表主键
     *
     * @return string
     */
    public function table_primary()
    {
        return $this->db->primary;
    }

    /**
     * 获取表字段
     *
     * @return array
     */
    public function table_fields()
    {
        return $this->db->fields;
    }

    /**
     * 检查表是否存在
     *
     * @param $table 表名
     * @return boolean
     */
    public function table_exists($table)
    {
        return $this->db->table_exists($this->db_tablepre . $table);
    }

    /**
     * 获得数据表大小
     *
     * @param string $table
     */
    public function table_size($table = null)
    {
        if (empty($table)) {
            $table = array(
                $this->table_name
            );
        }
        if (is_string($table)) {
            $table = array(
                $table
            );
        }

        $new_tables = array();
        foreach ($table as $t) {
            if (strpos($t, $this->db_tablepre) === false) {
                $new_tables[] = $this->db_tablepre . $t;
            } else {
                $new_tables[] = $t;
            }
        }

        return $this->db->table_size($new_tables);
    }

    /**
     * 获得表信息
     *
     * @param array $table
     */
    public function table_info($table = null)
    {
        if (empty($table)) {
            $table = array(
                $this->table_name
            );
        }
        if (is_string($table)) {
            $table = array(
                $table
            );
        }

        $new_tables = array();
        foreach ($table as $t) {
            if (strpos($t, $this->db_tablepre) === false) {
                $new_tables[] = $this->db_tablepre . $t;
            } else {
                $new_tables[] = $t;
            }
        }

        return $this->db->table_info($new_tables);
    }

}