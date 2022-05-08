<?php


namespace Ecjia\Component\Config\Seeder;

use Ecjia\Component\Config\Models\ConfigModel;
use Royalcms\Component\Database\Eloquent\Builder;
use Royalcms\Component\Database\Eloquent\Collection;

/**
 * 分组排序
 * Class SettingSequence
 * @package Ecjia\Component\Config\Seeder
 */
class SettingSequence
{

    /**
     * shop_config字段排序
     */
    public function seeder()
    {
        //更新分组ID
        $this->updateGroupId();

        //修改Item临时ID
        $id_start = 1000;

        /**
         * @var $item ConfigModel | Builder
         * @var $data Collection
         */
        $data = ConfigModel::where('id', '>', $id_start)->get();
        $data->map(function ($item) {

            $id = $item->id + 30000000;

            $item->id = $id;
            $item->save();
        });

        //再将Item分配新ID
        $data = ConfigModel::where('parent_id', 0)->get();
        $data->map(function ($item) {
            $this->updateItemIdWithGroupId($item['id']);
        });

        //移除code为空的配置项
        $this->removeEmptyCode();
    }

    /**
     * 移除code为空的配置项
     */
    protected function removeEmptyCode()
    {
        ConfigModel::where('code', '')->delete();
    }

    /**
     * 更新GroupId排序
     */
    protected function updateGroupId()
    {
        $data = ConfigModel::where('type', 'group')->get();

        $data->map(function ($item, $key) {
            $old_id = $item->id;
            $id = $key + 1;

            $item->id = $id;
            $item->save();

            $this->replaceItemIdForParentId($old_id, $id);
        });

    }

    /**
     * 更新子配置项的父级ID
     * @param $old_id
     * @param $new_id
     */
    protected function replaceItemIdForParentId($old_id, $new_id)
    {
        ConfigModel::where('parent_id', $old_id)->update(['parent_id' => $new_id]);
    }

    /**
     * 更新ItemId排序
     * @param $group_id
     */
    protected function updateItemIdWithGroupId($group_id)
    {
        $id_start = 1000;

        /**
         * @var $item ConfigModel | Builder
         * @var $data Collection
         */
        $data = ConfigModel::where('id', '>', $id_start)->where('parent_id', $group_id)->get();

        $data->map(function ($item, $key) use ($id_start) {

            $id = $key + 1;

            $id = $item->parent_id * $id_start + $id;

            $item->id = $id;
            $item->save();
        });
    }

}