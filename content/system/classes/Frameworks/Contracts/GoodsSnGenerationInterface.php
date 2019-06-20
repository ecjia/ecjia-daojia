<?php


namespace Ecjia\System\Frameworks\Contracts;


interface GoodsSnGenerationInterface
{

    /**
     * 获取最大的主键ID
     * @return mixed
     */
    public function getMaxId();


    /**
     * 获取相同的货号
     * @param $goods_sn
     * @param $goods_id
     * @return array
     */
    public function getSameGoodsSn($goods_sn, $goods_id = null);

    /**
     * 获取货号前缀
     * @return string
     */
    public function getSnPrefix();

}