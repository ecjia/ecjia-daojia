<?php

namespace Ecjia\Component\Region;


trait CompatibleTrait
{

    /**
     * 返回当前终级类对象的实例
     *
     * @return object
     */
    public function instance()
    {
        return royalcms('ecjia.region');
    }


    /**
     * 获取地区名称
     *
     * @param string $id
     */
    public function region_name($id)
    {
        return $this->getRegionName($id);
    }

    /**
     * 获取指定城市的下一级地区
     *
     * @param string $type
     * @param string $parent
     */
    public function region_datas($type = 0, $parent = 0)
    {
        return $this->getSubarea($parent);
    }

}

// end