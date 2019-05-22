<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use ecjia_error;
use RC_DB;
use RC_Api;
use ecjia_admin;

/**
 * 复制店铺中商品相册数据
 *
 * @todo 图片字段的处理 img_url img_desc thumb_url img_original
 *
 * Class StoreGoodsGalleryDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreGoodsGalleryDuplicate extends StoreProcessAfterDuplicateGoodsAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_goods_gallery_duplicate';

    private $replacement_goods_gallery = [];

    private $table = 'goods_gallery';

    public function __construct($store_id, $source_store_id, $sort = 17)
    {
        parent::__construct($store_id, $source_store_id, '商品相册', $sort);
    }

    /**
     * 统计数据条数并获取
     *
     * @return mixed
     */
    public function handleCount()
    {
        //如果已经统计过，直接返回统计过的条数
        if ($this->count) {
            return $this->count;
        }

        // 统计数据条数
        $old_goods_id = $this->getOldGoodsId();
        if (!empty($old_goods_id)) {
            $this->count = RC_DB::table($this->table)->whereIn('goods_id', $old_goods_id)->count();
        }
        return $this->count;
    }

    /**
     * 店铺复制操作的具体过程
     * @return bool|ecjia_error
     */
    protected function startDuplicateProcedure()
    {
        try {
            $this->setProgressData();

            //设置 goods 相关替换数据
            $this->setReplacementGoodsAfterSetProgressData();

            //取出源店铺 goods_id
            $old_goods_id = $this->getOldGoodsId();

            if (!empty($old_goods_id)) {
                //获取商家货品的替换数据
                $replacement_products = [];
                foreach ($this->dependents as $code) {
                    $replacement_products += $this->progress_data->getReplacementDataByCode($code . '.products');
                }

                //将数据同步到 goods_gallery 商品相册数据
                $this->duplicateGoodsGallery($old_goods_id, $replacement_products);
                //存储 goods_gallery 相关替换数据
                $this->setReplacementData($this->getCode(), $this->replacement_goods_gallery);
            }

            return true;
        } catch (\Royalcms\Component\Repository\Exceptions\RepositoryException $e) {
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }
    }

    /**
     * 复制 goods_gallery 数据
     * @param $old_goods_id
     * @param $replacement_products
     */
    private function duplicateGoodsGallery($old_goods_id, $replacement_products)
    {
        RC_DB::table($this->table)->whereIn('goods_id', $old_goods_id)->chunk(20, function ($items) use ($replacement_products) {
            foreach ($items as &$item) {
                $img_id = $item['img_id'];
                unset($item['img_id']);

                //通过 goods 替换数据设置新店铺的 goods_id
                $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);

                //通过 products 替换数据设置新店铺的 product_id
                $item['product_id'] = array_get($replacement_products, $item['product_id'], $item['product_id']);

                //@todo 图片字段的处理 img_url img_desc thumb_url img_original
                $item['img_url'] = $this->copyImage($item['img_url']);
                $item['img_desc'] = $this->copyImage($item['img_desc']);
                $item['thumb_url'] = $this->copyImage($item['thumb_url']);
                $item['img_original'] = $this->copyImage($item['img_original']);


                //将数据插入到新店铺
                //$new_img_id = $img_id + 1;
                $new_img_id = RC_DB::table($this->table)->insertGetId($item);

                //存储替换记录
                $this->replacement_goods_gallery[$img_id] = $new_img_id;
            }
            //dd($this->replacement_goods_gallery, $replacement_products, $items);
        });
    }

    /**
     * 复制单张图片
     *
     * @param $path
     *
     * @return string
     */
    protected function copyImage($path)
    {

        return $path;
    }

    /**
     * 复制缩编器内容中的图片
     *
     * @param $content
     *
     * @return string
     */
    protected function copyImageForContent($content)
    {

        return $content;
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        \Ecjia\App\Store\Helper::assign_adminlog_content();

        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'goods'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'goods'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'duplicate', 'store_goods');
    }

}