<?php


namespace Royalcms\Component\Model\Traits;

/**
 * 事务
 * Trait TransactionTrait
 * @package Royalcms\Component\Model\Traits
 */
trait TransactionTrait
{

    /**
     * 开启|关闭事务
     *
     * @param bool $stat
     *            true开启事务| false关闭事务
     * @return mixed
     */
    public function begin_trans($stat = true)
    {
        return $this->db->begin_trans($stat);
    }

    /**
     * 提供一个事务
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     * 回滚事务
     */
    public function rollback()
    {
        return $this->db->rollback();
    }

}