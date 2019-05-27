<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Goods\GoodsImage\CopyGoodsImage;
use ecjia_error;
use RC_DB;
use RC_Api;
use ecjia_admin;
use Royalcms\Component\Database\QueryException;

/**
 * 复制店铺中商品相册数据
 *
 * 图片字段的处理 img_url img_desc thumb_url img_original
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

    protected $rank_order = 7;

    protected $sort = 17;

    public function __construct($store_id, $source_store_id)
    {
        parent::__construct($store_id, $source_store_id, '商品相册');
    }

    protected function getTableName()
    {
        return 'goods_gallery';
    }

    /**
     * 店铺复制操作的具体过程
     * @return bool|ecjia_error
     */
    protected function startDuplicateProcedure()
    {
        //忽略内存大小限制
        ini_set('memory_limit',-1);
        set_time_limit(0);

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
                RC_DB::table($this->getTableName())->whereIn('goods_id', $old_goods_id)->chunk(20, function ($items) use ($replacement_products) {
                    foreach ($items as &$item) {
                        $img_id = $item['img_id'];
                        unset($item['img_id']);

                        //通过 goods 替换数据设置新店铺的 goods_id
                        $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);

                        //通过 products 替换数据设置新店铺的 product_id
                        $item['product_id'] = array_get($replacement_products, $item['product_id'], $item['product_id']);

                        //图片字段的处理 img_desc
                        $item['img_desc'] = $this->copyImageForContent($item['img_desc']);

                        //图片字段的处理 thumb_url img_original img_url
                        if ($item['product_id'] === 0){
                            list($item['img_original'], $item['img_url'], $item['thumb_url']) = $this->copyGoodsGallery(
                                $item['goods_id'],
                                $item['product_id'],
                                $item['img_original'],
                                $item['img_url'],
                                $item['thumb_url']
                            );
                        }else{
                            list($item['img_original'], $item['img_url'], $item['thumb_url']) = $this->copyProductGallery(
                                $item['goods_id'],
                                $item['product_id'],
                                $item['img_original'],
                                $item['img_url'],
                                $item['thumb_url']
                            );
                        }

                        try {
                            //将数据插入到新店铺
                            $new_img_id = RC_DB::table($this->getTableName())->insertGetId($item);

                            //存储替换记录
                            $this->replacement_goods_gallery[$img_id] = $new_img_id;
                        } catch (QueryException $e) {
                            ecjia_log_warning($e->getMessage());
                        }
                    }
                });

                //存储 goods_gallery 相关替换数据
                $this->setReplacementData($this->getCode(), $this->replacement_goods_gallery);
            }
            return true;
        } catch (QueryException $e) {
            ecjia_log_warning($e->getMessage());
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }
    }

    /**
     * @param $goods_id
     * @param $product_id
     * @param $original_path
     * @param $img_path
     * @param $thumb_path
     * @return array
     */
    private function copyGoodsGallery($goods_id, $product_id, $original_path, $img_path, $thumb_path)
    {
        $copy = new CopyGoodsImage($goods_id, $product_id);

        list($new_original_path, $new_img_path, $new_thumb_path) = $copy->copyGoodsGallery($original_path, $img_path, $thumb_path);

        return [$new_original_path, $new_img_path, $new_thumb_path];
    }

    private function copyProductGallery($goods_id, $product_id, $original_path, $img_path, $thumb_path)
    {
        $copy = new CopyGoodsImage($goods_id, $product_id);

        list($new_original_path, $new_img_path, $new_thumb_path) = $copy->copyProductGallery($original_path, $img_path, $thumb_path);

        return [$new_original_path, $new_img_path, $new_thumb_path];
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
        $new_content = CopyGoodsImage::copyDescriptionContentImages($content);

        return $new_content;
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        static $store_merchant_name, $source_store_merchant_name;

        if (empty($store_merchant_name)) {
            $store_info = RC_Api::api('store', 'store_info', ['store_id' => $this->store_id]);
            $store_merchant_name = array_get(empty($store_info) ? [] : $store_info, 'merchants_name');
        }

        if (empty($source_store_merchant_name)) {
            $source_store_info = RC_Api::api('store', 'store_info', ['store_id' => $this->source_store_id]);
            $source_store_merchant_name = array_get(empty($source_store_info) ? [] : $source_store_info, 'merchants_name');
        }

        \Ecjia\App\Store\Helper::assign_adminlog_content();
        $content = sprintf(__('将【%s】店铺所有商品相册复制到【%s】店铺中', 'goods'), $source_store_merchant_name, $store_merchant_name);
        ecjia_admin::admin_log($content, 'duplicate', 'store_goods');
    }
}