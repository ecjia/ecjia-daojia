<?php

namespace Royalcms\Component\Model\Traits;

trait ModelVersion
{

    /**
     * 返回数据库版本号
     */
    final public function version()
    {
        return $this->db->version();
    }

}