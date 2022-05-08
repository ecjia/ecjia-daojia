<?php


namespace Royalcms\Component\Cache\Stores;


Interface SpecialStoreInterface
{

    /**
     * 快速设置缓存数据
     *
     * @param $name
     * @param $data
     * @param null $expire
     * @return mixed
     */
    public function set($name, $data, $expire = null);

    /**
     * 快速添加缓存数据，如果name已经存在，则返回false
     * @param $name
     * @param $data
     * @param null $expire
     * @return mixed
     */
    public function add($name, $data, $expire = null);

    /**
     * 快速获取APP缓存数据
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * 快速删除APP缓存数据
     * @param $name
     * @return mixed
     */
    public function delete($name);

}